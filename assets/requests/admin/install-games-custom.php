<?php

if (!defined('R_PILOT')) exit();

set_time_limit(0);
ignore_user_abort(true);

$settingSql = "SELECT * FROM `" . SETTING . "` WHERE `id` = '1'";
$settings = $GameMonetizeConnect->query($settingSql);
$settings = $settings->fetch_assoc();

$custom_value = isset($_POST['customValue']) ? (int) $_POST['customValue'] : 1;
if ($custom_value < 1) {
      $custom_value = 1;
}

$feedUrl = trim($settings['custom_game_feed_url']);

$context = stream_context_create(array(
      'http' => array(
            'timeout' => 25,
            'ignore_errors' => true,
            'header' => "User-Agent: Mozilla/5.0\r\n"
      )
));

$catalog = file_get_contents($feedUrl, false, $context);

if (!!$catalog) {
      $games = json_decode($catalog, true);

      if (!is_array($games)) {
            $data['error_message'] = 'Feed JSON is invalid.';
            return;
      }

      $checkedGamesCounter = 0;
      $installedGamesCounter = 0;
      $skippedGamesCounter = 0;
      $installedGamesMaximum = $custom_value;

      foreach ($games as $game) {
            if ($installedGamesCounter >= $installedGamesMaximum) {
                  break;
            }

            if (empty($game['title']) || empty($game['url'])) {
                  $skippedGamesCounter++;
                  continue;
            }

            $checkedGamesCounter++;

            $title = seo_friendly_url($game['title']);
            $catalogId = !empty($game['id']) ? secureEncode($game['id']) : '';

            $existsSql = "SELECT game_id FROM `" . GAMES . "` 
                  WHERE `game_name` = '{$title}' 
                  OR `catalog_id` = 'gamemonetize-{$catalogId}' 
                  LIMIT 1";
            $existsQuery = $GameMonetizeConnect->query($existsSql);

            if ($existsQuery && $existsQuery->num_rows > 0) {
                  $skippedGamesCounter++;
                  continue;
            }

            $game_data = array();
            $game_data['catalog_id'] = $catalogId;
            $game_data['game_name'] = secureEncode($title);
            $game_data['name'] = secureEncode($game['title']);
            $game_data['description'] = !empty($game['description']) ? secureEncode($game['description']) : '';
            $game_data['instructions'] = !empty($game['instructions']) ? secureEncode($game['instructions']) : '';
            $game_data['file'] = secureEncode($game['url']);
            $game_data['width'] = !empty($game['width']) ? (int) $game['width'] : 800;
            $game_data['height'] = !empty($game['height']) ? (int) $game['height'] : 600;
            $game_data['image'] = !empty($game['thumb']) ? secureEncode($game['thumb']) : '';

            $category = 0;
            if (!empty($game['category'])) {
                  $category_data = getCategoriesLikeName($game['category']);
                  if ($category_data !== null && !empty($category_data['id'])) {
                        $category = (int) $category_data['id'];
                  }
            }

            $tags = '[]';
            $allTagsId = array();

            if (!empty($game['tags'])) {
                  $allTags = explode(",", $game['tags']);

                  foreach ($allTags as $tag) {
                        $tag = trim($tag);
                        if ($tag === '') {
                              continue;
                        }

                        $tag_data = getTagsLikeName($tag);

                        if ($tag_data !== null && !empty($tag_data['id'])) {
                              $tagId = (int) $tag_data['id'];
                              $allTagsId[] = '"' . $tagId . '"';
                        }
                  }

                  if (count($allTagsId) > 0) {
                        $tags = "[" . implode(",", array_unique($allTagsId)) . "]";
                  }
            }

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
                  published
            ) VALUES (
                  'gamemonetize-{$game_data['catalog_id']}',
                  '{$game_data['game_name']}',
                  '{$game_data['name']}',
                  '{$game_data['image']}',
                  '{$game_data['description']}',
                  '{$game_data['instructions']}',
                  '{$category}',
                  '{$game_data['file']}',
                  'html5',
                  '{$game_data['width']}',
                  '{$game_data['height']}',
                  '{$time}',
                  '{$tags}',
                  '1'
            )");

            if ($isSuccess) {
                  $installedGamesCounter++;

                  if ($category > 0) {
                        $GameMonetizeConnect->query("UPDATE `" . CATEGORIES . "` SET `total_games` = `total_games` + 1 WHERE `id` = '{$category}'");
                  }

                  foreach (array_unique($allTagsId) as $tagId) {
                        $tagId = (int) str_replace('"', '', $tagId);
                        if ($tagId > 0) {
                              $GameMonetizeConnect->query("UPDATE `" . TAGS . "` SET `total_games` = `total_games` + 1 WHERE `id` = {$tagId}");
                        }
                  }
            } else {
                  $skippedGamesCounter++;
            }
      }

      $data['status'] = 200;
      $data['message'] = 'Fast bulk install finished. Installed: ' . $installedGamesCounter . ' | Checked: ' . $checkedGamesCounter . ' | Skipped: ' . $skippedGamesCounter;
} else {
      $data['error_message'] = 'Something went wrong. Feed not loaded.';
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