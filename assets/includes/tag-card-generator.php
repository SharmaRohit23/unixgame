<?php
if (!defined('ABSPATH')) {
	exit();
}

if (!function_exists('gmGetTagCardBaseStyle')) {
	function gmGetTagCardBaseStyle()
	{
		global $config, $GameMonetizeConnect;

		$style = 'purple';

		if (!empty($config['tag_card_base_style'])) {
			$style = preg_replace('/[^a-z0-9_-]/i', '', $config['tag_card_base_style']);
		}

		if ($style === 'purple' && isset($GameMonetizeConnect)) {
			$q = $GameMonetizeConnect->query("SELECT tag_card_base_style FROM " . SETTING . " WHERE id='1' LIMIT 1");
			if ($q && $row = $q->fetch_assoc()) {
				if (!empty($row['tag_card_base_style'])) {
					$style = preg_replace('/[^a-z0-9_-]/i', '', $row['tag_card_base_style']);
				}
			}
		}

		$allowed = array('purple', 'green', 'red', 'blue', 'gamemonetize');

		if (!in_array($style, $allowed, true)) {
			$style = 'purple';
		}

		return $style;
	}
}

if (!function_exists('gmTagCardCreateImage')) {
	function gmTagCardCreateImage($path)
	{
		if (!file_exists($path)) {
			return false;
		}

		$info = @getimagesize($path);
		if (!$info || empty($info['mime'])) {
			return false;
		}

		if ($info['mime'] === 'image/webp' && function_exists('imagecreatefromwebp')) {
			return @imagecreatefromwebp($path);
		}

		if ($info['mime'] === 'image/png') {
			$img = @imagecreatefrompng($path);
			if ($img) {
				imagealphablending($img, true);
				imagesavealpha($img, true);
			}
			return $img;
		}

		if ($info['mime'] === 'image/jpeg') {
			return @imagecreatefromjpeg($path);
		}

		return false;
	}
}

if (!function_exists('gmTagCardCopyCover')) {
	function gmTagCardCopyCover($dst, $src, $dstX, $dstY, $dstW, $dstH)
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
			$cropW = (int) round($srcH * $dstRatio);
			$srcX = (int) round(($srcW - $cropW) / 2);
			$srcY = 0;
		} else {
			$cropW = $srcW;
			$cropH = (int) round($srcW / $dstRatio);
			$srcX = 0;
			$srcY = (int) round(($srcH - $cropH) / 2);
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

if (!function_exists('gmTagCardCopyContain')) {
	function gmTagCardCopyContain($dst, $src, $dstX, $dstY, $dstW, $dstH)
	{
		$srcW = imagesx($src);
		$srcH = imagesy($src);

		if ($srcW <= 0 || $srcH <= 0) {
			return false;
		}

		/*
		 * If already exact 180x180, do not touch quality.
		 * Copy 1:1 directly.
		 */
		if ($srcW === $dstW && $srcH === $dstH) {
			return imagecopy($dst, $src, $dstX, $dstY, 0, 0, $srcW, $srcH);
		}

		/*
		 * Do not upscale smaller images.
		 * Only downscale if bigger than target.
		 */
		$scale = min($dstW / $srcW, $dstH / $srcH, 1);

		$newW = (int) round($srcW * $scale);
		$newH = (int) round($srcH * $scale);

		$placeX = $dstX + (int) floor(($dstW - $newW) / 2);
		$placeY = $dstY + (int) floor(($dstH - $newH) / 2);

		return imagecopyresampled(
			$dst,
			$src,
			$placeX,
			$placeY,
			0,
			0,
			$newW,
			$newH,
			$srcW,
			$srcH
		);
	}
}

if (!function_exists('gmCreateTagCardFromImage')) {
	function gmCreateTagCardFromImage($sourcePath, $destPath)
	{
		if (!extension_loaded('gd') || !file_exists($sourcePath)) {
			return false;
		}

		$style = gmGetTagCardBaseStyle();

		$cardW = 360;
		$cardH = 180;

		$src = gmTagCardCreateImage($sourcePath);
		if (!$src) {
			return false;
		}

		$card = imagecreatetruecolor($cardW, $cardH);
		imagealphablending($card, false);
		imagesavealpha($card, true);

		$transparent = imagecolorallocatealpha($card, 0, 0, 0, 127);
		imagefilledrectangle($card, 0, 0, $cardW, $cardH, $transparent);

		imagealphablending($card, true);

		/*
		* STEP 1:
		* Put real tag image inside the right 180x180 half.
		* Use CONTAIN so original image is not zoomed/cropped.
		*/
		gmTagCardCopyContain($card, $src, 180, 0, 180, 180);

		/*
		 * STEP 2:
		 * Put transparent fade PNG above image.
		 * This file must be 360x180:
		 * color on left, transparent on right.
		 */
		$basePng  = ABSPATH . 'static/tag-card-base-' . $style . '.png';
		$baseWebp = ABSPATH . 'static/tag-card-base-' . $style . '.webp';

		$basePath = '';

		if (file_exists($basePng)) {
			$basePath = $basePng;
		} elseif (file_exists($baseWebp)) {
			$basePath = $baseWebp;
		}

		if ($basePath !== '') {
			$base = gmTagCardCreateImage($basePath);

			if ($base) {
				imagealphablending($card, true);
				imagecopyresampled(
					$card,
					$base,
					0,
					0,
					0,
					0,
					$cardW,
					$cardH,
					imagesx($base),
					imagesy($base)
				);
				imagedestroy($base);
			}
		} else {
			/*
			 * Fallback only if base image missing.
			 * This should almost never run if /static/tag-card-base-red.png exists.
			 */
			for ($x = 0; $x < $cardW; $x++) {
				$t = $x / ($cardW - 1);
				$alpha = (int)(20 + (105 * $t));
				$col = imagecolorallocatealpha($card, 170, 35, 62, $alpha);
				imageline($card, $x, 0, $x, $cardH, $col);
			}
		}

		if (!is_dir(dirname($destPath))) {
			@mkdir(dirname($destPath), 0755, true);
		}

		$saved = imagewebp($card, $destPath, 95);

		imagedestroy($src);
		imagedestroy($card);

		return $saved;
	}
}