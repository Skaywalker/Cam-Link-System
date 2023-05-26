<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csft_token" content="{{csrf_token()}}">
        <title>Cam-Link System</title>
            @vite(['resources/js/app.js'])
    </head>
    <body>
    <header>
    <nav id="nav-bar">
        <ul>
            <li>Cam-link-System</li>
            <li>Bejelentkezés</li>
            <li>Kapcsolat</li>
        </ul>
{{--bug: Miért nem lehet meghívni a onclick="logOut()"--}}
        <ul class="logout-nav-item">
            <li data-nav="logOut">Kijeletkezés</li>
        </ul>
    </nav>
        <div class="alert" id="alert">

        </div>
    </header>
    <main id="mainContent">

    </main>
    <footer>
        <ul>
            <li>Fejlesző: &copy  Bihacsy László</li>
            <li>A project portfolió céljábol készűlt! Felelőtlen használatért felelőség a fejlesztőt nem terheli!</li>
        </ul>
    </footer>
    </body>
</html>
