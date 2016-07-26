<?php
/**
 * @Hoang Phuc
 */

/** 
 * Tags: accounts.customchannels.list
 */

namespace GoogleApi\Model;
use Zend\Session\Container;
class GetAllCustomChannelsMP {
  /**
   * Gets all custom channels in an ad client.
   *
   * @param $service Google_Service_AdSense AdSense service object on which to
   *     run the requests.
   * @param $accountId string the ID for the account to be used.
   * @param $adClientId string the ID for the ad client to be used.
   * @param $maxPageSize int the maximum page size to retrieve.
   * @return array the last page of retrieved custom channels.
   */
  public static function run($service, $accountId, $adClientId, $maxPageSize) {
  	$session = new Container('AllCustomChannels');
    $optParams['maxResults'] = $maxPageSize; 
    $pageToken = null;
    $customChannels = null;
    do {
      $optParams['pageToken'] = $pageToken;
      $result = $service->accounts_customchannels->listAccountsCustomchannels(
          $accountId, $adClientId, $optParams);
      if (!empty($result['items'])) {
        $customChannels = $result['items'];
        $session->offsetSet('AllCustomChannels', $customChannels );
        foreach ($customChannels as $customChannel) {
          # printf("Custom channel with code \"%s\" and name \"%s\" was found.\n",  $customChannel['code'], $customChannel['name']);
          $session->offsetSet('AllCustomChannels_code',$customChannel['code'] );
          $session->offsetSet('AllCustomChannels_name',$customChannel['name'] );
        }
        if (isset($result['nextPageToken'])) {
          $pageToken = $result['nextPageToken'];
        }
      } else {
      	$customChannels = null;
        # print "No custom channels found.\n";
      }
    } while ($pageToken);
    

    return $customChannels;
  }
}
