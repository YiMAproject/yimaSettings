<?php
namespace yimaSettings\Controller\Admin;

use yimaSettings\DataStore\Collection\CollectionInterface;
use yimaSettings\DataStore\Entity;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\ArrayUtils;

/**
 * Class IndexController
 * @package yimaSettings\Controller\Admin
 */
class IndexController extends AbstractActionController
{
    public function dashboardAction()
    {
        $currSetting = $this->params()->fromRoute('setting', 'general');

        $form = $this->getSettingForm($currSetting);
        // add form action to this page
        $urlHelper = $this->getServiceLocator()->get('viewhelpermanager')->get('url');
        $form->setAttribute(
            'action',
            $urlHelper(
                \yimaAdminor\Module::ADMIN_DEFAULT_ROUTE_NAME
                ,array('setting' => $currSetting)
                ,true
            )
        );

        $posts = $this->params()->fromPost();
        if ($posts) {
            $form->setData($posts);
            if ($form->isValid()) {
                // Save Settings
                $formData = $form->getData();
                unset($formData['submit']);

                // TODO: filter read-only data from formData
                // TODO: filter only form data
                unset($formData['website']);

                /** @var $collection \yimaSettings\DataStore\FileStore\FileCollection */
                $collection = $this->settingHelper()->using($currSetting);
                $curEntity  = $collection->fetch();
                $curEntity  = $curEntity->getAs(new Entity\Converter\ArrayConverter());

                $data = ArrayUtils::merge($curEntity, $formData);

                $entity = new Entity($data);
                $collection->save($entity);

                $this->flashMessenger()->addMessage('Settings are saved.');
                $this->redirect()->refresh();
            }
        }

        // get lists of all settings ... {
        $settingsList = new \Poirot\Dataset\Entity();
        $config  = $this->getServiceLocator()
            ->get('Config');
        $config  = (isset($config['yima-settings'])) ? $config['yima-settings'] : array();
        foreach(array_keys($config) as $ns)
        {
            $settingsList->set(
                $ns,
                array(
                    'label' => $config[$ns]['label']
                )
            );
        }
        // ... }

        // return view params
        return array(
            'current_setting' => new \Poirot\Dataset\Entity(
                array('namespace' => $currSetting, 'label' => $config[$currSetting]['label'])
            ),
            'setting_form'    => $form,
            'settings_list'   => $settingsList,
            'flash_messages'  => $this->flashMessenger()->getMessages(),
        );
    }

    /**
     * Get Form for specific setting namespace
     *
     * @param string $setting Setting Namespace
     *
     * @return \Zend\Form\Form
     */
    protected function getSettingForm($setting)
    {
        $config  = $this->getServiceLocator()
            ->get('Config');
        $config  = (isset($config['yima-settings'])) ? $config['yima-settings'] : array();
        $config  = (isset($config[$setting])) ? $config[$setting] : $config;
        $config  = (isset($config['properties'])) ? $config['properties'] : $config;

        $form = new \Zend\Form\Form();

        foreach($config as $sett => $ent)
        {
            /* @note: Element values are set from hydrator */
            $elementLabel = (isset($ent['label'])) ? $ent['label'] : null;
            $elementName  = $sett;

            if (isset($ent['options']) && isset($ent['options']['read_only'])
                && $ent['options']['read_only']) {
                // add readonly element
                $element = array(
                    'type'    => 'yimaSettings\Form\ReadonlyElement',
                    'name'    => $elementName,
                    'attributes' => array(
                        'disabled' => 'disabled',
                    ),
                    'options' => array(
                        'label' => $elementLabel,
                    ),
                );
                $form->add($element);
            }
            else {
                // note: some not defined data come with default entity props -
                // @see SettingItemsEntity
                if (isset($ent['element'])) {
                    $element = $ent['element'];
                    if ($elementLabel) {
                        // set label for element
                        if (!isset($element['options']) && !is_array($element['options'])) {
                            $element['options'] = array();
                        }
                        $element['options'] = ArrayUtils::merge(
                            $element['options'],
                            array('label' => $elementLabel)
                        );
                    }
                    $element['name'] = $elementName; // we need name at least

                    $form->add($element);
                }
            }
        }

        $currentSettingValues = $this->settingHelper()->using($setting)->fetch();
        $currentSettingValues = $currentSettingValues->getAs(new Entity\Converter\ArrayConverter());
        $form->setData($currentSettingValues);

        $form->add(
            array(
                'type'       => 'Zend\Form\Element\Submit',
                'name'       => 'submit',
                'attributes' => array(
                    'value'    => 'Save Changes',
                ),
            )
        );

        $form->setAttribute('method', 'post');

        return $form;
    }
}
