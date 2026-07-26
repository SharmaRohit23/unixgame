// 
function __upGame_rx8(id) {
    $.ajax({
        url: Ajaxrequest() + '?t=gameplayed',
        type: 'POST',
        data: "gid=" + id
    });
}

/* FULLSCREEN FUNC */
function initFullScreen(fscreenToThis) {
    if (BigScreen.enabled) {
        BigScreen.request($(fscreenToThis)[0]);
    } else {
        alert("This browser doesn't support full screen");
    }
}

function __sGame() {
    $('.gmDisplay').show();
    $('._Ad-game').remove();
}

var __AdRNum = 6; // seconds to remove ads
function __AdRemoveCount() {
    if (__AdRNum != 0) {
        __AdRNum -= 1
        $('.rAdNum').text(__AdRNum);
    } else {
        $('.__r-Ad-1').css('display', 'none');
        $('.__r-Ad-2').css('display', 'inherit');
        $('._removeAd').attr('onclick', '__sGame()');
        $('._removeAd').attr('disabled', false);
        return false;
    }
    window.setTimeout(function () { __AdRemoveCount() }, 1000);
}

function __adCountD() {
    if (__AdNum != 0) {
        __AdNum -= 1
        $('.Adnum').text(__AdNum);
    } else {
        __sGame();
        return false;
    }
    window.setTimeout(function () { __adCountD() }, 1000);
}

function __sendReport(gid) {
    swal({
        title: "",
        text: "¿Tell us, what is your problem?",
        imageUrl: siteUrl + "/templates/modern/image/icon-color/worker.png",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "Write the problem here in detail..."
    }, function (inputValue) {
        if (inputValue === false) return false;
        if (inputValue === "") {
            swal.showInputError("You need to write something!");
            return false
        }

        $.ajax({
            url: Ajaxrequest() + '?t=send_report',
            type: 'POST',
            data: "gid=" + gid + "&report=" + inputValue,
            success: function (data) {
                if (data.status == 200) {
                    swal("", data.success_message, "success");
                } else {
                    swal("", data.error_message, "error");
                }
            }
        });
    });

}

$(function () {
    /* SEARCH AREA */
    // $('#search-data-form').ajaxForm({
    //     url: Ajaxrequest() + '?t=search',
    //     type: 'POST',
    //     success: function(data) {
    //         startLoadbar();
    //         Loadlink(data.redirect_url);
    //         stopLoadbar();
    //     }, 
    //     error: function() {
    //         console.log('Connection failed!');
    //     }
    // });

    /* FULLSCREEN BUTTON */
    $(document).on('click', '.initFullScreen', function () {
        initFullScreen($(this).attr('data-fullscreen-item'));
    });

    $(document).on('click', '#report-btn', function () {
        var gid_sR2 = $(this).attr('data-report');
        __sendReport(gid_sR2);
    });

    /* SHARE BUTTONS */
    $(document).on('click', '#share-btn', function (e) {
        e.preventDefault();
        var Dragon__socialURl_r2 = $(this).attr('data-share-url');
        window.open(
            '' + Dragon__socialURl_r2 + '',
            'Share',
            'toolbar=0, status=0, width=650, height=450'
        );
    });

    /* OVERLAY TOGGLE */
    $(document).on('click', '.overlay-toggle', function (e) {
        e.preventDefault();
        var data_target = $(this).attr('data-target');
        $(data_target).toggleClass('overlay-open');
        $('body').toggleClass('state-overlay-open');
        $(data_target).attr('data-status', function (_, attr) {
            return attr == 'closed' ? 'opened' : 'closed';
        });
    });

    $(document).on('click', '.overlay-wrapper', function (e) {
        if (e.target == this) {
            $(this).toggleClass('overlay-open');
            $('body').toggleClass('state-overlay-open');
            $(this).attr('data-status', function (_, attr) {
                return attr == 'closed' ? 'opened' : 'closed';
            });
        }
    });

});

(function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function () {
        (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o), m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
(function () {
    ga('create', 'UA-154497915-1', 'auto');
    ga('send', 'pageview');
})();

(function (a, b, c) {
    var d = a.getElementsByTagName(b)[0];
    a.getElementById(c) || (a = a.createElement(b), a.id = c, a.src = "https://api.gamemonetize.com/cms_api.js?" + new Date().valueOf(), d.parentNode.insertBefore(a, d))
})(document, "script", "gamemonetize-cms");

const tagList = document.querySelector('.tag-list');
let isDragging = false;
let startX;
let scrollLeft;
let moved = 0;

// Fungsi saat mulai drag
tagList.addEventListener('mousedown', (e) => {
    isDragging = true;
    startX = e.pageX - tagList.offsetLeft;
    scrollLeft = tagList.scrollLeft;
    moved = 0; // Reset pergeseran
});

// Fungsi saat drag berhenti
tagList.addEventListener('mouseup', () => {
    isDragging = false;
    if (moved > 5) {
        // Mencegah klik jika terjadi drag
        tagList.classList.add('no-click');
    } else {
        tagList.classList.remove('no-click');
    }
});

tagList.addEventListener('mouseleave', () => {
    isDragging = false;
});

// Fungsi saat drag bergerak
tagList.addEventListener('mousemove', (e) => {
    if (!isDragging) return;
    e.preventDefault();
    const x = e.pageX - tagList.offsetLeft;
    const walk = (x - startX) * 2; // Tambah kecepatan scroll
    tagList.scrollLeft = scrollLeft - walk;
    moved = Math.abs(x - startX); // Hitung pergeseran
});

// Cegah klik jika drag terjadi
tagList.addEventListener('click', (e) => {
    if (moved > 5) {
        e.preventDefault(); // Batalkan klik jika drag melebihi 5px
    }
});

// Pilih elemen yang dibutuhkan
const searchIcon = document.getElementById('search');
const searchLeft = document.getElementById('search-left');
const searchLeftClose = document.getElementById('search-left-close');
const searchContainer = document.querySelector('.search-container');

// Fungsi untuk membuka panel pencarian
function openSearch() {
    $('body').css('overflow', 'hidden');
    searchLeft.style.display = 'block';
    setTimeout(() => {
        searchLeft.classList.add('active'); // Tambahkan animasi atau transisi jika diinginkan
    }, 10); // Delay untuk memungkinkan transisi
}

// Fungsi untuk menutup panel pencarian
function closeSearch() {
    $('body').css('overflow', 'auto');
    searchLeft.classList.remove('active');
    setTimeout(() => {
        searchLeft.style.display = 'none';
    }, 300); // Sesuaikan waktu sesuai durasi transisi CSS jika ada
}

// Event listener untuk membuka panel pencarian
searchIcon.addEventListener('click', openSearch);

// Event listener untuk menutup panel pencarian saat tombol close diklik
searchLeftClose.addEventListener('click', closeSearch);

// Event listener untuk menutup panel pencarian saat klik di luar searchContainer
document.addEventListener('click', (e) => {
    if (
        searchLeft.classList.contains('active') &&
        !searchContainer.contains(e.target) &&
        !searchIcon.contains(e.target)
    ) {
        closeSearch();
    }
});

// Tangkap elemen input pencarian dan hasil pencarian
const searchInput = document.getElementById('Search-InArea');
const searchResults = document.getElementById('search-results');

// Fungsi debouncer untuk menghindari pengiriman permintaan berlebihan
function debounce(func, delay) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), delay);
    };
}

// Fungsi untuk mengambil hasil pencarian
function fetchSearchResults(query) {
    $.ajax({
        url: '/search-handler/' + query, // Ganti dengan URL pencarian Anda
        method: 'GET',
        success: function (data) {
            // Tampilkan hasil pencarian dalam elemen searchResults
            searchResults.innerHTML = data;
            searchResults.style.display = 'flex';
            $('#tag-and-games-contaner').hide();
            $('#search-left .search-container .search-form #clear-search').css('display', 'flex');
            $('#search-left .search-container .search-form #search').hide();
        },
        error: function () {
            console.error('Error fetching search results.');
        }
    });
}

// Debounce fetchSearchResults dengan jeda 300ms
const debouncedSearch = debounce(fetchSearchResults, 300);

// Event listener pada input pencarian
searchInput.addEventListener('keyup', function () {
    const query = searchInput.value.trim();
    if (query.length > 2) {
        debouncedSearch(query);
    } else {
        searchResults.style.display = 'none';
        searchResults.innerHTML = '';
        $('#tag-and-games-contaner').show();
        $('#search-left .search-container .search-form #clear-search').hide();
        $('#search-left .search-container .search-form #search').show();
    }
});

const clearSearchButton = document.getElementById('clear-search');

// Fungsi untuk membersihkan pencarian
function clearSearch() {
    // Mengosongkan input pencarian
    searchInput.value = '';
    // Menyembunyikan hasil pencarian
    searchResults.style.display = 'none';
    searchResults.innerHTML = '';
    // Menampilkan konten awal
    $('#tag-and-games-contaner').show();
    $('#search-left .search-container .search-form #clear-search').hide();
    $('#search-left .search-container .search-form #search').show();
}

// Event listener untuk tombol clear
clearSearchButton.addEventListener('click', clearSearch);