<?php

require_once('config.inc.php');

if ($_SERVER['REQUEST_METHOD'] != "POST") {
	//$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
	//header($protocol . ' 405 Method Not Allowed');

	die('Not permited');
}

$postData = getallheaders();

$device_hash = $postData['deviceHash'];
$device_name = $postData['deviceName'];
$device_version = $postData['deviceVersion'];
$device_country = $postData['deviceCountry'];
$device_carrier = $postData['deviceCarrier'];
$device_carrier_id = $postData['deviceCarrierId'];

$rom_name = $postData['romName'];
$rom_version = $postData['romVersion'];

if (empty($device_hash))
{
    die('Incomplete hash');
}

if (empty($device_name))
{
    die('Incomplete name');
}

if (empty($device_version))
{
    die('Incomplete version');
}

if (empty($rom_name))
{
    die('Incomplete ROM');
}

$deviceData = DB::query('SELECT * FROM zrom_stats WHERE device_hash = %s', $device_hash);

if ($deviceData) {
	DB::update('zrom_stats', array(
		'date_last_checking' => DB::sqlEval("NOW()"),
		'device_name' => $device_name,
		'device_version' => $device_version,
		'device_country' => $device_country,
		'device_carrier' => $device_carrier,
		'device_carrier_id' => $device_carrier_id,
		'rom_name' => $rom_name,
		'rom_version' => $rom_version
	), "device_hash=%s", $device_hash);
} else {
	DB::insert('zrom_stats', array(
		'date_register' => DB::sqlEval("NOW()"),
		'date_last_checking' => DB::sqlEval("NOW()"),
		'device_hash' => $device_hash,
		'device_name' => $device_name,
		'device_version' => $device_version,
		'device_country' => $device_country,
		'device_carrier' => $device_carrier,
		'device_carrier_id' => $device_carrier_id,
		'rom_name' => $rom_name,
		'rom_version' => $rom_version
	));
}

echo "OK";
