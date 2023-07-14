<body class="bg-light">
    <div style="width: 100vw; height: 100vh; max-height: 100vh; max-width: 100vw;" class="d-flex overflow-hidden">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4">{{ __('lang.siteName') }}</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="mb-3">
                    <a href="/area" class="nav-link{{ Request::is('area', '/') ? ' active' : '' }} text-white">
                        {{ __('lang.area') }}
                    </a>
                </li>
                <li class="mb-3">
                    <a href="/menu" class="nav-link{{ Request::is('menu') ? ' active' : '' }} text-white">
                        {{ __('lang.menu') }}
                    </a>
                </li>
                <li class="mb-3">
                    <a href="/news" class="nav-link{{ Request::is('news') ? ' active' : '' }} text-white">
                        {{ __('lang.news') }}
                    </a>
                </li>
                <li class="mb-3">
                    <a href="/admin" class="nav-link{{ Request::is('admin') ? ' active' : '' }} text-white">
                        {{ __('lang.adminSetting') }}
                    </a>
                </li>
                <li class="mb-3">
                    <a href="/role-permission" class="nav-link{{ Request::is('role-permission') ? ' active' : '' }} text-white">
                        {{ __('lang.rolePermission') }}
                    </a>
                </li>
            </ul>
            <span class="d-flex align-items-center">
                <span class="me-2">{{ app()->getLocale() === 'zh' ? '語言：' : 'Language:' }}</span>
                <a href="/lang/zh" class="text-white text-decoration-none">繁體中文</a>
                <span class="mx-2">/</span>
                <a href="/lang/en" class="text-white text-decoration-none">English</a>
            </span>
            <hr>
            <span class="d-flex justify-content-between align-items-center">
                <p class="m-0">{{ __('lang.version') }} v{{ config('versions.version') }}</p>
                <a href="/logout" class="text-white text-decoration-none">{{ __('lang.logout') }}</a>
            </span>
        </div>
        <div class="w-100" style="max-height: 100vh">
            {{ $slot }}
        </div>
    </div>
</body>