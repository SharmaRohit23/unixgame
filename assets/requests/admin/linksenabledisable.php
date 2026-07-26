<?php
if (!defined('R_PILOT')) {
    exit();
}
$links_id = isset($_POST['links_id']) ? (int)$_POST['links_id'] : 0;
$auto_cron = isset($_POST['auto_cron']) ? (int)$_POST['auto_cron'] : 0;
error_reporting(-1);

if ($auto_cron === 1) {
    header('Content-Type: application/json; charset=utf-8');

    $linksData = $GameMonetizeConnect->query("SELECT * FROM " . LINKS . " WHERE name = 'autopost' LIMIT 1");
    if ($linksData && $linksData->num_rows > 0) {
        $linksData = $linksData->fetch_array();
        $links_id = (int)$linksData['id'];
    } else {
        echo json_encode([
            'status' => 400,
            'error_message' => 'Autopost link not found.'
        ]);
        exit;
    }
}
if ($auto_cron === 1) {
    $newRandomString = generateRandomString(40);

    $isSuccess = $GameMonetizeConnect->query("
        UPDATE " . LINKS . "
        SET is_active = 1,
            url = '" . $newRandomString . "'
        WHERE id = " . $links_id . "
        LIMIT 1
    ");

    if (!$isSuccess) {
        echo json_encode([
            'status' => 400,
            'error_message' => 'Could not activate autopost link.'
        ]);
        exit;
    }
 
    $htaccessFilePath = $_SERVER['DOCUMENT_ROOT'] . '/.htaccess';
    updateHtaccessWithNewString($htaccessFilePath, $newRandomString, 'autopost');

    $autopostUrl = siteUrl() . '/links/' . $newRandomString;
    $cronUrl = 'https://www.freecronjob.com.es/schedule-url.php?url=' . urlencode($autopostUrl);

    echo json_encode([
        'status' => 200,
        'success_message' => 'Autopost enabled. Cron link ready.',
        'autopost_url' => $autopostUrl,
        'cron_url' => $cronUrl
    ]);
    exit;
}
// Check url generated
$linksData = $GameMonetizeConnect->query("SELECT * FROM " . LINKS . " WHERE id = $links_id");
if ($linksData && $linksData->num_rows > 0) {
    $linksData = $linksData->fetch_array();
    if ($linksData['url'] == "") {
        // Generate random url
        $randomString = generateRandomString(40);
        $GameMonetizeConnect->query("UPDATE " . LINKS . " 
            SET is_active = NOT is_active,
            url = '" . $randomString . "'
            WHERE id = $links_id
        ") or die();

        $htaccessPath = $_SERVER['DOCUMENT_ROOT'] . '/.htaccess'; // Path to your .htaccess file
        $newRule = "\nRewriteRule ^links/" . $randomString . "$ index.php?p=public\n"; // New rule to add

        // Read the current content of the .htaccess file
        $currentContent = file_get_contents($htaccessPath);
        // Define the marker where the new rule should be inserted
        $marker = "## API";

        // Split the content at the marker
        $parts = explode($marker, $currentContent);

        // Check if the marker was found and we have exactly two parts
        if (count($parts) == 2) {
            // Insert the new rule before the marker
            $modifiedContent = $parts[0] . $newRule . $marker . $parts[1];

            // Write the modified content back to the .htaccess file
            file_put_contents($htaccessPath, $modifiedContent);

            // echo "The new rule has been added successfully.";
        } else {
            // echo "The specified marker was not found or is duplicated.";
        }
    } else {
        $newRandomString = generateRandomString(40);
        
        $isSuccess = $GameMonetizeConnect->query("UPDATE " . LINKS . " 
        SET is_active = NOT is_active,
        url = '" . $newRandomString . "'
        WHERE id = $links_id
        ") or die();

        if ($isSuccess) {
            $htaccessFilePath = $_SERVER['DOCUMENT_ROOT'] . '/.htaccess'; // Path to your .htaccess file
            updateHtaccessWithNewString($htaccessFilePath, $newRandomString, $linksData['name']);
        }
    }

    $data['status'] = 200;
$data['success_message'] = $lang['links_success'];

if ($auto_cron === 1) {
    $latestLinkData = $GameMonetizeConnect->query("SELECT * FROM " . LINKS . " WHERE id = {$links_id} LIMIT 1");

    if ($latestLinkData && $latestLinkData->num_rows > 0) {
        $latestLinkData = $latestLinkData->fetch_array();

        $autopostUrl = siteUrl() . '/links/' . $latestLinkData['url'];
        $cronUrl = 'https://www.freecronjob.com.es/schedule-url.php?url=' . urlencode($autopostUrl);

        $data['autopost_url'] = $autopostUrl;
        $data['cron_url'] = $cronUrl;
    }
}
} else {
    $data['error_message'] = $lang['links_not_found'];
}

function generateRandomString($length = 10)
{
    // Define a string that contains all the characters you want to include in your random string
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    // Get a shuffled version of the $characters string
    $shuffled = str_shuffle($characters);
    // Return the first $length characters of the shuffled string
    return substr($shuffled, 0, $length);
}

function updateHtaccessWithNewString($filePath, $newRandomString, $linkUrl)
{
    $linkUrl = str_replace("autopost", "links", $linkUrl);

    // Read the existing content from the .htaccess file
    $htaccessContent = file_get_contents($filePath);

    // Define the pattern to find the old string
    $pattern = '/RewriteRule \^' . preg_quote($linkUrl, '/') . '\/[A-Za-z0-9]+\$ index\.php\?p=public/';

    // Create a new rule with the new random string
    $replacement = 'RewriteRule ^' . $linkUrl . '/' . $newRandomString . '$ index.php?p=public';

    // Check if a string that matches the pattern exists
    // var_dump($pattern);
    // var_dump(preg_match($pattern, $htaccessContent, $matches));
    // var_dump($matches);
    // die;
    if (preg_match($pattern, $htaccessContent)) {
        // Replace the old rule with the new rule in the file content
        $updatedContent = preg_replace($pattern, $replacement, $htaccessContent);
    } else {
        // If no match, append the new rule to the file content
        $updatedContent = $htaccessContent . PHP_EOL . $replacement;
    }

    // Write the updated content back to the .htaccess file
    file_put_contents($filePath, $updatedContent);
}
