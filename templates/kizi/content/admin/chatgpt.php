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

				<p class="_f12" style="margin: 0 0 18px 0; line-height: 1.6; color:#ffcc66;">
					<b>CMS AI Free limit:</b> max 2,000 characters per template. Keep prompts short. For long articles, use OpenAI, DeepSeek, Gemini, MiMo, or OpenRouter with your own API key.
				</p>

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
				<textarea data-ai-count="1" data-ai-max="2000" style="height:200px;width:500px;margin-bottom:6px;" class="b-input scroll-custom" name="template_game">{{CHATGPT_TEMPLATE_GAME}}</textarea>
				<small class="ai-char-counter" data-ai-for="template_game">0 / 2000 characters</small>

				<span class="_f12">Template Category</span>
				<textarea data-ai-count="1" data-ai-max="2000" style="height:200px;width:500px;margin-bottom:6px;" class="b-input scroll-custom" name="template_category">{{CHATGPT_TEMPLATE_CATEGORY}}</textarea>
				<small class="ai-char-counter" data-ai-for="template_category">0 / 2000 characters</small>

				<span class="_f12">Template Tags</span>
				<textarea data-ai-count="1" data-ai-max="2000" style="height:200px;width:500px;margin-bottom:6px;" class="b-input scroll-custom" name="template_tags">{{CHATGPT_TEMPLATE_TAGS}}</textarea>
				<small class="ai-char-counter" data-ai-for="template_tags">0 / 2000 characters</small>

				<span class="_f12">Template Footer</span>
				<textarea data-ai-count="1" data-ai-max="2000" style="height:200px;width:500px;margin-bottom:6px;" class="b-input scroll-custom" name="template_footer">{{CHATGPT_TEMPLATE_FOOTER}}</textarea>
				<small class="ai-char-counter" data-ai-for="template_footer">0 / 2000 characters</small>

				<span class="_f12">Template Blog</span>
				<textarea data-ai-count="1" data-ai-max="2000" style="height:200px;width:500px;margin-top:15px;margin-bottom:6px;" class="b-input scroll-custom" name="template_blog">{{CHATGPT_TEMPLATE_BLOG}}</textarea>
				<small class="ai-char-counter" data-ai-for="template_blog">0 / 2000 characters</small>

				<span class="_f12">Template Blog Tag</span>
				<textarea data-ai-count="1" data-ai-max="2000" style="height:200px;width:500px;margin-top:15px;margin-bottom:6px;" class="b-input scroll-custom" name="template_blog_tag">{{CHATGPT_TEMPLATE_BLOG_TAG}}</textarea>
				<small class="ai-char-counter" data-ai-for="template_blog_tag">0 / 2000 characters</small>

				<span class="_f12">Template Blog Title</span>
				<textarea data-ai-count="1" data-ai-max="2000" style="height:140px;width:500px;margin-top:15px;margin-bottom:6px;" class="b-input scroll-custom" name="template_blog_title">{{CHATGPT_TEMPLATE_BLOG_TITLE}}</textarea>
				<small class="ai-char-counter" data-ai-for="template_blog_title">0 / 2000 characters</small>

				<span class="_f12">Template Blog Related Box</span>
				<textarea data-ai-count="1" data-ai-max="2000" style="height:180px;width:500px;margin-top:15px;margin-bottom:6px;" class="b-input scroll-custom" name="template_blog_related_box">{{CHATGPT_TEMPLATE_BLOG_RELATED_BOX}}</textarea>
				<small class="ai-char-counter" data-ai-for="template_blog_related_box">0 / 2000 characters</small>

			</div>

			<div class="r05-t _b-r _5e4 _f12">
				<span class="_f12">Model</span>
				<input type="text" name="chatgpt_model" class="b-input" value="{{CHATGPT_MODEL_VALUE}}" placeholder="Type model name here">

				<p class="_f12" style="margin: 8px 0 16px 0; line-height: 1.6;">
					Examples by provider:<br>
					<b>CMS AI Free:</b> cms-ai-free<br>
					<b>OpenAI:</b> gpt-4o-mini<br>
					<b>DeepSeek:</b> deepseek-chat<br>
					<b>MiMo:</b> mimo-v2-flash<br>
					<b>Gemini:</b> gemini-2.5-flash<br>
					<b>OpenRouter:</b> meta-llama/llama-3.1-8b-instruct
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
			</div>
		</div>

		<div class="_a-r _5e4 _b-t">
			<button type="submit" class="btn-p btn-p1">
				<i class="fa fa-check icon-middle"></i>
				@save@
			</button>
		</div>
	</form>

	<script>
	(function () {
		var maxLimit = 2000;

		function getEditorValue(box) {
			if (typeof tinymce !== 'undefined') {
				var editor = tinymce.get(box.id || box.name);
				if (editor) {
					return editor.getContent({ format: 'text' }) || '';
				}
			}
			return box.value || '';
		}

		function updateCounter(box) {
			var counter = document.querySelector('.ai-char-counter[data-ai-for="' + box.name + '"]');
			if (!counter) return;

			var len = getEditorValue(box).length;
			counter.textContent = len + ' / ' + maxLimit + ' characters max';

			if (len > maxLimit) {
	counter.style.setProperty('color', '#ff3333', 'important');
	counter.style.setProperty('font-weight', '700', 'important');
	counter.style.setProperty('display', 'block', 'important');
	counter.style.setProperty('margin', '6px 0 12px 0', 'important');

	box.style.setProperty('border', '2px solid #ff3333', 'important');
	box.style.setProperty('box-shadow', '0 0 0 1px #ff3333', 'important');
} else {
	counter.style.setProperty('color', '#999', 'important');
	counter.style.setProperty('font-weight', '400', 'important');
	counter.style.setProperty('display', 'block', 'important');
	counter.style.setProperty('margin', '6px 0 12px 0', 'important');

	box.style.removeProperty('border');
	box.style.removeProperty('box-shadow');
}
		}

		function bindCounters() {
			var boxes = document.querySelectorAll('textarea[data-ai-count="1"]');

			boxes.forEach(function (box) {
				box.setAttribute('data-ai-max', maxLimit);

				if (!box.id) {
					box.id = 'ai_' + box.name;
				}

				box.addEventListener('input', function () {
					updateCounter(box);
				});

				if (typeof tinymce !== 'undefined') {
					var editor = tinymce.get(box.id);
					if (editor) {
						editor.on('keyup change input paste setcontent', function () {
							updateCounter(box);
						});
					}
				}

				updateCounter(box);
			});
		}

		document.addEventListener('DOMContentLoaded', function () {
			bindCounters();

			setTimeout(bindCounters, 500);
			setTimeout(bindCounters, 1500);

			var form = document.getElementById('chatgptArea-form');
			if (form) {
				form.addEventListener('submit', function (e) {
					var boxes = document.querySelectorAll('textarea[data-ai-count="1"]');

					for (var i = 0; i < boxes.length; i++) {
						var box = boxes[i];
						var len = getEditorValue(box).length;

						if (len > maxLimit) {
							e.preventDefault();
							updateCounter(box);
							alert('This AI template is too long. Maximum allowed is ' + maxLimit + ' characters.');
							return false;
						}
					}
				});
			}
		});
	})();
	</script>
</div>