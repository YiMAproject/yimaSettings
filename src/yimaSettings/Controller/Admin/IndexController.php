<?php
namespace yimaSettings\Controller\Admin;

use Poirot\Dataset\Entity;
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

        if ($posts = $this->params()->fromPost()) {
            // Save Settings
            // ...

            $this->redirect()->refresh();
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

        // prepare current setting form ... {
        $form = $this->settingHelper()->get($currSetting)->getForm();
        $form->add(
            array(
                'type'       => 'Zend\Form\Element\Submit',
                'name'       => 'submit',
                'attributes' => array(
                    'value'    => 'Save Changes',
                ),
            )
        );

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

        $form->setAttribute('method', 'post');
        // ... }


        // return view params
        return array(
            'current_setting' => new Entity(
                array('namespace' => $currSetting, 'label' => $this->settingHelper()->get($currSetting)->getLabel())
            ),
            'setting_form'    => $form,
            'settings_list'   => $settingsList,
        );
    }
}
