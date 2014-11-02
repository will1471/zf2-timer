<?php
return array(
    'router' => array(
        'routes' => array(
            'timer.rest.timer' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/timer[/:timer_id]',
                    'defaults' => array(
                        'controller' => 'Timer\\V1\\Rest\\Timer\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'timer.rest.timer',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Timer\\V1\\Rest\\Timer\\TimerResource' => 'Timer\\V1\\Rest\\Timer\\TimerResourceFactory',
        ),
    ),
    'zf-rest' => array(
        'Timer\\V1\\Rest\\Timer\\Controller' => array(
            'listener' => 'Timer\\V1\\Rest\\Timer\\TimerResource',
            'route_name' => 'timer.rest.timer',
            'route_identifier_name' => 'timer_id',
            'collection_name' => 'timer',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Timer\\V1\\Rest\\Timer\\TimerEntity',
            'collection_class' => 'Timer\\V1\\Rest\\Timer\\TimerCollection',
            'service_name' => 'timer',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Timer\\V1\\Rest\\Timer\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Timer\\V1\\Rest\\Timer\\Controller' => array(
                0 => 'application/vnd.timer.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Timer\\V1\\Rest\\Timer\\Controller' => array(
                0 => 'application/vnd.timer.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Timer\\V1\\Rest\\Timer\\TimerEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'timer.rest.timer',
                'route_identifier_name' => 'timer_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'Timer\\V1\\Rest\\Timer\\TimerCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'timer.rest.timer',
                'route_identifier_name' => 'timer_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Timer\\V1\\Rest\\Timer\\Controller' => array(
            'input_filter' => 'Timer\\V1\\Rest\\Timer\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Timer\\V1\\Rest\\Timer\\Validator' => array(
            0 => array(
                'name' => 'name',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'description' => 'Timer Name',
            ),
        ),
    ),
);
