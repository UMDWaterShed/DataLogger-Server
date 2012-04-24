<?php
require 'settings.inc.php';

$dbconn = mysql_connect($server,$user,$pass);

if (!$dbconn) {
    die(mysql_error());
}

mysql_select_db($dbname, $dbconn);

$result = mysql_query("SELECT max(`PointID`) as n FROM datapoints");

$datapoint = 0;

while($row = mysql_fetch_array($result)) {
    if (is_numeric($row['n'])) {
        $datapoint = $row['n'];
        header('X-LastPoint: ' . $datapoint);
    } else {
        header('X-LastPoint: 0');
    }
}

mysql_close($dbconn);

header('Content-Type: text/plain',true);
header('X-Powered-By: WaterShed ServerSide', true);
echo $datapoint;
flush();