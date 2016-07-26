<?php
/**
 * @Hoang Phuc
 */

/** 
 * Tags: accounts.adunits.customchannels.list
 */

namespace GoogleApi\Model;
use Zend\Session\Container;

class GetAllCustomChannelsForAdUnitMP {
  /**
   * Gets all custom channels an ad unit has been added to.
   *
   * @param $service Google_Service_AdSense AdSense service object on which to
   *     run the requests.
   * @param $accountId string the ID for the account to be used.
   * @param $adClientId string the ID for the ad client to be used.
   * @param $adUnitId string the ID for the ad unit to be used.
   * @param $maxPageSize int the maximum page size to retrieve.
   */
  public static function run($service, $accountId, $adClientId, $adUnitId,$maxPageSize) {
  	$session = new Container('AllCustomChannelsForAdUnit');
    $optParams['maxResults'] = $maxPageSize; 
    $pageToken = null;
    $customChannels = null;
    do {
      $optParams['pageToken'] = $pageToken;

      $customChannelResource = $service->accounts_adunits_customchannels;
      $result = $customChannelResource->listAccountsAdunitsCustomchannels(  $accountId, $adClientId, $adUnitId, $optParams);
      if (!empty($result['items'])) {
        $customChannels = $result['items'];
        $session->offsetSet('AllCustomChannelsForAdUnit', $customChannels );
        foreach ($customChannels as $customChannel) {
          # printf("Custom channel with code \"%s\" and name \"%s\" was found.\n", $customChannel['code'], $customChannel['name']);
        	$session->offsetSet('AllCustomChannelsForAdUnit_code', $customChannel['code'] );
        	$session->offsetSet('AllCustomChannelsForAdUnit_name', $customChannel['name'] );
        }
        if (isset($result['nextPageToken'])) {
          $pageToken = $result['nextPageToken'];
        }
      } else {
      	$customChannels = null;
        # print "No custom channels found.\n";
      }
    } while ($pageToken);
   # print "\n";
  }
}
