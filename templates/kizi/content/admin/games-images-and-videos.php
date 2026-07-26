<div class="gamemonetize-main-headself">
    <i class="fa fa-bookmark"></i>
</div>
<div class="general-box _0e4">
    <div class="header-box" style="text-align: left;">
        <h2>Manage Games Images</h2>
        <p>Make sure you have add the first images (/games-img folder) before you can manage them.</p>
        <h4 style="color: #2A73B1;">Here is the list of games from last 30 days.</h4>
        <button id="update-games-images-last-30-days" class="btn-p btn-p4"><i class="fa fa-refresh"></i> Update Last 30 Days Games Images</button>
        <button id="update-games-images-all" class="btn-p btn-p4"><i class="fa fa-refresh"></i> Update All Games Images</button>
    </div>
    <ul class="categories-list scroll-custom">
        {{GAMES_LIST_IMAGE}}
    </ul>
    <div class="header-box" style="text-align: left;">
        <h2>Manage Games Videos</h2>
        <p>Make sure you have done the "Add Walkthrough Video to DB" process add the first videos (/games-thumb-video folder) before you can manage them. If not, you can click the button below:</p>
        <a href="/add-wt-to-db.php" target="_blank" class="btn-p btn-p4"><i class="fa fa-plus"></i> Add Walkthrough Video to DB</a>
        <h4 style="color: #2A73B1;">Here is the list of games from last 30 days.</h4>
        <div style="">CRON URL: <i>You can change the VPS server in the VPS SERVER IP HERE.txt</i></div>
        <input type="hidden" id="ngrok-url" class="form-control" disabled value="{{NGROK_URL}}" style="width: 50%;">
        <input type="text" id="cron-url-30-days" class="form-control" disabled value="{{CRON_URL_30_DAYS}}" style="width: 50%;">
        <button id="update-games-videos-last-30-days" class="btn-p btn-p4"><i class="fa fa-refresh"></i> Update Last 30 Days Games Videos</button>
        <button id="copy-cron-url-30-days" class="btn-p btn-p4"><i class="fa fa-copy"></i> Copy Cron URL 30 Days</button>
        <input type="text" id="cron-url-all-games" class="form-control" disabled value="{{CRON_URL_ALL_GAMES}}" style="width: 50%;">
        <button id="update-games-videos-all" class="btn-p btn-p4"><i class="fa fa-refresh"></i> Update All Games Videos</button>
        <button id="copy-cron-url-all-games" class="btn-p btn-p4"><i class="fa fa-copy"></i> Copy Cron URL All Games</button>
    </div>
    <ul class="categories-list scroll-custom">
        {{GAMES_LIST_VIDEO}}
    </ul>
</div>

<script>
document.getElementById('update-games-images-last-30-days').addEventListener('click', function() {
    updateGamesImages('update_last_30_days');
});

document.getElementById('update-games-images-all').addEventListener('click', function() {
    updateGamesImages('update_all');
});

document.getElementById('update-games-videos-last-30-days').addEventListener('click', function() {
    updateGamesVideos('update_last_30_days');
});

document.getElementById('update-games-videos-all').addEventListener('click', function() {
    updateGamesVideos('update_all');
});

function updateGamesImages(action) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/ajax_updategamesimages.php?action=' + action, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                Toast.success(xhr.responseText);
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else {
                Toast.error('An error occurred: ' + xhr.statusText);
            }
        }
    };
    xhr.send();
}

function updateGamesVideos(action) {
    var xhr = new XMLHttpRequest();
    var ngrokUrl = document.getElementById('ngrok-url').value;
    if (!ngrokUrl) {
        alert('Please enter a valid Ngrok URL.');
        return;
    }
    xhr.open('GET', '/ajax_updategamesvideos.php?action=' + action + '&ngrokurl=' + encodeURIComponent(ngrokUrl), true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                Toast.success(xhr.responseText);
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else {
                Toast.error('An error occurred: ' + xhr.statusText);
            }
        }
    };
    xhr.send();
}

document.getElementById('copy-cron-url-30-days').addEventListener('click', function() {
    var copyText = document.getElementById('cron-url-30-days');
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    Toast.success('Copied the text: ' + copyText.value);
});

document.getElementById('copy-cron-url-all-games').addEventListener('click', function() {
    var copyText = document.getElementById('cron-url-all-games');
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    Toast.success('Copied the text: ' + copyText.value);
});

</script>