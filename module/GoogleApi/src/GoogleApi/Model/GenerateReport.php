<?php 

/**
 * Retrieves a report for the specified ad client.
 *
 * Tags: accounts.reports.generate
 */

namespace GoogleApi\Model;

class GenerateReport {
  /**
   * Retrieves a report for the specified ad client.
   *
   * @param $service Google_Service_AdSense AdSense service object on which to
   *     run the requests.
   * @param $accountId string the ID for the account to be used.
   * @param $adClientId string the ad client ID on which to run the report.
   */
  public static function run($service, $accountId, $adClientId) {
    $separator = str_repeat('=', 80) . "\n";
    print $separator;
    printf("Running report for ad client %s\n", $adClientId);
    print $separator;

    $startDate = 'today-7d';
    $endDate = 'today-1d';

    $optParams = array(
      'metric' => array(
        'PAGE_VIEWS', 'AD_REQUESTS', 'AD_REQUESTS_COVERAGE', 'CLICKS',
        'AD_REQUESTS_CTR', 'COST_PER_CLICK', 'AD_REQUESTS_RPM', 'EARNINGS'),
      'dimension' => 'DATE',
      'sort' => '+DATE',
      'filter' => array(
        'AD_CLIENT_ID==' . $adClientId
      )
    );

    // Run report.
    $report = $service->accounts_reports->generate($accountId, $startDate,
        $endDate, $optParams);

    if (isset($report) && isset($report['rows'])) {
      // Display headers.
      foreach($report['headers'] as $header) {
        printf('%25s', $header['name']);
      }
      print "\n";

      // Display results.
      foreach($report['rows'] as $row) {
        foreach($row as $column) {
          printf('%25s', $column);
        }
        print "\n";
      }
    } else {
      print "No rows returned.\n";
    }

    print "\n";
  }
}
