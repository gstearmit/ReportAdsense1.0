<?php
/**
 * @Hoang Phuc
 */

/** 
 * Tags: accounts.customchannels.adunits.list
 */

namespace GoogleApi\Model;
use Zend\Session\Container;

class GetAllAdUnitsForCustomChannelMP {
  /**
   * Gets all ad units corresponding to a specified custom channel.
   *
   * @param $service Google_Service_AdSense AdSense service object on which to
   *     run the requests.
   * @param $accountId string the ID for the account to be used.
   * @param $adClientId string the ID for the ad client to be used.
   * @param $customChannelId string the ID for the custom channel to be used.
   * @param $maxPageSize int the maximum page size to retrieve.
   */
  public static function run($service, $accountId, $adClientId, $customChannelId, $maxPageSize) {
  	$session = new Container('AllAdUnitsForCustomChannel');
    $optParams['maxResults'] = $maxPageSize; 
    $pageToken = null;
    $adUnits = null;
    do {
      $optParams['pageToken'] = $pageToken;

      $adUnitResource = $service->accounts_customchannels_adunits;
      $result = $adUnitResource->listAccountsCustomchannelsAdunits($accountId,  $adClientId, $customChannelId, $optParams);
      if (!empty($result['items'])) {
        $adUnits = $result['items'];
        $session->offsetSet('AllAdUnitsForCustomChannel', $adUnits );
        foreach ($adUnits as $adUnit) {
         # $format = "Ad unit with code \"%s\", name \"%s\" and status \"%s\"" . " was found.\n";
         # printf($format, $adUnit['code'], $adUnit['name'], $adUnit['status']);
        	$session->offsetSet('AllAdUnitsForCustomChannel_code', $adUnit['code'] );
        	$session->offsetSet('AllAdUnitsForCustomChannel_name', $adUnit['name'] );
        	$session->offsetSet('AllAdUnitsForCustomChannel_status', $adUnit['status']); 
        }
        if (isset($result['nextPageToken'])) {
          $pageToken = $result['nextPageToken'];
        }
      } else {
      	$adUnits = null;
        # print "No ad units found.\n";
      }
    } while ($pageToken);
     
  }
}
