<?php
if (!defined('R_PILOT')) {
    exit();
}

function cmsAiNormalizeDomain($domain)
{
    $domain = strtolower(trim((string)$domain));
    $domain = preg_replace('#^https?://#', '', $domain);
    $domain = preg_replace('#/.*$#', '', $domain);
    $domain = preg_replace('/^www\./', '', $domain);
    return preg_replace('/[^a-z0-9\.\-]/', '', $domain);
}

function cmsAiRequest($url, $postData, $timeout = 25)
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($postData),
        CURLOPT_TIMEOUT => $timeout,
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode((string)$response, true);
}

function cmsAiGetDomain()
{
    if (function_exists('siteUrl')) {
        return cmsAiNormalizeDomain(siteUrl());
    }

    return cmsAiNormalizeDomain($_SERVER['HTTP_HOST'] ?? '');
}

function cmsAiEnsureRegistered($db)
{
    $domain = cmsAiGetDomain();

    if ($domain === '') {
        return false;
    }

    $row = null;
    $q = $db->query("SELECT cms_ai_key, cms_ai_domain, cms_ai_registered FROM gm_chatgpt WHERE id = 1 LIMIT 1");
    if ($q && $q->num_rows > 0) {
        $row = $q->fetch_assoc();
    }

    if (!empty($row['cms_ai_key']) && !empty($row['cms_ai_registered']) && cmsAiNormalizeDomain($row['cms_ai_domain']) === $domain) {
        return $row['cms_ai_key'];
    }

    $start = cmsAiRequest('https://www.freecronjob.com.es/local-ai/register-start', [
        'domain' => $domain
    ], 20);

    if (empty($start['ok']) || empty($start['token']) || empty($start['verify_file'])) {
        return false;
    }

    $token = preg_replace('/[^a-f0-9]/', '', $start['token']);
    $verifyFile = basename($start['verify_file']);

    if ($token === '' || $verifyFile === '') {
        return false;
    }

    $verifyPath = rtrim((string)($_SERVER['DOCUMENT_ROOT'] ?? ''), '/') . '/' . $verifyFile;
    if ($verifyPath === '/' . $verifyFile) {
        return false;
    }

    if (file_put_contents($verifyPath, $token, LOCK_EX) === false) {
        file_put_contents(__DIR__ . '/../requests/admin/ai_helper_debug.log', date('Y-m-d H:i:s') . " cannot write verify file: {$verifyPath}\n", FILE_APPEND);
        return false;
    }

    $check = cmsAiRequest('https://www.freecronjob.com.es/local-ai/register-check', [
        'domain' => $domain,
        'token' => $token
    ], 30);

    if (empty($check['ok']) || empty($check['key'])) {
        file_put_contents(__DIR__ . '/../requests/admin/ai_helper_debug.log', date('Y-m-d H:i:s') . " register-check failed: " . json_encode($check) . "\n", FILE_APPEND);
        return false;
    }

    $key = mysqli_real_escape_string($db, (string)$check['key']);
    $domainSafe = mysqli_real_escape_string($db, $domain);

    $db->query("
        INSERT INTO gm_chatgpt (id, cms_ai_key, cms_ai_domain, cms_ai_registered)
        VALUES (1, '{$key}', '{$domainSafe}', 1)
        ON DUPLICATE KEY UPDATE
            cms_ai_key = '{$key}',
            cms_ai_domain = '{$domainSafe}',
            cms_ai_registered = 1
    ");

    return (string)$check['key'];
}

function cmsAiRewrite($db, $text)
{
    file_put_contents(
        $_SERVER['DOCUMENT_ROOT'].'/cms-ai-debug.txt',
        date('Y-m-d H:i:s') . " ENTER cmsAiRewrite\nTEXT LENGTH=" . strlen((string)$text) . "\n",
        FILE_APPEND
    );

    $text = trim((string)$text);
    if ($text === '') {
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/cms-ai-debug.txt', "STOP: empty text\n", FILE_APPEND);
        return false;
    }

    $domain = cmsAiGetDomain();

    file_put_contents(
        $_SERVER['DOCUMENT_ROOT'].'/cms-ai-debug.txt',
        "DOMAIN={$domain}\n",
        FILE_APPEND
    );

    $key = cmsAiEnsureRegistered($db);

    if (!$key) {
        file_put_contents(
            $_SERVER['DOCUMENT_ROOT'].'/cms-ai-debug.txt',
            "STOP: cmsAiEnsureRegistered returned false\n",
            FILE_APPEND
        );
        return false;
    }

    file_put_contents(
        $_SERVER['DOCUMENT_ROOT'].'/cms-ai-debug.txt',
        "KEY OK=" . substr($key, 0, 15) . "...\n",
        FILE_APPEND
    );

    $cleanText = trim(strip_tags($text));
$cleanText = preg_replace('/\s+/', ' ', $cleanText);

/* Remove common CMS prompt text before sending to VPS AI */
$cleanText = preg_replace('/write one unique seo-friendly html paragraph about the game using\s+/i', '', $cleanText);
$cleanText = preg_replace('/\s+as reference\.?\s*/i', ' ', $cleanText);
$cleanText = preg_replace('/do not add headings.*$/i', '', $cleanText);
$cleanText = preg_replace('/return only.*$/i', '', $cleanText);

$cleanText = trim($cleanText);
$cleanText = mb_substr($cleanText, 0, 12000);

if ($cleanText === '' || mb_strlen($cleanText) < 30) {
    return false;
}

$rewrite = cmsAiRequest('https://www.freecronjob.com.es/local-ai/rewrite', [
    'domain' => $domain,
    'key' => $key,
    'text' => $cleanText
], 240);

file_put_contents(
    $_SERVER['DOCUMENT_ROOT'].'/cms-ai-debug.txt',
    date('Y-m-d H:i:s') .
    "\nDOMAIN=".$domain .
    "\nKEY=".substr($key,0,15)."..." .
    "\nRESULT=" . print_r($rewrite, true) .
    "\n------------------\n",
    FILE_APPEND
);

file_put_contents(
    __DIR__ . '/../requests/admin/ai_helper_debug.log',
    date('Y-m-d H:i:s') .
    " CMSAI RESPONSE: " .
    json_encode($rewrite) .
    "\n",
    FILE_APPEND
);

    if (empty($rewrite['ok']) || empty($rewrite['rewrite'])) {
    file_put_contents(__DIR__ . '/../requests/admin/ai_helper_debug.log', date('Y-m-d H:i:s') . " rewrite failed: " . json_encode($rewrite) . "\n", FILE_APPEND);
    if (!empty($rewrite['error'])) {
    $GLOBALS['cms_ai_last_error'] = $rewrite['error'];

    file_put_contents(
        $_SERVER['DOCUMENT_ROOT'].'/cms-ai-debug.txt',
        "ERROR: ".$rewrite['error']."\n",
        FILE_APPEND
    );
}
return false;
}

$result = trim((string)$rewrite['rewrite']);

$plainOriginal = strtolower(trim(strip_tags($cleanText)));
$plainResult   = strtolower(trim(strip_tags($result)));

similar_text($plainOriginal, $plainResult, $similar);

file_put_contents(
    $_SERVER['DOCUMENT_ROOT'].'/cms-ai-debug.txt',
    "SIMILAR=".$similar."\n",
    FILE_APPEND
);

if ($similar > 90) {
    $GLOBALS['cms_ai_last_error'] = 'AI returned near-original text';
    return false;
}

/* Remove common AI labels or echoed prompt text */
$result = preg_replace('/^\s*rewritten description\s*:?\s*/i', '', $result);
$result = preg_replace('/^\s*description\s*:?\s*/i', '', $result);
$result = preg_replace('/^\s*final html paragraph\s*:?\s*/i', '', $result);
$result = preg_replace('/^\s*html paragraph\s*:?\s*/i', '', $result);
$result = preg_replace('/^\s*output\s*:?\s*/i', '', $result);
$result = preg_replace('/^\s*instruction\s*:?\s*/i', '', $result);
$result = preg_replace('/^\s*rewrite the description\s*:?\s*/i', '', $result);
$result = preg_replace('/^\s*start with a different sentence than the original\s*:?\s*/i', '', $result);

/* If AI repeats the prompt sentence, remove it */
$result = preg_replace(
    '/^\s*write one unique seo-friendly html paragraph about the game using .*? as reference\.?\s*/i',
    '',
    $result
);

$result = trim($result);
/* Clean bad AI HTML spacing and fake external links */
$result = preg_replace('#</p>\s*<br\s*/?>\s*<p\b#i', '</p><p', $result);
$result = preg_replace('#<br\s*/?>\s*(?=<p\b)#i', '', $result);
$result = preg_replace('#</p>\s*<br\s*/?>#i', '</p>', $result);
$result = preg_replace('#(<br\s*/?>\s*)+#i', '', $result);

/* Remove any external links AI invented */
$result = preg_replace('#<a\b[^>]*>(.*?)</a>#is', '$1', $result);

/* Clean source labels if AI adds them */
$result = preg_replace('/\b(Source|For more fun games like this)\b.*$/is', '', $result);

$result = trim($result);

/* Force paragraph output if AI returns plain text */
if ($result !== '' && stripos($result, '<p') !== 0) {
    $result = '<p>' . $result . '</p>';
}

return $result;
}