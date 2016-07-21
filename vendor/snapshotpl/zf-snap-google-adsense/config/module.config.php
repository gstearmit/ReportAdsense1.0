<?php

use \ZfSnapGoogleAdSense\Model\AdUnit;

return array(
    'zf-snap-google-adsense' => array(
        'ads' => array(
	         'home-page-160x160' => array(
	            'id' => 5973437642,
	            'size' => '336x280',
	          ),
            ),
        'enable' => true,
        'publisher-id' =>'pub-7367837713825577', # prokopmartin85@gmail.com 
        'renderer' => 'zf-snap-google-adsense-renderer-view-asynchronous',
        'unit-limit' => array(
            AdUnit::TYPE_CONTENT => 3,
            AdUnit::TYPE_LINK => 3,
        ),
        'renderers' => array(
            'zf-snap-google-adsense-renderer-view-placeholdit' => array(
                'params' => array(
                    'useAdNameToText' => true,
                    'backgroundColor' => 'ccc',
                    'textColor' => '969696',
                    'format' => 'gif',
                ),
            ),
            'zf-snap-google-adsense-renderer-view-html' => array(
                'params' => array(
                    'background' => '#ccc',
                    'color' => '#969696',
                    'style' => '',
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'ZfSnapGoogleAdSense\View\Helper\Renderer\ViewFactory' => 'ZfSnapGoogleAdSense\View\Helper\Renderer\ViewFactory',
        ),
    ),
    'view_helpers' => array(
        'aliases' => array(
            'adsense' => 'googleAdSense',
        ),
        'factories' => array(
            'googleAdSense' => 'ZfSnapGoogleAdSense\View\Helper\GoogleAdSenseFactory',
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'zf-snap-google-adsense-renderer-view-asynchronous' => __DIR__ . '/../view/zf-snap-google-adsense/renderer/view/asynchronous.phtml',
            'zf-snap-google-adsense-renderer-view-html'         => __DIR__ . '/../view/zf-snap-google-adsense/renderer/view/html.phtml',
            'zf-snap-google-adsense-renderer-view-placeholdit'  => __DIR__ . '/../view/zf-snap-google-adsense/renderer/view/placeholdit.phtml',
            'zf-snap-google-adsense-renderer-view-synchronous'  => __DIR__ . '/../view/zf-snap-google-adsense/renderer/view/synchronous.phtml',
        ),
    ),
);