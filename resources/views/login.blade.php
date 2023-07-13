<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</head>
<title>官網後台系統 - 登入</title>
</head>

<body class="bg-light d-flex justify-content-center algin-items-center" style="width: 100vw; height: 100vh;">
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h2 class="mb-5">YouBike 官網後台系統</h2>
        <div class="bg-white rounded p-3 shadow-sm" style="width: 35vw;">
            <form method="POST" action="{{ route('admin.login') }}" class="p-5 d-flex flex-column align-items-center">
                @csrf
                <h5 class="mb-4">請輸入帳號密碼登入系統</h5>
                <div class="form-outline mb-4 w-100">
                    <select class="form-select w-100">
                        <option selected disabled>選擇語言</option>
                        <option value="1">繁體中文</option>
                        <option value="2">English</option>
                    </select>
                </div>
                <div class="form-outline mb-4 w-100">
                    <input type="text" name="username" placeholder="請輸入帳號" value="{{ old('username') }}"
                        class="form-control" />
                    @if ($errors->has('username'))
                    <span class="text-danger">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="form-outline mb-4 w-100">
                    <input type="password" name="password" placeholder="請輸入密碼" class="form-control" />
                    @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary btn-block">登入</button>
            </form>
        </div>
    </div>

</body>

</html>