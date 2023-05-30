<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csft_token" content="{{csrf_token()}}">
        <title>Cam-Link System</title>
            @vite(['resources/js/app.js'])
    </head>
    <body data-bs-theme="dark">
    <header>
        <nav class="navbar bg-body-tertiary fixed-top"  >
            <div class="container-fluid">
                <a class="navbar-brand" data-nav="main">Cam-Link-System</a>
                <ul class="nav d-none d-md-flex" id="nav-bar">
                    {{--Oldalválasztó megjelenítése --}}
                </ul>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel" data-nav="main">Cam-Link-System</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" id="nav-side-menu">
                        </ul>
                    </div>
                </div>
            </div>
            {{--bug: Miért nem lehet meghívni a onclick="logOut()"--}}
        </nav>
        <div class="alert" id="alert">

        </div>
    </header>
    <main id="mainContent" style="color: white" class="">
        <div class="" style="color:white; margin: 1rem; display: inline-block">
            <h2>Rögtitők</h2>
            <ul style="display: inline-block">
                <li>Új rögzitő hozzáadása:</li>
                <li>Új ügyfél hozzáadása:</li>
            </ul>
        </div>
        <div>
            <table border="1" style="margin: 1rem; display: block; justify-content: center;">
                <thead style="margin:0 auto">
                <tr>
                    <th>#</th>
                    <th> Rögzitő neve:</th>
                    <th> Ügyfél neve:</th>
                    <th> Müvelet:</th>
                </tr>
                </thead>
            </table>
            <button class="btn btn-primary">daékhj</button>
        </div>
    </main>
    <footer>
        <ul>
            <li>Fejlesző: &copy  Bihacsy László</li>
            <li>A project portfolió céljábol készűlt! Felelőtlen használatért felelőség a fejlesztőt nem terheli!</li>
        </ul>
    </footer>
    </body>
</html>
