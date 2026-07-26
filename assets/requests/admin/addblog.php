<?php
if (!defined('R_PILOT')) {
    exit();
}

$data = array();

if (empty($_POST['title'])) {
    $data['error_message'] = $lang['must_enter_name'];
    return;
}

$blog_title_raw = trim($_POST['title']);

if ($blog_title_raw === '') {
    $data['error_message'] = $lang['must_enter_name'];
    return;
}

if (!preg_match("/^[a-zA-Z0-9 .-]+$/", $blog_title_raw)) {
    $data['error_message'] = $lang['invalid_characters'];
    return;
}

if (strlen($blog_title_raw) > 100) {
    $data['error_message'] = $lang['category_name_exceed'];
    return;
}

$blog_title = secureEncode($blog_title_raw);
$seo_name = seo_friendly_url($blog_title_raw);

$stmt = $GameMonetizeConnect->prepare("SELECT title FROM " . BLOGS . " WHERE title = ? LIMIT 1");
$stmt->bind_param("s", $blog_title);
$stmt->execute();
$sqlCheck = $stmt->get_result();

if ($sqlCheck && $sqlCheck->num_rows > 0) {
    $data['error_message'] = $lang['category_exists'];
    return;
}

$stmt = $GameMonetizeConnect->prepare("INSERT INTO " . BLOGS . " (title, url) VALUES (?, ?)");
$stmt->bind_param("ss", $blog_title, $seo_name);

if ($stmt->execute()) {
    $data['status'] = 200;
    $data['success_message'] = $lang['blog_added'];
    $data['redirect_url'] = siteUrl() . "/admin/blogs/edit/" . $GameMonetizeConnect->insert_id;
} else {
    $data['error_message'] = $lang['error_message'];
}

function seo_friendly_url($string)
{
    $string = trim($string);
    $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '$1', $string);
    $string = preg_replace('/[^a-z0-9]+/i', '-', $string);
    $string = preg_replace('/-+/', '-', $string);

    return strtolower(trim($string, '-'));
}