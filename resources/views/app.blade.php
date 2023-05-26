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
    <nav>
        <ul>
            <li>Cam-link-System</li>
            <li>Bejelentkezés</li>
            <li>Kapcsolat</li>
        </ul>
    </nav>
        <div class="hidden" id="alert">
            <div class="alert alert-warning alert-active">

            </div>
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
<script>
    (function (){
        const csrfToken = document.head.querySelector('meta[name="csft_token"]').content;
        console.log(csrfToken)
            if (csrfToken){
                localStorage.setItem('csrfToken',csrfToken)
            }
        }
    )();
</script>
</html>
