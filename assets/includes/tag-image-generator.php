<?php


if (!defined('ABSPATH')) {
	exit();
}
require_once ABSPATH . 'assets/includes/tag-image-intelligence.php';
/*
 * Tag Image Generator
 * Creates /tag-img/{tag-slug}.webp from existing game images.
 * Output image: 320x320 webp.
 */


if (!function_exists('gmTagImageSlug')) {
	function gmTagImageSlug($name, $fallback = '')
	{
		$name = trim(strip_tags((string)$name));

		if ($name === '' && $fallback !== '') {
			$name = $fallback;
		}

		if (function_exists('slugify')) {
			$slug = slugify($name);
		} else {
			$slug = strtolower($name);
			$slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
			$slug = trim($slug, '-');
		}

		return $slug !== '' ? $slug : 'tag-image';
	}
}

if (!function_exists('gmTagImageKeywords')) {
	function gmTagImageKeywords($tagName, $tagSlug = '')
	{
		$text = strtolower(trim($tagName . ' ' . str_replace('-', ' ', $tagSlug)));
		$text = preg_replace('/[^a-z0-9 ]+/i', ' ', $text);
		$parts = preg_split('/\s+/', $text);

		$stop = array(
			'game', 'games', 'free', 'online', 'play', 'unblocked',
			'new', 'best', 'top', 'fun', 'html5', 'io'
		);

		$out = array();

		foreach ($parts as $p) {
			$p = trim($p);

			if ($p === '' || strlen($p) < 2) {
				continue;
			}

			if (in_array($p, $stop, true)) {
				continue;
			}

			$out[] = $p;
		}

		$out = array_values(array_unique($out));

		if (empty($out)) {
			$cleanName = strtolower(trim(preg_replace('/[^a-z0-9 ]+/i', ' ', $tagName)));
			if ($cleanName !== '') {
				$out[] = $cleanName;
			}
		}

		return $out;
	}
}

if (!function_exists('gmTagImagePathFromGameImage')) {
	function gmTagImagePathFromGameImage($image)
	{
		$image = trim((string)$image);

		if ($image === '') {
			return '';
		}

		if (preg_match('~^https?://~i', $image)) {
			return $image;
		}

		$image = ltrim($image, '/');

		$try = array(
			ABSPATH . $image,
			ABSPATH . 'games-image/' . $image,
			ABSPATH . 'images/' . $image,
		);

		foreach ($try as $path) {
			if (is_file($path)) {
				return $path;
			}
		}

		return ABSPATH . $image;
	}
}

if (!function_exists('gmTagImageReadBinary')) {
	function gmTagImageReadBinary($pathOrUrl)
	{
		if ($pathOrUrl === '') {
			return false;
		}

		if (preg_match('~^https?://~i', $pathOrUrl)) {
			if (function_exists('curl_init')) {
				$ch = curl_init($pathOrUrl);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
				curl_setopt($ch, CURLOPT_TIMEOUT, 18);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 TagImageGenerator');
				$data = curl_exec($ch);
				$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);

				if ($data !== false && $code >= 200 && $code < 400) {
					return $data;
				}
			}

			return @file_get_contents($pathOrUrl);
		}

		if (is_file($pathOrUrl)) {
			return @file_get_contents($pathOrUrl);
		}

		return false;
	}
}

if (!function_exists('gmTagImageCreateFromPath')) {
	function gmTagImageCreateFromPath($pathOrUrl)
	{
		$data = gmTagImageReadBinary($pathOrUrl);

		if (!$data) {
			return false;
		}

		return @imagecreatefromstring($data);
	}
}

if (!function_exists('gmTagImageCopyCover')) {
	function gmTagImageCopyCover($dst, $src, $dstX, $dstY, $dstW, $dstH)
	{
		$srcW = imagesx($src);
		$srcH = imagesy($src);

		if ($srcW <= 0 || $srcH <= 0) {
			return false;
		}

		$srcRatio = $srcW / $srcH;
		$dstRatio = $dstW / $dstH;

		if ($srcRatio > $dstRatio) {
			$cropH = $srcH;
			$cropW = (int)round($srcH * $dstRatio);
			$srcX = (int)round(($srcW - $cropW) / 2);
			$srcY = 0;
		} else {
			$cropW = $srcW;
			$cropH = (int)round($srcW / $dstRatio);
			$srcX = 0;
			$srcY = (int)round(($srcH - $cropH) / 2);
		}

		return imagecopyresampled(
			$dst,
			$src,
			$dstX,
			$dstY,
			$srcX,
			$srcY,
			$dstW,
			$dstH,
			$cropW,
			$cropH
		);
	}
}

if (!function_exists('gmTagImageSave180')) {
	function gmTagImageSave180($sourcePathOrUrl, $destPath, $quality = 82)
	{
		if (!extension_loaded('gd')) {
			return false;
		}

		$src = gmTagImageCreateFromPath($sourcePathOrUrl);

		if (!$src) {
			return false;
		}

				/*
		* Keep old function name for compatibility,
		* but now output optimized landscape tag images.
		* Output: 256x144 WebP, better for tag cards and faster loading.
		*/
		$w = 256;
		$h = 144;

		$canvas = imagecreatetruecolor($w, $h);

		imagealphablending($canvas, false);
		imagesavealpha($canvas, true);

		$transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
		imagefilledrectangle($canvas, 0, 0, $w, $h, $transparent);

		gmTagImageCopyCover($canvas, $src, 0, 0, $w, $h);

		$dir = dirname($destPath);
		if (!is_dir($dir)) {
			@mkdir($dir, 0755, true);
		}

		$ok = imagewebp($canvas, $destPath, $quality);

		imagedestroy($src);
		imagedestroy($canvas);

		return $ok;
	}
}

if (!function_exists('gmTagImageFindBestGame')) {
	function gmTagImageFindBestGame($tagName, $tagSlug = '')
	{
		global $GameMonetizeConnect;

		$state = gmTagImageLoadState();

		$bestGame = gmTagImagePickBestGame($GameMonetizeConnect, $tagName, $state);

		if (!$bestGame || empty($bestGame['game_image'])) {
			return false;
		}

		return array(
			'game_id'   => $bestGame['game_id'],
			'name'      => $bestGame['game_title'],
			'game_name' => $bestGame['game_title'],
			'image'     => $bestGame['game_image'],
			'plays'     => isset($bestGame['plays']) ? $bestGame['plays'] : 0,
			'match_score' => isset($bestGame['match_score']) ? $bestGame['match_score'] : 0,
		);
	}
}

if (!function_exists('gmTagImageProgressPath')) {
	function gmTagImageProgressPath()
	{
		$dir = ABSPATH . 'json/';

		if (!is_dir($dir)) {
			@mkdir($dir, 0755, true);
		}

		return $dir . 'tag-image-generator-progress.json';
	}
}

if (!function_exists('gmTagImageLoadProgress')) {
	function gmTagImageLoadProgress()
	{
		$file = gmTagImageProgressPath();

		if (!is_file($file)) {
			return array(
				'active' => false,
				'mode' => 'missing',
				'last_id' => 0,
				'generated' => 0,
				'failed' => 0,
				'started_at' => 0,
				'updated_at' => 0
			);
		}

		$data = json_decode((string)@file_get_contents($file), true);

		if (!is_array($data)) {
			$data = array();
		}

		return array(
			'active' => !empty($data['active']),
			'mode' => !empty($data['mode']) ? $data['mode'] : 'missing',
			'last_id' => !empty($data['last_id']) ? (int)$data['last_id'] : 0,
			'generated' => !empty($data['generated']) ? (int)$data['generated'] : 0,
			'failed' => !empty($data['failed']) ? (int)$data['failed'] : 0,
			'started_at' => !empty($data['started_at']) ? (int)$data['started_at'] : 0,
			'updated_at' => !empty($data['updated_at']) ? (int)$data['updated_at'] : 0
		);
	}
}

if (!function_exists('gmTagImageSaveProgress')) {
	function gmTagImageSaveProgress($data)
	{
		$file = gmTagImageProgressPath();
		@file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
	}
}

if (!function_exists('gmTagImageResetProgress')) {
	function gmTagImageResetProgress()
	{
		$now = time();

		$data = array(
			'active' => true,
			'mode' => 'remake',
			'last_id' => 0,
			'generated' => 0,
			'failed' => 0,
			'started_at' => $now,
			'updated_at' => $now
		);

		gmTagImageSaveProgress($data);

		return $data;
	}
}

if (!function_exists('gmTagImageGetStatus')) {
	function gmTagImageGetStatus()
	{
		global $GameMonetizeConnect;

		$tagImgDir = ABSPATH . 'tag-img/';
		$progress = gmTagImageLoadProgress();

		$total = 0;
		$existing = 0;
		$missing = 0;
		$lastId = !empty($progress['last_id']) ? (int)$progress['last_id'] : 0;
		$remakeRemaining = 0;

		$q = $GameMonetizeConnect->query("SELECT id, name, url FROM " . TAGS . " ORDER BY id ASC");

		if ($q) {
			while ($tag = $q->fetch_assoc()) {
				$total++;

				$tagName = trim((string)$tag['name']);
				$tagSlug = !empty($tag['url']) ? trim((string)$tag['url']) : gmTagImageSlug($tagName);
				$tagSlug = gmTagImageSlug($tagSlug, $tagName);

				if (is_file($tagImgDir . $tagSlug . '.webp')) {
					$existing++;
				} else {
					$missing++;
				}

				if (!empty($progress['active']) && $progress['mode'] === 'remake' && (int)$tag['id'] > $lastId) {
					$remakeRemaining++;
				}
			}
		}

		return array(
			'total' => $total,
			'existing' => $existing,
			'missing' => $missing,
			'remake_active' => !empty($progress['active']) && $progress['mode'] === 'remake',
			'remake_last_id' => $lastId,
			'remake_remaining' => $remakeRemaining,
			'remake_generated' => !empty($progress['generated']) ? (int)$progress['generated'] : 0,
			'remake_failed' => !empty($progress['failed']) ? (int)$progress['failed'] : 0,
			'remake_started_at' => !empty($progress['started_at']) ? (int)$progress['started_at'] : 0,
			'remake_updated_at' => !empty($progress['updated_at']) ? (int)$progress['updated_at'] : 0
		);
	}
}

if (!function_exists('gmTagImageColorsPath')) {
	function gmTagImageColorsPath()
	{
		$dir = ABSPATH . 'json/';

		if (!is_dir($dir)) {
			@mkdir($dir, 0755, true);
		}

		return $dir . 'tag-image-colors.json';
	}
}

if (!function_exists('gmTagImageLoadColors')) {
	function gmTagImageLoadColors()
	{
		$file = gmTagImageColorsPath();

		if (!is_file($file)) {
			return array();
		}

		$data = json_decode((string)@file_get_contents($file), true);

		return is_array($data) ? $data : array();
	}
}

if (!function_exists('gmTagImageSaveColors')) {
	function gmTagImageSaveColors($colors)
	{
		$file = gmTagImageColorsPath();
		@file_put_contents($file, json_encode($colors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
	}
}

if (!function_exists('gmTagImageGetAverageColor')) {
	function gmTagImageGetAverageColor($imagePath)
	{
		if (!is_file($imagePath)) {
			return array(42, 16, 100);
		}

		$src = @imagecreatefromwebp($imagePath);

		if (!$src) {
			return array(42, 16, 100);
		}

		$w = imagesx($src);
		$h = imagesy($src);

		if ($w <= 0 || $h <= 0) {
			imagedestroy($src);
			return array(42, 16, 100);
		}

		/*
		 * Read mostly right/middle photo area, not the whole image.
		 * This avoids taking too much dark border or empty area.
		 */
		$startX = (int)($w * 0.35);
		$endX   = $w;
		$step   = max(1, (int)floor($w / 24));

		$rTotal = 0;
		$gTotal = 0;
		$bTotal = 0;
		$count = 0;

		for ($x = $startX; $x < $endX; $x += $step) {
			for ($y = 0; $y < $h; $y += $step) {
				$rgb = imagecolorat($src, $x, $y);

				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;

				/*
				 * Skip near white and near black pixels.
				 */
				if (($r > 235 && $g > 235 && $b > 235) || ($r < 18 && $g < 18 && $b < 18)) {
					continue;
				}

				$rTotal += $r;
				$gTotal += $g;
				$bTotal += $b;
				$count++;
			}
		}

		imagedestroy($src);

		if ($count <= 0) {
			return array(42, 16, 100);
		}

		$r = (int)round($rTotal / $count);
		$g = (int)round($gTotal / $count);
		$b = (int)round($bTotal / $count);

		/*
		 * Darken color for readable fade.
		 */
		$r = max(10, (int)round($r * 0.45));
		$g = max(8,  (int)round($g * 0.45));
		$b = max(18, (int)round($b * 0.55));

		return array($r, $g, $b);
	}
}

if (!function_exists('gmTagImageSaveDetectedColor')) {
	function gmTagImageSaveDetectedColor($tagSlug, $imagePath)
	{
		$tagSlug = trim((string)$tagSlug);

		if ($tagSlug === '') {
			return;
		}

		$rgb = gmTagImageGetAverageColor($imagePath);
		$colors = gmTagImageLoadColors();

		$colors[$tagSlug] = array(
			'r' => (int)$rgb[0],
			'g' => (int)$rgb[1],
			'b' => (int)$rgb[2],
			'updated_at' => time()
		);

		gmTagImageSaveColors($colors);
	}
}

if (!function_exists('gmGenerateMissingTagImages')) {
	function gmGenerateMissingTagImages($limit = 20, $generateCards = false, $force = false)
	{
		global $GameMonetizeConnect;

		$limit = (int)$limit;

		if ($limit < 1) {
			$limit = 20;
		}

		if ($limit > 200) {
			$limit = 200;
		}

		$tagImgDir = ABSPATH . 'tag-img/';

		if (!is_dir($tagImgDir)) {
			@mkdir($tagImgDir, 0755, true);
		}

		$result = array(
			'processed' => 0,
			'generated' => 0,
			'skipped' => 0,
			'failed' => 0,
			'cards' => 0,
			'items' => array(),
			'done' => false,
			'mode' => $force ? 'remake' : 'missing',
		);

		$progress = gmTagImageLoadProgress();

		if ($force) {
			if (empty($progress['active']) || $progress['mode'] !== 'remake') {
				$progress = gmTagImageResetProgress();
			}

			$lastId = !empty($progress['last_id']) ? (int)$progress['last_id'] : 0;

			$q = $GameMonetizeConnect->query(
				"SELECT id, name, url FROM " . TAGS . " WHERE id > " . (int)$lastId . " ORDER BY id ASC LIMIT " . (int)$limit
			);
		} else {
			$q = $GameMonetizeConnect->query("SELECT id, name, url FROM " . TAGS . " ORDER BY id ASC");
		}

		if (!$q) {
			$result['error'] = 'Tags query failed';
			return $result;
		}

		$lastProcessedId = !empty($progress['last_id']) ? (int)$progress['last_id'] : 0;

		while ($tag = $q->fetch_assoc()) {
			if ($result['processed'] >= $limit) {
				break;
			}

			$tagId = (int)$tag['id'];
			$tagName = trim((string)$tag['name']);
			$tagSlug = !empty($tag['url']) ? trim((string)$tag['url']) : gmTagImageSlug($tagName);

			$tagSlug = gmTagImageSlug($tagSlug, $tagName);
			$dest = $tagImgDir . $tagSlug . '.webp';

			if (!$force && is_file($dest)) {
				continue;
			}

			$result['processed']++;
			$lastProcessedId = $tagId;

			$bestGame = gmTagImageFindBestGame($tagName, $tagSlug);

			if (!$bestGame || empty($bestGame['image'])) {
				$result['failed']++;
				$result['items'][] = $tagName . ' => failed no game image';
				continue;
			}

			$srcImage = gmTagImagePathFromGameImage($bestGame['image']);
			$ok = gmTagImageSave180($srcImage, $dest, 80);

			if ($ok) {
				$result['generated']++;

				gmTagImageSaveDetectedColor($tagSlug, $dest);

				$state = gmTagImageLoadState();

				if (!empty($bestGame['game_id'])) {
					$state = gmTagImageMarkGameUsed($state, (int)$bestGame['game_id']);
				}

				if (!empty($tag['id'])) {
					$state = gmTagImageMarkTagDone($state, (int)$tag['id']);
				}

				gmTagImageSaveState($state);

				$result['items'][] = $tagName . ' => ' . ($bestGame['name'] ?: $bestGame['game_name']);
			} else {
				$result['failed']++;
				$result['items'][] = $tagName . ' => failed convert';
			}
		}

		if ($force) {
			$progress['last_id'] = $lastProcessedId;
			$progress['generated'] = (int)$progress['generated'] + (int)$result['generated'];
			$progress['failed'] = (int)$progress['failed'] + (int)$result['failed'];
			$progress['updated_at'] = time();

			$remainingQuery = $GameMonetizeConnect->query(
				"SELECT COUNT(*) AS total FROM " . TAGS . " WHERE id > " . (int)$progress['last_id']
			);

			$remaining = 0;

			if ($remainingQuery) {
				$row = $remainingQuery->fetch_assoc();
				$remaining = !empty($row['total']) ? (int)$row['total'] : 0;
			}

			if ($remaining <= 0 || $result['processed'] <= 0) {
				$progress['active'] = false;
				$result['done'] = true;
			}

			gmTagImageSaveProgress($progress);

			$result['left'] = $remaining;
			$result['remake_active'] = !empty($progress['active']);
			$result['remake_generated'] = (int)$progress['generated'];
			$result['remake_failed'] = (int)$progress['failed'];

			return $result;
		}

		$left = 0;
		$q2 = $GameMonetizeConnect->query("SELECT id, name, url FROM " . TAGS . " ORDER BY id ASC");

		if ($q2) {
			while ($tag = $q2->fetch_assoc()) {
				$tagName = trim((string)$tag['name']);
				$tagSlug = !empty($tag['url']) ? trim((string)$tag['url']) : gmTagImageSlug($tagName);
				$tagSlug = gmTagImageSlug($tagSlug, $tagName);

				if (!is_file($tagImgDir . $tagSlug . '.webp')) {
					$left++;
				}
			}
		}

		$result['left'] = $left;
		$result['done'] = ($left <= 0);

		return $result;
	}
}