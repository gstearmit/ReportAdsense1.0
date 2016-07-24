<?php
namespace GoogleApi\Model;
use Google_Service; 
require_once 'htmlHelper.php';

/**
 * Generates a Column Chart for a report.
 *
 * @author Silvano Luciani <silvano.luciani@gmail.com>
 */
class GenerateColumnChart  {
	
	public  $adSenseService;
	public  $dateFormat = 'Y-m-d';
	
	/**
	 * Inject the dependency.
	 * @param Google_Service $adSenseService an authenticated instance
	 *     of Google_Service
	 */
// 	public function __construct(Google_Service $adSenseService) {
// 		$this->adSenseService = $adSenseService;
// 	}
	
	/**
	 * Get the date for the instant of the call.
	 * @return string the date in the format expressed by $this->dateFormat
	 */
	public function getNow() {
		$now = new DateTime();
		return $now->format($this->dateFormat);
	}
	
	/**
	 * Get the date six month before the instant of the call.
	 * @return string the date in the format expressed by $this->dateFormat
	 */
	public function getSixMonthsBeforeNow() {
		$sixMonthsAgo = new DateTime('-6 months');
		return $sixMonthsAgo->format($this->dateFormat);
	}
	
	/**
	 * Implemented in the specific example class.
	 */
	
  public function render($service, $accountId, $adClientId) {
  	
  	$separator = str_repeat('=', 80) . "\n";
  	print $separator;
  	printf(" GenerateColumnChart for ad client %s\n", $adClientId);
  	print $separator;
  	
  	$sixMonthsAgo = new \DateTime('-6 months'); 
    $startDate = $sixMonthsAgo->format('Y-m-d');
    
    $now = new \DateTime(); 
    $endDate =  $now->format('Y-m-d');
    
    # 'COST_PER_CLICK' ,'EARNINGS'
    
    $optParams = array(
        'metric' => array('PAGE_VIEWS', 'AD_REQUESTS', 'MATCHED_AD_REQUESTS',  'INDIVIDUAL_AD_IMPRESSIONS','COST_PER_CLICK'),
        'dimension' => array('MONTH'),
        'sort' => 'MONTH'
    );
    // Retrieve report.
    $report = $service->reports
             ->generate($startDate, $endDate, $optParams);
    
       echo "</br> ------------report --------------- </br> ";
       echo "<pre>";
       print_r($report);
       echo "</pre>";

     # Get C        
             
             
    $data = $report['rows'];
    // We need to convert the metrics to numeric values for the chart.
    foreach ($data as &$row) {
      $row[1] = (int)$row[1];
      $row[2] = (int)$row[2];
      $row[3] = (int)$row[3];
      $row[4] = (int)$row[4];
      $row[5] = (double)$row[5];
    }
    $data = json_encode($data);
    $columns = array(
      array('string', 'Month'),
      array('number', 'Page views'),
      array('number', 'Ad requests'),
      array('number', 'Matched ad requests'),
      array('number', 'Individual ad impressions'),
      array('number', 'COST PER CLICK')
    );
    $type = 'ColumnChart';
    $options = json_encode(
      array('title' => 'Performances per month')
    );
    print generateChartHtml($data, $columns, $type, $options);
  }
}

