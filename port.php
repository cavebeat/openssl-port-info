<?php

/* Created @ 24.02.2015 by Christian Mayer <http://fox21.at> */

/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <christian@fox21.at> wrote this file.  As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return.   Christian Mayer
 * ----------------------------------------------------------------------------
 */


$ip = $_SERVER['REMOTE_ADDR'];

$action = isset($_GET['action']) ? $_GET['action'] : null;
#$ip = isset($_POST['ip']) ? $_POST['ip'] : 'encrypted.google.com';
$port = isset($_POST['port']) ? (int)$_POST['port'] : 443;
$output = '';

switch($action){
	case 'exec':
		if($ip && $port && $port <= 0xffff){
			exec('openssl s_client -connect '.$ip.':'.$port, $output, $code);
			if($code){
				$output = 'Not working with '.$ip.':'.$port.'. Code: '.$code;
			}
			else{
				$output = join(PHP_EOL, $output);
			}
		}
		else{
			$output = 'Wrong input.';
		}
		break;
	
	default:
		break;
}

?><!DOCTYPE html>
<html>
	<head>
		<title>Port Checker</title>
	</head>
	<body>
		<form method="post" action="?action=exec">
			<fieldset>
				<div>
					<label>Your IP:</label>
					<input name="ip" type="text" value="<?php print $ip; ?>">
				</div>

				<div>
					<label>Port:</label>
					<input name="port" type="text" value="<?php print $port; ?>">
				</div>

				<div>
					<input type="submit" value="Check" />
				</div>
			</fieldset>
		</form>
<?php if($output): ?>
		<p>
			<pre><?php print $output; ?></pre>
		</p>
<?php endif; ?>
	</body>
</html>