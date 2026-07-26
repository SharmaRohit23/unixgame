<?php
header('Content-Type: application/json; charset=utf-8');

$SECRET_KEY = 'r@Jos1_p91r`t&Sq';

$rootPath = dirname(__DIR__, 3);
$configFile = $rootPath . '/assets/includes/config.php';

if (!file_exists($configFile)) {
	echo json_encode(['ok' => false, 'error' => 'Config file not found']);
	exit;
}

require_once $configFile;

function syncFail($msg) {
	echo json_encode(['ok' => false, 'error' => $msg]);
	exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	syncFail('Bad request');
}

$key = $_POST['key'] ?? '';

if (!hash_equals($SECRET_KEY, $key)) {
	syncFail('Bad key');
}

$type = $_POST['type'] ?? '';

if ($type === 'version_ping') {
		$jsonDir = $rootPath . '/json';
	if (!is_dir($jsonDir)) {
		@mkdir($jsonDir, 0755, true);
	}

	$localVersionFile = $jsonDir . '/cms-version.json';

	if (!file_exists($localVersionFile)) {
		file_put_contents($localVersionFile, json_encode([
			'version' => '9.0',
			'created_at' => date('Y-m-d H:i:s')
		], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
	}
	echo json_encode([
		'ok' => true,
		'domain' => $_SERVER['HTTP_HOST'] ?? '',
		'cms_version' => '9.0',
		'can_receive_updates' => true,
		'receiver' => '/assets/requests/admin/function.php',
		'last_seen' => date('Y-m-d H:i:s')
	]);
	exit;
}

if ($type === 'push_update') {
	$version = trim($_POST['version'] ?? '');
	$zipUrl = trim($_POST['zip_url'] ?? '');
	$sqlUrl = trim($_POST['sql_url'] ?? '');
	$message = trim($_POST['message'] ?? '');
	$autoUpdate = !empty($_POST['auto_update']) && $_POST['auto_update'] == '1';

	if ($version === '') syncFail('Missing update version');
	if ($zipUrl === '') syncFail('Missing ZIP URL');

	$jsonDir = $rootPath . '/json';
	if (!is_dir($jsonDir)) {
		@mkdir($jsonDir, 0755, true);
	}

	$localVersionFile = $jsonDir . '/cms-version.json';
	$noticeFile = $jsonDir . '/cms-update-notice.json';

	$localVersion = '9.0';
	if (file_exists($localVersionFile)) {
		$localData = json_decode(file_get_contents($localVersionFile), true);
		if (is_array($localData) && !empty($localData['version'])) {
			$localVersion = (string)$localData['version'];
		}
	}

	if (version_compare($localVersion, $version, '>=')) {
		echo json_encode([
			'ok' => true,
			'status' => 'already_latest',
			'local_version' => $localVersion,
			'pushed_version' => $version
		]);
		exit;
	}

	$notice = [
		'available' => true,
		'version' => $version,
		'zip_url' => $zipUrl,
		'sql_url' => $sqlUrl,
		'message' => $message,
		'received_at' => date('Y-m-d H:i:s')
	];

	file_put_contents($noticeFile, json_encode($notice, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

$autoUpdateStatus = 'manual_notice_only';

if ($autoUpdate) {
	
				$runFile = $rootPath . '/assets/requests/admin/cms-update-run.php';

				if (is_file($runFile)) {
					$_GET['action'] = 'run';

					ob_start();
					include $runFile;
					$autoResponse = ob_get_clean();

					$autoJson = json_decode($autoResponse, true);

					if (is_array($autoJson) && !empty($autoJson['ok'])) {
						$autoUpdateStatus = 'auto_update_complete';
					} else {
						$autoUpdateStatus = 'auto_update_failed';
					}
				} else {
					$autoUpdateStatus = 'auto_update_runner_missing';
				}

		}

		echo json_encode([
			'ok' => true,
			'status' => 'update_notice_saved',
			'auto_update' => $autoUpdate ? 1 : 0,
			'auto_update_status' => $autoUpdateStatus,
			'local_version' => $localVersion,
			'pushed_version' => $version
		]);
		exit;
}

$id = intval($_POST['id'] ?? 0);
$html = trim($_POST['html'] ?? '');

if (!in_array($type, ['game', 'tag'], true)) syncFail('Bad type');
if ($id <= 0) syncFail('Bad ID');
if ($html === '') syncFail('Missing HTML content');

$html = strip_tags($html, '<p><a><strong><b><em><i><h3><h4><br><ul><ol><li>');

$db = new mysqli($dbGM['host'], $dbGM['user'], $dbGM['pass'], $dbGM['name']);

if ($db->connect_error) {
	syncFail('DB connection failed');
}

$db->set_charset('utf8mb4');

function columnExists($db, $table, $column) {
	$table = $db->real_escape_string($table);
	$column = $db->real_escape_string($column);

	$res = $db->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
	return ($res && $res->num_rows > 0);
}

if ($type === 'game') {
	$table = 'gm_games';
	$idCol = columnExists($db, $table, 'game_id') ? 'game_id' : 'id';
	$textCol = 'description';
} else {
	$table = 'gm_tags';
	$idCol = columnExists($db, $table, 'tag_id') ? 'tag_id' : 'id';
	$textCol = 'footer_description';
}

if (!columnExists($db, $table, $textCol)) {
	syncFail("Missing column: $table.$textCol");
}

$stmt = $db->prepare("SELECT `$textCol` FROM `$table` WHERE `$idCol` = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();

if (!$row = $res->fetch_assoc()) {

    $fallback = $db->query("
        SELECT `$idCol`
        FROM `$table`
        ORDER BY RAND()
        LIMIT 1
    ");

    if ($fallback && $fallbackRow = $fallback->fetch_assoc()) {

        $id = (int)$fallbackRow[$idCol];

        $stmt = $db->prepare("
            SELECT `$textCol`
            FROM `$table`
            WHERE `$idCol` = ?
            LIMIT 1
        ");

        $stmt->bind_param('i', $id);
        $stmt->execute();

        $res = $stmt->get_result();
        $row = $res->fetch_assoc();

    } else {
        syncFail('ID not found');
    }
}

$oldText = $row[$textCol] ?? '';

if (strpos($oldText, $html) !== false) {
	 

	$publicUrl = '';

if ($type === 'game' && columnExists($db, $table, 'game_name')) {
	$urlRes = $db->query("SELECT `game_name` FROM `$table` WHERE `$idCol` = " . (int)$id . " LIMIT 1");
	if ($urlRes && $urlRow = $urlRes->fetch_assoc()) {
		$slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $urlRow['game_name']), '-'));
		$publicUrl = 'https://' . ($_SERVER['HTTP_HOST'] ?? '') . '/game/' . $slug;
	}
}

if ($type === 'tag' && columnExists($db, $table, 'url')) {
	$urlRes = $db->query("SELECT `url` FROM `$table` WHERE `$idCol` = " . (int)$id . " LIMIT 1");
	if ($urlRes && $urlRow = $urlRes->fetch_assoc()) {
		$publicUrl = 'https://' . ($_SERVER['HTTP_HOST'] ?? '') . '/tag/' . trim($urlRow['url'], '/');
	}
}

echo json_encode([
	'ok' => true,
	'message' => 'Backlink inserted',
	'type' => $type,
	'id' => $id,
	'used_id' => $id,
	'public_url' => $publicUrl,
	'table' => $table,
	'column' => $textCol
]);
	exit;
}

$newText = trim($oldText . "\n\n" . $html);

$stmt = $db->prepare("UPDATE `$table` SET `$textCol` = ? WHERE `$idCol` = ? LIMIT 1");
$stmt->bind_param('si', $newText, $id);

if (!$stmt->execute()) {
	syncFail('Update failed');
}

echo json_encode([
	'ok' => true,
	'message' => 'Backlink inserted',
	'type' => $type,
	'id' => $id,
	'table' => $table,
	'column' => $textCol
]);