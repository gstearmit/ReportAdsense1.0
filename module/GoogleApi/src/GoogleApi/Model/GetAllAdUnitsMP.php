<?php
/*
 * Copyright 2016 Hoang Phuc. 
 */
 

namespace GoogleApi\Model;
use Zend\Session\Container;

class GetAllAdUnitsMP {
  /**
   * Gets all ad units in an ad client.
   *
   * @param $service Google_Service_AdSense AdSense service object on which to
   *     run the requests.
   * @param $accountId string the ID for the account to be used.
   * @param $adClientId string the ID for the ad client to be used.
   * @param $maxPageSize int the maximum page size to retrieve.
   * @return array the last page of retrieved ad units.
   */
  public static function run($service, $accountId, $adClientId, $maxPageSize) { 
  	$session = new Container('GetAllAdUnits');
   
    $optParams['maxResults'] = $maxPageSize; 
    $pageToken = null;
    $adUnits = null;
    do {
      $optParams['pageToken'] = $pageToken;
      $result = $service->accounts_adunits->listAccountsAdunits($accountId, $adClientId, $optParams);
      if (!empty($result['items'])) {
        $adUnits = $result['items'];
        $session->offsetSet('AllAdUnits', $adUnits );
           # foreach ($adUnits as $adUnit) { printf($format, $adUnit['code'], $adUnit['name'], $adUnit['status']); }
        if (isset($result['nextPageToken'])) {
        	$pageToken = $result['nextPageToken'];
        }
       } else {
          #  print "No ad units found.\n";
      	$adUnits = null;
      	  # $session->offsetSet('AllAdUnits', $adUnits );
      }
    } while ($pageToken);
   
    return $adUnits;
  }
}
