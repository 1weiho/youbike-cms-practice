<body class="bg-light">
    <div style="width: 100vw; height: 100vh; max-height: 100vh; max-width: 100vw;" class="d-flex overflow-hidden">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4">官網後台系統</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="mb-3">
                    <a href="/area" class="nav-link{{ Request::is('area', '/') ? ' active' : '' }} text-white">
                        區域
                    </a>
                </li>
                <li class="mb-3">
                    <a href="/menu" class="nav-link{{ Request::is('menu') ? ' active' : '' }} text-white">
                        選單
                    </a>
                </li>
                <li class="mb-3">
                    <a href="/news" class="nav-link{{ Request::is('news') ? ' active' : '' }} text-white">
                        最新消息
                    </a>
                </li>
                <li class="mb-3">
                    <a href="/admin" class="nav-link{{ Request::is('admin') ? ' active' : '' }} text-white">
                        管理者設定
                    </a>
                </li>
            </ul>
            <hr>
            <span>
                版本 v{{ config('versions.version') }}
            </span>
        </div>
        <div class="w-100" style="max-height: 100vh">
            {{ $slot }}
        </div>
    </div>
</body>