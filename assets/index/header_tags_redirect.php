<?php
// --- COD DE REDIRECT AUTOMAT 301 ---
include_once(__DIR__ . '/../includes/config.php'); // Ajustează calea dacă e nevoie

$conn = new mysqli($dbGM['host'], $dbGM['user'], $dbGM['pass'], $dbGM['name']);
if ($conn->connect_error) die("Eroare DB: " . $conn->connect_error);

// Preluare URL curent
$currentUrl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Căutare redirect
$stmt = $conn->prepare("SELECT new_url FROM gm_redirects WHERE old_url = ? LIMIT 1");
$stmt->bind_param("s", $currentUrl);
$stmt->execute();
$stmt->bind_result($newUrl);

if ($stmt->fetch()) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $newUrl");
    exit;
}

$stmt->close();
$conn->close();

// --- Restul fișierului header_tags.php original ---
$descriptionPixelChar = 135;
$themeData['config_site_description'] = substr($themeData['config_site_description'], 0, $descriptionPixelChar);
$themeData['date_all_css'] = date("Y-m-d\TH-i", filemtime($_SERVER["DOCUMENT_ROOT"] . '/templates/' . $config['site_theme'] . '/css/' . 'all.css'));
$themeData['date_play_css'] = date("Y-m-d\TH-i", filemtime($_SERVER["DOCUMENT_ROOT"] . '/templates/' . $config['site_theme'] . '/css/' . 'play.css'));
$specialPage = ['best-games', 'new-games', 'featured-games', 'played-games'];
// ... restul codului tău rămâne neschimbat ...