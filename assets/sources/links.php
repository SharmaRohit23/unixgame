<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the full request URI
$requestUri = $_SERVER['REQUEST_URI'];

// Use explode to split the URI into segments based on '/'
$uriSegments = explode('/', $requestUri);

// Assuming the structure is always like /links/{code},
// {code} will be the third segment (index 2 since arrays are zero-indexed in PHP)
$linkCode = end($uriSegments) ?? null;

$linksData = $GameMonetizeConnect->query("SELECT * FROM " . LINKS . " WHERE url = '$linkCode' AND is_active = 1");
if ($linksData && $linksData->num_rows > 0) {
    $linksData = $linksData->fetch_array();

    $cmsAiCheck = $GameMonetizeConnect->query("SELECT llm_provider FROM " . CHATGPT . " WHERE id = 1 LIMIT 1");
if ($cmsAiCheck && $cmsAiCheck->num_rows > 0) {
    $cmsAiRow = $cmsAiCheck->fetch_assoc();

    if (!empty($cmsAiRow['llm_provider']) && trim($cmsAiRow['llm_provider']) === 'cmsai') {
        if ($linksData['name'] == 'autopost') {
            include __DIR__ . '/linkscmsai.php';
            return;
        }

        if ($linksData['name'] == 'autopost_tags') {
            include __DIR__ . '/linkscmsai-tags.php';
            return;
        }

        if ($linksData['name'] == 'autopost_old_games') {
            include __DIR__ . '/linkscmsai-old-games.php';
            return;
        }
    }
}

    if ($linksData['name'] == 'autopost') {
        // error_reporting(-1);
        // Autopost new game
        $catalog = file_get_contents('https://gamemonetize.com/feed.php?format=0&num=30');
        if (!!$catalog) {
            $isError = false;
            $games = json_decode($catalog, true);
            $i = 0;
            $installedGamesCounter = 0;
            $installedGamesMaximum = 1;
            foreach ($games as $game) {
                if ($installedGamesCounter >= $installedGamesMaximum) break;
                $title = seo_friendly_url($game['title']);
                $user_info = "SELECT * FROM `" . GAMES . "` WHERE `game_name` = '$title'";
                $user_info_query = $GameMonetizeConnect->query($user_info);
                if ($user_info_query->num_rows == 0) {
                    $game_data = array();
                    $game_data['catalog_id'] = secureEncode($game['id']);
                    $game_data['game_name'] = secureEncode($title);
                    $game_data['name'] = secureEncode($game['title']);

                    $gameDescription = !empty($game['description']) ? secureEncode($game['description']) : '';
                    if ($gameDescription != "") {
                        // Chatgpt
                        // if ($linksData['rewrite_method'] == 'chatgpt') {
                        //     // Get chatgpt settings
                        //     $chatgptSetting = $GameMonetizeConnect->query("SELECT * FROM " . CHATGPT . "");
                        //     if ($chatgptSetting && $chatgptSetting->num_rows > 0) {
                        //         $chatgptSetting = $chatgptSetting->fetch_assoc();

                        //         $api_key = $chatgptSetting['api_key'];
                        //         $template_game = $chatgptSetting['template_game'];

                        //         if (strlen($api_key) > 1) {
                        //             $textToRewrite = $gameDescription;
                        //             if (strlen($textToRewrite) > 2) {
                        //                 $postData = [
                        //                     'model' => 'gpt-3.5-turbo',
                        //                     'messages' => [
                        //                         [
                        //                             'role' => 'system',
                        //                             'content' => 'You are a game description rephrasing or rewriter assistant. Please rephrase/rewrite the description. Result only.'
                        //                         ],
                        //                         [
                        //                             'role' => 'user',
                        //                             'content' => $textToRewrite
                        //                         ]
                        //                     ]
                        //                 ];
                            
                        //                 // Initialize a cURL session
                        //                 $ch = curl_init('https://api.openai.com/v1/chat/completions');
                            
                        //                 // Set the options for the cURL session
                        //                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        //                 curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        //                     'Content-Type: application/json',
                        //                     'Authorization: Bearer ' . $api_key,
                        //                 ]);
                        //                 curl_setopt($ch, CURLOPT_POST, true);
                        //                 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
                            
                        //                 // Execute the cURL session and store the response
                        //                 $response = $rawResponse = curl_exec($ch);
                            
                        //                 // Close the cURL session
                        //                 curl_close($ch);
                        //                 $response = json_decode($response);
                            
                        //                 if ($response != null && isset($response->choices)) {
                        //                     $response = $response->choices[0]->message->content;
                        //                     $gameDescription = $response;
                        //                     $gameDescription = convertBoldTags($gameDescription);
                        //                 } else {
                        //                     echo "Error from chatgpt: <br>";
                        //                     print_r($rawResponse);
                        //                     die;
                        //                 }
                        //             } else {
                        //             } 
                        //         } else {
                        //         }
                        //     }
                        // }

                        // Google
                        if ($linksData['rewrite_method'] == 'google') {
                            // auto translate some language and back to english
                            $translateLanguage = explode(",", $linksData["google_translate_language"]);
                            $currentLanguage = "en";
                            foreach ($translateLanguage as $index => $language) {
                                $language = trim($language);
                                $gameDescriptionTranslated = googleTranslate($gameDescription, $currentLanguage, $language);
                                if ($gameDescriptionTranslated) {
                                    $gameDescription = $gameDescriptionTranslated["data"];
                                }

                                $currentLanguage = $language;
                            }
                        }

                        // Spinner
                        if ($linksData['rewrite_method'] == 'spinner') {
                            error_reporting(-1);
                            include_once './assets/spinner/class.spin.php';

                            $spinner = new wp_auto_spin_spin(1, '', $gameDescription);

                            $spinResult = $spinner->spin();

                            $gameDescription = preg_replace_callback('/{([^}]+)}/', function($matches) {
                                // Split the options by '|'
                                $options = explode('|', $matches[1]);
                                // Randomly select one of the options
                                return $options[array_rand($options)];
                            }, $spinResult);

                        }
                    }
                    
                    $game_data['description'] = $gameDescription;

                    $game_data['instructions'] = !empty($game['instructions']) ? secureEncode($game['instructions']) : '';
                    $game_data['file'] = secureEncode($game['url']);
                    $game_data['width'] = $game['width'];
                    $game_data['height'] = $game['height'];
                    $game_data['image'] = $game['thumb'];

                // Get category from database or create it from feed
                $category = 1; // fallback default category id

                if (!empty($game['category'])) {
                    $feedCategories = array_values(array_filter(array_map('trim', explode(',', $game['category']))));

                    // 1. Try to find the first existing category from feed order
                    foreach ($feedCategories as $feedCategoryName) {
                        $category_data = getCategoriesLikeName($feedCategoryName);

                        if (!empty($category_data) && !empty($category_data['id'])) {
                            $category = (int)$category_data['id'];
                            break;
                        }
                    }

                    // 2. If none exist, create the first valid category from the feed
                    if ((int)$category === 1 && !empty($feedCategories[0])) {
                        $createdCategoryId = getOrCreateCategory($feedCategories[0]);
                        if ($createdCategoryId > 0) {
                            $category = $createdCategoryId;
                        }
                    }
                }

                    // Get tags from database
                    $allTags = explode(",", $game['tags']);
                    $allTagsId = [];
                    foreach ($allTags as $tag) {
                        $tag_data = getTagsLikeName(trim($tag));
                        $allTagsId[] = "\"{$tag_data["id"]}\"";
                    }
                    if (count($allTagsId) > 0) {
                        $tags = "[" . implode(",", $allTagsId) . "]";
                    }
                    $safeWtVideo = mysqli_real_escape_string($GameMonetizeConnect, getRealGameMonetizeWtVideo($game_data['file']));
                    $isSuccess = $GameMonetizeConnect->query("INSERT INTO " . GAMES . " (
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
                                        'gamemonetize-{$game_data['catalog_id']}',
                                        '{$game_data['game_name']}',
                                        '{$game_data['name']}',
                                        '{$game_data['image']}',
                                        \"{$game_data['description']}\",
                                        '{$game_data['instructions']}',
                                        '{$category}',
                                        '{$game_data['file']}',
                                        'html5',
                                        '{$game_data['width']}',
                                        '{$game_data['height']}',
                                        '{$time}', 
                                        '{$tags}',
                                        '1',
                                        '{$safeWtVideo}'
                                )");
                    if ($isSuccess) {
                    $lastId = (int)$GameMonetizeConnect->insert_id;

                    if ($linksData['rewrite_method'] == "chatgpt") {
                        $isSuccessRewrite = rewriteChatgpt($lastId);

                        if (!$isSuccessRewrite) {
                            $isError = true;
                            $GameMonetizeConnect->query("DELETE FROM " . GAMES . " WHERE game_id = {$lastId} LIMIT 1");
                            continue;
                        }
                    }

                    $installedGamesCounter++;
                    addGameXml(siteUrl() . '/game/' . $game_data['game_name']);
                } else {
                        var_dump($GameMonetizeConnect->error());
                        $isError = true;
                    }
                    $i++;
                }
            }

            sleep(1);
            $themeData['page_content'] = $i . ' ' . $lang['admin_premium_games_installed'] . " - " . $title;
            if ($isError) {
                $themeData['page_content'] = $i ." Error adding new games. - " . $title;
            }
        } else {
            $themeData['page_content'] = "Something went wrong.";
        }
} elseif ($linksData['name'] == 'autopost_old_games') {
        $mainLinksData = $GameMonetizeConnect->query("SELECT * FROM " . LINKS . " WHERE name = 'autopost' LIMIT 1");
        $mainLinksData = $mainLinksData ? $mainLinksData->fetch_array() : null;
                // Rewrite old games
        $lastId = (int)$linksData['last_id'];

        $chatgptLimitData = $GameMonetizeConnect->query("SELECT rewrite_old_games_limit FROM " . CHATGPT . " WHERE id = 1 LIMIT 1");
        $rewriteLimit = 1;
        if ($chatgptLimitData && $chatgptLimitData->num_rows > 0) {
            $chatgptLimitRow = $chatgptLimitData->fetch_assoc();
            $rewriteLimit = !empty($chatgptLimitRow['rewrite_old_games_limit']) ? (int)$chatgptLimitRow['rewrite_old_games_limit'] : 1;
        }
        if ($rewriteLimit < 1) {
            $rewriteLimit = 1;
        }

$gameData = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE game_id > '$lastId' AND published = '1' ORDER BY game_id ASC LIMIT {$rewriteLimit}");

if (!$gameData || $gameData->num_rows < 1) {
    echo "No more old games found (End of list reached). Last ID was: $lastId";
    die;
}

$lastProcessedId = $lastId;
$rewrittenCount = 0;

while ($game = $gameData->fetch_array()) {
    $currentId = (int)$game['game_id'];
    $updateSuccess = false;

    $lastRewriteGame = $GameMonetizeConnect->query("SELECT game_id FROM " . GAMES . " WHERE is_last_rewrite = '1' LIMIT 1");
    if ($lastRewriteGame && $lastRewriteGame->num_rows > 0) {
        $lastRewriteGame = $lastRewriteGame->fetch_array();
        if ((int)$lastRewriteGame['game_id'] == $currentId) {
            echo "Last rewrite game reached. No rewrite will be done. Current ID: {$currentId}<br>";
            break;
        }
    }

    $gameDescription = !empty($game['description']) ? secureEncode($game['description']) : '';
    if ($gameDescription != "") {
        if ($mainLinksData['rewrite_method'] == 'google') {
            $translateLanguage = explode(",", $mainLinksData["google_translate_language"]);
            $currentLanguage = "en";
            foreach ($translateLanguage as $index => $language) {
                $language = trim($language);
                $gameDescriptionTranslated = googleTranslate($gameDescription, $currentLanguage, $language);
                if ($gameDescriptionTranslated) {
                    $gameDescription = $gameDescriptionTranslated["data"];
                }
                $currentLanguage = $language;
            }
            $gameDescription = googleTranslate($gameDescription, $currentLanguage, "en");
            $gameDescription = $gameDescription["data"];
        }

        if ($mainLinksData['rewrite_method'] == 'spinner') {
            error_reporting(-1);
            include_once './assets/spinner/class.spin.php';

            $spinner = new wp_auto_spin_spin(1, '', $gameDescription);
            $spinResult = $spinner->spin();

            $gameDescription = preg_replace_callback('/{([^}]+)}/', function($matches) {
                $options = explode('|', $matches[1]);
                return $options[array_rand($options)];
            }, $spinResult);
        }

        if ($mainLinksData['rewrite_method'] == 'spinner' || $mainLinksData['rewrite_method'] == 'google') {
            $updateGameData = $GameMonetizeConnect->query("UPDATE " . GAMES . " SET description = '{$gameDescription}' WHERE game_id = '{$currentId}'");
            if ($updateGameData) {
                echo "Successfully rewriting game: " . $game['name'] . "<br>";
                $updateSuccess = true;
            } else {
                echo "Failed rewriting game: " . $game['name'] . "<br>";
                print_r($GameMonetizeConnect->error);
                echo "<br>";
            }
        }
    } else {
        echo "Game description is empty: " . $game['name'] . "<br>";
    }

    if ($mainLinksData['rewrite_method'] == 'chatgpt') {
        $isSuccessRewrite = rewriteChatgpt($currentId);
        if (!$isSuccessRewrite) {
            echo "Failed rewriting game: " . $game['name'] . "<br>";
        } else {
            echo "Successfully rewriting game: " . $game['name'] . "<br>";
            $updateSuccess = true;
        }
    }

    if ($updateSuccess) {
        $lastProcessedId = $currentId;
        $rewrittenCount++;
    }
}

if ($lastProcessedId > $lastId) {
    $GameMonetizeConnect->query("UPDATE " . LINKS . " SET last_id = '{$lastProcessedId}' WHERE name = 'autopost_old_games'");
}

echo "<br>Total rewritten: " . $rewrittenCount;
echo "<br>Current id: " . $lastProcessedId;
die;

        if ($gameData && $gameData->num_rows > 0) {
                        if ($currentId == 1) {
                $currentId = $game['game_id'];
            }
            // Check max limit
            $lastRewriteGame = $GameMonetizeConnect->query("SELECT game_id FROM " . GAMES . " WHERE is_last_rewrite = '1' LIMIT 1");
            if ($lastRewriteGame && $lastRewriteGame->num_rows < 1) {
                echo "Caution: No last rewrite game limit is set. So it will also rewriting new games.<br>";
            } else if ($lastRewriteGame && $lastRewriteGame->num_rows > 0) {
                $lastRewriteGame = $lastRewriteGame->fetch_array();
                if ($lastRewriteGame['game_id'] == $currentId) {
                    echo "Last rewrite game reached. No rewrite will be done. Current ID: {$currentId}";
                    die;
                }
            }

            // Rewrite logic
            $updateSuccess = false;

            $gameDescription = !empty($game['description']) ? secureEncode($game['description']) : '';
            if ($gameDescription != "") {
                // Google
                if ($mainLinksData['rewrite_method'] == 'google') {
                    // auto translate some language and back to english
                    $translateLanguage = explode(",", $mainLinksData["google_translate_language"]);
                    $currentLanguage = "en";
                    foreach ($translateLanguage as $index => $language) {
                        $language = trim($language);
                        $gameDescriptionTranslated = googleTranslate($gameDescription, $currentLanguage, $language);
                        if ($gameDescriptionTranslated) {
                            $gameDescription = $gameDescriptionTranslated["data"];
                        }

                        $currentLanguage = $language;
                    }
                    $gameDescription = googleTranslate($gameDescription, $currentLanguage, "en");
                    $gameDescription = $gameDescription["data"];
                }

                // Spinner
                if ($mainLinksData['rewrite_method'] == 'spinner') {
                    error_reporting(-1);
                    include_once './assets/spinner/class.spin.php';

                    $spinner = new wp_auto_spin_spin(1, '', $gameDescription);

                    $spinResult = $spinner->spin();

                    $gameDescription = preg_replace_callback('/{([^}]+)}/', function($matches) {
                        // Split the options by '|'
                        $options = explode('|', $matches[1]);
                        // Randomly select one of the options
                        return $options[array_rand($options)];
                    }, $spinResult);

                }

                if ($mainLinksData['rewrite_method'] == 'spinner' || $mainLinksData['rewrite_method'] == 'google') {
                    // Update existing description
                    $updateGameData = $GameMonetizeConnect->query("UPDATE " . GAMES . " SET description = '{$gameDescription}' WHERE game_id = '$currentId'");
                    
                    if ($updateGameData) {
                        echo "Successfully rewriting game: " . $game['name'];
                        $updateSuccess = true;
                    } else {
                        echo "Failed rewriting game: " . $game['name'];
                        echo "<br>";
                        print_r($GameMonetizeConnect->error);
                    }
                }
                
            } else {
                echo "Game description is empty.";
            }

            // Chatgpt
if ($mainLinksData['rewrite_method'] == 'chatgpt') {
    $isSuccessRewrite = rewriteChatgpt($currentId);
    if (!$isSuccessRewrite){
        echo "Failed rewriting game: " . $game['name'];
    } else {
        echo "Successfully rewriting game: " . $game['name'];
        $updateSuccess = true;
    }
} else {
    echo "DEBUG not using chatgpt branch<br>";
}

            
        } else {
            echo "Game not found.";
        }
        
        if($updateSuccess){
            // Update last id
            $updateGameData = $GameMonetizeConnect->query("UPDATE " . LINKS . " SET last_id = '{$currentId}' WHERE name = 'autopost_old_games'");
        }

        echo "<br>Current id: " . $currentId;
        die;
} elseif ($linksData['name'] == 'autopost_tags') {
        error_reporting(-1);
                $tagsData = $GameMonetizeConnect->query("
                        SELECT * FROM " . TAGS . "
                        WHERE footer_description IS NULL
                        OR TRIM(footer_description) = ''
                        OR LOWER(TRIM(footer_description)) = 'footer description'
                        OR is_rewrited = 0
                        ORDER BY id DESC
                        LIMIT 1
                    ");
        if ($tagsData && $tagsData->num_rows > 0) {
            $tags = $tagsData->fetch_array();

            $currentId = $tags['id'];

            // Check max limit
            $lastRewriteTags = $GameMonetizeConnect->query("SELECT id FROM " . TAGS . " WHERE is_last_rewrite = '1' LIMIT 1");
            if ($lastRewriteTags && $lastRewriteTags->num_rows < 1) {
                echo "Caution: No last rewrite tags limit is set.<br>";
            } else if ($lastRewriteTags && $lastRewriteTags->num_rows > 0) {
                $lastRewriteTags = $lastRewriteTags->fetch_array();
                if ($lastRewriteTags['id'] == $currentId) {
                    echo "Last rewrite tags reached. No rewrite will be done. Current ID: {$currentId}";
                    die;
                }
            }

                    $footerDescription = trim(strip_tags((string)$tags['footer_description']));

                    if (
                        $footerDescription == '' ||
                        strtolower($footerDescription) == 'footer description' ||
                        $tags['is_rewrited'] != '1'
                    ) {
                        $rewritedTags = rewriteTags($tags);
                        $rewritedTags = hitChatGpt($rewritedTags);

                        if ($rewritedTags === false || strlen(trim($rewritedTags)) < 10) {
                            echo "AI failed rewriting tag: " . $tags['name'];
                            die;
                        }

                        $safeRewrite = mysqli_real_escape_string($GameMonetizeConnect, $rewritedTags);

                        $updateTags = $GameMonetizeConnect->query("
                            UPDATE " . TAGS . "
                            SET footer_description = '{$safeRewrite}',
                                is_rewrited = 1
                            WHERE id = {$currentId}
                        ");

                        if ($updateTags) {
                            echo "Successfully rewriting tags: " . $tags['name'];
                        } else {
                            echo "Failed to update tags: " . $tags['name'];
                            var_dump($GameMonetizeConnect->error);
                        }
                    } else {
                        echo "The " . $tags['name'] . " is already rewritten and has description, skipping.";
                    }

                    } else {
                        echo "No tags found to rewrite.";
                        die;
                    }

        if (!empty($currentId)) {
            $GameMonetizeConnect->query("UPDATE " . LINKS . " SET last_id = '{$currentId}' WHERE name = 'autopost_tags'");
        }

        echo "<br>Current id: " . $currentId;
        die;

} elseif ($linksData['name'] == 'autopost_footer') {

                error_reporting(-1);

                $footerData = $GameMonetizeConnect->query("SELECT * FROM gm_footer_description WHERE is_rewrited = 0 ORDER BY id ASC LIMIT 1");

                if ($footerData && $footerData->num_rows > 0) {

                    $footer = $footerData->fetch_array();
                    $currentId = $footer['id'];

                    if ($footer['is_rewrited'] != 1) {

                        $rewritedFooter = rewriteFooter($footer);
                        $rewritedFooter = hitChatGpt($rewritedFooter);

                        if ($rewritedFooter !== false && strlen(trim($rewritedFooter)) > 0) {

                            $safeContent = mysqli_real_escape_string($GameMonetizeConnect, $rewritedFooter);

                        $update = $GameMonetizeConnect->query("
                            UPDATE gm_footer_description 
                            SET description = '{$safeContent}',
                                is_rewrited = 1 
                            WHERE id = {$currentId}
                        ");

                            if ($update) {
                                echo "Successfully rewriting footer: " . $footer['page_name'];
                            } else {
                                echo "DB error:";
                                var_dump($GameMonetizeConnect->error);
                            }

                        } else {
                            echo "Failed generating footer content.";
                        }

                    } else {
                        echo "Already rewritten: " . $footer['page_name'];
                    }

                } else {
                    echo "No footer pages left.";
                }

                echo "<br>Current id: " . $currentId;
                die;

    
} elseif ($linksData['name'] == 'autopost_categories') {
            error_reporting(-1);

            $categoriesData = $GameMonetizeConnect->query("SELECT * FROM " . CATEGORIES . " WHERE is_rewrited = 0 ORDER BY id ASC LIMIT 1");

            if ($categoriesData && $categoriesData->num_rows > 0) {
                $category = $categoriesData->fetch_array();
                $currentId = $category['id'];

                $lastRewriteCategory = $GameMonetizeConnect->query("SELECT id FROM " . CATEGORIES . " WHERE is_last_rewrite = '1' LIMIT 1");
                if ($lastRewriteCategory && $lastRewriteCategory->num_rows > 0) {
                    $lastRewriteCategory = $lastRewriteCategory->fetch_array();
                    if ($lastRewriteCategory['id'] == $currentId) {
                        echo "Last rewrite category reached. No rewrite will be done. Current ID: {$currentId}";
                        die;
                    }
                }

                if ($category['is_rewrited'] != '1') {
                    $updateSuccess = false;

                    $rewritedCategory = rewriteCategory($category);
                    $rewritedCategory = hitChatGpt($rewritedCategory);

                    if ($rewritedCategory !== false && strlen(trim($rewritedCategory)) > 0) {
                        $updateCategory = $GameMonetizeConnect->query("UPDATE " . CATEGORIES . " SET footer_description = \"" . mysqli_real_escape_string($GameMonetizeConnect, $rewritedCategory) . "\", is_rewrited = 1 WHERE id = {$currentId}");

                        if ($updateCategory) {
                            $updateSuccess = true;
                            echo "Successfully rewriting category: " . $category['name'];
                        } else {
                            echo "Failed to update category: " . $category['name'];
                            echo "<br>";
                            var_dump($GameMonetizeConnect->error);
                        }
                    } else {
                        echo "Failed generating category content: " . $category['name'];
                    }
                } else {
                    echo "The " . $category['name'] . " is already rewrited, skipping.";
                    $updateSuccess = true;
                }
            } else {
                echo "Category not found.";
            }

            if (!empty($currentId)) {
                $GameMonetizeConnect->query("UPDATE " . LINKS . " SET last_id = '{$currentId}' WHERE name = 'autopost_categories'");
            }

            echo "<br>Current id: " . $currentId;
            die;

} elseif ($linksData['name'] == 'autopost_blogs_tags') {
    error_reporting(-1);

    $lastId = (int)$linksData['last_id'];
    $processedId = $lastId;
    $created = false;
    $gmOnlySql = " AND file LIKE '%gamemonetize.%' ";

    $chatgpt_query = $GameMonetizeConnect->query("SELECT * FROM " . CHATGPT . " WHERE id = 1 LIMIT 1");
    if (!$chatgpt_query || $chatgpt_query->num_rows < 1) {
        echo "ChatGPT settings not found.";
        die;
    }

    $chatgpt_data = $chatgpt_query->fetch_assoc();

    if (empty($chatgpt_data['template_blog_tag'])) {
        echo "template_blog_tag is empty.";
        die;
    }

    if ($lastId > 0) {
        $tagData = $GameMonetizeConnect->query("
            SELECT *
            FROM " . TAGS . "
            WHERE id < {$lastId}
            ORDER BY id DESC
            LIMIT 50
        ");
    } else {
        $tagData = $GameMonetizeConnect->query("
            SELECT *
            FROM " . TAGS . "
            ORDER BY id DESC
            LIMIT 50
        ");
    }

    if (!$tagData || $tagData->num_rows < 1) {
        echo "No more tags found.";
        die;
    }

    while ($tag = $tagData->fetch_array()) {
        $currentId = (int)$tag['id'];
        $processedId = $currentId;

        $tagTitle = !empty($tag['name']) ? $tag['name'] : 'Tag';
        $tagDescription = !empty($tag['footer_description']) ? $tag['footer_description'] : '';
        $tagUrl = siteUrl() . "/tag/" . $tag['url'];
        $tag_link = "<a href='{$tagUrl}' target='_self' class='gameKeyword'><b>{$tagTitle} Games</b></a>";

        if (containsBlogLink($tagDescription)) {
            echo "Skipping tag ID {$currentId} because footer_description already contains /blog/: {$tagTitle}<br>";
            continue;
        }

        $existsCheck = $GameMonetizeConnect->query("
            SELECT id
            FROM " . BLOGS . "
            WHERE title LIKE '%" . mysqli_real_escape_string($GameMonetizeConnect, $tagTitle) . "%'
            LIMIT 1
        ");
        if ($existsCheck && $existsCheck->num_rows > 0) {
            echo "Skipping tag ID {$currentId} because related blog may already exist: {$tagTitle}<br>";
            continue;
        }

        $categoryName = '';
        $tagsText = $tagTitle;

        $randomGameLink = '';
        $randomGameImage = '';
        $backupRandomGameImage = '';
        $fallbackCategoryId = 0;
        $imageGame = false;

        $tagWords = preg_split('/\s+/', trim($tagTitle));
        $tagWords = array_values(array_filter($tagWords));

        $tagTitleSafe = mysqli_real_escape_string($GameMonetizeConnect, $tagTitle);
        $tagTitleNoSpace = str_replace(' ', '', strtolower($tagTitle));
        $tagTitleNoSpaceSafe = mysqli_real_escape_string($GameMonetizeConnect, $tagTitleNoSpace);

        $firstWord = !empty($tagWords[0]) ? mysqli_real_escape_string($GameMonetizeConnect, $tagWords[0]) : '';
        $secondWord = !empty($tagWords[1]) ? mysqli_real_escape_string($GameMonetizeConnect, $tagWords[1]) : '';

        $detectCategoryQuery = $GameMonetizeConnect->query("
            SELECT category
            FROM " . GAMES . "
            WHERE tags_ids LIKE '%\"{$currentId}\"%'
            AND published = '1'
            AND category IS NOT NULL
            AND category != ''
            ORDER BY RAND()
            LIMIT 1
        ");

        if ($detectCategoryQuery && $detectCategoryQuery->num_rows > 0) {
            $detectedCategory = $detectCategoryQuery->fetch_assoc();
            $fallbackCategoryId = (int)$detectedCategory['category'];

            if ($fallbackCategoryId > 0) {
                $categoryQuery = $GameMonetizeConnect->query("
                    SELECT name
                    FROM " . CATEGORIES . "
                    WHERE id = {$fallbackCategoryId}
                    LIMIT 1
                ");
                if ($categoryQuery && $categoryQuery->num_rows > 0) {
                    $categoryData = $categoryQuery->fetch_assoc();
                    $categoryName = $categoryData['name'];
                }
            }
        }

        // 1) Best match: same tag + exact tag title in game name
        $imageGameQuery = $GameMonetizeConnect->query("
            SELECT *
            FROM " . GAMES . "
            WHERE tags_ids LIKE '%\"{$currentId}\"%'
            AND published = '1'
            {$gmOnlySql}
            AND image IS NOT NULL
            AND image != ''
            AND name LIKE '%{$tagTitleSafe}%'
            ORDER BY RAND()
            LIMIT 10
        ");

        $queryGameData = fetchBestGameDataFromQuery($imageGameQuery);

        if (empty($backupRandomGameImage) && !empty($queryGameData['backupImage'])) {
            $backupRandomGameImage = $queryGameData['backupImage'];
        }

        if (!$imageGame && !empty($queryGameData['usableGame'])) {
            $imageGame = $queryGameData['usableGame'];
        }

        // 2) Same tag + no-space title match
        if (!$imageGame && $tagTitleNoSpaceSafe != '') {
            $imageGameQuery = $GameMonetizeConnect->query("
                SELECT *
                FROM " . GAMES . "
                WHERE tags_ids LIKE '%\"{$currentId}\"%'
                AND published = '1'
                {$gmOnlySql}
                AND image IS NOT NULL
                AND image != ''
                AND REPLACE(LOWER(name), ' ', '') LIKE '%{$tagTitleNoSpaceSafe}%'
                ORDER BY RAND()
                LIMIT 10
            ");

            $queryGameData = fetchBestGameDataFromQuery($imageGameQuery);

            if (empty($backupRandomGameImage) && !empty($queryGameData['backupImage'])) {
                $backupRandomGameImage = $queryGameData['backupImage'];
            }

            if (!$imageGame && !empty($queryGameData['usableGame'])) {
                $imageGame = $queryGameData['usableGame'];
            }
        }

        // 3) Same tag + first word / second word match
        if (!$imageGame && $firstWord != '') {
            $sqlExtraWord = '';
            if ($secondWord != '') {
                $sqlExtraWord = " AND name LIKE '%{$secondWord}%'";
            }

            $imageGameQuery = $GameMonetizeConnect->query("
                SELECT *
                FROM " . GAMES . "
                WHERE tags_ids LIKE '%\"{$currentId}\"%'
                AND published = '1'
                {$gmOnlySql}
                AND image IS NOT NULL
                AND image != ''
                AND name LIKE '%{$firstWord}%'
                {$sqlExtraWord}
                ORDER BY RAND()
                LIMIT 10
            ");

            $queryGameData = fetchBestGameDataFromQuery($imageGameQuery);

            if (empty($backupRandomGameImage) && !empty($queryGameData['backupImage'])) {
                $backupRandomGameImage = $queryGameData['backupImage'];
            }

            if (!$imageGame && !empty($queryGameData['usableGame'])) {
                $imageGame = $queryGameData['usableGame'];
            }
        }

        $tagWordsForSql = [];
        foreach ($tagWords as $word) {
            $word = trim($word);
            if ($word !== '' && mb_strlen($word) >= 3) {
                $safeWord = mysqli_real_escape_string($GameMonetizeConnect, $word);
                $tagWordsForSql[] = "name LIKE '%{$safeWord}%'";
            }
        }

        // 4) Same tag + relevance score from tag words
        if (!$imageGame && !empty($tagWordsForSql)) {
            $wordScoreSql = implode(" + ", array_map(function ($cond) {
                return "IF({$cond}, 1, 0)";
            }, $tagWordsForSql));

            $imageGameQuery = $GameMonetizeConnect->query("
                SELECT *,
                    ({$wordScoreSql}) AS relevance_score
                FROM " . GAMES . "
                WHERE tags_ids LIKE '%\"{$currentId}\"%'
                AND published = '1'
                {$gmOnlySql}
                AND image IS NOT NULL
                AND image != ''
                HAVING relevance_score > 0
                ORDER BY relevance_score DESC, RAND()
                LIMIT 10
            ");

            $queryGameData = fetchBestGameDataFromQuery($imageGameQuery);

            if (empty($backupRandomGameImage) && !empty($queryGameData['backupImage'])) {
                $backupRandomGameImage = $queryGameData['backupImage'];
            }

            if (!$imageGame && !empty($queryGameData['usableGame'])) {
                $imageGame = $queryGameData['usableGame'];
            }
        }

        // 5) Same category + relevance score from tag words
        if (!$imageGame && $fallbackCategoryId > 0 && !empty($tagWordsForSql)) {
            $wordScoreSql = implode(" + ", array_map(function ($cond) {
                return "IF({$cond}, 1, 0)";
            }, $tagWordsForSql));

            $imageGameQuery = $GameMonetizeConnect->query("
                SELECT *,
                    ({$wordScoreSql}) AS relevance_score
                FROM " . GAMES . "
                WHERE published = '1'
                {$gmOnlySql}
                AND category = '{$fallbackCategoryId}'
                AND image IS NOT NULL
                AND image != ''
                HAVING relevance_score > 0
                ORDER BY relevance_score DESC, RAND()
                LIMIT 10
            ");

            $queryGameData = fetchBestGameDataFromQuery($imageGameQuery);

            if (empty($backupRandomGameImage) && !empty($queryGameData['backupImage'])) {
                $backupRandomGameImage = $queryGameData['backupImage'];
            }

            if (!$imageGame && !empty($queryGameData['usableGame'])) {
                $imageGame = $queryGameData['usableGame'];
            }
        }

        if ($imageGame) {
            $gameUrl = siteUrl() . "/game/" . $imageGame['game_name'];
            $randomGameLink = "<a href='{$gameUrl}' target='_self' class='gameKeyword'><b>{$imageGame['name']}</b></a>";
            $randomGameImage = !empty($imageGame['image']) ? trim($imageGame['image']) : '';

            if (empty($categoryName) && !empty($imageGame['category'])) {
                $categoryQuery = $GameMonetizeConnect->query("
                    SELECT name
                    FROM " . CATEGORIES . "
                    WHERE id = '" . (int)$imageGame['category'] . "'
                    LIMIT 1
                ");
                if ($categoryQuery && $categoryQuery->num_rows > 0) {
                    $categoryData = $categoryQuery->fetch_assoc();
                    $categoryName = $categoryData['name'];
                }
            }
        }

        $relatedTags = [];
        $relatedTagsQuery = $GameMonetizeConnect->query("
            SELECT *
            FROM " . TAGS . "
            WHERE id != {$currentId}
            ORDER BY RAND()
            LIMIT 3
        ");

        if ($relatedTagsQuery) {
            while ($relatedTag = $relatedTagsQuery->fetch_assoc()) {
                $relatedUrl = siteUrl() . "/tag/" . $relatedTag['url'];
                $relatedTags[] = "<a href='{$relatedUrl}' target='_self' class='gameKeyword'><b>{$relatedTag['name']} Games</b></a>";
            }
        }

        $related_tags = implode(", ", $relatedTags);

        $generatedTitle = generateTagBlogTitleOnly($tagTitle, $categoryName, $tagsText);
        if ($generatedTitle === false || strlen(trim($generatedTitle)) < 1) {
            echo "Failed generating title for tag ID {$currentId}: {$tagTitle}<br>";
            continue;
        }

        $prompt = str_replace(
            [
                '$title',
                '$description',
                '$category',
                '$tags',
                '$tag_link',
                '$game_link',
                '$related_tags',
                '$blog_title'
            ],
            [
                $tagTitle,
                $tagDescription,
                $categoryName,
                $tagsText,
                $tag_link,
                '',
                $related_tags,
                $generatedTitle
            ],
            $chatgpt_data['template_blog_tag']
        );

        $prompt = str_replace('"', "'", $prompt);

        $response = hitChatGpt($prompt);

        if ($response === false || strlen(trim($response)) < 1) {
            echo "Failed generating blog content for tag ID {$currentId}: {$tagTitle}<br>";
            continue;
        }

        $blogContent = trim($response);

        $blogContent = stripAllAnchorsButKeepText($blogContent);

        $tagCtaParagraph = generateUniqueTagCta($tagTitle, $categoryName, $tagsText, $tag_link);
        $blogContent = injectParagraphAfterFirstParagraph($blogContent, $tagCtaParagraph);

        if (preg_match('/<h3\b[^>]*>.*?<\/h3>/is', $blogContent)) {
            $blogContent = preg_replace('/<h3\b[^>]*>.*?<\/h3>/is', '', $blogContent, 1);
            $blogContent = trim($blogContent);
        }

        $safeTitle = mysqli_real_escape_string($GameMonetizeConnect, $generatedTitle);
        $safeUrlRaw = seo_friendly_url($generatedTitle);
        $safeUrl = mysqli_real_escape_string($GameMonetizeConnect, $safeUrlRaw);
        $safePost = mysqli_real_escape_string($GameMonetizeConnect, $blogContent);

        $urlExists = $GameMonetizeConnect->query("SELECT id FROM " . BLOGS . " WHERE url = '{$safeUrl}' LIMIT 1");
        if ($urlExists && $urlExists->num_rows > 0) {
            echo "Skipping tag ID {$currentId} because blog URL already exists: {$safeUrlRaw}<br>";
            continue;
        }

        $localImagePath = '';
        $finalImageSource = '';

        echo "<hr>";
        echo "<strong>[IMAGE DEBUG - TAG BLOG]</strong><br>";
        echo "Tag ID: " . (int)$currentId . "<br>";
        echo "Tag Title: " . htmlspecialchars($tagTitle) . "<br>";

        echo "randomGameImage: " . (!empty($randomGameImage) ? htmlspecialchars($randomGameImage) : '[EMPTY]') . "<br>";
        echo "backupRandomGameImage: " . (!empty($backupRandomGameImage) ? htmlspecialchars($backupRandomGameImage) : '[EMPTY]') . "<br>";

        if (!empty($randomGameImage)) {
            $finalImageSource = $randomGameImage;
            echo "Using randomGameImage as finalImageSource<br>";
        } elseif (!empty($backupRandomGameImage)) {
            $finalImageSource = $backupRandomGameImage;
            echo "Using backupRandomGameImage as finalImageSource<br>";
        } else {
            echo "No randomGameImage and no backupRandomGameImage found<br>";
        }

        echo "finalImageSource: " . (!empty($finalImageSource) ? htmlspecialchars($finalImageSource) : '[EMPTY]') . "<br>";

        if (!empty($finalImageSource)) {
            $localImagePath = saveImageToLocal($finalImageSource, 'blog-img/');
            echo "saveImageToLocal result: " . (!empty($localImagePath) ? htmlspecialchars($localImagePath) : '[FAILED / EMPTY]') . "<br>";

            if (empty($localImagePath)) {
                $localImagePath = $finalImageSource;
                echo "Fallback to remote image URL: " . htmlspecialchars($localImagePath) . "<br>";
            }
        }

        if (empty($localImagePath)) {
            echo "Skipping tag blog because no usable image was found for this tag<br>";
            echo "<strong>[/IMAGE DEBUG - TAG BLOG]</strong><br>";
            echo "<hr>";
            continue;
        }

        echo "FINAL image used in insert: " . htmlspecialchars($localImagePath) . "<br>";
        echo "<strong>[/IMAGE DEBUG - TAG BLOG]</strong><br>";
        echo "<hr>";

        $safeImageUrl = mysqli_real_escape_string($GameMonetizeConnect, $localImagePath);

        $insertBlog = $GameMonetizeConnect->query("
            INSERT INTO " . BLOGS . " (title, url, image_url, post, date_created, is_rewrited, is_last_rewrite)
            VALUES ('{$safeTitle}', '{$safeUrl}', '{$safeImageUrl}', '{$safePost}', CURDATE(), 1, 0)
        ");

        if (!$insertBlog) {
            echo "Failed to insert blog for tag ID {$currentId}: {$tagTitle}<br>";
            var_dump($GameMonetizeConnect->error);
            continue;
        }

        $blogUrl = siteUrl() . "/blog/" . $safeUrlRaw;

        $relatedBoxHtml = generateRelatedBlogBox(
            $tagTitle,
            $categoryName,
            $tagsText,
            $generatedTitle,
            $blogUrl
        );

        if ($relatedBoxHtml === false || strlen(trim($relatedBoxHtml)) < 1) {
            echo "Blog created, but failed generating related box for tag ID {$currentId}: {$tagTitle}<br>";
        } else {
            $appendOk = appendRelatedBlogBoxToTagDescription($currentId, $relatedBoxHtml);
            if (!$appendOk) {
                echo "Blog created, but failed appending related box to tag description for tag ID {$currentId}: {$tagTitle}<br>";
            }
        }

        $created = true;
        echo "Successfully created blog for tag ID {$currentId}: {$generatedTitle}<br>";
        break;
    }

    $GameMonetizeConnect->query("UPDATE " . LINKS . " SET last_id = '{$processedId}' WHERE name = 'autopost_blogs_tags'");

    if (!$created) {
        echo "No eligible tag found. Last checked ID: {$processedId}";
    }

    die;

} elseif ($linksData['name'] == 'autopost_tags_from_list') {
    error_reporting(-1);

    $rootTxt  = dirname(__DIR__, 2) . '/keywords.txt';
    $rootJson = dirname(__DIR__, 2) . '/keywords.json';

    $keywordFile = '';
    if (file_exists($rootTxt)) {
        $keywordFile = $rootTxt;
    } elseif (file_exists($rootJson)) {
        $keywordFile = $rootJson;
    }

    if ($keywordFile == '') {
        echo "keywords.txt or keywords.json not found in root.";
        die;
    }

    $result = autopostTagFromKeywordList($keywordFile);

    echo $result;
    die;

} elseif ($linksData['name'] == 'autopost_blogs') {
                error_reporting(-1);

                $lastId = (int)$linksData['last_id'];
                $processedId = $lastId;
                $created = false;

                $chatgpt_query = $GameMonetizeConnect->query("SELECT * FROM " . CHATGPT . " WHERE id = 1 LIMIT 1");
                if (!$chatgpt_query || $chatgpt_query->num_rows < 1) {
                    echo "ChatGPT settings not found.";
                    die;
                }

                $chatgpt_data = $chatgpt_query->fetch_assoc();

                $gameData = $GameMonetizeConnect->query("
                    SELECT *
                    FROM " . GAMES . "
                    WHERE game_id > {$lastId} AND published = '1'
                    ORDER BY game_id ASC
                    LIMIT 50
                ");

                if (!$gameData || $gameData->num_rows < 1) {
                    echo "No more games found after ID: {$lastId}";
                    die;
                }

                while ($game = $gameData->fetch_array()) {
                    $currentId = (int)$game['game_id'];
                    $processedId = $currentId;

                    $gameTitle = !empty($game['name']) ? $game['name'] : 'Game';
                    $gameDescription = !empty($game['description']) ? $game['description'] : '';

                    if (containsBlogLink($gameDescription)) {
                        echo "Skipping game ID {$currentId} because description already contains /blog/: {$gameTitle}<br>";
                        continue;
                    }

                    $categoryName = '';
                    if (!empty($game['category'])) {
                        $categoryQuery = $GameMonetizeConnect->query("SELECT * FROM " . CATEGORIES . " WHERE id = '" . (int)$game['category'] . "' LIMIT 1");
                        if ($categoryQuery && $categoryQuery->num_rows > 0) {
                            $categoryData = $categoryQuery->fetch_assoc();
                            $categoryName = $categoryData['name'];
                        }
                    }

                    $tagsText = '';
                    $game_tags = [];
                    if (!empty($game['tags_ids']) && $game['tags_ids'] != 'null') {
                        $game_tags = json_decode($game['tags_ids'], true);
                    }

                    $tagNames = [];
                    if (!empty($game_tags) && is_array($game_tags)) {
                        $allGameTagsIds = implode(",", array_map('intval', $game_tags));
                        $gameTagsQuery = $GameMonetizeConnect->query("SELECT * FROM " . TAGS . " WHERE id IN({$allGameTagsIds})");
                        if ($gameTagsQuery) {
                            while ($tagRow = $gameTagsQuery->fetch_array()) {
                                $tagNames[] = $tagRow['name'];
                            }
                        }
                    }
                    $tagsText = implode(", ", $tagNames);

                    $gameUrl = siteUrl() . "/game/" . $game['game_name'];
                    $game_link = "<a href='{$gameUrl}' target='_self' class='gameKeyword'><b>{$game['name']}</b></a>";

                    $generatedTitle = generateBlogTitleOnly($gameTitle, $categoryName, $tagsText);
                    if ($generatedTitle === false || strlen(trim($generatedTitle)) < 1) {
                        echo "Failed generating title for game ID {$currentId}: {$gameTitle}<br>";
                        continue;
                    }

                    $prompt = str_replace(
                        [
                            '$title',
                            '$description',
                            '$category',
                            '$tags',
                            '$game_link',
                            '$blog_title'
                        ],
                        [
                            $gameTitle,
                            $gameDescription,
                            $categoryName,
                            $tagsText,
                            $game_link,
                            $generatedTitle
                        ],
                        $chatgpt_data['template_blog']
                    );

                    $prompt = str_replace('"', "'", $prompt);

                    $response = hitChatGpt($prompt);

                    if ($response === false || strlen(trim($response)) < 1) {
                        echo "Failed generating blog content for game ID {$currentId}: {$gameTitle}<br>";
                        continue;
                    }

                    $blogContent = trim($response);

                    preg_match_all('/<a\b[^>]*class=[\'"]gameKeyword[\'"][^>]*>.*?<\/a>/is', $blogContent, $links);
                    if (!empty($links[0])) {
                        $first = true;
                        foreach ($links[0] as $linkHtml) {
                            if ($first) {
                                $first = false;
                                continue;
                            }
                            $blogContent = str_replace($linkHtml, strip_tags($linkHtml), $blogContent);
                        }
                    }

                    if (preg_match('/^\s*<h3>/i', $blogContent)) {
                        $intro = "<p>{$gameTitle} is a fun and engaging online game that offers an enjoyable experience for players looking for quick entertainment and exciting gameplay.</p>";
                        $blogContent = $intro . "\n" . $blogContent;
                    }

                    if (preg_match('/<h3\b[^>]*>.*?<\/h3>/is', $blogContent)) {
                        $blogContent = preg_replace('/<h3\b[^>]*>.*?<\/h3>/is', '', $blogContent, 1);
                        $blogContent = trim($blogContent);
                    }

                    $safeTitle = mysqli_real_escape_string($GameMonetizeConnect, $generatedTitle);
                    $safeUrl = mysqli_real_escape_string($GameMonetizeConnect, seo_friendly_url($generatedTitle));
                    $safePost = mysqli_real_escape_string($GameMonetizeConnect, $blogContent);

                    $originalImageUrl = !empty($game['image']) ? $game['image'] : '';
                    $localImagePath = '';

                    if (!empty($originalImageUrl)) {
                        $localImagePath = saveImageToLocal($originalImageUrl, 'blog-img/');
                        if (empty($localImagePath)) {
                            $localImagePath = $originalImageUrl;
                        }
                    }

                    $safeImageUrl = mysqli_real_escape_string($GameMonetizeConnect, $localImagePath);

                    $insertBlog = $GameMonetizeConnect->query("
                        INSERT INTO " . BLOGS . " (title, url, image_url, post, date_created, is_rewrited, is_last_rewrite)
                        VALUES ('{$safeTitle}', '{$safeUrl}', '{$safeImageUrl}', '{$safePost}', CURDATE(), 1, 0)
                    ");

                    if (!$insertBlog) {
                        echo "Failed to insert blog for game ID {$currentId}: {$gameTitle}<br>";
                        var_dump($GameMonetizeConnect->error);
                        continue;
                    }

                    $blogUrl = siteUrl() . "/blog/" . seo_friendly_url($generatedTitle);

                    $relatedBoxHtml = generateRelatedBlogBox(
                        $gameTitle,
                        $categoryName,
                        $tagsText,
                        $generatedTitle,
                        $blogUrl
                    );

                    if ($relatedBoxHtml === false || strlen(trim($relatedBoxHtml)) < 1) {
                        echo "Blog created, but failed generating related box for game ID {$currentId}: {$gameTitle}<br>";
                    } else {
                        $appendOk = appendRelatedBlogBoxToGameDescription($currentId, $relatedBoxHtml);
                        if (!$appendOk) {
                            echo "Blog created, but failed appending related box to description for game ID {$currentId}: {$gameTitle}<br>";
                        }
                    }

                    $created = true;
                    echo "Successfully created blog for game ID {$currentId}: {$generatedTitle}<br>";
                    break;
                }

                $GameMonetizeConnect->query("UPDATE " . LINKS . " SET last_id = '{$processedId}' WHERE name = 'autopost_blogs'");

                if (!$created) {
                    echo "No eligible game found. Last checked ID: {$processedId}";
                }

                die;

} elseif ($linksData['name'] == 'autopost_old_blogs') {
                error_reporting(-1);

                $blogData = $GameMonetizeConnect->query("SELECT * FROM " . BLOGS . " WHERE is_rewrited = 0 ORDER BY id ASC LIMIT 1");

                if ($blogData && $blogData->num_rows > 0) {
                    $blog = $blogData->fetch_array();
                    $currentId = $blog['id'];

                    $lastRewriteBlog = $GameMonetizeConnect->query("SELECT id FROM " . BLOGS . " WHERE is_last_rewrite = '1' LIMIT 1");
                    if ($lastRewriteBlog && $lastRewriteBlog->num_rows > 0) {
                        $lastRewriteBlog = $lastRewriteBlog->fetch_array();
                        if ($lastRewriteBlog['id'] == $currentId) {
                            echo "Last rewrite blog reached. No rewrite will be done. Current ID: {$currentId}";
                            die;
                        }
                    }

                    if ($blog['is_rewrited'] != '1') {
                        $rewritedBlog = rewriteBlog($blog);
                        $rewritedBlog = hitChatGpt($rewritedBlog);

                        if ($rewritedBlog !== false && strlen(trim($rewritedBlog)) > 0) {
                            $safeContent = mysqli_real_escape_string($GameMonetizeConnect, $rewritedBlog);

                            $updateBlog = $GameMonetizeConnect->query("
                                UPDATE " . BLOGS . "
                                SET post = '{$safeContent}',
                                    is_rewrited = 1
                                WHERE id = {$currentId}
                            ");

                            if ($updateBlog) {
                                echo "Successfully rewriting blog: " . $blog['title'];
                            } else {
                                echo "Failed to update blog: " . $blog['title'];
                                echo "<br>";
                                var_dump($GameMonetizeConnect->error);
                            }
                        } else {
                            echo "Failed generating blog content: " . $blog['title'];
                        }
                    } else {
                        echo "The blog is already rewrited, skipping.";
                    }
                } else {
                    echo "Blog not found.";
                }

                if (!empty($currentId)) {
                    $GameMonetizeConnect->query("UPDATE " . LINKS . " SET last_id = '{$currentId}' WHERE name = 'autopost_old_blogs'");
                }

                echo "<br>Current id: " . $currentId;
                die;

        
    } else {
        $themeData['page_content'] = "Something went wrong.";
    }
} else {
    $themeData['page_content'] = "Something went wrong.";
}


function seo_friendly_url($string)
{
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/'), '-', $string);
    return strtolower(trim($string, '-'));
}

function getRealGameMonetizeWtVideo($fileUrl)
{
    $fileUrl = trim((string)$fileUrl);

    if ($fileUrl === '') {
        return '';
    }

    if (!preg_match('#html5\.gamemonetize\.(?:com|co|games)/([a-zA-Z0-9_-]+)/?#i', $fileUrl, $matches)) {
        return '';
    }

    $gameId = $matches[1];
    $apiUrl = 'https://api.gamemonetize.com/video.php?gameid=' . urlencode($gameId);

    $response = @file_get_contents($apiUrl);

    if ($response === false) {
        return '';
    }

    $data = json_decode($response, true);

    if (empty($data['isSuccess']) || empty($data['data']['detail'][0]['mediaURL'])) {
        return '';
    }

    $videoUrl = trim($data['data']['detail'][0]['mediaURL']);

    $blockedVideos = [
        '4kci7og3klgj0ivy2wz3gdvd9dth5e7n'
    ];

    foreach ($blockedVideos as $blockedVideo) {
        if (strpos($videoUrl, $blockedVideo) !== false) {
            return '';
        }
    }

    if (strpos($videoUrl, 'gamemonetize.video/video/') === false || strpos($videoUrl, '.mp4') === false) {
        return '';
    }

    return $videoUrl;
}

function rewriteChatgpt($gameId)
{
    error_reporting(-1);
    global $GameMonetizeConnect;

    $get_game = getGame($gameId);
    if ($get_game) {
        $game_tags = [];
        if ($get_game['tags_ids'] != 'null' && !is_null($get_game['tags_ids'])) {
            $game_tags = json_decode($get_game['tags_ids']);
        }
        $addgame_tags = $GameMonetizeConnect->query("SELECT * FROM " . TAGS . " WHERE id!=0");
        $tags_option = '';
        $tags_click_copy = '';
        while ($select_tags = $addgame_tags->fetch_array()) {
            if (in_array("{$select_tags['id']}", $game_tags)) {
                $tags_option .= '<option value="' . $select_tags['id'] . '" selected>' . $select_tags['name'] . '</option>';

                // Tags click copy
                $themeData['tags_url_copy'] = siteUrl() . "/tag/" . $select_tags['url'];
                $themeData['tags_name_copy'] = $select_tags['name'];
                $tags_click_copy .= \GameMonetize\UI::view('admin/sections/tags-click-copy');
            } else {
                $tags_option .= '<option value="' . $select_tags['id'] . '">' . $select_tags['name'] . '</option>';
            }
        }
        $themeData['edit_game_tags'] = $tags_option;
        $themeData['tags_click_to_copy'] = $tags_click_copy;

        $gameNameExplode = explode(' ', $get_game['name']);
        $firstName = substr($gameNameExplode[0], 0, 4);
        $secondName = substr($gameNameExplode[1], 0, 4);
        $threeRandomGame = array();

        // First word similar
        $first_name_click_copy = '';
        $sqlQuerySimilar = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE name LIKE '%{$firstName}%' AND published='1' AND name != '{$get_game['name']}' ORDER BY name ASC LIMIT 10");
        if ($sqlQuerySimilar->num_rows > 0) {
            while ($similarGames = $sqlQuerySimilar->fetch_array()) {
                $themeData['tags_url_copy'] = siteUrl() . "/game/" . $similarGames['game_name'];

                $firstWordRandomGame = $threeRandomGame[0] = "<a href='{$themeData['tags_url_copy']}' target='_self' class='gameKeyword'><bold>{$similarGames['name']}</bold></a>";

                $themeData['tags_name_copy'] = $similarGames['name'];
                $first_name_click_copy .= \GameMonetize\UI::view('admin/sections/tags-click-copy');
            }
        }

        $themeData['first_word_click_to_copy'] = $first_name_click_copy;

        // Second word similar
        $second_name_click_copy = '';
        $sqlQuerySimilar = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE name LIKE '%{$secondName}%' AND published='1' AND name != '{$get_game['name']}' ORDER BY name ASC LIMIT 10");
        if ($sqlQuerySimilar->num_rows > 0) {
            while ($similarGames = $sqlQuerySimilar->fetch_array()) {
                $themeData['tags_url_copy'] = siteUrl() . "/game/" . $similarGames['game_name'];
                $secondWordRandomGame = $threeRandomGame[1] = "<a href='{$themeData['tags_url_copy']}' target='_self' class='gameKeyword'><bold>{$similarGames['name']}</bold></a>";

                $themeData['tags_name_copy'] = $similarGames['name'];
                $second_name_click_copy .= \GameMonetize\UI::view('admin/sections/tags-click-copy');
            }
        }

        $themeData['second_word_click_to_copy'] = $second_name_click_copy;

        // Random word similar
        $oneRandomGame = "";
        $random_name_click_copy = '';
        $sqlQuerySimilar = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE  published='1' AND name != '{$get_game['name']}' ORDER BY RAND() LIMIT 10");
        if ($sqlQuerySimilar->num_rows > 0) {
            $index = 0;
            while ($similarGames = $sqlQuerySimilar->fetch_array()) {
                $themeData['tags_url_copy'] = siteUrl() . "/game/" . $similarGames['game_name'];
                $oneRandomGame = "<a href='{$themeData['tags_url_copy']}' target='_self' class='gameKeyword'><bold>{$similarGames['name']}</bold></a>";

                $themeData['tags_name_copy'] = $similarGames['name'];
                $random_name_click_copy .= \GameMonetize\UI::view('admin/sections/tags-click-copy');
                if ($index > 1) {
                    $thirdRandomGame = siteUrl() . "/game/" . $similarGames['game_name'];
                    $threeRandomGame[2] = "<a href='{$thirdRandomGame}' target='_self' class='gameKeyword'><bold>{$similarGames['name']}</bold></a>";
                }
                $index++;
            }
        }

        // Chatgpt template
        $chatgpt_query = $GameMonetizeConnect->query("SELECT * FROM " . CHATGPT . " WHERE id = 1 LIMIT 1");
        if ($chatgpt_query && $chatgpt_query->num_rows > 0) {
            $chatgpt_data = $chatgpt_query->fetch_assoc();

            $gameDescription = $get_game['description'];
            $gameTitle = $get_game['name'];
            if (!empty($game_tags)) {
                $beforeWordArray = explode(",", $chatgpt_data['random_words_before_tags']);
                $afterWordArray = explode(",", $chatgpt_data['random_words_after_tags']);

                $allRandomBeforeAfter = [];
                $allGameTagsIds = implode(",", $game_tags);
                $allGameTags = [];
                $gameTags = $GameMonetizeConnect->query("SELECT * FROM " . TAGS . " WHERE id IN({$allGameTagsIds}) ");
                $allRandomSimTagLink = [];
                while ($tagsData = $gameTags->fetch_array()) {
                    $beforeWord = $beforeWordArray[array_rand($beforeWordArray)] . " ";
                    $afterWord = " " . $afterWordArray[array_rand($afterWordArray)];
                    $allGameTags[] = $beforeWord . $tagsData['name'] . $afterWord;

                    $randomSimTagLink = siteUrl() . "/tag/" . $tagsData['url'];
                    $randomSimTagName = $tagsData['name'];
                    $allRandomSimTagLink[] = "<a href='{$randomSimTagLink}' target='_self' class='gameKeyword'><bold>{$randomSimTagName} Games</bold></a>";
                }

                $randomSimTagLink = $allRandomSimTagLink[array_rand($allRandomSimTagLink)];

                $gameTags = implode(",", $allGameTags);
            }

            $gameCategory = $GameMonetizeConnect->query("SELECT * FROM " . CATEGORIES . " WHERE id = '{$get_game['category']}'");
            if ($gameCategory) {
                $gameCategory = $gameCategory->fetch_assoc();
                $gameCategory = !empty($gameCategory['name']) ? $gameCategory['name'] : "";
            } else {
                $gameCategory = "";
            }

            // Random similar tag
            // $randomSimTag = $GameMonetizeConnect->query("SELECT * FROM " . TAGS . " ORDER BY RAND() LIMIT 1");
            // $randomSimTag = $randomSimTag->fetch_assoc();
            // $randomSimTagLink = siteUrl() . "/tag/" . $randomSimTag['url'];
            // $randomSimTagName = ucfirst($randomSimTag['name']);
            // $randomSimTagLink = "<a href='{$randomSimTagLink}' target='_self' class='gameKeyword'><bold>{$randomSimTagName} Games</bold></a>";

            // Random tag link
            $randomTag = $GameMonetizeConnect->query("SELECT * FROM " . TAGS . " ORDER BY RAND() LIMIT 1");
            $randomTag = $randomTag->fetch_assoc();
            $randomTagLink = siteUrl() . "/tag/" . $randomTag['url'];
            $randomTagName = ucfirst($randomTag['name']);
            $randomTagLink = "<a href='{$randomTagLink}' target='_self' class='gameKeyword'><bold>{$randomTagName} Games</bold></a>";
            $themeData['chat_gpt_template_game'] = str_replace(
                [
                    "\$description",
                    "\$title",
                    "\$tags",
                    "\$category",
                    "\$game_link",
                    "\$game_first_word",
                    "\$game_second_word",
                    "\$three_random_game",
                    "\$random_similar_tags",
                    "\$random_tags_link",
                ],
                [
                    $gameDescription,
                    $gameTitle,
                    $gameTags,
                    $gameCategory,
                    $oneRandomGame,
                    $firstWordRandomGame,
                    $secondWordRandomGame,
                    implode(",", $threeRandomGame),
                    $randomSimTagLink,
                    $randomTagLink
                ],
                $chatgpt_data['template_game']
            );
            
 $chatGptResult = hitChatGpt($themeData['chat_gpt_template_game']);
            if ($chatGptResult !== false) {
                // Update
                // $isSuccessUpdate = $GameMonetizeConnect->query("UPDATE " . GAMES . " SET description = '{$chatGptResult}' WHERE game_id = $gameId");
                $stmt = $GameMonetizeConnect->prepare("UPDATE " . GAMES . " SET description = ? WHERE game_id = ?");
                if ($stmt) {
                    $gameDescription = convertBoldTags($chatGptResult);
                    // Bind the variables to the parameter as strings.
                    $stmt->bind_param("si", $gameDescription, $gameId);

                    // Execute the statement
                    $isSuccessUpdate = $stmt->execute();

                    // Check for successful update
                    // if ($isSuccessUpdate) {
                    //     echo "Update successful.";
                    // } else {
                    //     echo "Update failed: " . $stmt->error;
                    // }

                    // Close the statement
                    $stmt->close();
                    
                    return true;
                } else {
                    echo "Prepare failed: " . $GameMonetizeConnect->error;
                    return false;
                }
            } else {
                
                return false;
            }
        }
    }
}

function hitChatGpt($textToRewrite)
{
    global $GameMonetizeConnect;
    
    $chatgptSetting = $GameMonetizeConnect->query("SELECT * FROM " . CHATGPT . " WHERE id = 1 LIMIT 1");
    if (!$chatgptSetting || $chatgptSetting->num_rows < 1) {
        echo "Failed to get chatgpt setting.";
        return false;
    }

    $chatgptSetting = $chatgptSetting->fetch_assoc();
 
    $provider = !empty($chatgptSetting['llm_provider']) ? trim((string)$chatgptSetting['llm_provider']) : 'openai';
    $provider = strtolower($provider);

    if (strpos($provider, 'cmsai') === 0) {
        $provider = 'cmsai';
    }

    $chatgpt_model = !empty($chatgptSetting['chatgpt_model']) ? trim((string)$chatgptSetting['chatgpt_model']) : 'gpt-4o-mini';

    $api_key = '';
    $url = '';
    $headers = ['Content-Type: application/json'];
    $postData = [];

    $systemPrompt = 'You are a game description rephrasing or rewriter assistant. Please do the instruction that i will give. Always include html links if i asked to. Separate the result into some paragraphs with <p> tag.';

    if ($provider == 'openai') {
        $api_key = !empty($chatgptSetting['openai_api_key']) ? trim($chatgptSetting['openai_api_key']) : '';
        $url = 'https://api.openai.com/v1/chat/completions';

        $postData = [
            'model' => $chatgpt_model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $systemPrompt
                ],
                [
                    'role' => 'user',
                    'content' => $textToRewrite
                ]
            ]
        ];

        $headers[] = 'Authorization: Bearer ' . $api_key;

    } elseif ($provider == 'deepseek') {
        $api_key = !empty($chatgptSetting['deepseek_api_key']) ? trim($chatgptSetting['deepseek_api_key']) : '';
        $url = 'https://api.deepseek.com/chat/completions';

        $postData = [
            'model' => $chatgpt_model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $systemPrompt
                ],
                [
                    'role' => 'user',
                    'content' => $textToRewrite
                ]
            ]
        ];

        $headers[] = 'Authorization: Bearer ' . $api_key;

    } elseif ($provider == 'mimo') {
        $api_key = !empty($chatgptSetting['mimo_api_key']) ? trim($chatgptSetting['mimo_api_key']) : '';
        $url = 'https://api.xiaomimimo.com/v1/chat/completions';

        $postData = [
            'model' => $chatgpt_model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $systemPrompt
                ],
                [
                    'role' => 'user',
                    'content' => $textToRewrite
                ]
            ]
        ];

        $headers[] = 'Authorization: Bearer ' . $api_key;

    } elseif ($provider == 'gemini') {
        $api_key = !empty($chatgptSetting['gemini_api_key']) ? trim($chatgptSetting['gemini_api_key']) : '';
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . urlencode($chatgpt_model) . ':generateContent?key=' . urlencode($api_key);

        $postData = [
            'systemInstruction' => [
                'parts' => [
                    ['text' => $systemPrompt]
                ]
            ],
            'contents' => [
                [
                    'parts' => [
                        ['text' => $textToRewrite]
                    ]
                ]
            ]
        ];

    } elseif ($provider == 'openrouter') {
        $api_key = !empty($chatgptSetting['openrouter_api_key']) ? trim($chatgptSetting['openrouter_api_key']) : '';
        $url = 'https://openrouter.ai/api/v1/chat/completions';

        $postData = [
            'model' => $chatgpt_model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $systemPrompt
                ],
                [
                    'role' => 'user',
                    'content' => $textToRewrite
                ]
            ]
        ];

        $headers[] = 'Authorization: Bearer ' . $api_key;
        $headers[] = 'HTTP-Referer: https://arcadegames.com.es';
        $headers[] = 'X-Title: ArcadeGames';

    } else {
            if ($provider === 'cmsai') {
                echo "CMS AI is currently enabled only for main autopost. Use OpenAI/MiMo for tags, or create separate linkscmsai-tags.php.";
                return false;
            }

            echo "Unsupported provider: " . htmlspecialchars($provider);
            return false;
        }

    if ($api_key == '') {
        echo "API key is empty for provider: " . htmlspecialchars($provider);
        return false;
    }

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

    $rawResponse = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);

    curl_close($ch);

    if ($rawResponse === false || !empty($curlError)) {
        echo "cURL error: " . $curlError;
        return false;
    }

    $response = json_decode($rawResponse, true);

    if ($provider == 'gemini') {
        if ($httpCode >= 200 && $httpCode < 300 && isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            return $response['candidates'][0]['content']['parts'][0]['text'];
        }

        echo "Error from gemini: ";
        print_r($response ?: $rawResponse);
        return false;
    }

    if ($httpCode >= 200 && $httpCode < 300 && isset($response['choices'][0]['message']['content'])) {
        return $response['choices'][0]['message']['content'];
    }

    echo "Error from provider: ";
    print_r($response ?: $rawResponse);
    return false;
}

function convertBoldTags($text) {
    // Use regex to find **text** and replace with <b>text</b>
    $pattern = '/\*\*(.*?)\*\*/';
    $replacement = '<b>$1</b>';
    return preg_replace($pattern, $replacement, $text);
}

function rewriteTags($edit_tags)
{
    global $GameMonetizeConnect;

        $themeData['edit_tags_id'] = $edit_tags['id'];
        $themeData['edit_tags_name'] = $edit_tags['name'];
        $themeData['edit_tags_footer_description'] = $edit_tags['footer_description'];
        $themeData['edit_tags_url'] = siteUrl() . '/tag/' . $edit_tags['url'];

        $chatgpt_query = $GameMonetizeConnect->query("SELECT * FROM " . CHATGPT . " WHERE id = 1 LIMIT 1");
        if ($chatgpt_query && $chatgpt_query->num_rows > 0) {
            $chatgpt_data = $chatgpt_query->fetch_assoc();

            $tagsDescription = $edit_tags['footer_description'];
            $tagsTitle = $edit_tags['name'];

            $tagsRandomGame = '';
            $sqlQuerySimilar = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE tags_ids LIKE '%\"{$edit_tags['id']}\"%' AND published='1' ORDER BY RAND() LIMIT 1");
            if ($sqlQuerySimilar->num_rows > 0) {
                while ($similarGames = $sqlQuerySimilar->fetch_array()) {
                    $tagsRandomGame = siteUrl() . "/game/" . $similarGames['game_name'];
                    $tagsRandomGame = "<a href='{$tagsRandomGame}' target='_self' class='gameKeyword'><bold>{$similarGames['name']}</bold></a>";

                }
            }

            $firstWordGame = $secondWordGame = $firstWordTagTitle = $secondWordTagTitle = "";

            // First word game
            $tagsTitleExploded = explode(" ", $tagsTitle);

            $firstWordTagTitle = substr($tagsTitleExploded[0], 0, 4);
            $sqlGameFirstWord = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE name LIKE '%{$firstWordTagTitle}%' AND published='1' LIMIT 1");
            if ($sqlGameFirstWord && $sqlGameFirstWord->num_rows > 0) {
                $firstGameData = $sqlGameFirstWord->fetch_array();
                $firstGameLink = siteUrl() . "/game/" . $firstGameData['game_name'];
                $firstWordGame = "<a href='{$firstGameLink}' target='_self' class='gameKeyword'><bold>{$firstGameData['name']}</bold></a>";
            }

            if ($sqlGameFirstWord->num_rows > 0) {
                while ($similarGames = $sqlQuerySimilar->fetch_array()) {
                    $tagsRandomGame = siteUrl() . "/game/" . $similarGames['game_name'];
                    $tagsRandomGame = "<a href='{$tagsRandomGame}' target='_self' class='gameKeyword'><bold>{$similarGames['name']}</bold></a>";
                }
            }

            if (count($tagsTitleExploded) > 1) {
                $secondWordTagTitle = $tagsTitleExploded[1];

                $sqlGameSecondWord = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE name LIKE '%{$secondWordTagTitle}%' AND published='1' LIMIT 1");

                if ($sqlGameSecondWord && $sqlGameSecondWord->num_rows > 0) {
                    $secondGameData = $sqlGameSecondWord->fetch_array();
                    $secondGameLink = siteUrl() . "/game/" . $secondGameData['game_name'];
                    $secondWordGame = "<a href='{$secondGameLink}' target='_self' class='gameKeyword'><bold>{$secondGameData['name']}</bold></a>";
                }
            }

            // Random games
            $sqlRandomGame = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE published='1' ORDER BY RAND() LIMIT 1");

            if ($sqlRandomGame && $sqlRandomGame->num_rows > 0) {
                $randomGameData = $sqlRandomGame->fetch_array();
                $randomGameLink = siteUrl() . "/game/" . $randomGameData['game_name'];
                $randomGame = "<a href='{$randomGameLink}' target='_self' class='gameKeyword'><bold>{$randomGameData['name']}</bold></a>";
            }

            // Random tags
            $sqlRandomTags = $GameMonetizeConnect->query("SELECT * FROM " . TAGS . " ORDER BY RAND() LIMIT 1");

            if ($sqlRandomTags && $sqlRandomTags->num_rows > 0) {
                $randomTagsData = $sqlRandomTags->fetch_array();
                $randomTagsLink = siteUrl() . "/tag/" . $randomTagsData['url'];
                $randomTags = "<a href='{$randomTagsLink}' target='_self' class='gameKeyword'><bold>{$randomTagsData['name']} Games</bold></a>";
                $randomTagText = "{$randomTagsData['name']} Games";
            }

            // Tags with random before and after words
            $beforeWordArray = explode(",", $chatgpt_data['random_words_before_tags']);
            $afterWordArray = explode(",", $chatgpt_data['random_words_after_tags']);

            $allRandomBeforeAfter = [];
            for ($i = 0; $i < 10; $i++) {
                $beforeWord = $beforeWordArray[array_rand($beforeWordArray)] . " ";
                $afterWord = " " . $afterWordArray[array_rand($afterWordArray)];
                $allRandomBeforeAfter[] = $beforeWord . $tagsTitle . $afterWord;
            }
            $allRandomBeforeAfter = implode(",", $allRandomBeforeAfter);

            $chatGptTemplateTags = str_replace(
                [
                    "\$description",
                    "\$title",
                    "\$game_link",
                    "\$firstWord",
                    "\$secondWord",
                    "\$randomSimGames",
                    "\$randomSimTags",
                    "\$randomSimTagBeforeAfter",
                ],
                [
                    $tagsDescription,
                    $tagsTitle,
                    $tagsRandomGame,
                    $firstWordGame,
                    $secondWordGame,
                    $randomGame,
                    $randomTags,
                    $allRandomBeforeAfter,
                ],
                $chatgpt_data['template_tags']
            );

            $chatGptTemplateTags = str_replace('"', "'", $chatGptTemplateTags);
            return $chatGptTemplateTags;
        }
}
function rewriteCategory($categoryData)
{
    global $GameMonetizeConnect;

    $chatgpt_query = $GameMonetizeConnect->query("SELECT * FROM " . CHATGPT . " WHERE id = 1 LIMIT 1");
    if ($chatgpt_query && $chatgpt_query->num_rows > 0) {
        $chatgpt_data = $chatgpt_query->fetch_assoc();

        $categoryTitle = !empty($categoryData['name']) ? $categoryData['name'] : '';
        $categoryDescription = '';

        if (!empty($categoryData['description'])) {
            $categoryDescription = $categoryData['description'];
        } elseif (!empty($categoryData['footer_description'])) {
            $categoryDescription = $categoryData['footer_description'];
        }

        $randomGameLink = '';
        $sqlRandomGame = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE category = '{$categoryData['id']}' AND published='1' ORDER BY RAND() LIMIT 1");
        if ($sqlRandomGame && $sqlRandomGame->num_rows > 0) {
            $randomGameData = $sqlRandomGame->fetch_array();
            $gameLink = siteUrl() . "/game/" . $randomGameData['game_name'];
            $randomGameLink = "<a href='{$gameLink}' target='_self' class='gameKeyword'><bold>{$randomGameData['name']}</bold></a>";
        }

        $firstWordGame = '';
        $secondWordGame = '';
        $randomSimGames = '';
        $randomSimTags = '';
        $randomSimTagBeforeAfter = '';

        $categoryTitleExploded = explode(" ", trim($categoryTitle));

        if (!empty($categoryTitleExploded[0])) {
            $firstWord = substr($categoryTitleExploded[0], 0, 4);
            $sqlGameFirstWord = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE name LIKE '%{$firstWord}%' AND published='1' LIMIT 1");
            if ($sqlGameFirstWord && $sqlGameFirstWord->num_rows > 0) {
                $firstGameData = $sqlGameFirstWord->fetch_array();
                $firstGameLink = siteUrl() . "/game/" . $firstGameData['game_name'];
                $firstWordGame = "<a href='{$firstGameLink}' target='_self' class='gameKeyword'><bold>{$firstGameData['name']}</bold></a>";
            }
        }

        if (!empty($categoryTitleExploded[1])) {
            $secondWord = substr($categoryTitleExploded[1], 0, 4);
            $sqlGameSecondWord = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE name LIKE '%{$secondWord}%' AND published='1' LIMIT 1");
            if ($sqlGameSecondWord && $sqlGameSecondWord->num_rows > 0) {
                $secondGameData = $sqlGameSecondWord->fetch_array();
                $secondGameLink = siteUrl() . "/game/" . $secondGameData['game_name'];
                $secondWordGame = "<a href='{$secondGameLink}' target='_self' class='gameKeyword'><bold>{$secondGameData['name']}</bold></a>";
            }
        }

        $sqlRandomGame2 = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE published='1' ORDER BY RAND() LIMIT 1");
        if ($sqlRandomGame2 && $sqlRandomGame2->num_rows > 0) {
            $randomGameData2 = $sqlRandomGame2->fetch_array();
            $randomGameLink2 = siteUrl() . "/game/" . $randomGameData2['game_name'];
            $randomSimGames = "<a href='{$randomGameLink2}' target='_self' class='gameKeyword'><bold>{$randomGameData2['name']}</bold></a>";
        }

        $sqlRandomTags = $GameMonetizeConnect->query("SELECT * FROM " . TAGS . " ORDER BY RAND() LIMIT 1");
        if ($sqlRandomTags && $sqlRandomTags->num_rows > 0) {
            $randomTagsData = $sqlRandomTags->fetch_array();
            $randomTagsLink = siteUrl() . "/tag/" . $randomTagsData['url'];
            $randomSimTags = "<a href='{$randomTagsLink}' target='_self' class='gameKeyword'><bold>{$randomTagsData['name']} Games</bold></a>";
        }

        $beforeWordArray = explode(",", $chatgpt_data['random_words_before_tags']);
        $afterWordArray = explode(",", $chatgpt_data['random_words_after_tags']);

        $allRandomBeforeAfter = [];
        for ($i = 0; $i < 10; $i++) {
            $beforeWord = trim($beforeWordArray[array_rand($beforeWordArray)]) . " ";
            $afterWord = " " . trim($afterWordArray[array_rand($afterWordArray)]);
            $allRandomBeforeAfter[] = $beforeWord . $categoryTitle . $afterWord;
        }
        $randomSimTagBeforeAfter = implode(",", $allRandomBeforeAfter);

        $chatGptTemplateCategory = str_replace(
            [
                "\$title",
                "\$description",
                "\$game_link",
                "\$firstWord",
                "\$secondWord",
                "\$randomSimGames",
                "\$randomSimTags",
                "\$randomSimTagBeforeAfter"
            ],
            [
                $categoryTitle,
                $categoryDescription,
                $randomGameLink,
                $firstWordGame,
                $secondWordGame,
                $randomSimGames,
                $randomSimTags,
                $randomSimTagBeforeAfter
            ],
            $chatgpt_data['template_category']
        );

        $chatGptTemplateCategory = str_replace('"', "'", $chatGptTemplateCategory);
        return $chatGptTemplateCategory;
    }

    return false;
}
function rewriteFooter($footerData)
{
    global $GameMonetizeConnect;

    $chatgpt_query = $GameMonetizeConnect->query("SELECT * FROM " . CHATGPT . " WHERE id = 1 LIMIT 1");

    if ($chatgpt_query && $chatgpt_query->num_rows > 0) {

        $chatgpt_data = $chatgpt_query->fetch_assoc();

        $title = !empty($footerData['page_name']) ? $footerData['page_name'] : '';
        $url = !empty($footerData['page_url']) ? $footerData['page_url'] : '';
        $description = !empty($footerData['description']) ? $footerData['description'] : '';

        // RANDOM GAME
        $random_game_link = '';
        $sqlGame = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE published = 1 ORDER BY RAND() LIMIT 1");

        if ($sqlGame && $sqlGame->num_rows > 0) {
            $game = $sqlGame->fetch_array();
            $link = siteUrl() . "/game/" . $game['game_name'];
            $random_game_link = "<a href='{$link}'><b>{$game['name']}</b></a>";
        }

        // RANDOM CATEGORY
        $random_category_link = '';
        $sqlCat = $GameMonetizeConnect->query("SELECT * FROM " . CATEGORIES . " ORDER BY RAND() LIMIT 1");

        if ($sqlCat && $sqlCat->num_rows > 0) {
            $cat = $sqlCat->fetch_array();
            $link = siteUrl() . "/category/" . $cat['url'];
            $random_category_link = "<a href='{$link}'><b>{$cat['name']}</b></a>";
        }

        // RANDOM TAG
        $random_tag_link = '';
        $sqlTag = $GameMonetizeConnect->query("SELECT * FROM " . TAGS . " ORDER BY RAND() LIMIT 1");

        if ($sqlTag && $sqlTag->num_rows > 0) {
            $tag = $sqlTag->fetch_array();
            $link = siteUrl() . "/tag/" . $tag['url'];
            $random_tag_link = "<a href='{$link}'><b>{$tag['name']}</b></a>";
        }

        // TEMPLATE
        $template = $chatgpt_data['template_footer'];

        $finalPrompt = str_replace(
            [
                '$title',
                '$url',
                '$description',
                '$random_game_link',
                '$random_category_link',
                '$random_tag_link'
            ],
            [
                $title,
                $url,
                $description,
                $random_game_link,
                $random_category_link,
                $random_tag_link
            ],
            $template
        );

        return str_replace('"', "'", $finalPrompt);
    }

    return false;
}
function rewriteBlog($blogData)
{
    global $GameMonetizeConnect;

    $chatgpt_query = $GameMonetizeConnect->query("SELECT * FROM " . CHATGPT . " WHERE id = 1 LIMIT 1");
    if ($chatgpt_query && $chatgpt_query->num_rows > 0) {
        $chatgpt_data = $chatgpt_query->fetch_assoc();

        $title = !empty($blogData['title']) ? $blogData['title'] : '';
        $description = !empty($blogData['post']) ? $blogData['post'] : '';

        $game_link = '';
        $sqlGame = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE published = 1 ORDER BY RAND() LIMIT 1");
        if ($sqlGame && $sqlGame->num_rows > 0) {
            $game = $sqlGame->fetch_array();
            $link = siteUrl() . "/game/" . $game['game_name'];
            $game_link = "<a href='{$link}'><b>{$game['name']}</b></a>";
        }

        $random_tags_link = '';
        $sqlTag = $GameMonetizeConnect->query("SELECT * FROM " . TAGS . " ORDER BY RAND() LIMIT 1");
        if ($sqlTag && $sqlTag->num_rows > 0) {
            $tag = $sqlTag->fetch_array();
            $link = siteUrl() . "/tag/" . $tag['url'];
            $random_tags_link = "<a href='{$link}'><b>{$tag['name']} Games</b></a>";
        }

        $template = $chatgpt_data['template_blog'];

        $finalPrompt = str_replace(
            [
                '$title',
                '$description',
                '$game_link',
                '$random_tags_link'
            ],
            [
                $title,
                $description,
                $game_link,
                $random_tags_link
            ],
            $template
        );

        return str_replace('"', "'", $finalPrompt);
    }

    return false;
}
function containsBlogLink($html)
{
    if (empty($html)) return false;
    return stripos($html, '/blog/') !== false;
}

function buildBlogLinkHtml($blogUrl, $blogTitle = '', $gameTitle = '', $categoryName = '', $tagsText = '')
{
    $gameTitle = trim($gameTitle);
    $categoryName = trim($categoryName);
    $tagsText = trim($tagsText);

    $anchorText = '';

    if ($gameTitle !== '') {
        $anchorText = $gameTitle;
    } elseif ($categoryName !== '') {
        $anchorText = strtolower($categoryName) . ' games';
    } elseif ($tagsText !== '') {
        $tagsArray = array_filter(array_map('trim', explode(',', $tagsText)));
        if (!empty($tagsArray[0])) {
            $anchorText = $tagsArray[0];
        }
    }

    if ($anchorText === '') {
        $anchorText = 'this guide';
    }

    return "<a href='" . $blogUrl . "' target='_self' class='gameKeyword'><b>" . htmlspecialchars($anchorText, ENT_QUOTES, 'UTF-8') . "</b></a>";
}
function buildRelatedHeading($gameTitle, $categoryName = '', $tagsText = '')
{
    $patterns = [];

    if (!empty($gameTitle)) {
        $patterns[] = 'More About ' . $gameTitle;
        $patterns[] = $gameTitle . ' Guide';
        $patterns[] = $gameTitle . ' Tips';
        $patterns[] = 'Improve at ' . $gameTitle;
    }

    if (!empty($categoryName)) {
        $patterns[] = ucfirst($categoryName) . ' Tips for ' . $gameTitle;
        $patterns[] = $gameTitle . ' ' . ucfirst($categoryName) . ' Guide';
    }

    if (!empty($tagsText)) {
        $tagsArray = array_filter(array_map('trim', explode(',', $tagsText)));
        if (!empty($tagsArray)) {
            $tag = $tagsArray[array_rand($tagsArray)];
            $patterns[] = ucfirst($tag) . ' Tips for ' . $gameTitle;
        }
    }

    $patterns = array_values(array_unique($patterns));
    return '<h3>' . htmlspecialchars($patterns[array_rand($patterns)], ENT_QUOTES, 'UTF-8') . '</h3>';
}
function generateBlogTitleOnly($gameTitle, $categoryName, $tagsText)
{
    global $GameMonetizeConnect;

    $chatgpt_query = $GameMonetizeConnect->query("SELECT * FROM " . CHATGPT . " WHERE id = 1 LIMIT 1");
    if (!$chatgpt_query || $chatgpt_query->num_rows < 1) {
        echo "ChatGPT settings not found for blog title.";
        return false;
    }

    $chatgpt_data = $chatgpt_query->fetch_assoc();
    if (empty($chatgpt_data['template_blog_title'])) {
        echo "template_blog_title is empty.";
        return false;
    }

    $prompt = str_replace(
        ['$title', '$category', '$tags'],
        [$gameTitle, $categoryName, $tagsText],
        $chatgpt_data['template_blog_title']
    );

    $prompt = str_replace('"', "'", $prompt);

    $response = hitChatGpt($prompt);
    if ($response === false || strlen(trim($response)) < 1) {
        return false;
    }

    $title = trim(html_entity_decode(strip_tags($response), ENT_QUOTES | ENT_HTML5, 'UTF-8'));

    // remove line breaks
    $title = preg_replace('/\s+/', ' ', $title);

    // hard limit to 70 chars
    if (mb_strlen($title) > 70) {
        $title = mb_substr($title, 0, 70);
        $title = preg_replace('/\s+\S*$/u', '', $title); // cut last broken word
    }

    // fallback if AI returns something bad
    if ($title === '' || mb_strlen($title) < 10) {
        $title = $gameTitle . ' Game Guide';
    }

    return trim($title);

}
function generateTagBlogTitleOnly($tagTitle, $categoryName = '', $tagsText = '')
{
    global $GameMonetizeConnect;

    $chatgpt_query = $GameMonetizeConnect->query("SELECT * FROM " . CHATGPT . " WHERE id = 1 LIMIT 1");
    if (!$chatgpt_query || $chatgpt_query->num_rows < 1) {
        echo "ChatGPT settings not found for tag blog title.";
        return false;
    }

    $chatgpt_data = $chatgpt_query->fetch_assoc();
    if (empty($chatgpt_data['template_blog_title'])) {
        echo "template_blog_title is empty.";
        return false;
    }

    $prompt = str_replace(
        ['$title', '$category', '$tags'],
        [$tagTitle, $categoryName, $tagsText],
        $chatgpt_data['template_blog_title']
    );

    $prompt = str_replace('"', "'", $prompt);

    $response = hitChatGpt($prompt);
    if ($response === false || strlen(trim($response)) < 1) {
        return false;
    }

    $title = trim(html_entity_decode(strip_tags($response), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    $title = preg_replace('/\s+/', ' ', $title);

    if (mb_strlen($title) > 70) {
        $title = mb_substr($title, 0, 70);
        $title = preg_replace('/\s+\S*$/u', '', $title);
    }

    if ($title === '' || mb_strlen($title) < 10) {
        $title = $tagTitle . ' Games Guide';
    }

    return trim($title);
}
function generateRelatedBlogBox($gameTitle, $categoryName, $tagsText, $blogTitle, $blogUrl)
{
    global $GameMonetizeConnect;

    $chatgpt_query = $GameMonetizeConnect->query("SELECT * FROM " . CHATGPT . " WHERE id = 1 LIMIT 1");
    if (!$chatgpt_query || $chatgpt_query->num_rows < 1) {
        echo "ChatGPT settings not found for related blog box.";
        return false;
    }

    $chatgpt_data = $chatgpt_query->fetch_assoc();
    if (empty($chatgpt_data['template_blog_related_box'])) {
        echo "template_blog_related_box is empty.";
        return false;
    }

    $prompt = str_replace(
        ['$title', '$category', '$tags', '$blog_title'],
        [$gameTitle, $categoryName, $tagsText, $blogTitle],
        $chatgpt_data['template_blog_related_box']
    );

    $prompt = str_replace('"', "'", $prompt);

    $response = hitChatGpt($prompt);
    if ($response === false || strlen(trim($response)) < 1) {
        return false;
    }

    $paragraph = trim(strip_tags($response, '<p>'));
    $paragraph = preg_replace('/<a\b[^>]*>.*?<\/a>/is', '', $paragraph);
    $paragraph = trim($paragraph);

    if (!preg_match('/<p\b[^>]*>.*<\/p>/is', $paragraph)) {
        $paragraph = "<p>{$paragraph}</p>";
    }

    $safeGameTitle = htmlspecialchars($gameTitle, ENT_QUOTES, 'UTF-8');
    $heading = buildRelatedHeading($gameTitle, $categoryName, $tagsText);
    $link = buildBlogLinkHtml($blogUrl, $blogTitle, $gameTitle, $categoryName, $tagsText);

    $paragraph = preg_replace('/^<p>/i', '', $paragraph, 1);
    $paragraph = preg_replace('/<\/p>\s*$/i', '', $paragraph, 1);
    $paragraph = trim(strip_tags($paragraph, '<a><b>'));

    $inserted = false;

    // 1) replace first natural mention of game/title
    if (!empty($gameTitle) && preg_match('/\b' . preg_quote($gameTitle, '/') . '\b/i', $paragraph)) {
        $paragraph = preg_replace('/\b' . preg_quote($gameTitle, '/') . '\b/i', $link, $paragraph, 1);
        $inserted = true;
    }

    // 2) fallback: replace first mention of category phrase
    if (!$inserted && !empty($categoryName) && preg_match('/\b' . preg_quote($categoryName, '/') . '\b/i', $paragraph)) {
        $paragraph = preg_replace('/\b' . preg_quote($categoryName, '/') . '\b/i', $link, $paragraph, 1);
        $inserted = true;
    }

    // 3) fallback: replace first tag word
    if (!$inserted && !empty($tagsText)) {
        $tagsArray = array_filter(array_map('trim', explode(',', $tagsText)));
        if (!empty($tagsArray)) {
            $firstTag = $tagsArray[0];
            if (preg_match('/\b' . preg_quote($firstTag, '/') . '\b/i', $paragraph)) {
                $paragraph = preg_replace('/\b' . preg_quote($firstTag, '/') . '\b/i', $link, $paragraph, 1);
                $inserted = true;
            }
        }
    }

    // 4) last fallback: insert after first sentence, but no fixed CTA text
    if (!$inserted) {
        $sentences = preg_split('/(?<=[.!?])\s+/u', $paragraph, -1, PREG_SPLIT_NO_EMPTY);
        if (!empty($sentences)) {
            array_splice($sentences, 1, 0, [$link]);
            $paragraph = implode(' ', $sentences);
        } else {
            $paragraph .= ' ' . $link;
        }
    }

    $paragraph = '<p>' . trim($paragraph) . '</p>';

    return $heading . "\n" . $paragraph;
}

function appendRelatedBlogBoxToGameDescription($gameId, $boxHtml)
{
    global $GameMonetizeConnect;

    $gameId = (int)$gameId;
    if ($gameId < 1 || trim($boxHtml) === '') {
        return false;
    }

    $gameQuery = $GameMonetizeConnect->query("SELECT description FROM " . GAMES . " WHERE game_id = {$gameId} LIMIT 1");
    if (!$gameQuery || $gameQuery->num_rows < 1) {
        return false;
    }

    $gameRow = $gameQuery->fetch_assoc();
    $currentDescription = !empty($gameRow['description']) ? $gameRow['description'] : '';

    if (containsBlogLink($currentDescription)) {
        return true;
    }

    $newDescription = trim($currentDescription) . "\n\n" . trim($boxHtml);

    $stmt = $GameMonetizeConnect->prepare("UPDATE " . GAMES . " SET description = ? WHERE game_id = ?");
    if (!$stmt) {
        echo "Prepare failed while updating game description: " . $GameMonetizeConnect->error;
        return false;
    }

    $stmt->bind_param("si", $newDescription, $gameId);
    $ok = $stmt->execute();
    $stmt->close();

    return $ok;
}
function appendRelatedBlogBoxToTagDescription($tagId, $boxHtml)
{
    global $GameMonetizeConnect;

    $tagId = (int)$tagId;
    if ($tagId < 1 || trim($boxHtml) === '') {
        return false;
    }

    $tagQuery = $GameMonetizeConnect->query("SELECT footer_description FROM " . TAGS . " WHERE id = {$tagId} LIMIT 1");
    if (!$tagQuery || $tagQuery->num_rows < 1) {
        return false;
    }

    $tagRow = $tagQuery->fetch_assoc();
    $currentDescription = !empty($tagRow['footer_description']) ? $tagRow['footer_description'] : '';

    if (containsBlogLink($currentDescription)) {
        return true;
    }

    $newDescription = trim($currentDescription);
    if ($newDescription !== '') {
        $newDescription .= "\n\n";
    }

    $newDescription .= trim($boxHtml);

    $safeDescription = mysqli_real_escape_string($GameMonetizeConnect, $newDescription);

    return $GameMonetizeConnect->query("
        UPDATE " . TAGS . "
        SET footer_description = '{$safeDescription}'
        WHERE id = {$tagId}
    ");
}
function saveImageToLocal($imageUrl, $uploadDir = 'blog-img/')
{
    if (empty($imageUrl)) return '';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $path = parse_url($imageUrl, PHP_URL_PATH);
    $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    if (empty($ext) || !in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
        $ext = 'jpg';
    }

    $fileName = 'blog_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
    $filePath = $uploadDir . $fileName;

    $ch = curl_init($imageUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $data = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($data === false || $httpCode != 200) {
        return '';
    }

    if (file_put_contents($filePath, $data) === false) {
        return '';
    }

    return '/blog-img/' . $fileName;
}
function autopostTagFromKeywordList($filePath)
{
    $keywords = loadKeywordListFile($filePath);

    if (empty($keywords)) {
        return "Keyword list is empty.";
    }

    $originalCount = count($keywords);
    $checked = 0;

    while (!empty($keywords)) {
        $keyword = trim($keywords[0]);
        $checked++;

        // remove empty line immediately
        if ($keyword === '') {
            array_shift($keywords);
            saveKeywordListFile($filePath, $keywords);
            continue;
        }

        // if tag already exists, remove it from list and try next
        if (tagExistsByKeyword($keyword)) {
            array_shift($keywords);
            saveKeywordListFile($filePath, $keywords);
            continue;
        }

        // create new tag
        $inserted = insertTagFromKeyword($keyword);

        if ($inserted) {
            array_shift($keywords);
            saveKeywordListFile($filePath, $keywords);
            return "Inserted new tag: " . htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') .
                   "<br>Checked: {$checked}" .
                   "<br>Remaining in list: " . count($keywords);
        }

        return "Failed inserting tag: " . htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8');
    }

    return "No new tag inserted. All {$originalCount} keywords were already in database or invalid, and were removed from the list.";
}
function getOrCreateCategory($categoryName)
{
    global $GameMonetizeConnect;

    $categoryName = trim($categoryName);
    if ($categoryName === '') {
        return 0;
    }

    $safeName = mysqli_real_escape_string($GameMonetizeConnect, $categoryName);
    $safeSlug = mysqli_real_escape_string($GameMonetizeConnect, seo_friendly_url($categoryName));

    // Try exact name
    $query = $GameMonetizeConnect->query("
        SELECT id 
        FROM " . CATEGORIES . " 
        WHERE name = '{$safeName}' 
        LIMIT 1
    ");
    if ($query && $query->num_rows > 0) {
        $row = $query->fetch_assoc();
        return (int)$row['id'];
    }

    // Try slug/url field
    $query = $GameMonetizeConnect->query("
        SELECT id 
        FROM " . CATEGORIES . " 
        WHERE category_pilot = '{$safeSlug}' 
        LIMIT 1
    ");
    if ($query && $query->num_rows > 0) {
        $row = $query->fetch_assoc();
        return (int)$row['id'];
    }

    // Create category
    $insert = $GameMonetizeConnect->query("
        INSERT INTO " . CATEGORIES . " 
        (name, category_pilot, footerdescription, isrewrited, islastrewrite)
        VALUES
        ('{$safeName}', '{$safeSlug}', '', 0, 0)
    ");

    if ($insert) {
        return (int)$GameMonetizeConnect->insert_id;
    }

    return 0;
}
function isUsableBlogImageGame($game)
{
    if (!$game || !is_array($game)) {
        return false;
    }

    if (empty($game['image'])) {
        return false;
    }

    if (empty($game['file'])) {
        return false;
    }

    if (stripos($game['file'], 'gamemonetize.') === false) {
        return false;
    }

    return true;
}

function fetchBestGameDataFromQuery($queryResult)
{
    $result = [
        'usableGame' => false,
        'backupImage' => ''
    ];

    if (!$queryResult || $queryResult->num_rows < 1) {
        return $result;
    }

    while ($candidateGame = $queryResult->fetch_assoc()) {
        if (empty($result['backupImage']) && !empty($candidateGame['image'])) {
            $result['backupImage'] = trim($candidateGame['image']);
        }

        if (isUsableBlogImageGame($candidateGame)) {
            $result['usableGame'] = $candidateGame;
            return $result;
        }
    }

    return $result;
}

function generateUniqueTagCta($tagTitle, $categoryName, $tagsText, $tag_link)
{
    $tagTitle = trim((string)$tagTitle);
    $categoryName = trim((string)$categoryName);

    if ($categoryName !== '') {
        return '<p>Explore more ' . htmlspecialchars($categoryName) . ' fun with ' . $tag_link . ' and enjoy quick browser games related to ' . htmlspecialchars($tagTitle) . '.</p>';
    }

    return '<p>Explore more games with ' . $tag_link . ' and enjoy quick browser fun related to ' . htmlspecialchars($tagTitle) . '.</p>';
}

function injectParagraphAfterFirstParagraph($html, $paragraph)
{
    if (preg_match('/<\/p>/i', $html)) {
        return preg_replace('/<\/p>/i', '</p>' . $paragraph, $html, 1);
    }

    return $paragraph . $html;
}

function stripAllAnchorsButKeepText($html)
{
    return preg_replace('#<a\b[^>]*>(.*?)</a>#is', '$1', $html);
}