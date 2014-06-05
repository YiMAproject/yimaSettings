<?php
namespace yimaSettings\Controller;

use yimaSettings\Service\Settings\SettingEntity;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        /** @var $entitySett SettingEntity */
        $entitySett = $this->getServiceLocator()->get('yimaSettings')
        ->getSetting('defaults');

        echo $entitySett->linkedin.'<br/>';

        d_r($entitySett->getForm()->get('linkedin'));

        die('>_');
    }
}
