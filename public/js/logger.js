// route 網址的第一層對應為各功能的名稱
const routeMap = {
    'area': '區域',
    'menu': '選單',
    'news': '最新消息',
    'admin': '管理者設定',
    'role-permission': '角色權限',
    'log': '操作紀錄',
    'logger': '操作紀錄',
    'lang': '語系',
    'login': '登入',
    'logout': '登出',
    '': '首頁',
}

const getLog = async (urlQuery) => {
    const res = await axios.get('/api/logger', {
        params: urlQuery
    });
    console.log(res.data);

    // 將路由網址對應成頁面功能名稱
    res.data.data.forEach(item => {
        if (item.route.split('/')[0] === 'api') {
            item.route = '[API] ' + routeMap[item.route.split('/')[1]];
        } else {
            item.route = routeMap[item.route.split('/')[0]];
        }
    });


    return res.data;
}

const setRouteSelectOption = () => {
    for (const key in routeMap) {
        $('#route').append(`<option value="${key}">${routeMap[key]}</option>`);
    }
}

const setLogList = (data) => {
    let html = '';
    const logListPagination = data.data;

    if (logListPagination.length == 0) {
        html = `
            <tr>
                <td colspan="7" class="text-center">${__['noSearchResult']}</td>
            </tr>
        `;
        $('tbody').html(html);
        return;
    }

    logListPagination.forEach(item => {

        html += `
            <tr>
                <td>${item.user}</td>
                <td>${item.ip}</td>
                <td>${item.route}</td>
                <td>${item.method}</td>
                <td class="break-word" title="${JSON.stringify(item.request)}">${JSON.stringify(item.request)}</td>
                <td class="break-word" title="${JSON.stringify(item.response)}">${JSON.stringify(item.response)}</td>
                <td>${item.time}</td>
            </tr>
        `;
    });
    $('tbody').html(html);
}

const setPagination = (data) => {
    $('#dataCount').text(data.total);
    $('#perPage').val(data.per_page);
    let html = '';
    if (data.total == 0) {
        $('#pagination').html(html);
        return;
    }
    let page = data.current_page;
    let totalPage = data.last_page;
    let prevPage = page - 1;
    let nextPage = page + 1;
    let prevDisabled = page == 1 ? 'disabled' : '';
    let nextDisabled = page == totalPage ? 'disabled' : '';
    const originalUrl = new URL(window.location.href);
    const searchParams = new URLSearchParams(originalUrl.search);

    let prevHtml = `
        <li class="page-item ${prevDisabled}">
            <a class="page-link" href="${updatePageQueryParam(searchParams, prevPage)}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    `;

    let nextHtml = `
        <li class="page-item ${nextDisabled}">
            <a class="page-link" href="${updatePageQueryParam(searchParams, nextPage)}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    `;

    let pageHtml = '';

    // 頁數超過 5 頁，只顯示 5 頁，左右加上...到第一頁和最後一頁
    if (totalPage > 5) {
        if (page <= 3) {
            for (let i = 1; i <= 5; i++) {
                let active = page == i ? 'active' : '';
                pageHtml += `
                    <li class="page-item ${active}"><a class="page-link" href="${updatePageQueryParam(searchParams, i)}">${i}</a></li>
                `;
            }
            pageHtml += `
                <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="${updatePageQueryParam(searchParams, totalPage)}">${totalPage}</a></li>
            `;
        } else if (page >= totalPage - 2) {
            pageHtml += `
                <li class="page-item"><a class="page-link" href="${updatePageQueryParam(searchParams, 1)}">1</a></li>
                <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
            `;
            for (let i = totalPage - 4; i <= totalPage; i++) {
                let active = page == i ? 'active' : '';
                pageHtml += `
                    <li class="page-item ${active}"><a class="page-link" href="${updatePageQueryParam(searchParams, i)}">${i}</a></li>
                `;
            }
        } else {
            pageHtml += `
                <li class="page-item"><a class="page-link" href="${updatePageQueryParam(searchParams, 1)}">1</a></li>   
                <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
            `;
            for (let i = page - 2; i <= page + 2; i++) {
                let active = page == i ? 'active' : '';
                pageHtml += `
                    <li class="page-item ${active}"><a class="page-link" href="${updatePageQueryParam(searchParams, i)}">${i}</a></li>
                `;
            }
            pageHtml += `
                <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="${updatePageQueryParam(searchParams, totalPage)}">${totalPage}</a></li>
            `;
        }

    } else {
        for (let i = 1; i <= totalPage; i++) {
            let active = page == i ? 'active' : '';
            pageHtml += `
                <li class="page-item ${active}"><a class="page-link" href="${updatePageQueryParam(searchParams, i)}">${i}</a></li>
            `;
        }
    }

    function updatePageQueryParam(searchParams, newPage) {
        searchParams.set('page', newPage);
        return `${originalUrl.pathname}?${searchParams.toString()}${originalUrl.hash}`;
    }

    html = prevHtml + pageHtml + nextHtml;
    $('#pagination').html(html);
}


const getUrlQuery = () => {
    const url = window.location.href;
    const params = url.substring(url.lastIndexOf('?') + 1).split('&');
    const query = {};
    params.forEach(param => {
        const [key, value] = param.split('=');
        if (key === 'datetimes') {
            query[key] = decodeURIComponent(value);
            return;
        }
        query[key] = value;
    });
    return query;
}

const handleQuery = async () => {
    const params = {
        username: $('#username').val(),
        route: $('#route').val(),
        method: $('#method').val(),
        datetimes: $('#datetimes').val(),
        perPage: $('#perPage').val(),
    };

    const queryParams = [];

    for (const [key, value] of Object.entries(params)) {
        if (value !== "all" && value) {
            queryParams.push(`${key}=${value}`);
        }
    }

    const url = queryParams.length > 0
        ? `/log?${queryParams.join('&')}`
        : '/log';

    window.location.href = url;
}

const setQueryForm = (query) => {
    if (query.username) {
        $('#username').val(query.username);
    }

    if (query.route) {
        $('#route').val(query.route);
    }

    if (query.method) {
        $('#method').val(query.method);
    }

    if (query.datetimes) {
        datetimes = decodeURIComponent(query.datetimes);
        $('#datetimes').val(datetimes);
        console.log(datetimes.split(' - ')[0]);
        initDateRangePicker(moment(datetimes.split(' - ')[0], 'M/D h:mm A'), moment(datetimes.split(' - ')[1], 'M/D h:mm A'));
    }
}

const initDateRangePicker = (startDate = null, endDate = null) => {
    if (startDate && endDate) {

        $('input[name="datetimes"]').daterangepicker({
            timePicker: true,
            startDate: startDate,
            endDate: endDate,
            locale: {
                format: 'M/DD hh:mm A',
            }
        })
    } else {
        $('input[name="datetimes"]').daterangepicker({
            autoUpdateInput: false,
            timePicker: true,
            locale: {
                format: 'M/DD hh:mm A',
            }
        })
        $('input[name="datetimes"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('M/DD hh:mm A') + ' - ' + picker.endDate.format('M/DD hh:mm A'));
        });
    }
    $('input[name="datetimes"]').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });
}