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

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'yima-kvsetting' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/settings',
                    'defaults' => array(
                        'controller' => 'yimaSettings.Controller.Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
);
