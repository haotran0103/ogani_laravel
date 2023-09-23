<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @php
    $backgroundImage = asset('resources/assets/images/golden.jpg');
    @endphp

    <style>
        body {
            background-image: url('{{ $backgroundImage }}');;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center center;
            height: 100vh; /* Đảm bảo ảnh nền chiếm toàn bộ chiều cao của màn hình */
        }

        .card {
            background-color: rgba(255, 255, 255, 0.7);
        }

    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Đăng nhập</div>
                    <div class="card-body">
                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="username">email đăng nhập:</label>
                                <input type="email" class="form-control" id="v" name="email" required>
                                <span class="text-danger">@error('email') {{$message}} @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <span class="text-danger">@error('password') {{$message}} @enderror
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Nhớ đăng nhập
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                        </form>
                        <div class="mt-3">
                            <p class="text-center">Chưa có tài khoản? <a href="{{route('register')}}">Đăng ký ngay</a></p>
                            <p class="text-center"><a href="#">Quên mật khẩu?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2
