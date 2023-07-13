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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>
<title>{{ __('lang.login') }}</title>
</head>

<body class="bg-light d-flex justify-content-center algin-items-center" style="width: 100vw; height: 100vh;">
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h2 class="mb-5">YouBike {{ __('lang.siteName') }}</h2>
        <div class="bg-white rounded p-3 shadow-sm" style="width: 35vw;">
            <form method="POST" action="{{ route('admin.login') }}" class="p-5 d-flex flex-column align-items-center">
                @csrf
                <h5 class="mb-4">{{ __('lang.pleaseEnterUsernameAndPasswordToLogin') }}</h5>
                <div class="form-outline mb-4 w-100">
                    <select class="form-select w-100" id="langSelect">
                        <option selected disabled>{{ __('lang.chooseLanguage') }}</option>
                        <option value="zh" {{ app()->getLocale() === 'zh' ? 'selected' : '' }}>繁體中文</option>
                        <option value="en"{{ app()->getLocale() === 'en' ? 'selected' : '' }}>English</option>
                    </select>
                </div>
                <div class="form-outline mb-4 w-100">
                    <input type="text" name="username" placeholder="{{ __('lang.pleaseEnterUsername') }}" value="{{ old('username') }}"
                        class="form-control" />
                    @if ($errors->has('username'))
                    <span class="text-danger">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="form-outline mb-4 w-100">
                    <input type="password" name="password" placeholder="{{ __('lang.pleaseEnterPassword') }}" class="form-control" />
                    @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary btn-block">{{ __('lang.login') }}</button>
            </form>
        </div>
    </div>

</body>

</html>

<script>
    $(document).ready(function () {
        $('#langSelect').on('change', function () {
            const lang = $(this).val();
            window.location.href = '/lang/' + lang;
        });
    });
</script>