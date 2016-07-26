<?php
/**
 * @Hoang Phuc
 */

/**  
 * Tags: accounts.adclients.list
 */

namespace GoogleApi\Model;
use Zend\Session\Container;

class GetAllAdClientsMP {
  /**
   * Gets all ad clients for the specified account.
   *
   * @param $service Google_Service_AdSense AdSense service object on which to
   *     run the requests.
   * @param $accountId string the ID for the account to be used.
   * @param $maxPageSize int the maximum page size to retrieve.
   * @return array the last page of retrieved ad clients.
   */
  public static function run($service, $accountId, $maxPageSize) {
  	$session = new Container('AllAdClients');
    $optParams['maxResults'] = $maxPageSize;

    $pageToken = null;
    $adClients = null;
    do {
      $optParams['pageToken'] = $pageToken;
      $result = $service->accounts_adclients->listAccountsAdclients($accountId,$optParams);
      if (!empty($result['items'])) {
        $adClients = $result['items'];
        $session->offsetSet('GetAllAdClients', $adClients );
        foreach ($adClients as $adClient) {
           # printf("Ad client for product \"%s\" with ID \"%s\" was found.\n", $adClient['productCode'], $adClient['id']);
        	$session->offsetSet('AllAdClients_productCode', $adClient['productCode'] );
        	$session->offsetSet('AllAdClients_id', $adClient['id']);
        }
        if (isset($result['nextPageToken'])) {
          $pageToken = $result['nextPageToken'];
        }
      } else {
      	$adClients = null;
        # print "No ad clients found.\n";
      }
    } while ($pageToken);
   # print "\n";

    return $adClients;
  }
}
