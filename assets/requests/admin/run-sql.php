<?php
require_once __DIR__ . '/../../../assets/includes/core.php';

if (!isset($GLOBALS['access']) || $GLOBALS['access'] !== true) {
	http_response_code(403);
	exit('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(405);
	exit('Invalid request.');
}

$sql = isset($_POST['sql_code']) ? trim($_POST['sql_code']) : '';

/*
	Fix escaped quotes coming from admin textarea / server config.
	Example: \'text\' becomes 'text'
*/
$sql = str_replace(array("\\'", '\\"'), array("'", '"'), $sql);
$sql = stripslashes($sql);
 
if ($sql === '') {
	exit('No SQL received.');
}

/*
	Safety block.
	Allow common manual admin SQL.
	Remove DROP/TRUNCATE by default because one mistake can destroy tables.
*/
$blocked = array(
	'/\bDROP\b/i',
	'/\bTRUNCATE\b/i',
	'/\bGRANT\b/i',
	'/\bREVOKE\b/i',
	'/\bCREATE\s+USER\b/i',
	'/\bALTER\s+USER\b/i',
	'/\bLOAD_FILE\b/i',
	'/\bINTO\s+OUTFILE\b/i',
	'/\bINTO\s+DUMPFILE\b/i'
);

foreach ($blocked as $pattern) {
	if (preg_match($pattern, $sql)) {
		http_response_code(400);
		exit('Blocked dangerous SQL command.');
	}
}

global $conn, $GameMonetizeConnect;

$db = null;

if (isset($conn) && $conn instanceof mysqli) {
	$db = $conn;
} elseif (isset($GameMonetizeConnect) && $GameMonetizeConnect instanceof mysqli) {
	$db = $GameMonetizeConnect;
}

if (!$db) {
	http_response_code(500);
	exit('Database connection not found. Check your core.php connection variable name.');
}

try {
	if (!$db->multi_query($sql)) {
		http_response_code(500);
		exit('SQL error: ' . $db->error);
	}
} catch (mysqli_sql_exception $e) {
	http_response_code(500);
	exit('SQL error: ' . $e->getMessage());
}

$output = '';

do {
	if ($result = $db->store_result()) {
		$rows = array();

		while ($row = $result->fetch_assoc()) {
			$rows[] = $row;
		}

		if (!empty($rows)) {
			$output .= print_r($rows, true) . "\n";
		} else {
			$output .= "Query returned 0 rows.\n";
		}

		$result->free();
	} else {
		if ($db->affected_rows >= 0) {
			$output .= "OK. Affected rows: " . $db->affected_rows . "\n";
		}
	}

	if (!$db->more_results()) {
		break;
	}

	$output .= "\n--- NEXT RESULT ---\n";
} while ($db->next_result());

if ($db->errno) {
	http_response_code(500);
	exit('SQL error: ' . $db->error);
}

echo $output !== '' ? $output : 'SQL executed.';
