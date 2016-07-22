<?php
namespace GoogleApi\Model;
use Google_Service; 
require_once 'htmlHelper.php';

 
class GenerateGeoChart  {
  public function render($service, $accountId, $adClientId) { 
  	$separator = str_repeat('=', 80) . "\n";
  	print $separator;
  	printf(" GenerateGeoChart for ad client %s\n", $adClientId);
  	print $separator;
  	
  	$sixMonthsAgo = new \DateTime('-6 months'); 
    $startDate = $sixMonthsAgo->format('Y-m-d');
    
    $now = new \DateTime(); 
    $endDate =  $now->format('Y-m-d');
    
    $optParams = array(
        'metric' => array('PAGE_VIEWS'),
        'dimension' => array('COUNTRY_NAME'),
        'sort' => 'COUNTRY_NAME'
    );
    // Retrieve report.
    $report = $service->reports
             ->generate($startDate, $endDate, $optParams);
    $data = $report['rows'];
    // We need to convert the metrics to numeric values for the chart.
    foreach ($data as &$row) {
      $row[1] = (int)$row[1];
    }
    $data = json_encode($data);
    $columns = array(
      array('string', 'Country name'),
      array('number', 'Page views'),
    );
    $type = 'GeoChart';
    $options = json_encode(array());
    print generateChartHtml($data, $columns, $type, $options);
  }
}

