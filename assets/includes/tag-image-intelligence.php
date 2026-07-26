<?php
if (!defined('ABSPATH')) {
    exit();
}

if (!function_exists('gmTagImageStatePath')) {
    function gmTagImageStatePath()
    {
        $dir = ABSPATH . 'json/';
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        return $dir . 'tag-image-generator-state.json';
    }
}

if (!function_exists('gmTagImageLoadState')) {
    function gmTagImageLoadState()
    {
        $path = gmTagImageStatePath();

        if (!file_exists($path)) {
            return array(
                'used_games' => array(),
                'done_tags'   => array()
            );
        }

        $json = @file_get_contents($path);
        $data = @json_decode($json, true);

        if (!is_array($data)) {
            $data = array();
        }

        if (empty($data['used_games']) || !is_array($data['used_games'])) {
            $data['used_games'] = array();
        }

        if (empty($data['done_tags']) || !is_array($data['done_tags'])) {
            $data['done_tags'] = array();
        }

        return $data;
    }
}

if (!function_exists('gmTagImageSaveState')) {
    function gmTagImageSaveState($state)
    {
        $path = gmTagImageStatePath();
        @file_put_contents($path, json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

if (!function_exists('gmTagImageResetState')) {
    function gmTagImageResetState()
    {
        $path = gmTagImageStatePath();
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}

if (!function_exists('gmTagImageMarkGameUsed')) {
    function gmTagImageMarkGameUsed($state, $gameId)
    {
        $gameId = (int) $gameId;
        if ($gameId <= 0) {
            return $state;
        }

        if (empty($state['used_games'][$gameId])) {
            $state['used_games'][$gameId] = 0;
        }

        $state['used_games'][$gameId]++;

        return $state;
    }
}

if (!function_exists('gmTagImageMarkTagDone')) {
    function gmTagImageMarkTagDone($state, $tagId)
    {
        $tagId = (int) $tagId;
        if ($tagId > 0) {
            $state['done_tags'][$tagId] = 1;
        }
        return $state;
    }
}

if (!function_exists('gmTagImageIsTagDone')) {
    function gmTagImageIsTagDone($state, $tagId)
    {
        $tagId = (int) $tagId;
        return !empty($state['done_tags'][$tagId]);
    }
}

if (!function_exists('gmTagImageNormalizeText')) {
    function gmTagImageNormalizeText($text)
    {
        $text = trim((string) $text);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = mb_strtolower($text, 'UTF-8');

        $converted = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
        if ($converted !== false && $converted !== '') {
            $text = $converted;
        }

        $text = preg_replace('/[^a-z0-9]+/i', ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        return $text;
    }
}

if (!function_exists('gmTagImageStopWords')) {
    function gmTagImageStopWords()
    {
        return array(
            'game', 'games', 'free', 'online', 'best', 'new',
            'for', 'the', 'and', 'with', 'your', 'website',
            'a', 'an', 'of', 'to', 'in', 'on'
        );
    }
}

if (!function_exists('gmTagImageTokenize')) {
    function gmTagImageTokenize($text)
    {
        $text = gmTagImageNormalizeText($text);
        if ($text === '') {
            return array();
        }

        $parts = explode(' ', $text);
        $stopWords = gmTagImageStopWords();
        $tokens = array();

        foreach ($parts as $part) {
            $part = trim($part);
            if ($part === '' || strlen($part) < 2) {
                continue;
            }

            if (in_array($part, $stopWords, true)) {
                continue;
            }

            $tokens[] = $part;
        }

        return array_values(array_unique($tokens));
    }
}

if (!function_exists('gmTagImageSynonymsMap')) {
    function gmTagImageSynonymsMap()
    {
        return array(
            '1 player'             => array('single player', 'solo', '1player'),
            '2 player'             => array('2player', 'multiplayer', 'duo', 'versus'),
            '3d'                   => array('3d game', '3d games'),
            '2d'                   => array('2d game', '2d games'),
            'air'                  => array('airplane', 'aircraft', 'plane', 'flight', 'jet'),
            'aircraft'             => array('airplane', 'plane', 'flight', 'jet'),
            'car'                  => array('cars', 'driving', 'racing'),
            'cars'                 => array('car', 'driving', 'racing'),
            'dress up'             => array('fashion', 'makeup', 'girl'),
            'girls'                => array('girl', 'dress up', 'makeup', 'fashion'),
            'gun'                  => array('shooting', 'sniper', 'fps', 'weapon'),
            'shooting'             => array('gun', 'sniper', 'fps', 'war'),
            'zombie'               => array('survival', 'monster', 'horror'),
            'horror'               => array('scary', 'zombie', 'monster'),
            'stickman'             => array('stick', 'ragdoll'),
            'truck'                => array('trucks', 'driving'),
            'drifting'             => array('drift', 'car', 'racing'),
            'io'                   => array('io game', '.io'),
            'puzzle'               => array('match', 'brain', 'logic', '2048'),
            'mahjong'              => array('tile', 'puzzle'),
            'minecraft'            => array('craft', 'block'),
            'superhero'            => array('hero', 'marvel'),
            'android'              => array('mobile', 'phone'),
            'arcade'               => array('action', 'fun'),
            'animal'               => array('pet', 'zoo'),
            'ballon'               => array('balloon'),
            'restaurant'           => array('cooking', 'chef', 'food'),
            'first person shooter' => array('fps', 'shooting', 'gun'),
            'fps'                  => array('first person shooter', 'shooting', 'gun'),
        );
    }
}

if (!function_exists('gmTagImageBuildPhrases')) {
    function gmTagImageBuildPhrases($tagName)
    {
        $tagName = trim((string) $tagName);
        $normalized = gmTagImageNormalizeText($tagName);
        if ($normalized === '') {
            return array();
        }

        $phrases = array($normalized);

        if (preg_match('/^(.*?) games$/', $normalized, $m) && !empty($m[1])) {
            $phrases[] = trim($m[1]);
        }

        $map = gmTagImageSynonymsMap();

        if (!empty($map[$normalized])) {
            foreach ($map[$normalized] as $alt) {
                $alt = gmTagImageNormalizeText($alt);
                if ($alt !== '') {
                    $phrases[] = $alt;
                }
            }
        }

        $tokens = gmTagImageTokenize($normalized);
        foreach ($tokens as $token) {
            if (!empty($map[$token])) {
                foreach ($map[$token] as $alt) {
                    $alt = gmTagImageNormalizeText($alt);
                    if ($alt !== '') {
                        $phrases[] = $alt;
                    }
                }
            }
        }

        return array_values(array_unique($phrases));
    }
}

if (!function_exists('gmTagImageDetectGameColumns')) {
    function gmTagImageDetectGameColumns($db)
    {
        static $cache = null;

        if ($cache !== null) {
            return $cache;
        }

        $cols = array();

        $q = $db->query("SHOW COLUMNS FROM " . GAMES);
        if ($q) {
            while ($row = $q->fetch_assoc()) {
                $cols[] = $row['Field'];
            }
        }

        $pick = function ($choices) use ($cols) {
            foreach ($choices as $choice) {
                if (in_array($choice, $cols, true)) {
                    return $choice;
                }
            }
            return '';
        };

        $cache = array(
            'id'    => $pick(array('game_id', 'id')),
            'title' => $pick(array('name', 'game_name')),
            'image' => $pick(array('image')),
            'plays' => $pick(array('plays')),
        );

        return $cache;
    }
}

if (!function_exists('gmTagImageFetchCandidates')) {
    function gmTagImageFetchCandidates($db, $tagName, $limit = 120)
    {
        $cols = gmTagImageDetectGameColumns($db);

        if (empty($cols['id']) || empty($cols['title']) || empty($cols['image'])) {
            return array();
        }

        $phrases = gmTagImageBuildPhrases($tagName);
        $tokens  = gmTagImageTokenize($tagName);

        $where = array();

        foreach ($phrases as $phrase) {
            $phrase = $db->real_escape_string($phrase);
            $where[] = "LOWER(`{$cols['title']}`) LIKE '%{$phrase}%'";
        }

        foreach ($tokens as $token) {
            $token = $db->real_escape_string($token);
            $where[] = "LOWER(`{$cols['title']}`) LIKE '%{$token}%'";
        }

        $sql  = "SELECT ";
        $sql .= "`{$cols['id']}` AS game_id, ";
        $sql .= "`{$cols['title']}` AS game_title, ";
        $sql .= "`{$cols['image']}` AS game_image, ";
        $sql .= (!empty($cols['plays']) ? "`{$cols['plays']}`" : "0") . " AS plays ";
        $sql .= "FROM " . GAMES . " ";
        $sql .= "WHERE `{$cols['image']}` IS NOT NULL AND `{$cols['image']}` <> '' ";

        if (!empty($where)) {
            $sql .= "AND (" . implode(' OR ', array_unique($where)) . ") ";
        }

        $sql .= "ORDER BY plays DESC, game_id DESC ";
        $sql .= "LIMIT " . (int) $limit;

        $rows = array();
        $q = $db->query($sql);
        if ($q) {
            while ($row = $q->fetch_assoc()) {
                $rows[] = $row;
            }
        }

        return $rows;
    }
}

if (!function_exists('gmTagImageScoreCandidate')) {
    function gmTagImageScoreCandidate($tagName, $row, $state = array())
    {
        $tagNorm   = gmTagImageNormalizeText($tagName);
        $titleNorm = gmTagImageNormalizeText(isset($row['game_title']) ? $row['game_title'] : '');

        if ($tagNorm === '' || $titleNorm === '') {
            return -999999;
        }

        $score   = 0;
        $tokens  = gmTagImageTokenize($tagName);
        $phrases = gmTagImageBuildPhrases($tagName);

        if ($titleNorm === $tagNorm) {
            $score += 3000;
        }

        if (preg_match('/\b' . preg_quote($tagNorm, '/') . '\b/', $titleNorm)) {
            $score += 1800;
        } elseif (strpos($titleNorm, $tagNorm) !== false) {
            $score += 900;
        }

        $allTokensFound = true;

        foreach ($tokens as $token) {
            if (preg_match('/\b' . preg_quote($token, '/') . '\b/', $titleNorm)) {
                $score += 180;
            } elseif (strpos($titleNorm, $token) !== false) {
                $score += 80;
            } else {
                $allTokensFound = false;
            }
        }

        if ($allTokensFound && count($tokens) > 1) {
            $score += 500;
        }

        foreach ($phrases as $phrase) {
            if ($phrase === $tagNorm) {
                continue;
            }

            if (preg_match('/\b' . preg_quote($phrase, '/') . '\b/', $titleNorm)) {
                $score += 240;
            } elseif (strpos($titleNorm, $phrase) !== false) {
                $score += 100;
            }
        }

        $gameId = isset($row['game_id']) ? (int) $row['game_id'] : 0;
        $usedCount = !empty($state['used_games'][$gameId]) ? (int) $state['used_games'][$gameId] : 0;

        // Hard penalty if same game was already used too much
        if ($usedCount >= 3) {
            $score -= 1500;
        } elseif ($usedCount === 2) {
            $score -= 700;
        } elseif ($usedCount === 1) {
            $score -= 250;
        }

        return $score;
    }
}

if (!function_exists('gmTagImagePickBestGame')) {
    function gmTagImagePickBestGame($db, $tagName, $state = array())
    {
        $candidates = gmTagImageFetchCandidates($db, $tagName, 120);

        $best      = null;
        $bestScore = -999999;

        foreach ($candidates as $row) {
            $score = gmTagImageScoreCandidate($tagName, $row, $state);

            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $row;
                $best['match_score'] = $score;
            }
        }

        // If no good match, fallback to least-used random-ish image
        if ($best === null || $bestScore < 250) {
            $cols = gmTagImageDetectGameColumns($db);

            if (!empty($cols['id']) && !empty($cols['title']) && !empty($cols['image'])) {
                $sql  = "SELECT ";
                $sql .= "`{$cols['id']}` AS game_id, ";
                $sql .= "`{$cols['title']}` AS game_title, ";
                $sql .= "`{$cols['image']}` AS game_image, ";
                $sql .= (!empty($cols['plays']) ? "`{$cols['plays']}`" : "0") . " AS plays ";
                $sql .= "FROM " . GAMES . " ";
                $sql .= "WHERE `{$cols['image']}` IS NOT NULL AND `{$cols['image']}` <> '' ";
                $sql .= "ORDER BY plays DESC, game_id DESC LIMIT 200";

                $q = $db->query($sql);
                $fallbackRows = array();

                if ($q) {
                    while ($row = $q->fetch_assoc()) {
                        $fallbackRows[] = $row;
                    }
                }

                $bestFallback = null;
                $bestFallbackScore = -999999;

                foreach ($fallbackRows as $row) {
                    $gameId = (int) $row['game_id'];
                    $usedCount = !empty($state['used_games'][$gameId]) ? (int) $state['used_games'][$gameId] : 0;

                    $score = 100 - ($usedCount * 40) + ((int)$row['plays'] > 0 ? 5 : 0);

                    if ($score > $bestFallbackScore) {
                        $bestFallbackScore = $score;
                        $bestFallback = $row;
                        $bestFallback['match_score'] = $score;
                    }
                }

                if ($bestFallback !== null) {
                    return $bestFallback;
                }
            }
        }

        return $best;
    }
}