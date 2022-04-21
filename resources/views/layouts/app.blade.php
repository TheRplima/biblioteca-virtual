<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&family=Poppins:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
  </head>
  <body>
    <header id="header">
        <?php
         $title = explode(' ',config('app.name', 'Laravel'));
         if (count($title) > 1){
             $title = $title[0].'<span>'.$title[count($title)-1].'</span>';
         }
        ?>
        <nav class="container "><a class="logo" href="/">{!! $title !!}</span></a>
            <div class="menu">
                <ul class="grid">
                    <li><a class="title" href="/">Home</a></li>
                    @if (Auth::guest())
                    <li>
                      <a class="title" href="{{ url('/auth/login') }}">Login</a>
                    </li>
                    <li>
                      <a class="title" href="{{ url('/auth/register') }}">Register</a>
                    </li>
                    @else
                        @if (Auth::user()->can_post())
                        <li>
                        <a class="title" href="{{ url('/new-book') }}">Add new book</a>
                        </li>
                        <li>
                        <a class="title" href="{{ url('/user/'.Auth::id().'/books') }}">My Books</a>
                        </li>
                        @endif
                        <li>
                        <a class="title" href="{{ url('/user/'.Auth::id()) }}">My Profile</a>
                        </li>
                        <li>
                            <a class="title" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('frm-logout').submit();">Logout</a>
                            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="toggle icon-menu"><ion-icon name="menu-outline"></ion-icon></div>
            <div class="toggle icon-close"><ion-icon name="close-outline"></ion-icon></div>
        </nav>
    </header>
    <main>
        @if (Session::has('message'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <ul class="panel-body">
            @foreach ( $errors->all() as $error )
            <li>
              {{ $error }}
            </li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <section class="section" id="home">
            <div class="container">
                <div class="card">
                    <h5 class="card-header">@yield('title')</h5>
                    <div class="card-body">
                        @yield('content')
                    </div>
                    <div class="card-footer text-muted">
                        @yield('title-meta')
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="section" id="#footer">
        <div class="container grid">
            <div class="brand"><a class="logo logo-alt" href="/">{!! $title !!}</a>
                <p>©2022 {{config('app.name', 'Laravel')}}</p>
                <p>All rights reserved.</p>
            </div>
            <div class="social grid">
                <a href="https://www.instagram.com/pegaemprestimos" target="_blank" rel="noreferrer"><ion-icon name="logo-instagram"></ion-icon></a>
                <a href="https://www.facebook.com/pegaemprestimos" target="_blank" rel="noreferrer"><ion-icon name="logo-facebook"></ion-icon></a>
                <a href="https://twitter.com/pegaemprestimos" target="_blank" rel="noreferrer"><ion-icon name="logo-twitter"></ion-icon></a>
            </div>
        </div>
    </footer>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="/js/scripts.js"></script>
  </body>
</html>
