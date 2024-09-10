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
    <link rel="icon" href="{{ asset('images/x.png') }}" type="image/x-icon">

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
    <div class="min-h-screen flex flex-row">
        <div class="basis-1/4 ml-28 mt-4 fixed max-xl:ml-16 max-xl:basis-0">@include('inc.leftsidebar')</div>

        <div class="basis-2/4 md:mx-28 max-xl:basis-4/5 max-lg:basis-full max-lg:inset-x-0 max-lg:m-0 xl:mr-0 xl:ml-[25rem] overflow-hidden border-x border-zinc-700">@yield('content')</div>

        <div class="basis-1/4 mt-4 mr-28 ml-4 max-xl:hidden">@include('inc.rightsidebar')</div>
    </div>
</body>
</html>
