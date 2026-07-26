<div class="gamemonetize-main-headself">
	<i class="fa fa-flag-o"></i>
</div>
<div class="general-box _yt10 _yb10 _0e4">
	<form id="chatgptArea-form" method="POST">
		<div class="g-d5">
			<div class="r05-t _b-r _5e4">
				<span class="_f12">Provider</span>
<select name="llm_provider" class="b-input" style="margin-bottom: 20px;">
	{{LLM_PROVIDER_OPTIONS}}
</select>

<span class="_f12">OpenAI API Key</span>
<textarea style="height:80px;" class="b-input scroll-custom" name="openai_api_key" placeholder="Paste OpenAI API key here">{{OPENAI_API_KEY}}</textarea>

<span class="_f12">DeepSeek API Key</span>
<textarea style="height:80px;" class="b-input scroll-custom" name="deepseek_api_key" placeholder="Paste DeepSeek API key here">{{DEEPSEEK_API_KEY}}</textarea>

<span class="_f12">MiMo API Key</span>
<textarea style="height:80px;" class="b-input scroll-custom" name="mimo_api_key" placeholder="Paste MiMo API key here">{{MIMO_API_KEY}}</textarea>

<span class="_f12">Gemini API Key</span>
<textarea style="height:80px;" class="b-input scroll-custom" name="gemini_api_key" placeholder="Paste Gemini API key here">{{GEMINI_API_KEY}}</textarea>

<span class="_f12">OpenRouter API Key</span>
<textarea style="height:80px;" class="b-input scroll-custom" name="openrouter_api_key" placeholder="Paste OpenRouter API key here">{{OPENROUTER_API_KEY}}</textarea>

<p class="_f12" style="margin: 8px 0 20px 0; line-height: 1.6;">
	Get keys / docs:
	<a href="https://platform.openai.com/api-keys" target="_blank" rel="noopener noreferrer">OpenAI</a>
	|
	<a href="https://platform.deepseek.com/" target="_blank" rel="noopener noreferrer">DeepSeek</a>
	|
	<a href="https://platform.xiaomimimo.com/" target="_blank" rel="noopener noreferrer">MiMo</a>
	|
	<a href="https://aistudio.google.com/app/apikey" target="_blank" rel="noopener noreferrer">Gemini</a>
	|
	<a href="https://openrouter.ai/keys" target="_blank" rel="noopener noreferrer">OpenRouter</a>
</p>

				<span class="_f12">Template Game</span>
				<textarea style="height:200px;width:500px;margin-bottom: 40px;" class="b-input scroll-custom" name="template_game">{{CHATGPT_TEMPLATE_GAME}}</textarea>

				<span class="_f12">Template Category</span>
				<textarea style="height:200px;width:500px;margin-bottom: 110px;" class="b-input scroll-custom" name="template_category">{{CHATGPT_TEMPLATE_CATEGORY}}</textarea>

				<span class="_f12">Template Tags</span>
				<textarea style="height:200px;width:500px" class="b-input scroll-custom" name="template_tags">{{CHATGPT_TEMPLATE_TAGS}}</textarea>

				<span class="_f12">Template Footer</span>
				<textarea style="height:200px;width:500px" class="b-input scroll-custom" name="template_footer">{{CHATGPT_TEMPLATE_FOOTER}}</textarea>

				<span class="_f12">Template Blog</span>
				<textarea style="height:200px;width:500px;margin-top:15px;" class="b-input scroll-custom" name="template_blog">{{CHATGPT_TEMPLATE_BLOG}}</textarea>

				<span class="_f12">Template Blog Tag</span>
                <textarea style="height:200px;width:500px;margin-top:15px;" class="b-input scroll-custom" name="template_blog_tag">{{CHATGPT_TEMPLATE_BLOG_TAG}}</textarea>

				<span class="_f12">Template Blog Title</span>
				<textarea style="height:140px;width:500px;margin-top:15px;" class="b-input scroll-custom" name="template_blog_title">{{CHATGPT_TEMPLATE_BLOG_TITLE}}</textarea>

				<span class="_f12">Template Blog Related Box</span>
				<textarea style="height:180px;width:500px;margin-top:15px;" class="b-input scroll-custom" name="template_blog_related_box">{{CHATGPT_TEMPLATE_BLOG_RELATED_BOX}}</textarea>
								
				</div>

			<div class="r05-t _b-r _5e4 _f12">
<span class="_f12">Model</span>
<input type="text" name="chatgpt_model" class="b-input" value="{{CHATGPT_MODEL_VALUE}}" placeholder="Type model name here">

<p class="_f12" style="margin: 8px 0 16px 0; line-height: 1.6;">
	Examples by provider:<br>
	<b>OpenAI:</b> gpt-4o-mini<br>
	<b>DeepSeek:</b> deepseek-chat<br>
	<b>MiMo:</b> mimo-v2-flash<br>
	<b>Gemini:</b> gemini-2.5-flash<br>
	<b>OpenRouter:</b> meta-llama/llama-3.1-8b-instruct
</p>

<p class="_f12" style="margin: 8px 0 16px 0; line-height: 1.6;">
	<b>OpenRouter model tiers:</b><br>
	<b>Cheapest:</b> meta-llama/llama-3.1-8b-instruct<br>
	<b>Cheap:</b> mistralai/mistral-7b-instruct<br>
	<b>Cheap+ / Better:</b> mistralai/mistral-small-3.2-24b-instruct
</p>

				<span class="_f12">Maximum Words</span>
				<input type="number" name="maximum_words" class="b-input" placeholder="0 for disable" value="{{CHATGPT_MAXIMUM_WORDS}}">

				<span class="_f12">Rewrite Old Games Per Run</span>
                <input type="number" name="rewrite_old_games_limit" class="b-input" placeholder="1" value="{{REWRITE_OLD_GAMES_LIMIT}}">

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
				<p style="margin: 0;">$title -> page name (example: home, blogs, categories)</p>
				<p style="margin: 0;">$url -> page URL (example: /, /blogs, /categories)</p>
				<p style="margin: 0;">$description -> existing page description</p>
				<p style="margin: 0;">$random_game_link -> a link to a random game</p>
				<p style="margin: 0;">$random_category_link -> a link to a random category</p>
				<p style="margin: 0;">$random_tag_link -> a link to a random tag</p>

				<p class="_f12" style="height: 40px"></p>
				<p>Guides For Template Blog</p>
				<p style="margin: 0;">$title -> game title</p>
				<p style="margin: 0;">$description -> source game description</p>
				<p style="margin: 0;">$category -> game category name</p>
				<p style="margin: 0;">$tags -> game tags list</p>
				<p style="margin: 0;">$game_link -> internal link to the main game</p>
				<p style="margin: 0;">$blog_title -> generated blog title</p>

				<p class="_f12" style="height: 30px"></p>
				<p>Guides For Template Blog Title</p>
				<p style="margin: 0;">$title -> game title</p>
				<p style="margin: 0;">$category -> game category name</p>
				<p style="margin: 0;">$tags -> game tags list</p>

				<p class="_f12" style="height: 30px"></p>
				<p>Guides For Template Blog Related Box</p>
				<p style="margin: 0;">$title -> game title</p>
				<p style="margin: 0;">$category -> game category name</p>
				<p style="margin: 0;">$tags -> game tags list</p>
				<p style="margin: 0;">$blog_title -> generated blog title</p>
				<p style="margin: 0;">$blog_link -> internal link to the created blog</p>
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
