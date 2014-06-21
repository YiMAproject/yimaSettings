<?php
namespace yimaSettings\Controller\Admin;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class IndexController
 * @package yimaSettings\Controller\Admin
 */
class IndexController extends AbstractActionController
{
    public function dashboardAction()
    {
        /*$this->settingHelper()->linkedin = 'ir.linkedin.com/payamnaderi';
        echo $this->settingHelper()->linkedin;

        $this->settingHelper()->save();*/

        die('> you are on settings dashboard');
    }
}
