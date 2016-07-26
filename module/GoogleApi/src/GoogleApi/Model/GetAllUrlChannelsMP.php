<?php
/**
 * @Hoang Phuc
 */

/** 
 * Tags: accounts.urlchannels.list
 */

namespace GoogleApi\Model;
use Zend\Session\Container;

class GetAllUrlChannelsMP {
  /**
   * Gets all URL channels in an ad client.
   *
   * @param $service Google_Service_AdSense AdSense service object on which to
   *     run the requests.
   * @param $accountId string the ID for the account to be used.
   * @param $adClientId string the ID for the ad client to be used.
   * @param $maxPageSize int the maximum page size to retrieve.
   */
  public static function run($service, $accountId, $adClientId, $maxPageSize) {
  	$session = new Container('AllUrlChannels'); 
    $optParams['maxResults'] = $maxPageSize; 
    $pageToken = null;
    $urlChannels = null;
    do {
      $optParams['pageToken'] = $pageToken;
      $result = $service->accounts_urlchannels->listAccountsUrlchannels(  $accountId, $adClientId, $optParams);
      if (!empty($result['items'])) {
        $urlChannels = $result['items'];
        $session->offsetSet('AllUrlChannels', $urlChannels );
        foreach ($urlChannels as $urlChannel) {
             # printf("URL channel with URL pattern \"%s\" was found.\n",  $urlChannel['urlPattern']);
        	$session->offsetSet('AllUrlChannels_urlPattern',$urlChannel['urlPattern'] );
        }
        if (isset($result['nextPageToken'])) {
          $pageToken = $result['nextPageToken'];
        }
      } else {
      	$urlChannels = null;
       # print "No URL channels found.\n";
      }
    } while ($pageToken);
    
  }
}
