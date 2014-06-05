<?php
return array(
    'yima-settings' => array(
        # we can use default settings as shared Setting
        'defaults' => array(
            'linkedin'   => array(
                # used as default value
                'value'   => 'http://ir.linkedin.com/in/payamnaderi',
                # form element
                'element' => array(
                    'type' => 'Zend\Form\Element\Url',
                    'options' => array(
                        'label' => 'Your Linkedin Address'
                    ),
                    'attributes' => array(
                        'required' => 'required',
                    )
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
