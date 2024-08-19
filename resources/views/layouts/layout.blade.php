<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>X</title>

    <style>
        /*Post Dropdown Menüsü için Stil */
        .dropdown-menu {
            display: none;
        }

        .group:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>
<body class="bg-black">
<div class="flex flex-row">
    <div class="basis-1/4 h-max ml-28 mt-4 fixed">@include('inc.leftsidebar')</div>

    <div class="basis-2/4 ml-[25rem]">@yield('content')</div>

    <div class="basis-1/4 mt-4 mr-28 ml-4">@include('inc.rightsidebar')</div>
</div>


</body>
</html>
