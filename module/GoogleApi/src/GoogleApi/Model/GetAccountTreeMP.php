<?php
/*
 * Copyright 2016 Hoang Phuc. 
 */

/**
 * Gets a specific account for the logged in user.
 * This includes the full tree of sub-accounts.
 *
 * Tags: accounts.get
 */

namespace GoogleApi\Model;
use Zend\Session\Container;
class GetAccountTreeMP {
  /**
   * Gets a specific account for the logged in user.
   *
   * @param $service Google_Service_AdSense AdSense service object on which to
   *     run the requests.
   * @param $accountId string the ID for the account to be used.
   */
  public static function run($service, $accountId) {
  	$session = new Container('GetAccountTree');
    $optParams = array('tree' => true); 
    $account = $service->accounts->get($accountId, $optParams);
    self::displayTree($account, 0); 
    
  }

  /**
   * Auxiliary method to recurse through the account tree, displaying it.
   */
  private static function displayTree($parentAccount, $level) {
    print str_repeat(' ', $level);
    # printf("Account with ID \"%s\" and name \"%s\" was found.\n",  $parentAccount['id'], $parentAccount['name']); 
    if (!empty($parentAccount['subAccounts'])) {
      foreach ($subAccounts as $subAccount) {
        self::displayTree($subAccount, $level + 1);
      }
    }
  }
}
