<?php 
namespace GoogleApi\Model;

class GetAllAccounts {
  /**
   * Gets all accounts for the logged in user.
   *
   * @param $service Google_Service_AdSense AdSense service object on which to
   *     run the requests.
   * @param $maxPageSize int the maximum page size to retrieve.
   * @return array the last page of retrieved accounts.
   */
  public static function run($service, $maxPageSize) {
    $separator = str_repeat('=', 80) . "\n";
    print $separator;
    print "Listing all AdSense accounts\n";
    print $separator;

    $optParams['maxResults'] = $maxPageSize;

    $pageToken = null;
    do {
      $optParams['pageToken'] = $pageToken;
      $result = $service->accounts->listAccounts($optParams);
      $accounts = null;
      if (!empty($result['items'])) {
        $accounts = $result['items'];
        foreach ($accounts as $account) {
          printf("Account with ID \"%s\" and name \"%s\" was found.\n",$account['id'], $account['name']);
        }
        if (isset($result['nextPageToken'])) {
          $pageToken = $result['nextPageToken'];
        }
      } else {
        print "No accounts found.\n";
      }
    } while ($pageToken);
    print "\n";

    return $accounts;
  }
}
