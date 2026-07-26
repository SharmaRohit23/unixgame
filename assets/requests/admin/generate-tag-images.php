<?php
require_once '../../../assets/includes/core.php';

header('Content-Type: application/json; charset=utf-8');

if (!is_logged() || !is_admin()) {
	echo json_encode(array(
		'status' => 0,
		'message' => 'Unauthorized'
	));
	exit;
}

require_once ABSPATH . 'assets/includes/tag-image-generator.php';

$action = isset($_POST['action']) ? trim((string)$_POST['action']) : 'generate';

if ($action === 'status') {
	$result = gmTagImageGetStatus();

	echo json_encode(array(
		'status' => 1,
		'message' => 'Tag image status loaded',
		'data' => $result
	));
	exit;
}

if ($action === 'reset') {
	gmTagImageResetProgress();

	$result = gmTagImageGetStatus();

	echo json_encode(array(
		'status' => 1,
		'message' => 'Tag image remake progress reset',
		'data' => $result
	));
	exit;
}

$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 100;
$force = !empty($_POST['force']) ? true : false;

$result = gmGenerateMissingTagImages($limit, false, $force);

echo json_encode(array(
	'status' => 1,
	'message' => 'Tag image generation finished',
	'data' => $result
));
exit;