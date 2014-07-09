<?php
namespace yimaSettings\Controller\Admin;

use Poirot\Entity;
use Zend\Mvc\Controller\AbstractActionController;

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
            $form->bindValues($posts);
            if ($form->isValid()) {
                // Save Settings
                $entity = $form->getData();
                $this->settingHelper()->save($entity);

                $this->flashMessenger()->addMessage('Settings are saved.');
                $this->redirect()->refresh();
            }
        }

        // get lists of all settings ... {
        $settingsList = new Entity();
        foreach($this->settingHelper()->getSettingsList() as $ns)
        {
            $settingsList->set(
                $ns,
                array(
                    'label' => $this->settingHelper()->get($ns)->getLabel()
                )
            );
        }
        // ... }

        // return view params
        return array(
            'current_setting' => new Entity(
                array('namespace' => $currSetting, 'label' => $this->settingHelper()->get($currSetting)->getLabel())
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
        $form = $this->settingHelper()->get($setting)->getForm();
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
