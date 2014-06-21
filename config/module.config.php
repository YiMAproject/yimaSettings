<?php
return array(
    'yima-settings' => array(
        # we can use default settings as shared Setting
        'defaults' => array(
            'linkedin'   => array(
                # used as default value
                'value' => 'http://ir.linkedin.com/in/payamnaderi',
                'label' => 'Your Linkedin Address',
                # form element
                'element' => array(
                    'type' => 'Zend\Form\Element\Url',
                    'attributes' => array(
                        'required' => 'required',
                    ),
                    'options' => array(
                        # these options was replaced by values from top
                        # 'label' => 'label not set here',
                        # 'value' => 'value not set from here because of hydrator',
                    ),
                ),
            ),
        ),
    ),

    // --------------------------------------------------------------------------------------

    # Add menu item into adminor navigation
    'navigation' => array(
        'admin' => array(
            array(
                'label' 	 => 'Settings',
                'route'		 => \yimaAdminor\Module::ADMIN_ROUTE_NAME.'/default',
                'module'     =>'yimaSettings',
                'controller' => 'Index',
                //'action'     => 'dashboard', // by default
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
