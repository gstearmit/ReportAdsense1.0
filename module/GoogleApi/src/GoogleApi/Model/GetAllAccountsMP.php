<?php 
/**
 * @Hoang Phuc
 */
namespace GoogleApi\Model;
use Zend\Session\Container;

class GetAllAccountsMP {
  /**
   * Gets all accounts for the logged in user.
   *
   * @param $service Google_Service_AdSense AdSense service object on which to
   *     run the requests.
   * @param $maxPageSize int the maximum page size to retrieve.
   * @return array the last page of retrieved accounts.
   */
  public static function run($service, $maxPageSize) {
  	$session = new Container('AllAccounts');
    $optParams['maxResults'] = $maxPageSize;

    $pageToken = null;
    do {
      $optParams['pageToken'] = $pageToken;
      $result = $service->accounts->listAccounts($optParams);
      $accounts = null;
      if (!empty($result['items'])) {
        $accounts = $result['items'];
        $session->offsetSet('AllAccounts', $accounts );
        foreach ($accounts as $account) {  
        	# printf("Account with ID \"%s\" and name \"%s\" was found.\n",$account['id'], $account['name']); 
        	$session->offsetSet('Accounts_id', $account['id'] );
        	$session->offsetSet('Accounts_name', $account['name'] );
        }
        if (isset($result['nextPageToken'])) {
          $pageToken = $result['nextPageToken'];
        }
      } else {
      	$accounts = null;
      	#$session->offsetSet('AllAccounts', $accounts );
        #print "No accounts found.\n";
      }
    } while ($pageToken);
    #print "\n";

    return $accounts;
  }
}
