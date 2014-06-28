<?php
/* @var $this SiteController */
/* @var $model FitbitForm */
/* @var $form CActiveForm */

session_start();
		
$this->pageTitle=Yii::app()->name . ' - Fitbit';
$this->breadcrumbs=array(
	'Fitbit',
);

// Fitbit data constants
$baseUrl = 'http://api.fitbit.com';
// API call path to get temporary credentials (request token and secret):
$req_url = $baseUrl . '/oauth/request_token';
// Base path of URL where the user will authorize this application:
$authurl = $baseUrl . '/oauth/authorize';
// API call path to get token credentials (access token and secret):
$acc_url = $baseUrl . '/oauth/access_token';
// Consumer key 
$conskey = '95a49509137e483287bba1817269438e';
// Consumer secret 
$conssec = '112179a5af3843e18dbce270c714eece';
// Start session used store state data between API calls: session_start();
// Create OAuth object: 
$oauth = new OAuth($conskey, $conssec, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_AUTHORIZATION);
$callbackUrl='http://dev.quantimodo.com/site/fitest';
?>

<h1>Fitbit test</h1>

<?php
	if (!empty($_POST['yt0']) && empty($_SESSION['fitbit_state'])) {
		// Get temporary credentials (request token and secret):
		$request_token_info = $oauth->getRequestToken($req_url, $callbackUrl);
		// Store temporary credentials retrieved and state in a session:
		$_SESSION['fitbit_secret'] = $request_token_info['oauth_token_secret'];
		$_SESSION['fitbit_state'] = 1;
		// Redirect to Fitbit in order have the user login or signup and authorize this application:
		header('Location: '.$authurl.'?oauth_token='.$request_token_info['oauth_token']);
	}

	if (empty($_SESSION['fitbit_state']))  
		print '<p>Just a simple info to test the Fitbit connector. Thank you.</p>
			<form method="POST">
				<div class="row buttons">'.CHtml::submitButton('Fitbit connect').'</div>
			</form>';
	else {
		if ($_SESSION['fitbit_state']==1 && !empty($_GET['oauth_token'])) {
			// Authorized. Get token credentials (access token and secret):
			$oauth->setToken($_GET['oauth_token'], $_SESSION['fitbit_secret']);
			$access_token_info = $oauth->getAccessToken($acc_url);
			// Store token credentials and state in the session:
			$_SESSION['fitbit_state'] = 2;
			$_SESSION['fitbit_token'] = $access_token_info['oauth_token'];
			$_SESSION['fitbit_secret'] = $access_token_info['oauth_token_secret'];
		}
	
		if ($_SESSION['fitbit_state'] == 2) {
			print '<p>We are connected with Fitbit! Here is the data about the user provided by Fitbit API:</p>';
			// Set access token to the OAuth object:
			$oauth->setToken($_SESSION['fitbit_token'], $_SESSION['fitbit_secret']);
			// Make API call:
			$apiCall='/1/user/-/profile.json';
			$oauth->fetch($baseUrl.$apiCall);
			// Get last response:
			$response = $oauth->getLastResponse();
			// print print_r($response,true);
			$response = json_decode($response,true);
			$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
							'id'=>1,
							'options'=>array(
								'show' => 'blind',
								'hide' => 'explode',
								'modal' => 'true',
								'title' => 'We are sucessfully connected with Fitbit!',
								'autoOpen'=>true,
								),
							));
			printf('<span class="dialog">%s</span>', 'Congratulations with Fitbit!<br>The data can start flowing<br><br>&nbsp;Quantimodo <--> Fitbit');
			$this->endWidget('zii.widgets.jui.CJuiDialog');
			print "<PRE>".print_r($response['user'],true);
		} 
	}

	// print print_r($_SESSION,true);
?>
