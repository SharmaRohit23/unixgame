<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 

$helperPath = dirname(__DIR__) . '/includes/ai-helper.php';

 
if (!file_exists($helperPath)) {
    echo "STOP: ai-helper.php not found<br>";
    return;
}
 
if (!defined('R_PILOT')) {
    define('R_PILOT', true);
}

require_once $helperPath;

if (!function_exists('cmsAiRewrite')) {
    echo "STOP: cmsAiRewrite function not found<br>";
    return;
}


if (!defined('R_PILOT')) {
    exit();
}

require_once dirname(__DIR__) . '/includes/ai-helper.php';

function cmsai_autopost_status($name, $status, $message = '')
{
    $dir = $_SERVER['DOCUMENT_ROOT'] . '/gm-content';
    $file = $dir . '/autopost-status.json';

    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }

    $data = [];
    if (file_exists($file)) {
        $json = file_get_contents($file);
        $data = json_decode($json, true);
        if (!is_array($data)) {
            $data = [];
        }
    }

    $data[$name] = [
        'status' => $status,
        'message' => $message,
        'time' => date('Y-m-d H:i:s')
    ];

    @file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);
}

$isError = false;
$installedGamesCounter = 0;
$installedGamesMaximum = 1;
$lastTitle = '';

$catalog = @file_get_contents('https://gamemonetize.com/feed.php?format=0&num=30');

echo "LINKSCMSAI HIT<br>";


if (!$catalog) {
    cmsai_autopost_status('autopost', 'error', 'Could not load GameMonetize feed.');
    $themeData['page_content'] = 'CMS AI autopost failed: could not load GameMonetize feed.';
    return;
}

$games = json_decode($catalog, true);

if (!is_array($games)) {
    cmsai_autopost_status('autopost', 'error', 'Invalid GameMonetize feed JSON.');
    $themeData['page_content'] = 'CMS AI autopost failed: invalid feed JSON.';
    return;
}

foreach ($games as $game) {
    if ($installedGamesCounter >= $installedGamesMaximum) {
        break;
    }

    if (empty($game['title']) || empty($game['url'])) {
        continue;
    }

    $title = seo_friendly_url($game['title']);
    $lastTitle = $title;

    $safeTitleCheck = mysqli_real_escape_string($GameMonetizeConnect, $title);
    $exists = $GameMonetizeConnect->query("SELECT game_id FROM `" . GAMES . "` WHERE `game_name` = '{$safeTitleCheck}' LIMIT 1");

    if ($exists && $exists->num_rows > 0) {
        continue;
    }

    $originalDescription = !empty($game['description']) ? trim((string)$game['description']) : '';

    if ($originalDescription === '' || strlen($originalDescription) < 10) {
        cmsai_autopost_status('autopost', 'warning', 'Skipped game with empty description: ' . $game['title']);
        continue;
    }

    $prompt = "Game title: " . $game['title'] . "\n\nDescription:\n" . $originalDescription;

    $rewrittenDescription = cmsAiRewrite($GameMonetizeConnect, $prompt);
    echo "AI RESULT TYPE: " . gettype($rewrittenDescription) . "<br>";
    echo "AI RESULT LEN: " . strlen((string)$rewrittenDescription) . "<br>";

    if ($rewrittenDescription === false || strlen(trim((string)$rewrittenDescription)) < 30) {
        $aiError = !empty($GLOBALS['cms_ai_last_error']) ? $GLOBALS['cms_ai_last_error'] : 'Unknown CMS AI error';
        cmsai_autopost_status('autopost', 'error', 'Game was not inserted because CMS AI rewrite failed. Reason: ' . $aiError);
        $themeData['page_content'] = 'CMS AI rewrite failed. No game inserted. Reason: ' . htmlspecialchars($aiError);
        return;
    }

    $rewrittenDescription = trim((string)$rewrittenDescription);
    $rewrittenDescription = preg_replace('#<br\s*/?>#i', '', $rewrittenDescription);
    $rewrittenDescription = preg_replace('#<a\b[^>]*>(.*?)</a>#is', '$1', $rewrittenDescription);
    $rewrittenDescription = preg_replace('#>\s+<#', '><', $rewrittenDescription);
    $rewrittenDescription = trim($rewrittenDescription);

    $gameName = secureEncode($title);
    $name = secureEncode($game['title']);
    $description = secureEncode($rewrittenDescription);
    $instructions = !empty($game['instructions']) ? secureEncode($game['instructions']) : '';
    $file = secureEncode($game['url']);
    $image = !empty($game['thumb']) ? secureEncode($game['thumb']) : '';
    $width = !empty($game['width']) ? (int)$game['width'] : 800;
    $height = !empty($game['height']) ? (int)$game['height'] : 600;
    $catalogId = !empty($game['id']) ? secureEncode($game['id']) : '';

    $category = 1;

    if (!empty($game['category'])) {
        $feedCategories = array_values(array_filter(array_map('trim', explode(',', $game['category']))));

        foreach ($feedCategories as $feedCategoryName) {
            $categoryData = getCategoriesLikeName($feedCategoryName);

            if (!empty($categoryData) && !empty($categoryData['id'])) {
                $category = (int)$categoryData['id'];
                break;
            }
        }

        if ((int)$category === 1 && !empty($feedCategories[0]) && function_exists('getOrCreateCategory')) {
            $createdCategoryId = getOrCreateCategory($feedCategories[0]);
            if ($createdCategoryId > 0) {
                $category = (int)$createdCategoryId;
            }
        }
    }

    $tags = '[]';

    if (!empty($game['tags'])) {
        $allTags = explode(',', $game['tags']);
        $allTagsId = [];

        foreach ($allTags as $tag) {
            $tag = trim($tag);
            if ($tag === '') {
                continue;
            }

            $tagData = getTagsLikeName($tag);
            if (!empty($tagData['id'])) {
                $allTagsId[] = '"' . (int)$tagData['id'] . '"';
            }
        }

        if (!empty($allTagsId)) {
            $tags = '[' . implode(',', $allTagsId) . ']';
        }
    }

    $wtVideo = '';
    if (function_exists('getRealGameMonetizeWtVideo')) {
        $wtVideo = getRealGameMonetizeWtVideo($file);
    }

    $safeWtVideo = mysqli_real_escape_string($GameMonetizeConnect, $wtVideo);

    $insert = $GameMonetizeConnect->query("
        INSERT INTO " . GAMES . " (
            catalog_id,
            game_name,
            name,
            image,
            description,
            instructions,
            category,
            file,
            game_type,
            w,
            h,
            date_added,
            tags_ids,
            published,
            wt_video
        ) VALUES (
            'gamemonetize-{$catalogId}',
            '{$gameName}',
            '{$name}',
            '{$image}',
            \"{$description}\",
            '{$instructions}',
            '{$category}',
            '{$file}',
            'html5',
            '{$width}',
            '{$height}',
            '{$time}',
            '{$tags}',
            '1',
            '{$safeWtVideo}'
        )
    ");

    if (!$insert) {
        cmsai_autopost_status('autopost', 'error', 'DB insert failed: ' . $GameMonetizeConnect->error);
        $themeData['page_content'] = 'CMS AI autopost DB insert failed: ' . htmlspecialchars($GameMonetizeConnect->error);
        return;
    }

    $installedGamesCounter++;

    if (function_exists('addGameXml')) {
        addGameXml(siteUrl() . '/game/' . $gameName);
    }

    cmsai_autopost_status('autopost', 'success', 'CMS AI inserted game: ' . $name);
    break;
}

if ($installedGamesCounter < 1 && $lastTitle == '') {
    $themeData['page_content'] = "No new game found in feed.";
    echo $themeData['page_content'];
    return;
}

$themeData['page_content'] = $installedGamesCounter . ' ' . $lang['admin_premium_games_installed'] . ' - ' . $lastTitle;
return;