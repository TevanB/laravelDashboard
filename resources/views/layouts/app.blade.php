<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bd-wizard.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
      .chat {
        list-style: none;
        margin: 0;
        padding: 0;
      }

      .chat li {
        margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 1px dotted #B3A9A9;
      }

      .chat li .chat-body p {
        margin: 0;
        color: #777777;
      }

      .panel-body {
        overflow-y: scroll;
        height: 350px;
      }

      ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        background-color: #F5F5F5;
      }

      ::-webkit-scrollbar {
        width: 12px;
        background-color: #F5F5F5;
      }

      ::-webkit-scrollbar-thumb {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #555;
      }
    </style>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md bggrey shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/img/profile/profile.png" width="197" height="180" alt="BMS Boosting Logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                      <li class="nav-item ml-2 mr-2">
                          <a class="nav-link text-light" href="https://bmsboosting.com">Home</a>
                      </li>
                      <li class="nav-item ml-2 mr-2">
                          <a class="nav-link text-light" href="https://bms-dash.herokuapp.com/boosting">{{ __('Boosting') }}</a>
                      </li>
                      <li class="nav-item ml-2 mr-2">
                          <a class="nav-link text-light" href="https://bmsboosting.com/coaching">Coaching</a>
                      </li>
                      <li class="nav-item ml-2 mr-2">
                          <a class="nav-link text-light" href="https://bmsboosting.com/account-selling">Accounts</a>
                      </li>
                      <li class="nav-item ml-2 mr-2">
                          <a class="nav-link text-light" href="https://bmsboosting.com/reviews">Reviews</a>
                      </li>
                      <li class="nav-item ml-2 mr-2">
                          <a class="nav-link text-light" href="https://bmsboosting.com/team">Team</a>
                      </li>
                      <li class="nav-item dropdown ml-2 mr-2">
                          <a id="navbarDropdown" class="nav-link text-light dropdown-toggle" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Help Centre<span class="caret"></span></a>
                          <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item text-light" href="https://bmsboosting.com/tos">
                                  Terms of Service
                              </a>
                              <a class="dropdown-item text-light" href="https://bmsboosting.com/faq">
                                  F.A.Q.
                              </a>
                              <a class="dropdown-item text-light" href="https://bmsboosting.com/contact-us">
                                  Contact Us
                              </a>
                              <a class="dropdown-item text-light" href="https://bmsboosting.com/booster-applications">
                                  Join Our Team
                              </a>
                          </div>
                      </li>
                      <li class="nav-item ml-2 mr-2">
                        <i class="fas fa-shopping-cart" href="https://bmsboosting.com/cart"></i>

                      </li>
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link text-light" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-light" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item text-light" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 bg-dark">
            @yield('content')
        </main>

    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <script src="assets/js/jquery.steps.min.js"></script>
    <script src="assets/js/bd-wizard.js"></script>
</body>
</html>
