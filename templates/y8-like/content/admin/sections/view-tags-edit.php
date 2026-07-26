<div class="general-box _0e4">
	<div class="header-box">
		<i class="fa fa-pencil color-w icon-middle"></i>
	</div>
	<div class="_5e4">
		<form id="edittags-form" enctype="multipart/form-data" method="POST">
			<div class="vByg5">
				<input type="text" name="ec_name" value="{{EDIT_TAGS_NAME}}">
				<input type="hidden" name="ec_id" class="ec_id" value="{{EDIT_TAGS_ID}}">
			</div>
			<div class="show-home-input-container">
				<label for="show-home-input">Show at Home</label>
				<input type="checkbox" id="show-home-input" name="ec_show_home" value="true" {{EDIT_TAGS_SHOW_HOME}}>
			</div>
			<div class="" style="margin-top: 10px;">
				<label for="">Footer Description</label>
				<textarea name="ec_footer_description" placeholder="footer description" rows="15" style="min-height: 339px;" class="editor-js _text-input _tr5 tinymce">
				{{EDIT_TAGS_FOOTER_DESCRIPTION}}
				</textarea>
				<p>
					<button class="btn-p btn-p1 rewriteText" type="button" data-text="{{CHAT_GPT_TEMPLATE_TAGS}}">Rewrite</button>
					<button class="btn-p btn-p1 clickToCopyText" type="button" data-text="{{CHAT_GPT_TEMPLATE_TAGS}}">Copy Rewrite Prompt</button>
				</p>
			</div>
			<div class="rewriteResultBox" style="display: none;">
				<p>
					<bold>Rewrite Result</bold> <button class="btn-p btn-p1 clickToCopyText" type="button" data-text="">Copy</button>
				</p>
				<p class="rewriteResult"></p>
			</div>

			<div class="_yt10">
				<div class="_a6">
					<label>
						<input type="checkbox" name="is_last_rewrite" {{EDIT_TAGS_IS_LAST_REWRITE}} style="transform: scale(1.5)">
						<span class="_tr5 color-grey _bold">Set as last rewrite</span>
					</label>
				</div>
			</div>

			<button type="submit" class="btn-p btn-p1" onclick="tinymce.triggerSave();">
				<i class="fa fa-check icon-middle"></i>
				@save@
			</button>
			<a class="btn-default btn-sm" target="_blank" href="{{EDIT_TAGS_URL}}">
				<i class="fa fa-send icon-middle"></i>
				@open@
			</a>
		</form>
	</div>
</div>