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
				$lines[] = $_REQUEST['entry'];	
			} else {
				$lines = array($_REQUEST['entry']);
			}
			$content = implode("\n", $lines);
			$handle = fopen($file_name, 'w');
			fwrite($handle, $content);
			fclose($handle);
			
			print 'OK';	
		}
		break;

	case 'delete_entry':
		if (!empty($_REQUEST['list_id']) && !empty($_REQUEST['entry'])) {
			$file_name = $_REQUEST['list_id'].'.dat';
			if (file_exists($file_name)) {
				$lines = file($file_name);
				if (!empty($lines) && !empty($lines[$_REQUEST['entry']])) {
					unset($lines[$_REQUEST['entry']]);
				}
				$content = !empty($lines)? implode("\n", $lines) : '';
				$handle = fopen($file_name, 'w');
				fwrite($handle, implode("\n", $content));
				fclose($handle);
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

?>