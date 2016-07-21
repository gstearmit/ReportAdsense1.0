<?php

namespace GoogleApi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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


class AdsenseController extends AbstractActionController {
	
	public function indexAction() {
		return new ViewModel ();
	}
	
	function isWebRequest() {
		return isset($_SERVER['HTTP_USER_AGENT']);
	}
	
	
	public function pageHeader($title) {
		$ret = "";
		if ($this->isWebRequest()) {
			$ret .= "<!doctype html>
    <html>
    <head>
      <title>" . $title . "</title>
      <link href='styles/style.css' rel='stylesheet' type='text/css' />
    </head>
    <body>\n";
			$ret .= "<header><h1>" . $title . "</h1></header>";
		}
		return $ret;
	}
	
	public function pageFooter() {
		$ret = "";
		if ($this->isWebRequest()) {
			$ret .= "</html>";
		}
		return $ret;
	}
	
	public function missingClientSecretsWarning() 
	{
		$ret = "";
		if ($this->isWebRequest()) {
			$ret = "
      <h3 class='warn'>
        Warning: You need to set Client ID, Client Secret and Redirect URI on
        the client_secrets.json file. You can get these from the
        <a href='http://developers.google.com/console'>Google API console</a>
      </h3>";
		} else {
			$ret = "Warning: You need to set Client ID, Client Secret and Redirect URI";
			$ret .= " on the client_secrets.json file. You can get these from:\n";
			$ret .= "http://developers.google.com/console";
		}
		return $ret;
	}
	 
	public function loginAuthenAction() {
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
		
		/*
		echo '<div><div class="request">';
		if (isset($authUrl)) {
			echo '<a class="login" href="' . $authUrl . '">Connect Me!</a>';
		} else {
			echo '<a class="logout" href="?logout">Logout</a>';
		};
		echo '</div>';
		*/
		
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
			
// 				echo "<pre>";
// 				print_r($accounts);
// 				echo "</pre>";
// 				die("viewwwww");
			
			
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
		# echo pageFooter(__FILE__); 
		$ret = "";
		$file = __FILE__;
		if ($this->isWebRequest()) {
			// Echo the code if in an example.
			if ($file) {
				$ret .= "<h3>Code:</h3>";
				$ret .= "<pre class='code'>";
				$ret .= htmlspecialchars(file_get_contents($file));
				$ret .= "</pre>";
			}
			$ret .= "</html>";
		}
		# echo $ret;
		
		
		
		
		// $this->layout ('layout/theme-validate-mp' );
		$view = new ViewModel ( array (
				'authUrl' => $authUrl,
				'client' => $client,
				'filename_client'=>$filename_client,
		) );
		return $view;
	}
	
	
	public function loginGoogleAction() {
		@session_start (); 
		$client = new Google_Client (); 
		 /*
		  {
			  "web": {
			    "client_id": "769901707687-9sdig1lfgnah6eni9855mt8o5hrrb2fh.apps.googleusercontent.com",
			    "client_secret": "myIBbLHgM1EyBDsfEqMzkFW3",
			    "redirect_uris": "http://localhost:8090/google-api/login-google"
			  }
			}
		  */
		$filename_client = __DIR__ . '/../data/client_secrets.json';
		if (file_exists ( $filename_client )) {
			$client->setAuthConfigFile ( $filename_client );
		} else {
			die ( "Erro Get Client Secrets" );
		}
		
		// $client->setAuthConfig($filename_client); 
		$client->setAuthConfigFile ( $filename_client );
		
		$client->addScope ( Google_Service_Drive::DRIVE_METADATA_READONLY );
		 
		echo "</br> access_token : <pre>";
		print_r ( $_SESSION ['access_token'] );
		echo "</pre>";
		
// 		die ( "-----------view -----------" );
		
		if (isset ( $_SESSION ['access_token'] ) && $_SESSION ['access_token']) {
			/* json_decode($_SESSION['access_token']);
				if (isset($_SESSION['access_token']) && $_SESSION['access_token'] && !json_last_error()) {
				  $client->setAccessToken($_SESSION['access_token']);
				} else {
				  $authUrl = $client->createAuthUrl();
				} */
			$token      = $_SESSION ['access_token'];
			# $json_token = json_encode($token);
			$client->setAccessToken ( $token );
			  
			// $client->setIncludeGrantedScopes(true);
			$drive_service = new Google_Service_Drive ( $client );
			
			echo "<pre>";
			print_r($drive_service->files);
			echo "</pre>";
			die('Rietw99999999');
			
			// $files_list = $drive_service->files->listFiles(array())->getItems();
			// echo json_encode($files_list);
			
			$files_list = $drive_service->files->listFiles ( array () );
			echo "</br> files_list <pre>";
			print_r ( $files_list );
			echo "</pre>";
			
			// $files_list = $drive_service->files->listFiles(array())->getFiles();
			// var_dump($files_list);
			//
			
			if (count ( $files_list->getFiles () ) == 0) {
				print "No files found.\n";
			} else {
				foreach ( $files_list->getFiles () as $file ) {
					$res ['name'] = $file->getName ();
					$res ['id'] = $file->getId ();
					$files [] = $res;
				}
				echo "<pre>";
				print_r ( $files );
				echo "</pre>";
			}
		} else {
			// $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
			die('WAOOOOOO');
// 			$redirect_uri = 'http://localhost:8090/google-api/login-google'; 
// 			header ( 'Location: ' . filter_var ( $redirect_uri, FILTER_SANITIZE_URL ) );
		}
		
		// $this->layout ('layout/theme-validate-mp' );
		$view = new ViewModel ( array (
				'filename_client'=>$filename_client,
		    ) 	
		 );
		return $view;
	}
	
	public function loginGoogleNextAction() {
		@session_start ();
		$client = new Google_Client ();
		/*
		 WEB REPORT 2016 -001 
        248018190114-d8fjjcjfm14963pqgbc15a8t8fmt5o3r.apps.googleusercontent.com

			Here is your client ID :   248018190114-l6mv8dk0itpe0svs0roq9qo2rit3fg2v.apps.googleusercontent.com
			
			Here is your client secret :   A9y3PLWgvSdajWaarnAD5RZ3
		 */
			
		$filename_client = __DIR__ . '/../data/client_secretsnext.json';
		if (file_exists ( $filename_client )) {
			$client->setAuthConfigFile ( $filename_client );
		} else {
			die ( "Erro Get Client Secrets" );
		}
	
		// $client->setAuthConfig($filename_client);
		$client->setAuthConfigFile ( $filename_client );
	
		$client->addScope ( Google_Service_Drive::DRIVE_METADATA_READONLY );
			
		echo "</br> access_token : <pre>";
		print_r ( $_SESSION ['access_token'] );
		echo "</pre>";
	
		// 		die ( "-----------view -----------" );
	
		if (isset ( $_SESSION ['access_token'] ) && $_SESSION ['access_token']) {
			
			/* json_decode($_SESSION['access_token']);
			 if (isset($_SESSION['access_token']) && $_SESSION['access_token'] && !json_last_error()) {
			 $client->setAccessToken($_SESSION['access_token']);
			 } else {
			 $authUrl = $client->createAuthUrl();
			 } */
			
			$token      = $_SESSION ['access_token'];
			#$json_token = json_encode($token);
			
			$client->setAccessToken ( $token );
				
			// $client->setIncludeGrantedScopes(true);
			$drive_service = new Google_Service_Drive ( $client );
				
			echo "<pre>";
			print_r($drive_service->files);
			echo "</pre>";
			die('Rietw99999999');
				
			// $files_list = $drive_service->files->listFiles(array())->getItems();
			// echo json_encode($files_list);
				
			$files_list = $drive_service->files->listFiles ( array () );
			echo "</br> files_list <pre>";
			print_r ( $files_list );
			echo "</pre>";
				
			// $files_list = $drive_service->files->listFiles(array())->getFiles();
			// var_dump($files_list);
			//
				
			if (count ( $files_list->getFiles () ) == 0) {
				print "No files found.\n";
			} else {
				foreach ( $files_list->getFiles () as $file ) {
					$res ['name'] = $file->getName ();
					$res ['id'] = $file->getId ();
					$files [] = $res;
				}
				echo "<pre>";
				print_r ( $files );
				echo "</pre>";
			}
		} else {
			// $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
			die('WAOOOOOO');
			// 			$redirect_uri = 'http://localhost:8090/google-api/login-google';
			// 			header ( 'Location: ' . filter_var ( $redirect_uri, FILTER_SANITIZE_URL ) );
		}
	
		// $this->layout ('layout/theme-validate-mp' );
		$view = new ViewModel ( array (
				'filename_client'=>$filename_client,
		        ) 
			 );
		return $view;
	}
}
