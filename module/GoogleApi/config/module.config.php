<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'GoogleApi\Controller\Adsense' => 'GoogleApi\Controller\AdsenseController',  
        	'GoogleApi\Controller\AdsenseReport' => 'GoogleApi\Controller\AdsenseReportController',
        		
        )
    ),
    'router' => array(
        'routes' => array(
            'GoogleApi' => array(
                'type' => 'Segment',
            		'options' => array(
            				'route' => '/google-api[/:action[/:id][/:status][/page-:page]][.html]',
            				'constraints' => array(
            						'action' => '[a-zA-Z][a-zA-Z0-9-]*',
            						'id' => '[1-9][0-9]*',
            						'status' => '[0-9]*',
            						'page' => '[1-9][0-9]*'
            				),
            				'defaults' => array(
            						'__NAMESPACE__' => 'GoogleApi\Controller',
            						'controller' => 'GoogleApi\Controller\Adsense',
            						'action' => 'index',
            						'page' => '1'
            				)
            		)
            ),
        		
          # 
            		
        		'Adsense-Report' => array(
        				'type' => 'Segment',
        				'options' => array(
        						'route' => '/adsense[/:action]',
        						'constraints' => array(
        								'action' => '[a-zA-Z][a-zA-Z0-9-]*', 
        						),
        						'defaults' => array(
        								'__NAMESPACE__' => 'GoogleApi\Controller',
        								'controller' => 'AdsenseReport',
        								'action' => 'index'
        						)
        				)
        		),
        		 
        	 # /set-param-adsense	
        		'Adsense-Report-Set-Param' => array(
        				'type' => 'Segment',
        				'options' => array(
        						'route' => '/set-param-adsense',
        						'constraints' => array( ),
        						'defaults' => array(
        								'__NAMESPACE__' => 'GoogleApi\Controller',
        								'controller' => 'GoogleApi\Controller\AdsenseReport',
        								'action' => 'SetParamAdsense'
        						)
        				)
        		),
        		
        	# reportcallback	
        		'Adsense-Report-Callback' => array(
        				'type' => 'Segment',
        				'options' => array(
        						'route' => '/reportcallback',
        						'constraints' => array( ),
        						'defaults' => array(
        								'__NAMESPACE__' => 'GoogleApi\Controller',
        								'controller' => 'GoogleApi\Controller\AdsenseReport',
        								'action' => 'reportcallback'
        						)
        				)
        		),
        		
         # report-colum-chart	
        		'Adsense-Report-Colum-Chart' => array(
        				'type' => 'Segment',
        				'options' => array(
        						'route' => '/report-colum-chart',
        						'constraints' => array( ),
        						'defaults' => array(
        								'__NAMESPACE__' => 'GoogleApi\Controller',
        								'controller' => 'GoogleApi\Controller\AdsenseReport',
        								'action' => 'reportcolumchart'
        						)
        				)
        		),
        		
         
          # report-geo-chart
        		'Adsense-Report-Geo-Chart' => array(
        				'type' => 'Segment',
        				'options' => array(
        						'route' => '/report-geo-chart',
        						'constraints' => array( ),
        						'defaults' => array(
        								'__NAMESPACE__' => 'GoogleApi\Controller',
        								'controller' => 'GoogleApi\Controller\AdsenseReport',
        								'action' => 'reportgeochart'
        						)
        				)
        		),
        	
       
          # report-geo-chart
        		'Adsense-Report-LineChart' => array(
        				'type' => 'Segment',
        				'options' => array(
        						'route' => '/report-line-chart',
        						'constraints' => array( ),
        						'defaults' => array(
        								'__NAMESPACE__' => 'GoogleApi\Controller',
        								'controller' => 'GoogleApi\Controller\AdsenseReport',
        								'action' => 'reportlinechart'
        						)
        				)
        		),
         	
        # reportpiechart	 
        	 'Adsense-Report-PieChart' => array(
        				'type' => 'Segment',
        				'options' => array(
        						'route' => '/report-pie-chart',
        						'constraints' => array( ),
        						'defaults' => array(
        								'__NAMESPACE__' => 'GoogleApi\Controller',
        								'controller' => 'GoogleApi\Controller\AdsenseReport',
        								'action' => 'reportpiechart'
        						)
        				)
        		), 
        		
        # reporttablechart		 
        	 'Adsense-Report-TableChart' => array(
        				'type' => 'Segment',
        				'options' => array(
        						'route' => '/report-table-chart',
        						'constraints' => array( ),
        						'defaults' => array(
        								'__NAMESPACE__' => 'GoogleApi\Controller',
        								'controller' => 'GoogleApi\Controller\AdsenseReport',
        								'action' => 'reporttablechart'
        						)
        				)
        		), 
        	 	
        ),
    		
    		
    ),

	'service_manager' => array(
				'factories' => array(
						 
				),
		),
		
    'view_manager' => array(
    	'template_map' => array(
    				'google-api-adsense/layout/admin'   => __DIR__ . '/../view/layout/admin.phtml', 
    			    'layout/home' => __DIR__ . '/../view/layout/home.phtml',
    		),
        'template_path_stack' => array(
               __DIR__ . '/../view'
        ),
        'strategies' => array(
            'ViewJsonStrategy'
        ),
         
    ),
    'module_layouts' => array(

    ),
    'controller_plugins' => array(
        'invokables' => array(

        )
    ),
    'view_helpers' => array(
        'invokables' => array(

        ),
    ),
);
