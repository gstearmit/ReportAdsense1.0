<?php
 
namespace GoogleApi\Model;
use Google_Service;
require_once 'htmlHelper.php';
/**
 * Include the AdSense service class and the HTML generation functions.
 */
# require_once "../../src/contrib/Google_Service.php"; 
# require_once("Google/Service.php");


 
 
abstract class BaseExample {
  protected $adSenseService;
  protected $dateFormat = 'Y-m-d';

  /**
   * Inject the dependency.
   * @param Google_Service $adSenseService an authenticated instance
   *     of Google_Service
   */
  public function __construct(Google_Service $adSenseService) {
    $this->adSenseService = $adSenseService;
  }

  /**
   * Get the date for the instant of the call.
   * @return string the date in the format expressed by $this->dateFormat
   */
  protected function getNow() {
    $now = new DateTime();
    return $now->format($this->dateFormat);
  }

  /**
   * Get the date six month before the instant of the call.
   * @return string the date in the format expressed by $this->dateFormat
   */
  protected function getSixMonthsBeforeNow() {
    $sixMonthsAgo = new DateTime('-6 months');
    return $sixMonthsAgo->format($this->dateFormat);
  }

  /**
   * Implemented in the specific example class.
   */
  abstract public function render();

}

