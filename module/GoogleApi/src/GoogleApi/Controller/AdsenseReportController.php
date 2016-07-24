<?php

namespace GoogleApi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

// require_once("Google/autoload.php");
use Google_Client;
use Google_Service_AdSense;
use Google_Service_Drive;

// Error Mail
/*
 * CopyRight @ Hoang Phuc
 */

// Get All Service;
use GoogleApi\Service\GenerateReport;
// Ens Get All Service;


class AdsenseReportController extends AbstractActionController {
	 
	public function SetParamAdsenseAction() {
		
		# http://localhost:8090/file-upload-examples/multi-html5
		
		// https://developers.google.com/api-client-library/php/auth/web-app 
		$authUrl = '';
		// Set up authentication.
		$client = new Google_Client ();
		$client->addScope ( 'https://www.googleapis.com/auth/adsense.readonly' );
		$client->setAccessType ( 'offline' );
		
		// Be sure to replace the contents of client_secrets.json with your developer
		// credentials.
		 
		$filename_client = __DIR__ . '/../data/client_secrets2.json';
		$File_json      = __DIR__ . '/../data/'.'client_secret_396827155016-pp6a3h6ldj6dn7f1cef9ujoln1o75tn0.apps.googleusercontent.com.json';
		
		if (file_exists ( $filename_client )) {
			$client->setAuthConfigFile ( $filename_client );
		} else {
			die ( "Erro Get Client Secrets" );
		}
		
		// Create service.
		$service = new Google_Service_AdSense ( $client );
		
		// If we're logging out we just need to clear our local access token.
		// Note that this only logs you out of the session. If STORE_ON_DISK is
		// enabled and you want to remove stored data, delete the file.
		if (isset ( $_REQUEST ['logout'] )) {
			unset ( $_SESSION ['access_token'] );
		}
		
		// If we have a code back from the OAuth 2.0 flow, we need to exchange that
		// with the authenticate() function. We store the resultant access token
		// bundle in the session (and disk, if enabled), and redirect to this page.
		if (isset ( $_GET ['code'] )) {
			$client->authenticate ( $_GET ['code'] );
			// Note that "getAccessToken" actually retrieves both the access and refresh
			// tokens, assuming both are available.
			$_SESSION ['access_token'] = $client->getAccessToken ();
			if (STORE_ON_DISK) {
				@file_put_contents ( TOKEN_FILENAME, $_SESSION ['access_token'] );
			}
			// $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			// http://localhost:8082/adsense-sample.php
			$redirect = 'http://localhost:8090/google-api/login-authen';
			header ( 'Location: ' . filter_var ( $redirect, FILTER_SANITIZE_URL ) );
			exit ();
		}
		
		// If we have an access token, we can make requests, else we generate an
		// authentication URL.
		
		 
		
		if (isset ( $_SESSION ['access_token'] ) && $_SESSION ['access_token']) {
			$client->setAccessToken ( $_SESSION ['access_token'] );
			 
		} else if (STORE_ON_DISK && file_exists ( TOKEN_FILENAME ) && @filesize ( TOKEN_FILENAME ) > 0) {
			// Note that "setAccessToken" actually sets both the access and refresh token,
			// assuming both were saved.
			$client->setAccessToken ( file_get_contents ( TOKEN_FILENAME ) );
			$_SESSION ['access_token'] = $client->getAccessToken ();
		} else {
			// If we're doing disk storage, generate a URL that forces user approval.
			// This is the only way to guarantee we get back a refresh token.
			if (STORE_ON_DISK) {
				$client->setApprovalPrompt ( 'force' );
			}
			$authUrl = $client->createAuthUrl ();
		} 
		
	 
// 		echo '<div><div class="request">';
// 		if (isset($authUrl)) {
// 			echo '<a class="login" href="' . $authUrl . '">Connect Me!</a>';
// 		} else {
// 			echo '<a class="logout" href="?logout">Logout</a>';
// 		};
// 		echo '</div>';
		 
		
		if ($client->getAccessToken())
		{
			echo '<pre class="result">';
			 
			# Start makeRequests($service);
			
// 			@spl_autoload_register(function ($class_name) {
// 				# include __DIR__.'/../examples/' . $class_name . '.php';
// 			}); 
				# include __DIR__.'/../examples/GetAllAccounts.php';
				print "\n";
			
				$GetAllAccounts = new \GoogleApi\Model\GetAllAccounts;
				$accounts = $GetAllAccounts::run($service, MAX_LIST_PAGE_SIZE);
 
				if (isset($accounts) && !empty($accounts)) {
					// Get an example account ID, so we can run the following sample.
					$exampleAccountId = $accounts[0]['id'];
					
					$GetAccountTree = new \GoogleApi\Model\GetAccountTree;
					$GetAccountTree::run($service, $exampleAccountId);
			
					$GetAllAdClients = new \GoogleApi\Model\GetAllAdClients;
					$adClients       = $GetAllAdClients::run($service, $exampleAccountId, MAX_LIST_PAGE_SIZE);
			
					if (isset($adClients) && !empty($adClients)) {
						// Get an ad client ID, so we can run the rest of the samples.
						$exampleAdClient = end($adClients);
						$exampleAdClientId = $exampleAdClient['id'];
			
						$GetAllAdUnits  = new \GoogleApi\Model\GetAllAdUnits;
						$adUnits        = $GetAllAdUnits::run($service, $exampleAccountId, $exampleAdClientId, MAX_LIST_PAGE_SIZE);
						if (isset($adUnits) && !empty($adUnits)) {
							// Get an example ad unit ID, so we can run the following sample.
							$exampleAdUnitId = $adUnits[0]['id'];
			
							$GetAllCustomChannelsForAdUnit = new \GoogleApi\Model\GetAllCustomChannelsForAdUnit;
							$GetAllCustomChannelsForAdUnit::run($service, $exampleAccountId, $exampleAdClientId, $exampleAdUnitId, MAX_LIST_PAGE_SIZE);
						} else {
							print 'No ad units found, unable to run dependant example.';
						}
			
						$GetAllCustomChannels  = new \GoogleApi\Model\GetAllCustomChannels;
						$customChannels        = $GetAllCustomChannels::run($service, $exampleAccountId,  $exampleAdClientId, MAX_LIST_PAGE_SIZE);
						if (isset($customChannels) && !empty($customChannels)) {
							// Get an example ad unit ID, so we can run the following sample.
							$exampleCustomChannelId = $customChannels[0]['id'];
			
							$GetAllAdUnitsForCustomChannel = new \GoogleApi\Model\GetAllAdUnitsForCustomChannel;
							$GetAllAdUnitsForCustomChannel::run($service, $exampleAccountId,  $exampleAdClientId, $exampleCustomChannelId, MAX_LIST_PAGE_SIZE);
						} else {
							print 'No custom channels found, unable to run dependant example.';
						}
			
						$GetAllUrlChannels = new \GoogleApi\Model\GetAllUrlChannels;
						$GetAllUrlChannels::run($service, $exampleAccountId, $exampleAdClientId,
								MAX_LIST_PAGE_SIZE);
						
						$GenerateReport = new \GoogleApi\Model\GenerateReport;
						$GenerateReport::run($service, $exampleAccountId, $exampleAdClientId);
						
						$GenerateReportWithPaging = new \GoogleApi\Model\GenerateReportWithPaging;
						$GenerateReportWithPaging::run($service, $exampleAccountId,
								$exampleAdClientId, MAX_REPORT_PAGE_SIZE);
						
						$FillMissingDatesInReport = new \GoogleApi\Model\FillMissingDatesInReport;
						$FillMissingDatesInReport::run($service, $exampleAccountId,
								$exampleAdClientId);
						
						$CollateReportData = new \GoogleApi\Model\CollateReportData;
						$CollateReportData::run($service, $exampleAccountId, $exampleAdClientId);
					} else {
						print 'No ad clients found, unable to run dependant examples.';
					}
			
					$GetAllSavedReports = new \GoogleApi\Model\GetAllSavedReports;
					$savedReports = $GetAllSavedReports::run($service, $exampleAccountId,
							MAX_LIST_PAGE_SIZE);
					if (isset($savedReports) && !empty($savedReports)) {
						// Get an example saved report ID, so we can run the following sample.
						$exampleSavedReportId = $savedReports[0]['id'];
						
						$GenerateSavedReport = new \GoogleApi\Model\GenerateSavedReport;
						$GenerateSavedReport::run($service, $exampleAccountId,
								$exampleSavedReportId);
					} else {
						print 'No saved reports found, unable to run dependant example.';
					}
			
					$GetAllSavedAdStyles = new \GoogleApi\Model\GetAllSavedAdStyles;
					$GetAllSavedAdStyles::run($service, $exampleAccountId, MAX_LIST_PAGE_SIZE);
					
					$GetAllAlerts = new \GoogleApi\Model\GetAllAlerts;
					$GetAllAlerts::run($service, $exampleAccountId);
				} else {
					'No accounts found, unable to run dependant examples.';
				}
			
				$GetAllDimensions = new \GoogleApi\Model\GetAllDimensions;
				$GetAllDimensions::run($service);
				$GetAllMetrics = new \GoogleApi\Model\GetAllMetrics;
				$GetAllMetrics::run($service);
			
			# End 
			
			# $_SESSION['access_token'] = $client->getAccessToken();
		
			echo '</pre>';
		}
		
		echo '</div>';
		  
		
		// $this->layout ('layout/theme-validate-mp' );
		$view = new ViewModel ( array (
				'authUrl' => $authUrl,
				'client' => $client,
				'filename_client'=>$filename_client,
		) );
		return $view;
	}
	
	
	public function reportcallbackAction() 
	{
	
		# Noty-alert
		$this->flashMessenger()->addSuccessMessage('Success message, bravo!');
		$this->flashMessenger()->addErrorMessage('Error with system, contact us.');
		$this->flashMessenger()->addInfoMessage('Info message, to do whatever...');
		$this->flashMessenger()->addWarningMessage('Warning message to be careful.'); 
		# End Noty Alert
		
		$dir_files_json  = dirname(dirname(dirname(dirname(dirname(__DIR__))))).'/files/';
		
		$session = new Container('User');
		$userId    = $session->offsetGet('userId');
		$userEmail = $session->offsetGet('userEmail');
		$str = $userId.'-'.$userEmail.Hash_token;
		$Token_key_user = md5($str);
		$session->offsetSet('Token_key_user', $Token_key_user);
		$name_json = $Token_key_user.'.json';
		
		$filename_client_json = $dir_files_json.$name_json;
		
		echo "name_json : ".$name_json;
		echo "</br>";
		
		# http://localhost:8090/file-upload-examples/multi-html5
	
		// https://developers.google.com/api-client-library/php/auth/web-app
		$authUrl = '';
		// Set up authentication.
		$client = new Google_Client ();
		$client->addScope ( 'https://www.googleapis.com/auth/adsense.readonly' );
		$client->setAccessType ( 'offline' );
	
		// Be sure to replace the contents of client_secrets.json with your developer
		// credentials.
		
		# tai khoan cez
		$filename_client = __DIR__ . '/../data/client_secret_248018190114-ikfifcdrsah8sbsr3qvh0otph9sgtphf.apps.googleusercontent.com.json';
		  
		if (file_exists ( $filename_client_json )) {
			$client->setAuthConfigFile ( $filename_client_json );
		} else {
			die ( "Error Get Client Secrets" );
		}
	
		// Create service.
		$service = new Google_Service_AdSense ( $client );
	
		// If we're logging out we just need to clear our local access token.
		// Note that this only logs you out of the session. If STORE_ON_DISK is
		// enabled and you want to remove stored data, delete the file.
		if (isset ( $_REQUEST ['logout'] )) {
			unset ( $_SESSION ['access_token'] );
		}
	
		// If we have a code back from the OAuth 2.0 flow, we need to exchange that
		// with the authenticate() function. We store the resultant access token
		// bundle in the session (and disk, if enabled), and redirect to this page.
		if (isset ( $_GET ['code'] )) {
			$client->authenticate ( $_GET ['code'] );
			// Note that "getAccessToken" actually retrieves both the access and refresh
			// tokens, assuming both are available.
			$_SESSION ['access_token'] = $client->getAccessToken ();
			if (STORE_ON_DISK) {
				@file_put_contents ( TOKEN_FILENAME, $_SESSION ['access_token'] );
			}
			// $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			// http://localhost:8082/adsense-sample.php
			$redirect = 'http://localhost:8090/reportcallback';
			header ( 'Location: ' . filter_var ( $redirect, FILTER_SANITIZE_URL ) );
			exit ();
		}
	
		// If we have an access token, we can make requests, else we generate an
		// authentication URL.
	
			
	
		if (isset ( $_SESSION ['access_token'] ) && $_SESSION ['access_token']) {
			$client->setAccessToken ( $_SESSION ['access_token'] );
	
		} else if (STORE_ON_DISK && file_exists ( TOKEN_FILENAME ) && @filesize ( TOKEN_FILENAME ) > 0) {
			// Note that "setAccessToken" actually sets both the access and refresh token,
			// assuming both were saved.
			$client->setAccessToken ( file_get_contents ( TOKEN_FILENAME ) );
			$_SESSION ['access_token'] = $client->getAccessToken ();
		} else {
			// If we're doing disk storage, generate a URL that forces user approval.
			// This is the only way to guarantee we get back a refresh token.
			if (STORE_ON_DISK) {
				$client->setApprovalPrompt ( 'force' );
			}
			$authUrl = $client->createAuthUrl ();
		}
	 
	  # Start Taking Google 	
	  
		echo '<div class="container">
				  <div class="row">
				    <div class="col-sm-12">';
			 
		if ($client->getAccessToken())
		{ 
			
			echo '<ul class="list-group">
				  <li class="list-group-item">';
			       echo '<a class="login" href="' . WEBPATH . '/report-colum-chart"> Report Generate ColumnChart</a>'; 
			echo '</li>';
			echo '<li class="list-group-item">';
			      echo '<a class="login" href="' . WEBPATH . '/report-geo-chart"> Report Generate GeoChart</a>';
			echo '</li>';
			
			echo '<li class="list-group-item">';
			      echo '<a class="login" href="' . WEBPATH . '/report-line-chart"> Report Generate LineChart</a>';
			echo '</li>';
			
			echo '<li class="list-group-item">';
		        	echo '<a class="login" href="' . WEBPATH . '/report-pie-chart"> Report Generate Pie Chart</a>';
			echo '</li>';
			
			echo '<li class="list-group-item">';
			       echo '<a class="login" href="' . WEBPATH . '/report-table-chart"> Report Generate Table Chart</a>';
			echo '</li>'; 
			 
			
			echo '</ul>';
			
			
			echo '</div>';
			echo '<pre class="result">';
	
			# Start makeRequests($service);
				
			// 			@spl_autoload_register(function ($class_name) {
			// 				# include __DIR__.'/../examples/' . $class_name . '.php';
			// 			});
			# include __DIR__.'/../examples/GetAllAccounts.php';
			print "\n";
				
			$GetAllAccounts = new \GoogleApi\Model\GetAllAccounts;
			$accounts = $GetAllAccounts::run($service, MAX_LIST_PAGE_SIZE);
	
			if (isset($accounts) && !empty($accounts)) {
				// Get an example account ID, so we can run the following sample.
				$exampleAccountId = $accounts[0]['id'];
					
				$GetAccountTree = new \GoogleApi\Model\GetAccountTree;
				$GetAccountTree::run($service, $exampleAccountId);
					
				$GetAllAdClients = new \GoogleApi\Model\GetAllAdClients;
				$adClients       = $GetAllAdClients::run($service, $exampleAccountId, MAX_LIST_PAGE_SIZE);
					
				if (isset($adClients) && !empty($adClients)) {
					// Get an ad client ID, so we can run the rest of the samples.
					$exampleAdClient = end($adClients);
					$exampleAdClientId = $exampleAdClient['id'];
						
					$GetAllAdUnits  = new \GoogleApi\Model\GetAllAdUnits;
					$adUnits        = $GetAllAdUnits::run($service, $exampleAccountId, $exampleAdClientId, MAX_LIST_PAGE_SIZE);
					if (isset($adUnits) && !empty($adUnits)) {
						// Get an example ad unit ID, so we can run the following sample.
						$exampleAdUnitId = $adUnits[0]['id'];
							
						$GetAllCustomChannelsForAdUnit = new \GoogleApi\Model\GetAllCustomChannelsForAdUnit;
						$GetAllCustomChannelsForAdUnit::run($service, $exampleAccountId, $exampleAdClientId, $exampleAdUnitId, MAX_LIST_PAGE_SIZE);
					} else {
						print 'No ad units found, unable to run dependant example.';
					}
						
					$GetAllCustomChannels  = new \GoogleApi\Model\GetAllCustomChannels;
					$customChannels        = $GetAllCustomChannels::run($service, $exampleAccountId,  $exampleAdClientId, MAX_LIST_PAGE_SIZE);
					if (isset($customChannels) && !empty($customChannels)) {
						// Get an example ad unit ID, so we can run the following sample.
						$exampleCustomChannelId = $customChannels[0]['id'];
							
						$GetAllAdUnitsForCustomChannel = new \GoogleApi\Model\GetAllAdUnitsForCustomChannel;
						$GetAllAdUnitsForCustomChannel::run($service, $exampleAccountId,  $exampleAdClientId, $exampleCustomChannelId, MAX_LIST_PAGE_SIZE);
					} else {
						print 'No custom channels found, unable to run dependant example.';
					}
						
					$GetAllUrlChannels = new \GoogleApi\Model\GetAllUrlChannels;
					$GetAllUrlChannels::run($service, $exampleAccountId, $exampleAdClientId, MAX_LIST_PAGE_SIZE);
	
					$GenerateReport = new \GoogleApi\Model\GenerateReport;
					$GenerateReport::run($service, $exampleAccountId, $exampleAdClientId);
	
					$GenerateReportWithPaging = new \GoogleApi\Model\GenerateReportWithPaging;
					$GenerateReportWithPaging::run($service, $exampleAccountId, $exampleAdClientId, MAX_REPORT_PAGE_SIZE);
	
					$FillMissingDatesInReport = new \GoogleApi\Model\FillMissingDatesInReport;
					$FillMissingDatesInReport::run($service, $exampleAccountId, $exampleAdClientId);
	
					$CollateReportData = new \GoogleApi\Model\CollateReportData;
					$CollateReportData::run($service, $exampleAccountId, $exampleAdClientId);
					
					
					# GenerateColumnChart
					$GenerateColumnChart = new \GoogleApi\Model\GenerateColumnChart;
					$GenerateColumnChart::render($service,$exampleAccountId, $exampleAdClientId);
					
					
					# GenerateGeoChart
					$GenerateGeoChart = new \GoogleApi\Model\GenerateGeoChart;
					$GenerateGeoChart::render($service,$exampleAccountId, $exampleAdClientId);
					
					
				} else {
					print 'No ad clients found, unable to run dependant examples.';
				}
					
				$GetAllSavedReports = new \GoogleApi\Model\GetAllSavedReports;
				$savedReports = $GetAllSavedReports::run($service, $exampleAccountId,MAX_LIST_PAGE_SIZE);
				if (isset($savedReports) && !empty($savedReports)) {
					// Get an example saved report ID, so we can run the following sample.
					$exampleSavedReportId = $savedReports[0]['id'];
	
					$GenerateSavedReport = new \GoogleApi\Model\GenerateSavedReport;
					$GenerateSavedReport::run($service, $exampleAccountId,$exampleSavedReportId);
				} else {
					print 'No saved reports found, unable to run dependant example.';
				}
					
				$GetAllSavedAdStyles = new \GoogleApi\Model\GetAllSavedAdStyles;
				$GetAllSavedAdStyles::run($service, $exampleAccountId, MAX_LIST_PAGE_SIZE);
					
				$GetAllAlerts = new \GoogleApi\Model\GetAllAlerts;
				$GetAllAlerts::run($service, $exampleAccountId);
			} else {
				'No accounts found, unable to run dependant examples.';
			}
				
			$GetAllDimensions = new \GoogleApi\Model\GetAllDimensions;
			$GetAllDimensions::run($service);
			$GetAllMetrics = new \GoogleApi\Model\GetAllMetrics;
			$GetAllMetrics::run($service);
				
			# End
				
			$_SESSION['access_token'] = $client->getAccessToken();
	
			echo '</pre>';
			echo '</div>';
			
	} else 
	{ 
		# Neu Chua co Token thi ket noi den api google de lay token
		echo '<div><div class="request">';
		if (isset($authUrl)) {
			echo '<a class="login" href="' . $authUrl . '">Connect Me!</a>';
		} else {
			echo '<a class="logout" href="?logout">Logout</a>';
		};
		echo "</div></div>";
	}	
	
	echo "</div></div></div>"; # end Container
	 
	$view = new ViewModel ( array (
			'authUrl' => $authUrl,
			'client' => $client,
			'filename_client'=>$filename_client,
	) );
	return $view;
	}
	
	
	# reportcolumchart
	public function reportcolumchartAction() {
		$dir_files_json  = dirname(dirname(dirname(dirname(dirname(__DIR__))))).'/files/';
		
		$session = new Container('User');
		$userId    = $session->offsetGet('userId');
		$userEmail = $session->offsetGet('userEmail');
		$str = $userId.'-'.$userEmail.Hash_token;
		$Token_key_user = md5($str);
		$session->offsetSet('Token_key_user', $Token_key_user);
		$name_json = $Token_key_user.'.json';
		
		$filename_client_json = $dir_files_json.$name_json;
		
		$authUrl = '';
		// Set up authentication.
		$client = new Google_Client ();
		$client->addScope ( 'https://www.googleapis.com/auth/adsense.readonly' );
		$client->setAccessType ( 'offline' );
	
		// Be sure to replace the contents of client_secrets.json with your developer
		// credentials.
	
		# tai khoan cez
		$filename_client = __DIR__ . '/../data/client_secret_248018190114-ikfifcdrsah8sbsr3qvh0otph9sgtphf.apps.googleusercontent.com.json';
			
		if (file_exists ( $filename_client_json )) {
			$client->setAuthConfigFile ( $filename_client_json );
		} else {
			die ( "Erro Get Client Secrets" );
		}
	
		// Create service.
		$service = new Google_Service_AdSense ( $client );
	
		// If we're logging out we just need to clear our local access token.
		// Note that this only logs you out of the session. If STORE_ON_DISK is
		// enabled and you want to remove stored data, delete the file.
		if (isset ( $_REQUEST ['logout'] )) {
			unset ( $_SESSION ['access_token'] );
		}
	
		// If we have a code back from the OAuth 2.0 flow, we need to exchange that
		// with the authenticate() function. We store the resultant access token
		// bundle in the session (and disk, if enabled), and redirect to this page.
		if (isset ( $_GET ['code'] )) {
			$client->authenticate ( $_GET ['code'] );
			// Note that "getAccessToken" actually retrieves both the access and refresh
			// tokens, assuming both are available.
			$_SESSION ['access_token'] = $client->getAccessToken ();
			if (STORE_ON_DISK) {
				@file_put_contents ( TOKEN_FILENAME, $_SESSION ['access_token'] );
			}
			// $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			$redirect = 'http://localhost:8090/reportcallback';
			header ( 'Location: ' . filter_var ( $redirect, FILTER_SANITIZE_URL ) );
			exit ();
		}
	
		// If we have an access token, we can make requests, else we generate an
		// authentication URL.
	
			
	
		if (isset ( $_SESSION ['access_token'] ) && $_SESSION ['access_token']) {
			$client->setAccessToken ( $_SESSION ['access_token'] );
	
		} else if (STORE_ON_DISK && file_exists ( TOKEN_FILENAME ) && @filesize ( TOKEN_FILENAME ) > 0) {
			// Note that "setAccessToken" actually sets both the access and refresh token,
			// assuming both were saved.
			$client->setAccessToken ( file_get_contents ( TOKEN_FILENAME ) );
			$_SESSION ['access_token'] = $client->getAccessToken ();
		} else {
			// If we're doing disk storage, generate a URL that forces user approval.
			// This is the only way to guarantee we get back a refresh token.
			if (STORE_ON_DISK) {
				$client->setApprovalPrompt ( 'force' );
			}
			$authUrl = $client->createAuthUrl ();
		}
	
		# Start Taking Google
		 
		echo '<div class="container">
				  <div class="row">
				    <div class="col-sm-12">';
	
		if ($client->getAccessToken())
		{
				
			echo '<ul class="list-group">
				  <li class="list-group-item">';
			echo '<a class="login" href="' . WEBPATH . '/report-colum-chart"> Report Generate ColumnChart</a>';
			echo '</li>
				  <li class="list-group-item">';
			echo '<a class="login" href="' . WEBPATH . '/report-geo-chart"> Report Generate GeoChart</a>';
			echo '</li>';
			echo '</ul>';
				
				
			echo '</div>';
			echo '<pre class="result">';
	
			 
			print "\n";
	
			$GetAllAccounts = new \GoogleApi\Model\GetAllAccounts;
			$accounts = $GetAllAccounts::run($service, MAX_LIST_PAGE_SIZE);
	
			if (isset($accounts) && !empty($accounts)) {
				// Get an example account ID, so we can run the following sample.
				$exampleAccountId = $accounts[0]['id'];
				
				
					
				$GetAccountTree = new \GoogleApi\Model\GetAccountTree;
				$GetAccountTree::run($service, $exampleAccountId);
					
				$GetAllAdClients = new \GoogleApi\Model\GetAllAdClients;
				$adClients       = $GetAllAdClients::run($service, $exampleAccountId, MAX_LIST_PAGE_SIZE);
					
				if (isset($adClients) && !empty($adClients)) {
					// Get an ad client ID, so we can run the rest of the samples.
					$exampleAdClient = end($adClients);
					$exampleAdClientId = $exampleAdClient['id'];
					
					# GenerateColumnChart
					$GenerateColumnChart = new \GoogleApi\Model\GenerateColumnChart;
					$GenerateColumnChart::render($service,$exampleAccountId, $exampleAdClientId);
					
					
	
					/* 
					$GetAllAdUnits  = new \GoogleApi\Model\GetAllAdUnits;
					$adUnits        = $GetAllAdUnits::run($service, $exampleAccountId, $exampleAdClientId, MAX_LIST_PAGE_SIZE);
					if (isset($adUnits) && !empty($adUnits)) {
						// Get an example ad unit ID, so we can run the following sample.
						$exampleAdUnitId = $adUnits[0]['id'];
							
						$GetAllCustomChannelsForAdUnit = new \GoogleApi\Model\GetAllCustomChannelsForAdUnit;
						$GetAllCustomChannelsForAdUnit::run($service, $exampleAccountId, $exampleAdClientId, $exampleAdUnitId, MAX_LIST_PAGE_SIZE);
					} else {
						print 'No ad units found, unable to run dependant example.';
					}
	
					$GetAllCustomChannels  = new \GoogleApi\Model\GetAllCustomChannels;
					$customChannels        = $GetAllCustomChannels::run($service, $exampleAccountId,  $exampleAdClientId, MAX_LIST_PAGE_SIZE);
					if (isset($customChannels) && !empty($customChannels)) {
						// Get an example ad unit ID, so we can run the following sample.
						$exampleCustomChannelId = $customChannels[0]['id'];
							
						$GetAllAdUnitsForCustomChannel = new \GoogleApi\Model\GetAllAdUnitsForCustomChannel;
						$GetAllAdUnitsForCustomChannel::run($service, $exampleAccountId,  $exampleAdClientId, $exampleCustomChannelId, MAX_LIST_PAGE_SIZE);
					} else {
						print 'No custom channels found, unable to run dependant example.';
					}
	
					$GetAllUrlChannels = new \GoogleApi\Model\GetAllUrlChannels;
					$GetAllUrlChannels::run($service, $exampleAccountId, $exampleAdClientId, MAX_LIST_PAGE_SIZE);
	
					$GenerateReport = new \GoogleApi\Model\GenerateReport;
					$GenerateReport::run($service, $exampleAccountId, $exampleAdClientId);
	
					$GenerateReportWithPaging = new \GoogleApi\Model\GenerateReportWithPaging;
					$GenerateReportWithPaging::run($service, $exampleAccountId, $exampleAdClientId, MAX_REPORT_PAGE_SIZE);
	
					$FillMissingDatesInReport = new \GoogleApi\Model\FillMissingDatesInReport;
					$FillMissingDatesInReport::run($service, $exampleAccountId, $exampleAdClientId);
	
					$CollateReportData = new \GoogleApi\Model\CollateReportData;
					$CollateReportData::run($service, $exampleAccountId, $exampleAdClientId);
						  */
						
				} else {
					print 'No ad clients found, unable to run dependant examples.';
				}
					
				
				 /*
				$GetAllSavedReports = new \GoogleApi\Model\GetAllSavedReports;
				$savedReports = $GetAllSavedReports::run($service, $exampleAccountId,MAX_LIST_PAGE_SIZE);
				if (isset($savedReports) && !empty($savedReports)) {
					// Get an example saved report ID, so we can run the following sample.
					$exampleSavedReportId = $savedReports[0]['id'];
	
					$GenerateSavedReport = new \GoogleApi\Model\GenerateSavedReport;
					$GenerateSavedReport::run($service, $exampleAccountId,$exampleSavedReportId);
				} else {
					print 'No saved reports found, unable to run dependant example.';
				}
					
				$GetAllSavedAdStyles = new \GoogleApi\Model\GetAllSavedAdStyles;
				$GetAllSavedAdStyles::run($service, $exampleAccountId, MAX_LIST_PAGE_SIZE);
					
				$GetAllAlerts = new \GoogleApi\Model\GetAllAlerts;
				$GetAllAlerts::run($service, $exampleAccountId);
				*/
				
			} else {
				'No accounts found, unable to run dependant examples.';
			}
	
			/*
			$GetAllDimensions = new \GoogleApi\Model\GetAllDimensions;
			$GetAllDimensions::run($service);
			$GetAllMetrics = new \GoogleApi\Model\GetAllMetrics;
			$GetAllMetrics::run($service);
			*/
	
			# End
	
			# $_SESSION['access_token'] = $client->getAccessToken();
	
			echo '</pre>';
			echo '</div>';
				
	} else
	{
		# Neu Chua co Token thi ket noi den api google de lay token
		echo '<div><div class="request">';
		if (isset($authUrl)) {
			echo '<a class="login" href="' . $authUrl . '">Connect Me!</a>';
		} else {
			echo '<a class="logout" href="?logout">Logout</a>';
		};
		echo "</div></div>";
	}
	
	echo "</div></div></div>"; # end Container
	
	$view = new ViewModel ( array (
			'authUrl' => $authUrl,
			'client' => $client,
			'filename_client'=>$filename_client,
			) );
	return $view;
	}
	
	
	# report-geo-chart
	public function reportgeochartAction() {
		$dir_files_json  = dirname(dirname(dirname(dirname(dirname(__DIR__))))).'/files/';
		
		$session = new Container('User');
		$userId    = $session->offsetGet('userId');
		$userEmail = $session->offsetGet('userEmail');
		$str = $userId.'-'.$userEmail.Hash_token;
		$Token_key_user = md5($str);
		$session->offsetSet('Token_key_user', $Token_key_user);
		$name_json = $Token_key_user.'.json';
		
		$filename_client_json = $dir_files_json.$name_json;
		
		$authUrl = '';
		// Set up authentication.
		$client = new Google_Client ();
		$client->addScope ( 'https://www.googleapis.com/auth/adsense.readonly' );
		$client->setAccessType ( 'offline' );
	
		// Be sure to replace the contents of client_secrets.json with your developer
		// credentials.
	
		# tai khoan cez
		$filename_client = __DIR__ . '/../data/client_secret_248018190114-ikfifcdrsah8sbsr3qvh0otph9sgtphf.apps.googleusercontent.com.json';
			
		if (file_exists ( $filename_client_json )) {
			$client->setAuthConfigFile ( $filename_client_json );
		} else {
			die ( "Erro Get Client Secrets" );
		}
	
		// Create service.
		$service = new Google_Service_AdSense ( $client );
	
		// If we're logging out we just need to clear our local access token.
		// Note that this only logs you out of the session. If STORE_ON_DISK is
		// enabled and you want to remove stored data, delete the file.
		if (isset ( $_REQUEST ['logout'] )) {
			unset ( $_SESSION ['access_token'] );
		}
	
		// If we have a code back from the OAuth 2.0 flow, we need to exchange that
		// with the authenticate() function. We store the resultant access token
		// bundle in the session (and disk, if enabled), and redirect to this page.
		if (isset ( $_GET ['code'] )) {
			$client->authenticate ( $_GET ['code'] );
			// Note that "getAccessToken" actually retrieves both the access and refresh
			// tokens, assuming both are available.
			$_SESSION ['access_token'] = $client->getAccessToken ();
			if (STORE_ON_DISK) {
				@file_put_contents ( TOKEN_FILENAME, $_SESSION ['access_token'] );
			}
			// $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			// http://localhost:8082/adsense-sample.php
			$redirect = 'http://localhost:8090/reportcallback';
			header ( 'Location: ' . filter_var ( $redirect, FILTER_SANITIZE_URL ) );
			exit ();
		}
	
		// If we have an access token, we can make requests, else we generate an
		// authentication URL.
	
			
	
		if (isset ( $_SESSION ['access_token'] ) && $_SESSION ['access_token']) {
			$client->setAccessToken ( $_SESSION ['access_token'] );
	
		} else if (STORE_ON_DISK && file_exists ( TOKEN_FILENAME ) && @filesize ( TOKEN_FILENAME ) > 0) {
			// Note that "setAccessToken" actually sets both the access and refresh token,
			// assuming both were saved.
			$client->setAccessToken ( file_get_contents ( TOKEN_FILENAME ) );
			$_SESSION ['access_token'] = $client->getAccessToken ();
		} else {
			// If we're doing disk storage, generate a URL that forces user approval.
			// This is the only way to guarantee we get back a refresh token.
			if (STORE_ON_DISK) {
				$client->setApprovalPrompt ( 'force' );
			}
			$authUrl = $client->createAuthUrl ();
		}
	
		# Start Taking Google
			
		echo '<div class="container">
				  <div class="row">
				    <div class="col-sm-12">';
	
		if ($client->getAccessToken())
		{
	
			echo '<ul class="list-group">
				  <li class="list-group-item">';
			echo '<a class="login" href="' . WEBPATH . '/report-colum-chart"> Report Generate ColumnChart</a>';
			echo '</li>
				  <li class="list-group-item">';
			echo '<a class="login" href="' . WEBPATH . '/report-geo-chart"> Report Generate GeoChart</a>';
			echo '</li>';
			echo '</ul>';
	
	
			echo '</div>';
			echo '<pre class="result">';
	
	
			print "\n";
	
			$GetAllAccounts = new \GoogleApi\Model\GetAllAccounts;
			$accounts = $GetAllAccounts::run($service, MAX_LIST_PAGE_SIZE);
	
			if (isset($accounts) && !empty($accounts)) {
				// Get an example account ID, so we can run the following sample.
				$exampleAccountId = $accounts[0]['id'];
	
	
					
				$GetAccountTree = new \GoogleApi\Model\GetAccountTree;
				$GetAccountTree::run($service, $exampleAccountId);
					
				$GetAllAdClients = new \GoogleApi\Model\GetAllAdClients;
				$adClients       = $GetAllAdClients::run($service, $exampleAccountId, MAX_LIST_PAGE_SIZE);
					
				if (isset($adClients) && !empty($adClients)) {
					// Get an ad client ID, so we can run the rest of the samples.
					$exampleAdClient = end($adClients);
					$exampleAdClientId = $exampleAdClient['id'];
						
					# GenerateGeoChart
					$GenerateGeoChart = new \GoogleApi\Model\GenerateGeoChart;
					$GenerateGeoChart::render($service,$exampleAccountId, $exampleAdClientId);
						
						
	
					/*
						$GetAllAdUnits  = new \GoogleApi\Model\GetAllAdUnits;
						$adUnits        = $GetAllAdUnits::run($service, $exampleAccountId, $exampleAdClientId, MAX_LIST_PAGE_SIZE);
						if (isset($adUnits) && !empty($adUnits)) {
						// Get an example ad unit ID, so we can run the following sample.
						$exampleAdUnitId = $adUnits[0]['id'];
							
						$GetAllCustomChannelsForAdUnit = new \GoogleApi\Model\GetAllCustomChannelsForAdUnit;
						$GetAllCustomChannelsForAdUnit::run($service, $exampleAccountId, $exampleAdClientId, $exampleAdUnitId, MAX_LIST_PAGE_SIZE);
						} else {
						print 'No ad units found, unable to run dependant example.';
						}
	
						$GetAllCustomChannels  = new \GoogleApi\Model\GetAllCustomChannels;
						$customChannels        = $GetAllCustomChannels::run($service, $exampleAccountId,  $exampleAdClientId, MAX_LIST_PAGE_SIZE);
						if (isset($customChannels) && !empty($customChannels)) {
						// Get an example ad unit ID, so we can run the following sample.
						$exampleCustomChannelId = $customChannels[0]['id'];
							
						$GetAllAdUnitsForCustomChannel = new \GoogleApi\Model\GetAllAdUnitsForCustomChannel;
						$GetAllAdUnitsForCustomChannel::run($service, $exampleAccountId,  $exampleAdClientId, $exampleCustomChannelId, MAX_LIST_PAGE_SIZE);
						} else {
						print 'No custom channels found, unable to run dependant example.';
						}
	
						$GetAllUrlChannels = new \GoogleApi\Model\GetAllUrlChannels;
						$GetAllUrlChannels::run($service, $exampleAccountId, $exampleAdClientId, MAX_LIST_PAGE_SIZE);
	
						$GenerateReport = new \GoogleApi\Model\GenerateReport;
						$GenerateReport::run($service, $exampleAccountId, $exampleAdClientId);
	
						$GenerateReportWithPaging = new \GoogleApi\Model\GenerateReportWithPaging;
						$GenerateReportWithPaging::run($service, $exampleAccountId, $exampleAdClientId, MAX_REPORT_PAGE_SIZE);
	
						$FillMissingDatesInReport = new \GoogleApi\Model\FillMissingDatesInReport;
						$FillMissingDatesInReport::run($service, $exampleAccountId, $exampleAdClientId);
	
						$CollateReportData = new \GoogleApi\Model\CollateReportData;
						$CollateReportData::run($service, $exampleAccountId, $exampleAdClientId);
						*/
	
				} else {
					print 'No ad clients found, unable to run dependant examples.';
				}
					
	
				/*
					$GetAllSavedReports = new \GoogleApi\Model\GetAllSavedReports;
					$savedReports = $GetAllSavedReports::run($service, $exampleAccountId,MAX_LIST_PAGE_SIZE);
					if (isset($savedReports) && !empty($savedReports)) {
					// Get an example saved report ID, so we can run the following sample.
					$exampleSavedReportId = $savedReports[0]['id'];
	
					$GenerateSavedReport = new \GoogleApi\Model\GenerateSavedReport;
					$GenerateSavedReport::run($service, $exampleAccountId,$exampleSavedReportId);
					} else {
					print 'No saved reports found, unable to run dependant example.';
					}
						
					$GetAllSavedAdStyles = new \GoogleApi\Model\GetAllSavedAdStyles;
					$GetAllSavedAdStyles::run($service, $exampleAccountId, MAX_LIST_PAGE_SIZE);
						
					$GetAllAlerts = new \GoogleApi\Model\GetAllAlerts;
					$GetAllAlerts::run($service, $exampleAccountId);
					*/
	
			} else {
				'No accounts found, unable to run dependant examples.';
			}
	
			/*
				$GetAllDimensions = new \GoogleApi\Model\GetAllDimensions;
				$GetAllDimensions::run($service);
				$GetAllMetrics = new \GoogleApi\Model\GetAllMetrics;
				$GetAllMetrics::run($service);
				*/
	
			# End
	
			# $_SESSION['access_token'] = $client->getAccessToken();
	
			echo '</pre>';
			echo '</div>';
	
		} else
		{
			# Neu Chua co Token thi ket noi den api google de lay token
			echo '<div><div class="request">';
			if (isset($authUrl)) {
				echo '<a class="login" href="' . $authUrl . '">Connect Me!</a>';
			} else {
				echo '<a class="logout" href="?logout">Logout</a>';
			};
			echo "</div></div>";
		}
	
		echo "</div></div></div>"; # end Container
	
		$view = new ViewModel ( array (
				'authUrl' => $authUrl,
				'client' => $client,
				'filename_client'=>$filename_client,
				) );
		return $view;
	}
	
	
	public function reportlinechartAction() {
		$dir_files_json  = dirname(dirname(dirname(dirname(dirname(__DIR__))))).'/files/';
		
		$session = new Container('User');
		$userId    = $session->offsetGet('userId');
		$userEmail = $session->offsetGet('userEmail');
		$str = $userId.'-'.$userEmail.Hash_token;
		$Token_key_user = md5($str);
		$session->offsetSet('Token_key_user', $Token_key_user);
		$name_json = $Token_key_user.'.json';
		
		$filename_client_json = $dir_files_json.$name_json;
		
		$authUrl = '';
		// Set up authentication.
		$client = new Google_Client ();
		$client->addScope ( 'https://www.googleapis.com/auth/adsense.readonly' );
		$client->setAccessType ( 'offline' );
	
		// Be sure to replace the contents of client_secrets.json with your developer
		// credentials.
	
		# tai khoan cez
		$filename_client = __DIR__ . '/../data/client_secret_248018190114-ikfifcdrsah8sbsr3qvh0otph9sgtphf.apps.googleusercontent.com.json';
			
		if (file_exists ( $filename_client_json )) {
			$client->setAuthConfigFile ( $filename_client_json );
		} else {
			die ( "Erro Get Client Secrets" );
		}
	
		// Create service.
		$service = new Google_Service_AdSense ( $client );
	
		// If we're logging out we just need to clear our local access token.
		// Note that this only logs you out of the session. If STORE_ON_DISK is
		// enabled and you want to remove stored data, delete the file.
		if (isset ( $_REQUEST ['logout'] )) {
			unset ( $_SESSION ['access_token'] );
		}
	
		// If we have a code back from the OAuth 2.0 flow, we need to exchange that
		// with the authenticate() function. We store the resultant access token
		// bundle in the session (and disk, if enabled), and redirect to this page.
		if (isset ( $_GET ['code'] )) {
			$client->authenticate ( $_GET ['code'] );
			// Note that "getAccessToken" actually retrieves both the access and refresh
			// tokens, assuming both are available.
			$_SESSION ['access_token'] = $client->getAccessToken ();
			if (STORE_ON_DISK) {
				@file_put_contents ( TOKEN_FILENAME, $_SESSION ['access_token'] );
			}
			// $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			// http://localhost:8082/adsense-sample.php
			$redirect = 'http://localhost:8090/reportcallback';
			header ( 'Location: ' . filter_var ( $redirect, FILTER_SANITIZE_URL ) );
			exit ();
		}
	
		// If we have an access token, we can make requests, else we generate an
		// authentication URL.
	
			
	
		if (isset ( $_SESSION ['access_token'] ) && $_SESSION ['access_token']) {
			$client->setAccessToken ( $_SESSION ['access_token'] );
	
		} else if (STORE_ON_DISK && file_exists ( TOKEN_FILENAME ) && @filesize ( TOKEN_FILENAME ) > 0) {
			// Note that "setAccessToken" actually sets both the access and refresh token,
			// assuming both were saved.
			$client->setAccessToken ( file_get_contents ( TOKEN_FILENAME ) );
			$_SESSION ['access_token'] = $client->getAccessToken ();
		} else {
			// If we're doing disk storage, generate a URL that forces user approval.
			// This is the only way to guarantee we get back a refresh token.
			if (STORE_ON_DISK) {
				$client->setApprovalPrompt ( 'force' );
			}
			$authUrl = $client->createAuthUrl ();
		}
	
		# Start Taking Google
			
		echo '<div class="container">
				  <div class="row">
				    <div class="col-sm-12">';
	
		if ($client->getAccessToken())
		{
	
			echo '<ul class="list-group">
				  <li class="list-group-item">';
			echo '<a class="login" href="' . WEBPATH . '/report-colum-chart"> Report Generate ColumnChart</a>';
			echo '</li>
				  <li class="list-group-item">';
			echo '<a class="login" href="' . WEBPATH . '/report-geo-chart"> Report Generate GeoChart</a>';
			echo '</li>';
			echo '</ul>';
	
	
			echo '</div>';
			echo '<pre class="result">';
	
	
			print "\n";
	
			$GetAllAccounts = new \GoogleApi\Model\GetAllAccounts;
			$accounts = $GetAllAccounts::run($service, MAX_LIST_PAGE_SIZE);
	
			if (isset($accounts) && !empty($accounts)) {
				// Get an example account ID, so we can run the following sample.
				$exampleAccountId = $accounts[0]['id'];
	 
					
				$GetAccountTree = new \GoogleApi\Model\GetAccountTree;
				$GetAccountTree::run($service, $exampleAccountId);
					
				$GetAllAdClients = new \GoogleApi\Model\GetAllAdClients;
				$adClients       = $GetAllAdClients::run($service, $exampleAccountId, MAX_LIST_PAGE_SIZE);
					
				if (isset($adClients) && !empty($adClients)) {
					// Get an ad client ID, so we can run the rest of the samples.
					$exampleAdClient = end($adClients);
					$exampleAdClientId = $exampleAdClient['id'];
	
					# GenerateLineChart
					$GenerateLineChart = new \GoogleApi\Model\GenerateLineChart;
					$GenerateLineChart::render($service,$exampleAccountId, $exampleAdClientId);
	 
	
				} else {
					print 'No ad clients found, unable to run dependant examples.';
				}
					 
	
			} else {
				'No accounts found, unable to run dependant examples.';
			}
	 
	
			$_SESSION['access_token'] = $client->getAccessToken();
	
			echo '</pre>';
			echo '</div>';
	
		} else
		{
			# Neu Chua co Token thi ket noi den api google de lay token
			echo '<div><div class="request">';
			if (isset($authUrl)) {
				echo '<a class="login" href="' . $authUrl . '">Connect Me!</a>';
			} else {
				echo '<a class="logout" href="?logout">Logout</a>';
			};
			echo "</div></div>";
		}
	
		echo "</div></div></div>"; # end Container
	
		$view = new ViewModel ( array (
				'authUrl' => $authUrl,
				'client' => $client,
				'filename_client'=>$filename_client,
				) );
		return $view;
	}
	 
	
	
	public function reportpiechartAction() { 
		$dir_files_json  = dirname(dirname(dirname(dirname(dirname(__DIR__))))).'/files/';
		
		$session = new Container('User');
		$userId    = $session->offsetGet('userId');
		$userEmail = $session->offsetGet('userEmail');
		$str = $userId.'-'.$userEmail.Hash_token;
		$Token_key_user = md5($str);
		$session->offsetSet('Token_key_user', $Token_key_user);
		$name_json = $Token_key_user.'.json';
		
		$filename_client_json = $dir_files_json.$name_json;
		
		$authUrl = '';
		// Set up authentication.
		$client = new Google_Client ();
		$client->addScope ( 'https://www.googleapis.com/auth/adsense.readonly' );
		$client->setAccessType ( 'offline' );
	
		// Be sure to replace the contents of client_secrets.json with your developer
		// credentials.
	
		# tai khoan cez
		$filename_client = __DIR__ . '/../data/client_secret_248018190114-ikfifcdrsah8sbsr3qvh0otph9sgtphf.apps.googleusercontent.com.json';
			
		if (file_exists ( $filename_client_json )) {
			$client->setAuthConfigFile ( $filename_client_json );
		} else {
			die ( "Erro Get Client Secrets" );
		} 
		// Create service.
		$service = new Google_Service_AdSense ( $client );
	
		// If we're logging out we just need to clear our local access token.
		// Note that this only logs you out of the session. If STORE_ON_DISK is
		// enabled and you want to remove stored data, delete the file.
		if (isset ( $_REQUEST ['logout'] )) {
			unset ( $_SESSION ['access_token'] );
		}
	
		// If we have a code back from the OAuth 2.0 flow, we need to exchange that
		// with the authenticate() function. We store the resultant access token
		// bundle in the session (and disk, if enabled), and redirect to this page.
		if (isset ( $_GET ['code'] )) {
			$client->authenticate ( $_GET ['code'] );
			// Note that "getAccessToken" actually retrieves both the access and refresh
			// tokens, assuming both are available.
			$_SESSION ['access_token'] = $client->getAccessToken ();
			if (STORE_ON_DISK) {
				@file_put_contents ( TOKEN_FILENAME, $_SESSION ['access_token'] );
			}
			// $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			// http://localhost:8082/adsense-sample.php
			$redirect = 'http://localhost:8090/reportcallback';
			header ( 'Location: ' . filter_var ( $redirect, FILTER_SANITIZE_URL ) );
			exit ();
		}
	
		// If we have an access token, we can make requests, else we generate an
		// authentication URL.
	 
	
		if (isset ( $_SESSION ['access_token'] ) && $_SESSION ['access_token']) {
			$client->setAccessToken ( $_SESSION ['access_token'] );
	
		} else if (STORE_ON_DISK && file_exists ( TOKEN_FILENAME ) && @filesize ( TOKEN_FILENAME ) > 0) {
			// Note that "setAccessToken" actually sets both the access and refresh token,
			// assuming both were saved.
			$client->setAccessToken ( file_get_contents ( TOKEN_FILENAME ) );
			$_SESSION ['access_token'] = $client->getAccessToken ();
		} else {
			// If we're doing disk storage, generate a URL that forces user approval.
			// This is the only way to guarantee we get back a refresh token.
			if (STORE_ON_DISK) {
				$client->setApprovalPrompt ( 'force' );
			}
			$authUrl = $client->createAuthUrl ();
		}
	
		# Start Taking Google
			
		echo '<div class="container">
				  <div class="row">
				    <div class="col-sm-12">';
	
		if ($client->getAccessToken())
		{
	
			echo '<ul class="list-group">
				  <li class="list-group-item">';
			echo '<a class="login" href="' . WEBPATH . '/report-colum-chart"> Report Generate ColumnChart</a>';
			echo '</li>
				  <li class="list-group-item">';
			echo '<a class="login" href="' . WEBPATH . '/report-geo-chart"> Report Generate GeoChart</a>';
			echo '</li>';
			echo '</ul>';
	
	
			echo '</div>';
			echo '<pre class="result">'; 
			print "\n";
	
			$GetAllAccounts = new \GoogleApi\Model\GetAllAccounts;
			$accounts = $GetAllAccounts::run($service, MAX_LIST_PAGE_SIZE);
	
			if (isset($accounts) && !empty($accounts)) {
				// Get an example account ID, so we can run the following sample.
				$exampleAccountId = $accounts[0]['id'];
	
					
				$GetAccountTree = new \GoogleApi\Model\GetAccountTree;
				$GetAccountTree::run($service, $exampleAccountId);
					
				$GetAllAdClients = new \GoogleApi\Model\GetAllAdClients;
				$adClients       = $GetAllAdClients::run($service, $exampleAccountId, MAX_LIST_PAGE_SIZE);
					
				if (isset($adClients) && !empty($adClients)) {
					// Get an ad client ID, so we can run the rest of the samples.
					$exampleAdClient = end($adClients);
					$exampleAdClientId = $exampleAdClient['id'];
	
					# GeneratePieChart
					$GeneratePieChart = new \GoogleApi\Model\GeneratePieChart;
					$GeneratePieChart::render($service,$exampleAccountId, $exampleAdClientId);
	
	
				} else {
					print 'No ad clients found, unable to run dependant examples.';
				} 
	
			} else {
				'No accounts found, unable to run dependant examples.';
			}
	 
			$_SESSION['access_token'] = $client->getAccessToken();
	
			echo '</pre>';
			echo '</div>';
	
		} else
		{
			# Neu Chua co Token thi ket noi den api google de lay token
			echo '<div><div class="request">';
			if (isset($authUrl)) {
				echo '<a class="login" href="' . $authUrl . '">Connect Me!</a>';
			} else {
				echo '<a class="logout" href="?logout">Logout</a>';
			};
			echo "</div></div>";
		} 
		echo "</div></div></div>"; # end Container
	
		$view = new ViewModel ( array (
				'authUrl' => $authUrl,
				'client' => $client,
				'filename_client'=>$filename_client,
				) );
		return $view;
	}
	
	
	public function reporttablechartAction() {
		$dir_files_json  = dirname(dirname(dirname(dirname(dirname(__DIR__))))).'/files/';
		
		$session = new Container('User');
		$userId    = $session->offsetGet('userId');
		$userEmail = $session->offsetGet('userEmail');
		$str = $userId.'-'.$userEmail.Hash_token;
		$Token_key_user = md5($str);
		$session->offsetSet('Token_key_user', $Token_key_user);
		$name_json = $Token_key_user.'.json';
		
		$filename_client_json = $dir_files_json.$name_json;
		
		
		$authUrl = '';
		// Set up authentication.
		$client = new Google_Client ();
		$client->addScope ( 'https://www.googleapis.com/auth/adsense.readonly' );
		$client->setAccessType ( 'offline' );
	
		// Be sure to replace the contents of client_secrets.json with your developer
		// credentials.
	
		# tai khoan cez
		$filename_client = __DIR__ . '/../data/client_secret_248018190114-ikfifcdrsah8sbsr3qvh0otph9sgtphf.apps.googleusercontent.com.json';
			
		if (file_exists ( $filename_client_json )) {
			$client->setAuthConfigFile ( $filename_client_json );
		} else {
			die ( "Erro Get Client Secrets" );
		}
		// Create service.
		$service = new Google_Service_AdSense ( $client );
	
		// If we're logging out we just need to clear our local access token.
		// Note that this only logs you out of the session. If STORE_ON_DISK is
		// enabled and you want to remove stored data, delete the file.
		if (isset ( $_REQUEST ['logout'] )) {
			unset ( $_SESSION ['access_token'] );
		}
	
		// If we have a code back from the OAuth 2.0 flow, we need to exchange that
		// with the authenticate() function. We store the resultant access token
		// bundle in the session (and disk, if enabled), and redirect to this page.
		if (isset ( $_GET ['code'] )) {
			$client->authenticate ( $_GET ['code'] );
			// Note that "getAccessToken" actually retrieves both the access and refresh
			// tokens, assuming both are available.
			$_SESSION ['access_token'] = $client->getAccessToken ();
			if (STORE_ON_DISK) {
				@file_put_contents ( TOKEN_FILENAME, $_SESSION ['access_token'] );
			}
			// $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			// http://localhost:8082/adsense-sample.php
			$redirect = 'http://localhost:8090/reportcallback';
			header ( 'Location: ' . filter_var ( $redirect, FILTER_SANITIZE_URL ) );
			exit ();
		}
	
		// If we have an access token, we can make requests, else we generate an
		// authentication URL.
	
	
		if (isset ( $_SESSION ['access_token'] ) && $_SESSION ['access_token']) {
			$client->setAccessToken ( $_SESSION ['access_token'] );
	
		} else if (STORE_ON_DISK && file_exists ( TOKEN_FILENAME ) && @filesize ( TOKEN_FILENAME ) > 0) {
			// Note that "setAccessToken" actually sets both the access and refresh token,
			// assuming both were saved.
			$client->setAccessToken ( file_get_contents ( TOKEN_FILENAME ) );
			$_SESSION ['access_token'] = $client->getAccessToken ();
		} else {
			// If we're doing disk storage, generate a URL that forces user approval.
			// This is the only way to guarantee we get back a refresh token.
			if (STORE_ON_DISK) {
				$client->setApprovalPrompt ( 'force' );
			}
			$authUrl = $client->createAuthUrl ();
		}
	
		# Start Taking Google
			
		echo '<div class="container">
				  <div class="row">
				    <div class="col-sm-12">';
	
		if ($client->getAccessToken())
		{
	
			echo '<ul class="list-group">
				  <li class="list-group-item">';
			echo '<a class="login" href="' . WEBPATH . '/report-colum-chart"> Report Generate ColumnChart</a>';
			echo '</li>
				  <li class="list-group-item">';
			echo '<a class="login" href="' . WEBPATH . '/report-geo-chart"> Report Generate GeoChart</a>';
			echo '</li>';
			echo '</ul>';
	
	
			echo '</div>';
			echo '<pre class="result">';
			print "\n";
	
			$GetAllAccounts = new \GoogleApi\Model\GetAllAccounts;
			$accounts = $GetAllAccounts::run($service, MAX_LIST_PAGE_SIZE);
	
			if (isset($accounts) && !empty($accounts)) {
				// Get an example account ID, so we can run the following sample.
				$exampleAccountId = $accounts[0]['id'];
	
					
				$GetAccountTree = new \GoogleApi\Model\GetAccountTree;
				$GetAccountTree::run($service, $exampleAccountId);
					
				$GetAllAdClients = new \GoogleApi\Model\GetAllAdClients;
				$adClients       = $GetAllAdClients::run($service, $exampleAccountId, MAX_LIST_PAGE_SIZE);
					
				if (isset($adClients) && !empty($adClients)) {
					// Get an ad client ID, so we can run the rest of the samples.
					$exampleAdClient = end($adClients);
					$exampleAdClientId = $exampleAdClient['id'];
	
					# GenerateTableChart
					$GenerateTableChart = new \GoogleApi\Model\GenerateTableChart;
					$GenerateTableChart::render($service,$exampleAccountId, $exampleAdClientId);
	
	
				} else {
					print 'No ad clients found, unable to run dependant examples.';
				}
	
			} else {
				'No accounts found, unable to run dependant examples.';
			}
	
			$_SESSION['access_token'] = $client->getAccessToken();
	
			echo '</pre>';
			echo '</div>';
	
		} else
		{
			# Neu Chua co Token thi ket noi den api google de lay token
			echo '<div><div class="request">';
			if (isset($authUrl)) {
				echo '<a class="login" href="' . $authUrl . '">Connect Me!</a>';
			} else {
				echo '<a class="logout" href="?logout">Logout</a>';
			};
			echo "</div></div>";
		}
		echo "</div></div></div>"; # end Container
	
		$view = new ViewModel ( array (
		'authUrl' => $authUrl,
		'client' => $client,
		'filename_client'=>$filename_client,
		) );
		return $view;
	}
	
}
