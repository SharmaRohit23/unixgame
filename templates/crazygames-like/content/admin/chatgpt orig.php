<div class="gamemonetize-main-headself">
	<i class="fa fa-flag-o"></i>
</div>
<div class="general-box _yt10 _yb10 _0e4">
	<form id="chatgptArea-form" method="POST">
		<div class="g-d5">
			<div class="r05-t _b-r _5e4">
				<span class="_f12"><a href="https://platform.openai.com/api-keysadd" target="_blank">Api Key</a></span>
				<textarea style="height:80px;" class="b-input scroll-custom" name="api_key">{{CHATGPT_API_KEY}}</textarea>
				<span class="_f12">Template Game</span>
				<textarea style="height:200px;width:500px;margin-bottom: 40px;" class="b-input scroll-custom" name="template_game">{{CHATGPT_TEMPLATE_GAME}}</textarea>
				<span class="_f12">Template Category</span>
				<textarea style="height:200px;width:500px;margin-bottom: 110px;" class="b-input scroll-custom" name="template_category">{{CHATGPT_TEMPLATE_CATEGORY}}</textarea>
				<span class="_f12">Template Tags</span>
				<textarea style="height:200px;width:500px" class="b-input scroll-custom" name="template_tags">{{CHATGPT_TEMPLATE_TAGS}}</textarea>
				<div class="d-flex">
					<span>Random Words Before Tags</span>
					<input type="text" class="b-input scroll-custom" name="random_words_before_tags" value="{{CHATGPT_RANDOM_WORDS_BEFORE_TAGS}}">
					<span>Random Words After Tags</span>
					<input type="text" class="b-input scroll-custom" name="random_words_after_tags" value="{{CHATGPT_RANDOM_WORDS_AFTER_TAGS}}">
				</div>
				<span class="_f12">Template Footer</span>
				<textarea style="height:200px;width:500px" class="b-input scroll-custom" name="template_footer">{{CHATGPT_TEMPLATE_FOOTER}}</textarea>
			</div>
			<div class="r05-t _b-r _5e4 _f12">
				<span class="_f12">Chatgpt Model</span>
				<select name="chatgpt_model" class="b-input">
					{{CHATGPT_MODELS}}
				</select>
				<span class="_f12">Maximum Words</span>
				<input type="number" name="maximum_words" class="b-input" placeholder="0 for disable" value="{{CHATGPT_MAXIMUM_WORDS}}">
				<p class="_f12" style="height: 0"></p>
				<p>Guides For Template Game</p>
				<p style="margin: 0;">$title -> title of the game</p>
				<p style="margin: 0;">$description -> description of the game</p>
				<p style="margin: 0;">$category -> category for the game</p>
				<p style="margin: 0;">$tags -> tags for the game</p>
				<p style="margin: 0;">$game_link -> a link of random similar game</p>
				<p style="margin: 0;">$game_first_word -> a link of random similar game based on first word</p>
				<p style="margin: 0;">$game_second_word -> a link of random similar game based on second word</p>
				<p style="margin: 0;">$three_random_game -> 3 game link of random similar game</p>
				<p style="margin: 0;">$random_similar_tags -> A link of random similar tags</p>
				<p style="margin: 0;">$random_tags_link -> A link of random tags</p>
				
				<p class="_f12" style="height: 0"></p>
				<p>Guides For Template Category</p>
				<p style="margin: 0;">$title -> title of the category</p>
				<p style="margin: 0;">$description -> description of the category</p>
				<p style="margin: 0;">$game_link -> a link of random game on the category</p>
				<p style="margin: 0;">$firstWord -> A link of a game on category based on first word</p>
				<p style="margin: 0;">$secondWord -> A link of a game on category based on second word</p>
				<p style="margin: 0;">$randomSimGames -> A link of a game on category based on random</p>
				<p style="margin: 0;">$randomSimTags -> A link of a tags based on random</p>
				<!-- <p style="margin: 0;">$randomSimCategoryText -> All text of a category based on random</p> -->
				<p style="margin: 0;">$randomSimTagBeforeAfter -> All text of a category based on random and add random word on before and after tag</p>

				<p class="_f12" style="height: 0px"></p>
				<p>Guides For Template Tags</p>
				<p style="margin: 0;">$title -> title of the tags</p>
				<p style="margin: 0;">$description -> description of the tags</p>
				<p style="margin: 0;">$game_link -> a link of random game on the tags</p>
				<p style="margin: 0;">$firstWord -> A link of a game on tags based on first word</p>
				<!-- <p style="margin: 0;">$secondWord -> A link of a game on tags based on second word</p> -->
				<p style="margin: 0;">$randomSimGames -> A link of a game on tags based on random</p>
				<p style="margin: 0;">$randomSimTags -> A link of a tags based on random</p>
				<!-- <p style="margin: 0;">$randomSimTagTxt -> All text of a tags based on random</p> -->
				<p style="margin: 0;">$randomSimTagBeforeAfter -> All text of a tags based on random and add random word on before and after tag</p>

				<p class="_f12" style="height: 40px"></p>
				<p>Guides For Template Footer</p>
				<p style="margin: 0;">$title -> title of the footer</p>
				<p style="margin: 0;">$description -> description of the footer</p>
			</div>
		</div>
		<div class="_a-r _5e4 _b-t">
			<button type="submit" class="btn-p btn-p1">
				<i class="fa fa-check icon-middle"></i>
				@save@
			</button>
		</div>
	</form>
</div>