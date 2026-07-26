<?php 
    if (!defined('R_PILOT')) { exit(); }

        if ( !empty($_POST['ss_sitename']) && !empty($_POST['ss_siteurl']) && !empty($_POST['ss_sitetheme'])) {
            if ( isset($_POST['ss_sitename']) && isset($_POST['ss_siteurl']) && isset($_POST['ss_sitetheme'])) {
                $adm_ss = array();
                $adm_ss['site_name']        = secureEncode($_POST['ss_sitename']);
                $adm_ss['site_url']         = secureEncode($_POST['ss_siteurl']);
                $adm_ss['site_theme']       = secureEncode($_POST['ss_sitetheme']);
                $adm_ss['site_description'] = secureEncode($_POST['ss_sitedescription']);
                $adm_ss['site_keywords']    = secureEncode($_POST['ss_sitekeywords']);
                $adm_ss['site_ads']         = (isset($_POST['ss_ads'])) ? '1' : '0';
                $adm_ss['xp_play']          = secureEncode($_POST['ss_xp_play']);
                $adm_ss['xp_report']        = secureEncode($_POST['ss_xp_report']);
                $adm_ss['xp_register']      = secureEncode($_POST['ss_xp_register']);
                $adm_ss['featured_game_limit'] = secureEncode($_POST['ss_featured_game_limit']);
                $adm_ss['mp_game_limit']    = secureEncode($_POST['ss_mp_game_limit']);

$tagCardBaseStyle = isset($_POST['tag_card_base_style']) ? secureEncode($_POST['tag_card_base_style']) : 'custom';
$allowedTagCardBaseStyles = array('custom', 'purple', 'green', 'red', 'blue', 'gamemonetize');

if (!in_array($tagCardBaseStyle, $allowedTagCardBaseStyles, true)) {
	$tagCardBaseStyle = 'custom';
}

$adm_ss['tag_card_base_style'] = $tagCardBaseStyle;

$tagCardPresetColors = array(
	'purple'       => '#2A1064',
	'green'        => '#064D25',
	'red'          => '#4A0C1C',
	'blue'         => '#071C4F',
	'gamemonetize' => '#063B6D',
	'custom'       => '#2A1064'
);

$tagCardFadeColor = isset($_POST['tag_card_fade_color']) ? trim((string)$_POST['tag_card_fade_color']) : '';

if (!preg_match('/^#[0-9a-fA-F]{6}$/', $tagCardFadeColor)) {
	$tagCardFadeColor = isset($tagCardPresetColors[$tagCardBaseStyle]) ? $tagCardPresetColors[$tagCardBaseStyle] : '#2A1064';
}

$tagCardFadeColor = strtoupper($tagCardFadeColor);
$adm_ss['tag_card_fade_color'] = secureEncode($tagCardFadeColor);

$theme_custom_css = isset($_POST['theme_custom_css']) ? trim(stripslashes($_POST['theme_custom_css'])) : '';
$theme_custom_css = str_ireplace(array('<style', '</style', '<script', '</script'), '', $theme_custom_css);

$hex = ltrim($tagCardFadeColor, '#');
$tagCardR = hexdec(substr($hex, 0, 2));
$tagCardG = hexdec(substr($hex, 2, 2));
$tagCardB = hexdec(substr($hex, 4, 2));

$tagCardCssVersion = time();

$tagCardAutoCss = "/* === AUTO TAG CARD COLOR START === */\n";
$tagCardAutoCss .= "/* generated: {$tagCardCssVersion} */\n";
$tagCardAutoCss .= ":root {\n";
$tagCardAutoCss .= "    --tag-card-left-rgb: {$tagCardR}, {$tagCardG}, {$tagCardB};\n";
$tagCardAutoCss .= "    --tag-card-bg: {$tagCardFadeColor};\n";
$tagCardAutoCss .= "    --tag-card-default-end: {$tagCardFadeColor};\n";
$tagCardAutoCss .= "}\n";
$tagCardAutoCss .= "/* === AUTO TAG CARD COLOR END === */\n";

$theme_custom_css = preg_replace(
	'/\/\* === AUTO TAG CARD BASE START === \*\/[\s\S]*?\/\* === AUTO TAG CARD BASE END === \*\//',
	'',
	$theme_custom_css
);

$theme_custom_css = preg_replace(
	'/\/\* === AUTO TAG CARD COLOR START === \*\/[\s\S]*?\/\* === AUTO TAG CARD COLOR END === \*\//',
	'',
	$theme_custom_css
);

$theme_custom_css = trim($theme_custom_css) . "\n\n" . $tagCardAutoCss;
                $css_theme_folder = isset($_POST['theme_custom_css_theme']) ? $_POST['theme_custom_css_theme'] : $adm_ss['site_theme'];
                $safe_theme_folder = preg_replace('/[^a-zA-Z0-9_-]/', '', $css_theme_folder);
                $custom_css_path = __DIR__ . '/../../../templates/' . $safe_theme_folder . '/css/custom-theme.css';
                $customCssSaved = false;

                if (is_dir(dirname($custom_css_path)) && is_writable(dirname($custom_css_path))) {
                    $customCssSaved = file_put_contents($custom_css_path, $theme_custom_css, LOCK_EX) !== false;
                }

                                /* Upload and overwrite current theme logo */
                /* Upload and overwrite selected theme logo */
$logoSaved = true;
$logoError = '';

if (!empty($_FILES['theme_logo_upload']['name'])) {
    $logoMap = array(
        'crazygames-like' => array(
            'dir'  => __DIR__ . '/../../../static/logo/crazygames-like/',
            'file' => 'logo-crazygames.webp',
            'w'    => 240,
            'h'    => 128
        ),
        'kizi' => array(
            'dir'  => __DIR__ . '/../../../static/logo/kizi/',
            'file' => 'logo-kizi.webp',
            'w'    => 164,
            'h'    => 100
        ),
        'poki-like' => array(
            'dir'  => __DIR__ . '/../../../static/logo/poki/',
            'file' => 'logo-poki.webp',
            'w'    => 326,
            'h'    => 140
        ),
        'y8-like' => array(
            'dir'  => __DIR__ . '/../../../static/logo/y8/',
            'file' => 'logo-y8.webp',
            'w'    => 163,
            'h'    => 70
        )
    );

    /*
     * Logo upload uses its own dropdown: theme_logo_target.
     * Site theme dropdown changes the live theme.
     * Logo dropdown chooses which logo file is overwritten.
     * No CSS file is edited here.
     */
    $currentLogoTheme = isset($_POST['theme_logo_target'])
        ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['theme_logo_target'])
        : '';

    if ($currentLogoTheme === '') {
        $logoSaved = false;
        $logoError = 'Logo upload failed: please select a logo theme.';
    } elseif (!isset($logoMap[$currentLogoTheme])) {
        $logoSaved = false;
        $logoError = 'Logo upload failed: theme logo path not configured.';
    } elseif (!isset($_FILES['theme_logo_upload']['tmp_name']) || !is_uploaded_file($_FILES['theme_logo_upload']['tmp_name'])) {
        $logoSaved = false;
        $logoError = 'Logo upload failed: invalid uploaded file.';
    } elseif (!function_exists('imagewebp')) {
        $logoSaved = false;
        $logoError = 'Logo upload failed: PHP GD WebP support missing.';
    } else {
        $tmpLogo = $_FILES['theme_logo_upload']['tmp_name'];
        $logoInfo = @getimagesize($tmpLogo);

        if (!$logoInfo || empty($logoInfo['mime'])) {
            $logoSaved = false;
            $logoError = 'Logo upload failed: invalid image.';
        } else {
            $mime = strtolower($logoInfo['mime']);
            $sourceImage = false;

            if ($mime === 'image/png') {
                $sourceImage = @imagecreatefrompng($tmpLogo);
            } elseif ($mime === 'image/jpeg' || $mime === 'image/jpg') {
                $sourceImage = @imagecreatefromjpeg($tmpLogo);
            } elseif ($mime === 'image/webp') {
                $sourceImage = @imagecreatefromwebp($tmpLogo);
            }

            if (!$sourceImage) {
                $logoSaved = false;
                $logoError = 'Logo upload failed: only PNG, JPG, JPEG, and WebP allowed.';
            } else {
                $targetW = (int) $logoMap[$currentLogoTheme]['w'];
                $targetH = (int) $logoMap[$currentLogoTheme]['h'];

                $srcW = imagesx($sourceImage);
                $srcH = imagesy($sourceImage);

                $scale = min($targetW / $srcW, $targetH / $srcH);
                $newW = (int) round($srcW * $scale);
                $newH = (int) round($srcH * $scale);
                $dstX = (int) round(($targetW - $newW) / 2);
                $dstY = (int) round(($targetH - $newH) / 2);

                $finalLogo = imagecreatetruecolor($targetW, $targetH);
                imagealphablending($finalLogo, false);
                imagesavealpha($finalLogo, true);

                $transparent = imagecolorallocatealpha($finalLogo, 0, 0, 0, 127);
                imagefilledrectangle($finalLogo, 0, 0, $targetW, $targetH, $transparent);

                imagecopyresampled(
                    $finalLogo,
                    $sourceImage,
                    $dstX,
                    $dstY,
                    0,
                    0,
                    $newW,
                    $newH,
                    $srcW,
                    $srcH
                );

                $logoDir = $logoMap[$currentLogoTheme]['dir'];
                $logoPath = $logoDir . $logoMap[$currentLogoTheme]['file'];

                if (!is_dir($logoDir)) {
                    @mkdir($logoDir, 0755, true);
                }

                if (!is_dir($logoDir) || !is_writable($logoDir)) {
                    $logoSaved = false;
                    $logoError = 'Logo upload failed: logo folder is not writable.';
                } else {
                    $logoSaved = imagewebp($finalLogo, $logoPath, 80);

                    if (!$logoSaved) {
                        $logoError = 'Logo upload failed: could not save WebP.';
                    }
                }

                imagedestroy($sourceImage);
                imagedestroy($finalLogo);
            }
        }
    }
}
                if (empty($adm_ss['xp_play']) && $adm_ss['xp_play'] == NULL && is_numeric($adm_ss['xp_play'])) {
                    $adm_ss['xp_play'] = '0';
                } if (empty($adm_ss['xp_report']) && $adm_ss['xp_report'] == NULL && is_numeric($adm_ss['xp_report'])) {
                    $adm_ss['xp_report'] = '0';
                } if (empty($adm_ss['xp_register']) && $adm_ss['xp_register'] == NULL && is_numeric($adm_ss['xp_register'])) {
                    $adm_ss['xp_register'] = '0';
                } if (empty($adm_ss['featured_game_limit']) && $adm_ss['featured_game_limit'] == NULL && is_numeric($adm_ss['featured_game_limit'])) {
                    $adm_ss['featured_game_limit'] = '0';
                } if (empty($adm_ss['mp_game_limit']) && $adm_ss['mp_game_limit'] == NULL && is_numeric($adm_ss['mp_game_limit'])) {
                    $adm_ss['mp_game_limit'] = '0';
                }
                
                                $result = $GameMonetizeConnect->query("UPDATE ".SETTING." SET site_name='{$adm_ss['site_name']}', site_url='{$adm_ss['site_url']}', site_theme='{$adm_ss['site_theme']}', site_description='{$adm_ss['site_description']}', site_keywords='{$adm_ss['site_keywords']}', language='english', ads_status='{$adm_ss['site_ads']}', xp_play='{$adm_ss['xp_play']}', xp_report='{$adm_ss['xp_report']}', xp_register='{$adm_ss['xp_register']}', featured_game_limit='{$adm_ss['featured_game_limit']}', mp_game_limit='{$adm_ss['mp_game_limit']}', tag_card_base_style='{$adm_ss['tag_card_base_style']}', tag_card_fade_color='{$adm_ss['tag_card_fade_color']}', recaptcha_site_key='', recaptcha_secret_key='' WHERE id='1'");

                               if ($result && $customCssSaved && $logoSaved) {
                    $data['status'] = 200;
                    $data['success_message'] = $lang['setting_saved'];
                } else {
                    if (!$result) {
                        $data['error_message'] = 'Database update failed: ' . $GameMonetizeConnect->error;
                    } elseif (!$customCssSaved) {
                        $data['error_message'] = 'Settings saved, but custom-theme.css could not be written. Check permission: templates/' . $safe_theme_folder . '/css/custom-theme.css';
                    } else {
                        $data['error_message'] = $logoError;
                    }
                }
            } else { $data['error_message'] = $lang['error_message']; }
        } else { $data['error_message'] = $lang['empty_place']; }