<?php
if (!defined('R_PILOT')) {
    exit();
}

/*
|--------------------------------------------------------------------------
| Safe gm_chatgpt save handler
|--------------------------------------------------------------------------
| Fixes old CMS database issue:
| - Adds missing blog template columns if old database does not have them
| - Makes sure row id=1 exists
| - Then saves normally
|--------------------------------------------------------------------------
*/

$table = CHATGPT;

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

function chatgptColumnExists($db, $table, $column)
{
    $tableSafe = str_replace('`', '', $table);
    $columnSafe = mysqli_real_escape_string($db, $column);

    $check = $db->query("SHOW COLUMNS FROM `{$tableSafe}` LIKE '{$columnSafe}'");

    return ($check && $check->num_rows > 0);
}

function chatgptAddColumnIfMissing($db, $table, $column, $definition)
{
    if (chatgptColumnExists($db, $table, $column)) {
        return true;
    }

    $tableSafe = str_replace('`', '', $table);
    $columnSafe = str_replace('`', '', $column);

    return $db->query("ALTER TABLE `{$tableSafe}` ADD COLUMN `{$columnSafe}` {$definition}");
}

function chatgptPostText($db, $key, $default = '')
{
    return isset($_POST[$key])
        ? mysqli_real_escape_string($db, trim((string) $_POST[$key]))
        : $default;
}

function chatgptPostInt($key, $default = 0)
{
    return isset($_POST[$key]) ? (int) $_POST[$key] : (int) $default;
}

/*
|--------------------------------------------------------------------------
| Add missing columns for newer admin form
|--------------------------------------------------------------------------
*/

chatgptAddColumnIfMissing($GameMonetizeConnect, $table, 'llm_provider', "varchar(50) NOT NULL DEFAULT 'openai'");
chatgptAddColumnIfMissing($GameMonetizeConnect, $table, 'template_blog', "text NULL");
chatgptAddColumnIfMissing($GameMonetizeConnect, $table, 'template_blog_tag', "text NULL");
chatgptAddColumnIfMissing($GameMonetizeConnect, $table, 'template_blog_title', "text NULL");
chatgptAddColumnIfMissing($GameMonetizeConnect, $table, 'template_blog_related_box', "text NULL");
chatgptAddColumnIfMissing($GameMonetizeConnect, $table, 'openai_api_key', "text NULL");
chatgptAddColumnIfMissing($GameMonetizeConnect, $table, 'deepseek_api_key', "text NULL");
chatgptAddColumnIfMissing($GameMonetizeConnect, $table, 'mimo_api_key', "text NULL");
chatgptAddColumnIfMissing($GameMonetizeConnect, $table, 'gemini_api_key', "text NULL");
chatgptAddColumnIfMissing($GameMonetizeConnect, $table, 'openrouter_api_key', "text NULL");
chatgptAddColumnIfMissing($GameMonetizeConnect, $table, 'cms_ai_key', "text NULL");
chatgptAddColumnIfMissing($GameMonetizeConnect, $table, 'cms_ai_domain', "varchar(255) DEFAULT NULL");
chatgptAddColumnIfMissing($GameMonetizeConnect, $table, 'cms_ai_registered', "tinyint(1) NOT NULL DEFAULT 0");
chatgptAddColumnIfMissing($GameMonetizeConnect, $table, 'rewrite_old_games_limit', "int(11) NOT NULL DEFAULT 1");

/*
|--------------------------------------------------------------------------
| Make sure row id=1 exists
|--------------------------------------------------------------------------
*/

$tableSafe = str_replace('`', '', $table);

$GameMonetizeConnect->query("
    INSERT INTO `{$tableSafe}` (`id`)
    SELECT 1
    WHERE NOT EXISTS (
        SELECT 1 FROM `{$tableSafe}` WHERE `id` = 1
    )
");

/*
|--------------------------------------------------------------------------
| Read POST values
|--------------------------------------------------------------------------
*/

$llm_provider = isset($_POST['llm_provider']) ? trim((string)$_POST['llm_provider']) : 'openai';

$allowedProviders = ['openai', 'deepseek', 'mimo', 'gemini', 'openrouter', 'cmsai'];

if (!in_array($llm_provider, $allowedProviders, true)) {
    $llm_provider = 'openai';
}

$llm_provider = mysqli_real_escape_string($GameMonetizeConnect, $llm_provider);

$openai_api_key = chatgptPostText($GameMonetizeConnect, 'openai_api_key');
$deepseek_api_key = chatgptPostText($GameMonetizeConnect, 'deepseek_api_key');
$mimo_api_key = chatgptPostText($GameMonetizeConnect, 'mimo_api_key');
$gemini_api_key = chatgptPostText($GameMonetizeConnect, 'gemini_api_key');
$openrouter_api_key = chatgptPostText($GameMonetizeConnect, 'openrouter_api_key');

$cms_ai_key = chatgptPostText($GameMonetizeConnect, 'cms_ai_key');
$cms_ai_domain = chatgptPostText($GameMonetizeConnect, 'cms_ai_domain');
$cms_ai_registered = !empty($cms_ai_key) ? 1 : 0;

$template_game = chatgptPostText($GameMonetizeConnect, 'template_game');
$template_category = chatgptPostText($GameMonetizeConnect, 'template_category');
$template_tags = chatgptPostText($GameMonetizeConnect, 'template_tags');
$template_footer = chatgptPostText($GameMonetizeConnect, 'template_footer');

$template_blog = chatgptPostText($GameMonetizeConnect, 'template_blog');
$template_blog_tag = chatgptPostText($GameMonetizeConnect, 'template_blog_tag');
$template_blog_title = chatgptPostText($GameMonetizeConnect, 'template_blog_title');
$template_blog_related_box = chatgptPostText($GameMonetizeConnect, 'template_blog_related_box');

$random_words_before_tags = chatgptPostText($GameMonetizeConnect, 'random_words_before_tags');
$random_words_after_tags = chatgptPostText($GameMonetizeConnect, 'random_words_after_tags');

$chatgpt_model = chatgptPostText($GameMonetizeConnect, 'chatgpt_model');
$maximum_words = chatgptPostInt('maximum_words', 0);
$rewrite_old_games_limit = chatgptPostInt('rewrite_old_games_limit', 1);

/*
|--------------------------------------------------------------------------
| Save settings
|--------------------------------------------------------------------------
*/

$save = $GameMonetizeConnect->query("
    UPDATE `{$tableSafe}`
    SET
        `llm_provider` = '{$llm_provider}',
        `openai_api_key` = '{$openai_api_key}',
        `deepseek_api_key` = '{$deepseek_api_key}',
        `mimo_api_key` = '{$mimo_api_key}',
        `gemini_api_key` = '{$gemini_api_key}',
        `openrouter_api_key` = '{$openrouter_api_key}',

        `cms_ai_key` = '{$cms_ai_key}',
        `cms_ai_domain` = '{$cms_ai_domain}',
        `cms_ai_registered` = '{$cms_ai_registered}',

        `template_game` = '{$template_game}',
        `template_category` = '{$template_category}',
        `template_tags` = '{$template_tags}',
        `template_footer` = '{$template_footer}',
        `template_blog` = '{$template_blog}',
        `template_blog_tag` = '{$template_blog_tag}',
        `template_blog_title` = '{$template_blog_title}',
        `template_blog_related_box` = '{$template_blog_related_box}',
        `random_words_before_tags` = '{$random_words_before_tags}',
        `random_words_after_tags` = '{$random_words_after_tags}',
        `chatgpt_model` = '{$chatgpt_model}',
        `maximum_words` = '{$maximum_words}',
        `rewrite_old_games_limit` = '{$rewrite_old_games_limit}'
    WHERE `id` = 1
");

if (!$save) {
    $data['status'] = 400;
    $data['error_message'] = mysqli_error($GameMonetizeConnect);
    return;
}

$data['status'] = 200;
$data['success_message'] = $lang['chatgpt_saved'] ?? 'ChatGPT settings saved successfully.';