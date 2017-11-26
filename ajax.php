<?php
error_reporting(E_ALL);
if ($_REQUEST['token']!='HgjHGKJHjHJKhKhKHKh') {
	exit;
}

switch ($_REQUEST['do']) {
	case 'save_entry':
		if (!empty($_REQUEST['list_id'])) {
			$file_name = $_REQUEST['list_id'].'.dat';
			if (file_exists($file_name)) {
				$lines = file($file_name);
				$lines[] = $_REQUEST['entry']."\n";	
			} else {
				$lines = array($_REQUEST['entry']."\n");
			}
			$content = implode("", $lines);
			$handle = fopen($file_name, 'w');
			fwrite($handle, $content);
			fclose($handle);
			send_push('Ein TODO-Eintrag wurde hinzugefügt.');
			print 'OK';	
		}
		break;

	case 'delete_entry':
		if (!empty($_REQUEST['list_id']) && isset($_REQUEST['entry'])) {
			$file_name = $_REQUEST['list_id'].'.dat';
			if (file_exists($file_name)) {
				$lines = file($file_name);
				if (!empty($lines) && isset($lines[$_REQUEST['entry']])) {
					unset($lines[$_REQUEST['entry']]);
				}
				$content = !empty($lines)? implode("", $lines) : '';
				$handle = fopen($file_name, 'w');
				fwrite($handle, $content);
				fclose($handle);
				send_push('Ein TODO-Eintrag wurde entfernt.');
				print 'OK';	
			}
		}
		break;

	case 'get_list':
		if (!empty($_REQUEST['list_id'])) {
			$file_name = $_REQUEST['list_id'].'.dat';
			if (file_exists($file_name)) {
				$lines = file($file_name);
				print json_encode($lines);
			}
		}
		break;
}

function send_push($message) {
	curl_setopt_array(
		$ch = curl_init(), array(
			CURLOPT_URL => "https://api.pushover.net/1/messages.json",
			CURLOPT_POSTFIELDS => array(
				"token" => "argtgpis3yx9em28n5xmxitgbz7erh",
				"user" => "villa-pusher",
				"message" => $message,
			)
		)
	);
	curl_exec($ch);
	curl_close($ch);
}

?>