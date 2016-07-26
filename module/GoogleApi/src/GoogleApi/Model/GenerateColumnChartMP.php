<?php
namespace GoogleApi\Model;
use Zend\Session\Container;
use Google_Service; 
require_once 'htmlHelper.php';

/**
 * Generates a Column Chart for a report.
 *
 * @author Silvano Luciani <silvano.luciani@gmail.com>
 */
class GenerateColumnChartMP  {
	
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
  	$session = new Container('GenerateColumnChart');
  	$sixMonthsAgo = new \DateTime('-6 months'); 
    $startDate = $sixMonthsAgo->format('Y-m-d');
    
    $now = new \DateTime(); 
    $endDate =  $now->format('Y-m-d');
    
    # 'COST_PER_CLICK' ,'EARNINGS'
    
    $optParams = array(
        'metric' => array('PAGE_VIEWS', 'AD_REQUESTS', 'MATCHED_AD_REQUESTS',  'INDIVIDUAL_AD_IMPRESSIONS'),
        'dimension' => array('MONTH'),
        'sort' => 'MONTH'
    );
    // Retrieve report.
    $report = $service->reports
             ->generate($startDate, $endDate, $optParams);
     
     $session->offsetSet('GenerateColumnChart_report_all', $report);
             
    $data = $report['rows'];
    // We need to convert the metrics to numeric values for the chart.
    if(!empty($data)) {
		    foreach ($data as &$row) {
		      $row[1] = (int)$row[1];
		      $row[2] = (int)$row[2];
		      $row[3] = (int)$row[3];
		      $row[4] = (int)$row[4]; 
		    }
		    $data = json_encode($data);
		    
		    $session->offsetSet('GenerateColumnChart_report_data_json', $data);
		    
		    $columns = array(
		      array('string', 'Month'),
		      array('number', 'Page views'),
		      array('number', 'Ad requests'),
		      array('number', 'Matched ad requests'),
		      array('number', 'Individual ad impressions'), 
		    );
		     
		    $session->offsetSet('GenerateColumnChart_report_data_colum', $columns);
		    
		    $type = 'ColumnChart';
		    $session->offsetSet('GenerateColumnChart_report_data_type', $type);
		    
		    $options = json_encode(
		        array('title' => 'Performances per month')
		    );
		    $session->offsetSet('GenerateColumnChart_report_data_options', $options);
		   # print generateChartHtml($data, $columns, $type, $options);
      } # end not Empty
      else  {
      	#print "No Data Report Column Chart";
      	#echo "</br>";
      }
  }
}

