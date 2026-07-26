<?php
if (!defined('R_PILOT')) {
    define('R_PILOT', true);
}

require_once dirname(__DIR__) . '/includes/ai-helper.php';

echo "LINKSCMSAI TAGS HIT<br>";

$tagsData = $GameMonetizeConnect->query("
    SELECT * FROM " . TAGS . "
    WHERE footer_description IS NULL
       OR TRIM(footer_description) = ''
       OR LOWER(TRIM(footer_description)) = 'footer description'
       OR is_rewrited = 0
    ORDER BY id DESC
    LIMIT 1
");

if (!$tagsData || $tagsData->num_rows < 1) {
    echo "No tags found to rewrite.";
    return;
}

$tags = $tagsData->fetch_array();
$currentId = (int)$tags['id'];

$footerDescription = trim(strip_tags((string)$tags['footer_description']));

if ($footerDescription !== '' && strtolower($footerDescription) !== 'footer description' && $tags['is_rewrited'] == '1') {
    echo "Tag already rewritten and has description: " . htmlspecialchars($tags['name']);
    return;
}

$tagTitle = trim((string)$tags['name']);

$prompt = "Game category: " . $tagTitle . " Games

Description:
Write a clean gaming website description for this category. Explain what players can expect, why this category is fun, and what kind of gameplay it usually includes. Use simple English.";

$rewritedTags = cmsAiRewrite($GameMonetizeConnect, $prompt);

echo "AI RESULT TYPE: " . gettype($rewritedTags) . "<br>";
echo "AI RESULT LEN: " . strlen((string)$rewritedTags) . "<br>";

if ($rewritedTags === false || strlen(trim((string)$rewritedTags)) < 30) {
    $aiError = !empty($GLOBALS['cms_ai_last_error']) ? $GLOBALS['cms_ai_last_error'] : 'Unknown CMS AI error';
    echo "CMS AI failed rewriting tag: " . htmlspecialchars($tagTitle) . "<br>Reason: " . htmlspecialchars($aiError);
    return;
}
$rewritedTags = strip_tags((string)$rewritedTags);
$rewritedTags = preg_replace('/game description\s*:/i', '', $rewritedTags);
$rewritedTags = preg_replace('/rules\s*:.*$/is', '', $rewritedTags);
$rewritedTags = preg_replace('/html only.*$/is', '', $rewritedTags);
$rewritedTags = preg_replace('/return only.*$/is', '', $rewritedTags);
$rewritedTags = preg_replace('/```.*?```/is', '', $rewritedTags);
$rewritedTags = preg_replace('/\s+/', ' ', $rewritedTags);
$rewritedTags = trim($rewritedTags);

if ($rewritedTags !== '') {
    $rewritedTags = '<p>' . $rewritedTags . '</p>';
}
$safeRewrite = mysqli_real_escape_string($GameMonetizeConnect, trim((string)$rewritedTags));

$updateTags = $GameMonetizeConnect->query("
    UPDATE " . TAGS . "
    SET footer_description = '{$safeRewrite}',
        is_rewrited = 1
    WHERE id = {$currentId}
");

if (!$updateTags) {
    echo "Failed to update tag: " . htmlspecialchars($tagTitle) . "<br>";
    echo htmlspecialchars($GameMonetizeConnect->error);
    return;
}

$GameMonetizeConnect->query("UPDATE " . LINKS . " SET last_id = '{$currentId}' WHERE name = 'autopost_tags'");

$themeData['page_content'] = "Successfully rewriting tag: " . htmlspecialchars($tagTitle) . "<br>Current id: " . $currentId;
echo $themeData['page_content'];
return;