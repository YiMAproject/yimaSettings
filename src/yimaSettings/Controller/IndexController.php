<?php
namespace yimaSettings\Controller;

use yimaSettings\Service\Settings\SettingEntity;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $this->settingHelper()->linkedin = 'this is changed';
        echo $this->settingHelper()->linkedin;

        $this->settingHelper()->save();

        die('>_');
    }
}
