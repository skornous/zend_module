<?php
	return array(
		'controllers' => array(
			'invokables' =>	array(
				'Users\Controller\Index' => 'Users\Controller\IndexController',
				'Users\Controller\Register' => 'Users\Controller\RegisterController',
				'Users\Controller\Login' => 'Users\Controller\LoginController',
			)
		),
		'router' => array(
			'routes' => array(
				'users' => array(
					'type' => 'Literal',
					'options' => array(
						'route'    => '/users',
						'defaults' => array(
							'__NAMESPACE__' => 'Users\Controller',
							'controller' => 'Index',
							'action'     => 'index',
						),
					),
					'may_terminate' => true,
					'child_routes' => array(
						'default' => array(
							'type' => 'Segment',
							'options' => array(
								'route' => '/[:controller[/:action]]',
								'constraint' => array(
									'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
									'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								),
								'defaults' => array(
								),
							),
						),
					),
				),
			),
		),
		'service_manager' => array(
			'abstract_factories' => array(
				'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
				'Zend\Log\LoggerAbstractServiceFactory',
			),
			'aliases' => array(
				'translator' => 'MvcTranslator',
			),
		),
		'translator' => array(
			'locale' => 'en_US',
			'translation_file_patterns' => array(
				array(
					'type'     => 'gettext',
					'base_dir' => __DIR__ . '/../language',
					'pattern'  => '%s.mo',
				),
			),
		),
		'view_manager' => array(
			'template_path_stack' => array(
				'users' => __DIR__ . '/../view',
			),
		),
		'console' => array(
			'router' => array(
				'routes' => array(
				),
			),
		),
	);
