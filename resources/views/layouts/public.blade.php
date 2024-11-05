<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinemera</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }
        .navbar, .footer {
            background-color: #1f1f1f;
        }
        .footer {
            padding: 10px 0;
            text-align: center;
            margin-top: 30px;
        }
        .movie-card {
            background-color: #1f1f1f;
            border: none;
        }
        .movie-title {
            font-size: 1.2em;
        }
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1040;
        }
        .auth-modal, .register-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #333;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            z-index: 1050;
            width: 300px;
        }
        .auth-modal .close, .register-modal .close {
            position: absolute;
            top: 10px;
            right: 15px;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- Шапка сайта -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="/">Cinemera</a>
    <div class="mx-auto">
        <form class="form-inline" action="{{ route('search') }}" method="GET">
            <input class="form-control mr-sm-2" type="search" name="name" placeholder="Поиск по названию" aria-label="Search">
            <select class="form-control mr-sm-2" name="genre_id" aria-label="Filter by genre">
                <option value="">Все жанры</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach
            </select>
            <button class="btn btn-outline-light" type="submit">Поиск</button>
        </form>
    </div>
    @auth
        <div id="user-section" class="user-menu">
            <span class="nav-link">{{ auth()->user()->name }}</span>
            <div class="user-menu-content">
                <a href=""
                   onclick="event.preventDefault();
                            document.getElementById('public-logout-form').submit();"
                >
                    Выйти
                </a>
                <form id="public-logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </div>
        </div>
    @else
        <ul class="navbar-nav" id="auth-section">
            <li class="nav-item">
                <a href="#" id="auth-icon" class="nav-link">
                    <i class="fa fa-user"></i>
                </a>
            </li>
        </ul>
    @endauth
</nav>

<div id="modal-overlay" class="modal-overlay"></div>

<div id="auth-modal" class="auth-modal">
    <span class="close" id="close-auth-modal">&times;</span>
    <h4 class="text-center">Авторизация</h4>
    <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Введите email">
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Войти</button>
        <p class="text-center mt-2">
            Нет аккаунта? <a href="#" id="show-register-modal">Зарегистрироваться</a>
        </p>
        <input type="hidden" name="public" value="1">
    </form>
</div>

<div id="register-modal" class="register-modal">
    <span class="close" id="close-register-modal">&times;</span>
    <h4 class="text-center">Регистрация</h4>
    <form action="{{ route('register') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Введите имя">
        </div>
        <div class="form-group">
            <label for="email-register">Email</label>
            <input type="email" class="form-control" id="email-register" name="email" placeholder="Введите email">
        </div>
        <div class="form-group">
            <label for="password-register">Пароль</label>
            <input type="password" class="form-control" id="password-register" name="password" placeholder="Введите пароль">
        </div>
        <div class="form-group">
            <label for="confirm-password">Подтверждение пароля</label>
            <input type="password" class="form-control" id="confirm-password" name="password_confirmation" placeholder="Подтвердите пароль">
        </div>
        <button type="submit" class="btn btn-success btn-block">Зарегистрироваться</button>
    </form>
</div>

@yield('content')

<footer class="footer">
    <div class="container">
        <p>&copy; 2024 Cinemera. Все права защищены.</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('#auth-icon').click(function (e) {
            e.preventDefault();
            $('#modal-overlay').show();
            $('#auth-modal').show();
        });

        $('#show-register-modal').click(function (e) {
            e.preventDefault();
            $('#auth-modal').hide();
            $('#register-modal').show();
        });

        $('#close-auth-modal, #close-register-modal, #modal-overlay').click(function () {
            $('#auth-modal, #register-modal, #modal-overlay').hide();
        });

        $('#user-section .nav-link').click(function () {
            $('#user-section .user-menu-content').toggle();
        });

        $(document).click(function (e) {
            if (!$(e.target).closest('#user-section').length) {
                $('#user-section .user-menu-content').hide();
            }
        });
    });

    function authorized_user() {
        $('#auth-section').hide();
        $('#user-section').show();
    }
</script>
</body>
</html>
