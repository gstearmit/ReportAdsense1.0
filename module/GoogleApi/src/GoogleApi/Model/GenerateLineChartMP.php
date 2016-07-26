<?php
namespace GoogleApi\Model;
use Zend\Session\Container;
use Google_Service;
require_once 'htmlHelper.php';

class GenerateLineChartMP {
  public function  render($service, $accountId, $adClientId) { 
  	$session = new Container('GenerateLineChart');
  	$sixMonthsAgo = new \DateTime('-6 months'); 
    $startDate = $sixMonthsAgo->format('Y-m-d');
    
    $now = new \DateTime(); 
    $endDate =  $now->format('Y-m-d');
    
    $optParams = array(
        'metric' => array('PAGE_VIEWS', 'AD_REQUESTS', 'MATCHED_AD_REQUESTS',
            'INDIVIDUAL_AD_IMPRESSIONS'),
        'dimension' => array('MONTH'),
        'sort' => 'MONTH'
    );
    // Retrieve report.
    $report = $service->reports
        ->generate($startDate, $endDate, $optParams);
    $session->offsetSet('GenerateLineChart_report_all', $report);
    if(!empty($data)) {
		    $data = $report['rows'];
		    // We need to convert the metrics to numeric values for the chart.
		    foreach ($data as &$row) {
		      $row[1] = (int)$row[1];
		      $row[2] = (int)$row[2];
		      $row[3] = (int)$row[3];
		      $row[4] = (int)$row[4];
		    }
		    $data = json_encode($data);
		    $session->offsetSet('GenerateLineChart_report_all_data_json', $data);
		    $columns = array(
		      array('string', 'Month'),
		      array('number', 'Page views'),
		      array('number', 'Ad requests'),
		      array('number', 'Matched ad requests'),
		      array('number', 'Individual ad impressions')
		    );
		    $session->offsetSet('GenerateLineChart_report_all_data_colum', $columns);
		    $type = 'LineChart';
		    $session->offsetSet('GenerateLineChart_report_all_data_type', $type);
		    $options = json_encode(
		      array('title' => 'Performances per month')
		    );
		    $session->offsetSet('GenerateLineChart_report_all_data_options', $options);
		    # print generateChartHtml($data, $columns, $type, $options);
	  } else  {
		    	# print "No Data Report Line Chart";
		    	# echo "</br>";
		    } 		    
  }
}

