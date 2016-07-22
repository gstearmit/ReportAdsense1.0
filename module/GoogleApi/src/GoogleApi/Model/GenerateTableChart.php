<?php
namespace GoogleApi\Model;
use Google_Service;
require_once 'htmlHelper.php';
 
class GenerateTableChart   {
  public function render($service, $accountId, $adClientId) { 
  	$separator = str_repeat('=', 80) . "\n";
  	print $separator;
  	printf(" GenerateTableChart for ad client %s\n", $adClientId);
  	 
  	
  	$sixMonthsAgo = new \DateTime('-6 months'); 
    $startDate = $sixMonthsAgo->format('Y-m-d');
    
    $now = new \DateTime(); 
    $endDate =  $now->format('Y-m-d');
    
    
    $optParams = array(
        'metric' => array('AD_REQUESTS', 'MATCHED_AD_REQUESTS',
            'INDIVIDUAL_AD_IMPRESSIONS'),
        'dimension' => array('AD_CLIENT_ID'),
        'sort' => 'AD_CLIENT_ID'
    );
    // Retrieve report.
    $report = $service->reports
             ->generate($startDate, $endDate, $optParams);
    $data = $report['rows'];
    // We need to convert the metrics to numeric values for the chart.
    foreach ($data as &$row) {
      $row[1] = (int)$row[1];
      $row[2] = (int)$row[2];
      $row[3] = (int)$row[3];
    }
    $data = json_encode($data);
    $columns = array(
      array('string', 'Ad client id'),
      array('number', 'Ad requests'),
      array('number', 'Matched ad requests'),
      array('number', 'Individual ad impressions')
    );
    $type = 'Table';
    $options = json_encode(array());
    print generateChartHtml($data, $columns, $type, $options);
  }
}

