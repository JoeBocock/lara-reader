<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ URL::asset('css/terminal.css') }}">
        <title>LaraReader</title>
    </head>
    <body>

    <!-- Navigation -->
    <section id="nav" class="container">
        <div class="terminal-nav" role="navigation">
            <div class="terminal-logo">
                <div class="logo terminal-prompt">
                    <a href="/" class="no-style">Lara-reader</a>
                </div>
            </div>
            <nav class="terminal-menu">
                <ul>
                    <li>
                        <a class="menu-item active" href="/" role="menuitem"
                            >Home</a
                        >
                    </li>
                    <li>
                        <a id="add-feed" class="menu-item" href="#" role="menuitem"
                            >Add Feed</a
                        >
                    </li>
                </ul>
            </nav>
        </div>
    </section>

        <section id="content" class="container">
            @yield('content')
        </section>
    </body>
</html>
