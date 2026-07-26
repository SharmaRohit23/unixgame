<?php
if (!defined('R_PILOT')) {
    define('R_PILOT', true);
}

require_once dirname(__DIR__) . '/includes/ai-helper.php';

echo "LINKSCMSAI OLD GAMES HIT<br>";

$lastId = (int)$linksData['last_id'];

$gameData = $GameMonetizeConnect->query("
    SELECT * FROM " . GAMES . "
    WHERE game_id > '{$lastId}'
      AND published = '1'
    ORDER BY game_id ASC
    LIMIT 1
");

if (!$gameData || $gameData->num_rows < 1) {
    echo "No more old games found. Last ID was: " . $lastId;
    return;
}

$game = $gameData->fetch_array();
$currentId = (int)$game['game_id'];

$lastRewriteGame = $GameMonetizeConnect->query("SELECT game_id FROM " . GAMES . " WHERE is_last_rewrite = '1' LIMIT 1");
if ($lastRewriteGame && $lastRewriteGame->num_rows > 0) {
    $lastRewriteGame = $lastRewriteGame->fetch_array();
    if ((int)$lastRewriteGame['game_id'] == $currentId) {
        echo "Last rewrite game reached. Current ID: " . $currentId;
        return;
    }
}

$gameTitle = trim((string)$game['name']);
$gameDescription = trim(strip_tags((string)$game['description']));

if ($gameDescription === '' || strlen($gameDescription) < 20) {
    $GameMonetizeConnect->query("UPDATE " . LINKS . " SET last_id = '{$currentId}' WHERE name = 'autopost_old_games'");
    echo "Skipped empty description: " . htmlspecialchars($gameTitle);
    echo "<br>Current id: " . $currentId;
    return;
}

$prompt = "Game title: " . $gameTitle . "\n\nDescription:\n" . $gameDescription;

$rewrittenDescription = cmsAiRewrite($GameMonetizeConnect, $prompt);

echo "AI RESULT TYPE: " . gettype($rewrittenDescription) . "<br>";
echo "AI RESULT LEN: " . strlen((string)$rewrittenDescription) . "<br>";

if ($rewrittenDescription === false || strlen(trim((string)$rewrittenDescription)) < 30) {
    $aiError = !empty($GLOBALS['cms_ai_last_error']) ? $GLOBALS['cms_ai_last_error'] : 'Unknown CMS AI error';
    echo "CMS AI failed rewriting old game: " . htmlspecialchars($gameTitle) . "<br>Reason: " . htmlspecialchars($aiError);
    return;
}

$rewrittenDescription = trim((string)$rewrittenDescription);
$rewrittenDescription = preg_replace('#<br\s*/?>#i', '', $rewrittenDescription);
$rewrittenDescription = preg_replace('#<a\b[^>]*>(.*?)</a>#is', '$1', $rewrittenDescription);
$rewrittenDescription = preg_replace('#>\s+<#', '><', $rewrittenDescription);
$rewrittenDescription = trim($rewrittenDescription);

$safeDescription = mysqli_real_escape_string($GameMonetizeConnect, $rewrittenDescription);

$updateGame = $GameMonetizeConnect->query("
    UPDATE " . GAMES . "
    SET description = '{$safeDescription}'
    WHERE game_id = {$currentId}
");

if (!$updateGame) {
    echo "Failed to update old game: " . htmlspecialchars($gameTitle) . "<br>";
    echo htmlspecialchars($GameMonetizeConnect->error);
    return;
}

$GameMonetizeConnect->query("UPDATE " . LINKS . " SET last_id = '{$currentId}' WHERE name = 'autopost_old_games'");

$themeData['page_content'] = "Successfully rewriting old game: " . htmlspecialchars($gameTitle) . "<br>Current id: " . $currentId;
echo $themeData['page_content'];
return;