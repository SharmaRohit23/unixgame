<?php
$themeData['ads_header'] = getADS('header');
$themeData['ads_footer'] = getADS('footer');
$themeData['ads_sidebar'] = getADS('column_one');

//require_once ABSPATH . 'assets/includes/tag-card-generator.php';

$sql_tag_query = $GameMonetizeConnect->query("SELECT * FROM " . TAGS . " ORDER BY name");
	$ct_r = '';
		$activeFirstLetter = '';

		$tagColors = array();
		$tagColorJson = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/json/tag-image-colors.json';

		if (is_file($tagColorJson)) {
			$tagColors = json_decode((string)@file_get_contents($tagColorJson), true);

			if (!is_array($tagColors)) {
				$tagColors = array();
			}
		}

		while ($tags = $sql_tag_query->fetch_array()) {
		$tagName = trim((string)$tags['name']);
		$tagSlug = !empty($tags['url']) ? trim((string)$tags['url']) : slugify($tagName);

		$themeData['tags_id'] = $tags['id'];
		$themeData['tags_name'] = $tagName;
		$themeData['tags_number'] = isset($tags['total_games']) ? (int)$tags['total_games'] : 0;
		$themeData['tags_url'] = siteUrl() . '/tag/' . $tagSlug;

		$tagImg = '';
		$hasTagImage = false;

		$tagWebpPath = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/tag-img/' . $tagSlug . '.webp';
		$tagPngPath  = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/tag-img/' . $tagSlug . '.png';
		$tagJpgPath  = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/tag-img/' . $tagSlug . '.jpg';
		$tagJpegPath = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/tag-img/' . $tagSlug . '.jpeg';

		if (is_file($tagWebpPath)) {
			$tagImg = siteUrl() . '/tag-img/' . $tagSlug . '.webp?v=' . filemtime($tagWebpPath);
			$hasTagImage = true;
		} elseif (is_file($tagPngPath)) {
			$tagImg = siteUrl() . '/tag-img/' . $tagSlug . '.png?v=' . filemtime($tagPngPath);
			$hasTagImage = true;
		} elseif (is_file($tagJpgPath)) {
			$tagImg = siteUrl() . '/tag-img/' . $tagSlug . '.jpg?v=' . filemtime($tagJpgPath);
			$hasTagImage = true;
		} elseif (is_file($tagJpegPath)) {
			$tagImg = siteUrl() . '/tag-img/' . $tagSlug . '.jpeg?v=' . filemtime($tagJpegPath);
			$hasTagImage = true;
		} else {
			$defaultTagImgPath = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/static/tag-img-default.webp';

			if (is_file($defaultTagImgPath)) {
				$tagImg = siteUrl() . '/static/tag-img-default.webp?v=' . filemtime($defaultTagImgPath);
				$hasTagImage = true;
			}
		}
		$themeData['tags_thumb'] = $tagImg;

		$firstLetter = (!empty($tagName[0]) && ctype_alpha($tagName[0])) ? strtolower($tagName[0]) : '#';

		if ($config['site_theme'] == 'crazygames-like' && $activeFirstLetter != $firstLetter) {
			$ct_r .= '<div class="my-2 text-5xl font-extrabold text-white text-opacity-60 md:col-span-3 lg:col-span-4 2xl:col-span-6">' . strtoupper($firstLetter) . '</div>';
			$activeFirstLetter = $firstLetter;
		}

		if ($config['site_theme'] == 'crazygames-like') {
				$cardClass = $hasTagImage ? 'tag-page-card has-tag-image' : 'tag-page-card tag-page-card-default';

				$tagColorStyle = '';

				if ($hasTagImage && !empty($tagColors[$tagSlug])) {
					$r = isset($tagColors[$tagSlug]['r']) ? (int)$tagColors[$tagSlug]['r'] : 42;
					$g = isset($tagColors[$tagSlug]['g']) ? (int)$tagColors[$tagSlug]['g'] : 16;
					$b = isset($tagColors[$tagSlug]['b']) ? (int)$tagColors[$tagSlug]['b'] : 100;

					$r = max(0, min(255, $r));
					$g = max(0, min(255, $g));
					$b = max(0, min(255, $b));

					$tagColorStyle = ' style="--tag-card-left-rgb:' . $r . ',' . $g . ',' . $b . ';"';
				}

				$tagImageHtml = '';
			if ($hasTagImage) {
				$tagImageHtml = '<img src="' . htmlspecialchars($tagImg, ENT_QUOTES) . '" alt="' . htmlspecialchars($tagName, ENT_QUOTES) . ' image" loading="lazy" decoding="async">';
			}

			$themeData['tags_home_card_html'] = '<a href="' . $themeData['tags_url'] . '" class="' . $cardClass . '"' . $tagColorStyle . '>
				' . $tagImageHtml . '
				<span>
					<strong>' . htmlspecialchars($tagName, ENT_QUOTES) . '</strong>
					<small>' . number_format((int)$themeData['tags_number']) . ' Games</small>
				</span>
			</a>';
		} else {
			$themeData['tags_home_card_html'] = '<a href="' . $themeData['tags_url'] . '" class="border-transparent border-l-4 text-white flex items-center font-semibold no-underline h-[34px] hover:text-opacity-65 text-[15px]">
				<div class="relative truncate transition-all duration-300">' . htmlspecialchars($tagName, ENT_QUOTES) . '</div>
			</a>';
		}

		$ct_r .= \GameMonetize\UI::view('category/tags-list');
	}

	$themeData['categories_list'] = $ct_r;

	$tags_footer_description = getFooterDescription('tags');
	$tags_footer_description = htmlspecialchars_decode($tags_footer_description->description);

	// Variabel untuk menyimpan hasil
	$header_title = '';
	$header_desc = '';
	$footer_description = '';

	// Ambil teks dalam tag <h1>
	if (preg_match('/<h1>(.*?)<\/h1>/', $tags_footer_description, $matches)) {
		$header_title = $matches[1]; // Simpan teks <h1> ke variabel header_title
	}

	// Ambil semua tag <p> dalam teks
	if (preg_match_all('/<p>(.*?)<\/p>/', $tags_footer_description, $matches)) {
		// Jika ada setidaknya 1 tag <p>
		if (!empty($matches[1])) {
			// Ambil isi tag <p> pertama
			$first_p_content = $matches[1][0];

			// Pisahkan berdasarkan tag <br>
			$br_split = preg_split('/<br\s*\/?>/i', $first_p_content);

			// Simpan bagian pertama sebagai header_desc
			if (!empty($br_split[0])) {
				$header_desc = trim($br_split[0]); // Trim untuk menghapus spasi berlebih
			}

			// Jika ada lebih dari satu bagian, gabungkan sisanya menjadi footer_description
			if (count($br_split) > 1) {
				$footer_description = '<p>' . implode('</p><p>', array_map('trim', array_slice($br_split, 1))) . '</p>'; // Gabungkan sisa bagian setelah <br> pertama menjadi tag <p>
			}

			// Gabungkan sisa tag <p> ke footer_description
			if (count($matches[1]) > 1) {
				$footer_description .= '<p>' . implode('</p><p>', array_map('trim', array_slice($matches[1], 1))) . '</p>';
			}
		}
	}

	$themeData['page_title'] = $header_title;
	$themeData['page_description'] = $header_desc;
	$themeData['footer_description'] = $footer_description;

	$themeData['tags_content'] = \GameMonetize\UI::view('game/tags');
	$themeData['page_content'] = \GameMonetize\UI::view('category/tags-content');