<!DOCTYPE html>
<html lang="en">

<head>
    {{HEADER_TAGS}}

    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="preload" as="style" onload="this.rel='stylesheet'">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="preload" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" as="style" onload="this.rel='stylesheet'" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    {{HEADER}}

    {{SIDEBAR}}

    <div {{PAGE_THEATER_MODE}} class="px-4 pt-20 pb-5 md:pb-10 lg:pl-20 min-[1920px]:pl-[256px] transition-all duration-300 {{PLAY_CONTAINER_CSS}}" style="{{SIDEBAR_MARGIN}}">

        {{PAGE_CONTENT}}
    </div>
    {{FOOTER}}

    <script>
        $('.sidebar').mouseenter(function() {
            $('.logo-icon').css('width', '120px');
            $('.logo-icon').attr('src', '../../../static/logo/kizi/logo.png');
        });

        $('.sidebar').mouseleave(function() {
            $('.logo-icon').css('width', '35px');
            $('.logo-icon').attr('src', '../../../static/logo/kizi/logo-35.png');
        });
    </script>
</body>

</html>