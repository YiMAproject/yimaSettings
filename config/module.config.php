<?php
return array(
    'yima-settings' => array(
        # we can use general settings as shared Setting
        'general' => array(
            # Entity Factory Options
            # ----------------------------------------------------------------------------------|
            'label' => 'General System Settings',
            'properties' => array(
                'linkedin'   => array(
                    'label' => 'Your Linkedin Address',

                    # form element
                    'element' => array(
                        'type' => 'Zend\Form\Element\Url',
                        'attributes' => array(
                            #'required' => 'required',
                            #'disabled' => 'disabled',
                        ),
                        'options' => array(
                            # these options was replaced by values from top
                            # 'label' => 'label not set here',
                            # 'value' => 'value not set from here because of hydrator',
                        ),
                    ),
                    # sets of action behavior options
                    'options' => array(
                        # merge with application config on bootstrap
                        # note: only contents of general namespace will merged with app. config
                        'merged_config' => true,
                        # not editable with setting form in controller
                        'read_only'     => false,
                    ),
                ),
                'website'   => array(
                    # used as default value
                    'label' => 'Raya Web Site',

                    # sets of action behavior options
                    'options' => array(
                        # not editable with setting form in controller
                        'read_only'     => true,
                    ),
                ),
            ),
            'options' => array(
                // default values
                'default_values' => array(
                    'linkedin' => 'http://linkedin.com',
                    'website'  => 'http://raya-media.com',
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
                'order' 	 => 10000,
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
