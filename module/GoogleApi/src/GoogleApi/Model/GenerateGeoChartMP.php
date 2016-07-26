<?php
namespace GoogleApi\Model;
use Zend\Session\Container;
use Google_Service; 
require_once 'htmlHelper.php';

 
class GenerateGeoChartMP  {
  public function render($service, $accountId, $adClientId) { 
  	$session = new Container('GenerateGeoChart');
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
    
    $session->offsetSet('GenerateGeoChart_report_all', $report);
    $data = $report['rows'];
    // We need to convert the metrics to numeric values for the chart.
    if(!empty($data)) {
	    foreach ($data as &$row) {
	      $row[1] = (int)$row[1];
	    }
	    $data = json_encode($data);
	    $session->offsetSet('GenerateGeoChart_report_all_data_json', $data);
	    $columns = array(
	      array('string', 'Country name'),
	      array('number', 'Page views'),
	    );
	    $session->offsetSet('GenerateGeoChart_report_all_data_colum', $columns);
	    $type = 'GeoChart';
	    $session->offsetSet('GenerateGeoChart_report_all_data_type', $type);
	    $options = json_encode(array());
	    $session->offsetSet('GenerateGeoChart_report_all_data_options', $options);
	    # print generateChartHtml($data, $columns, $type, $options);
     } else  {
	    	# print "No Data Report Geo Chart";
	    	# echo "</br>";
	    }  
  }
}

