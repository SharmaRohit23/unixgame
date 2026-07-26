<link rel="preload" href="{{CONFIG_THEME_PATH}}/css/play.css?ver={{DATE_PLAY_CSS}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="{{CONFIG_THEME_PATH}}/css/play.css?ver={{DATE_PLAY_CSS}}"></noscript>

<link rel="preload" href="{{CONFIG_THEME_PATH}}/css/all.css?ver={{DATE_ALL_CSS}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="{{CONFIG_THEME_PATH}}/css/all.css?ver={{DATE_ALL_CSS}}"></noscript>

<script src="{{CONFIG_THEME_PATH}}/js/jquery.v1.min.js"></script>

<link rel="preload" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/css/splide.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/css/splide.min.css"></noscript>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {},
        },
        corePlugins: {
            preflight: false, // Opsional, jika ada masalah dengan reset CSS bawaan
        }
    };
</script>

<link rel="stylesheet" href="{{CONFIG_THEME_PATH}}/css/custom-theme.css?ver={{DATE_CUSTOM_THEME_CSS}}">