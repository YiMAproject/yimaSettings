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
                    # used as default value
                    'value' => 'http://linkedin.com',
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
                    # sets of action behavior options
                    'options' => array(
                        # merge with application config on bootstrap
                        # note: only contents of general namespace will merged with app. config
                        'merged_config' => true,
                        # not editable with setting form in controller
                        'read_only'     => true,
                    ),
                ),
            ),
            'filters' => array(
                'linkedin' => new \Poirot\Dataset\EntityFilterCallable(array(
                    'callable' => function($ve) {
                        /** @var $ve \yimaSettings\Entity\SettingItemsEntity */
                        if (!$ve->hasFilter('value', 'value.array')) {
                            $ve->addFilter(
                                'value' // entity property
                                ,new \Poirot\Dataset\EntityFilterCallable(array(
                                    'callable' => function($v) {
                                        return array('social' => array('linkedin' => $v));
                                    },
                                    'name' => 'value.array'
                                ))
                            );
                        }
                    },
                    'name' => 'linkedin.array'
                ))
            ),
            # -----------------------------------------------------------------------------------|
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
