<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield("title") - ORM Manager1</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.2.3/css/bulma.css" />
</head>
<body>
<div id="app">
    <nav class="nav">
        <div class="container">
            <div class="nav-left">
                <a class="nav-item is-brand" href="#">
                    <img src="http://bulma.io/images/bulma-type.png" alt="Bulma logo">
                </a>
            </div>
            <div class="nav-right">
                @yield("nav-items")
                <a class="nav-item is-brand" href="#">
                    Home
                </a>
                <a class="nav-item is-brand" href="#">
                    Models
                </a>
                @show
            </div>
        </div>

    </nav>

    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column">
                    @section('sidebar')
                        <aside class="menu">
                            <p class="menu-label">
                                General
                            </p>
                            <ul class="menu-list">
                                <li><a href="{{ route('dashboard') }}" class="{{Request::route()->getName() == 'dashboard' ? 'is-active' : ''}}">Dashboard</a></li>
                                <li><a href="{{ route('models') }}" class="{{Request::route()->getName() == 'models' ? 'is-active' : ''}}">Models</a></li>
                            </ul>

                            @yield("sidebar-nav")

                        </aside>
                    @show
                </div>
                <div class="column is-three-quarters">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="container">
            <div class="content has-text-centered">
                @section('footer')
                    <p>
                        <strong>ORM Manager</strong> by <a href="http://boshkov.tech">Ilija Boshkov</a>. The source code is licensed
                        <a href="http://opensource.org/licenses/mit-license.php">MIT</a>.
                    </p>
                    <p>
                        <a class="icon" href="https://github.com/iboshkov/orm-manager">
                            <i class="fa fa-github"></i>
                        </a>
                    </p>
                @show
            </div>
        </div>
    </footer>
</div>

</body>
<script src="/js/app.js"></script>

</html>