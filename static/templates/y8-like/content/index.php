<!DOCTYPE html>
<html lang="en">

<head>
    {{HEADER_TAGS}}

    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="preload" as="style" onload="this.rel='stylesheet'">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="preload" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" as="style" onload="this.rel='stylesheet'" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .sidebar {
            width: 40px;
            height: 100vh;
            position: fixed;
            top: 0;
            display: flex;
            transition: visibility 0s, all 0.15s ease-in-out;
            content-visibility: auto;
            background: #fff;
            z-index: 999999999;
            flex-direction: column;
            cursor: pointer;
            padding-top: 10px;
            padding-bottom: 30px;
            overflow: auto;
            overflow-x: hidden;
            overflow-anchor: none;
            scrollbar-width: none;
            font-family: Oswald, sans-serif;
        }

        .sidebar:hover {
            width: 220px;
            scrollbar-width: thin;
            scrollbar-color: #0b9bca;
        }

        .sidebar::-webkit-scrollbar {
            width: 0;
            height: 0;
        }

        .sidebar:hover::-webkit-scrollbar {
            width: 3px;
            height: 3px;
            background: rgba(0, 0, 0, 0);
        }

        .sidebar::-webkit-scrollbar-thumb {
            border-radius: 30px;
        }

        .sidebar:hover::-webkit-scrollbar-thumb {
            background: #AAADBE;
            border-radius: 30px;
        }

        .sidebar:hover::-webkit-scrollbar-corner {
            background: rgba(0, 0, 0, 0);
        }

        .sidebar+.wrapper {
            margin-left: 40px;
        }

        .sidebar-item:not(.no-hover):hover {
            border-left-color: #E92224 !important;
        }

        .sidebar-item.no-link {
            pointer-events: none;
        }

        .sidebar-item.logo-title:hover {
            border-left-color: #E92224 !important;
            cursor: default;
        }

        .sidebar-item {
            display: flex;
            color: white !important;
            text-decoration: none !important;
            border-left-width: 6px !important;
            border-left-style: solid !important;
            border-left-color: transparent !important;
        }

        .sidebar-item.active {
            color: #0b9bca !important;
        }

        .sidebar-item:hover .sidebar-item-icon {
            opacity: .7;
        }

        .sidebar-item:not(.no-hover):hover .sidebar-item-title {
            transition: visibility 0s, all 0.15s ease-in-out;
            margin-left: 5px;
        }

        .sidebar-item.logo-title:hover .sidebar-item-title {
            transition: visibility 0s, all 0.15s ease-in-out;
            margin-left: 0 !important;
        }

        .sidebar-item .search input {
            width: 100px;
            background: #fff;
            border: 0;
            height: 30px;
            padding: 0 10px;
            box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.35) inset;
            border-radius: 5px;
        }

        .sidebar-item .search button {
            width: 30px;
            line-height: 30px;
            color: #fff;
            font-size: 14px;
            font-family: Oswald sans-serif;
            background: #043856;
            border-radius: 5px;
            border: 0;
            cursor: pointer;
        }

        .sidebar-item-icon {
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-align-items: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            text-align: center;
            display: flex;
            font-size: 2rem;
            /* padding: 0 19px; */
            /* margin-left: -5px; */
            /* width: 40px; */
            max-width: 45px;
            min-width: 45px;
            height: 40px;
        }

        .sidebar-item-icon i {
            /* margin: 0 !important; */
            color: #66667E;
        }

        .sidebar-item-title {
            white-space: nowrap;
            font-weight: bold;
            align-self: center;
            color: #66667E;
            letter-spacing: 1px;
            font-size: 1.4em !important;
        }

        .sidebar .separator {
            width: 100%;
            margin-right: 5px;
            padding: 0;
            opacity: 0.4;
            border: none;
            height: 2px;
            color: #cacaca;
            background-color: #cacaca;
            border-radius: 5%;

        }
    </style>
</head>

<body>
    {{HEADER}}

    {{SIDEBAR}}

    <div {{PAGE_THEATER_MODE}} class="gamemonetize-page-tree gamemonetize-container" style="{{SIDEBAR_MARGIN}}">

        {{PAGE_CONTENT}}
    </div>

    {{FOOTER_BAR}}
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