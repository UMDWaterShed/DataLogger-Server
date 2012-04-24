<?php
require 'settings.inc.php';

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="WaterShed Data"');
    header('HTTP/1.0 401 Unauthorized');
    exit;
}

if (stripos($_SERVER['HTTP_USER_AGENT'], $userAgent) === false) {
	header('HTTP/1.0 404 Not Found');
    exit;
}

if ($_SERVER['PHP_AUTH_USER'] !== $postUser || $_SERVER['PHP_AUTH_PW'] !== $postPass) {
    header('HTTP/1.0 403 Forbidden');
	
	/** CODE FOR DEBUGGING */
	/*$myFile = "data".time().".txt";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$headers = apache_request_headers();
	foreach ($headers as $k => $v) {
		fwrite($fh, $k . ": " . $v . "\n");
	}
	fwrite($fh, "\n");
	
	fwrite($fh, "\n" . print_r($_SERVER['PHP_AUTH_USER'], true));
	fwrite($fh, "\n" . print_r($postUser, true));
	fwrite($fh, "\n" . print_r($_SERVER['PHP_AUTH_PW'], true));
	fwrite($fh, "\n" . print_r($postPass, true));
	
	fclose($fh);*/
	
    exit;
}

$dbconn = @new mysqli($server, $user, $pass, $dbname);

if ($dbconn->connect_errno) {
    die('Connect Error: ' . $dbconn->connect_errno);
}

$inputJSON = file_get_contents('php://input');

$inputJSON = preg_replace( '/[^[:print:]]/', '',$inputJSON);

$input = json_decode( $inputJSON, TRUE );

/** CODE FOR DEBUGGING */
//$myFile = "data".time().".txt";
//$fh = fopen($myFile, 'w') or die("can't open file");
//$headers = apache_request_headers();
//foreach ($headers as $k => $v) {
//    fwrite($fh, $k . ": " . $v . "\n");
//}
//fwrite($fh, "\n");
//fwrite($fh, print_r($inputJSON, true));
//
//fwrite($fh, "\n");
//fwrite($fh, print_r($input, true));
//fclose($fh);
//
//reset($input);

$sqlstring = 'INSERT INTO datapoints VALUES(?, ?, ?, ?, ?)';
$stmt = $dbconn->stmt_init();
if ($stmt->prepare($sqlstring)) {
	echo "Query Prepared\n";
	$stmt->bind_param('issss', $point_id, $point_sys, $point_name, $point_val, $point_time);

	foreach ($input as $point) {
		echo "Insert: " . $point['id'] ;
		$point_id = $point['id'];
		$point_sys = $point['system'];
		$point_name = $point['sensor'];
		$point_val = $point['value'];
		$point_time = date("y-m-d H:i:s", strtotime($point['timestamp']));
		$stmt->execute();
		printf(" - %d row\n", $stmt->affected_rows);
		if ($stmt->errno) {
			printf("\t Error: %s.\n", $stmt->error);
		}
	}
}

$dbconn->close();
