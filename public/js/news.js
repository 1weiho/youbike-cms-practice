const getNews = async (urlQuery) => {
    const res = await axios.get('/api/news', {
        params: urlQuery
    });
    return res.data;
}

const initEditor = async (content) => {
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            if (content) {
                editor.setData(content);
            }
        })
        .catch(error => {
            console.error(error);
        });
}

const handleDeleteNews = async (id) => {
    if (!confirm(`${__['confirmDeleteData']}`)) return;

    try {
        const res = await axios.delete('/api/news/' + id);
        window.location.reload();
    } catch (err) {
        const message = err.response.data.message;
        alert(message);
    }
}

const setNewsList = (data) => {
    let html = '';
    const newsListPagination = data.data;
    const canUpdate = data.canUpdate;
    const canDelete = data.canDelete;

    if (newsListPagination.data.length == 0) {
        html = `
            <tr>
                <td colspan="5" class="text-center">${__['noSearchResult']}</td>
            </tr>
        `;
        $('tbody').html(html);
        return;
    }

    newsListPagination.data.forEach(item => {
        let statusBadge;
        if (item.status == 0) {
            statusBadge = `<span class="badge bg-danger">${__['hide']}</span>`;
        } else if (item.status == 1) {
            statusBadge = `<span class="badge bg-success">${__['display']}</span>`;
        } else {
            statusBadge = `<span class="badge bg-warning">${__['unknown']}</span>`;
        }

        html += `
            <tr>
                <td>
                    ${item.area.map(area => `<span class="badge bg-secondary me-2">${area.name}</span>`).join('')}
                </td>
                <td>${item.menu.name}</td>
                <td>${item.title}</td>
                <td>${statusBadge}</td>
                <td>
                    ${canUpdate ? `<a class="btn btn-warning me-3" href="/news/edit/${item._id}">${__['modify']}</a>` : ''}
                    ${canDelete ? `<button type="button" class="btn btn-danger delete-btn" id="${item._id}">${__['delete']}</button>` : ''}
                </td>
            </tr>
        `;
    });
    $('tbody').html(html);
    $('.delete-btn').on('click', function () {
        const id = $(this).attr('id');
        handleDeleteNews(id);
    })
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
    for (let i = 1; i <= totalPage; i++) {
        let active = page == i ? 'active' : '';
        pageHtml += `
            <li class="page-item ${active}"><a class="page-link" href="${updatePageQueryParam(searchParams, i)}">${i}</a></li>
        `;
    }

    function updatePageQueryParam(searchParams, newPage) {
        searchParams.set('page', newPage);
        return `${originalUrl.pathname}?${searchParams.toString()}${originalUrl.hash}`;
    }

    html = prevHtml + pageHtml + nextHtml;
    $('#pagination').html(html);
}

const getUrlId = () => {
    const url = window.location.href;
    return url.substring(url.lastIndexOf('/') + 1);
}

const getArea = async () => {
    const area = await axios.get('/api/area');
    return area.data;
}

const getMenu = async () => {
    const menu = await axios.get('/api/menu');
    return menu.data;
}

const submitForm = async () => {
    await new Promise(resolve => setTimeout(resolve, 100));

    let formData = new FormData(document.getElementById('newForms'));
    let imageFile = document.getElementById('coverUpload').files[0];
    formData.append('image', imageFile);

    try {
        const res = await axios.post('/api/news', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        alert(`${__['addSuccess']}`);
        window.location.href = '/news';
    } catch (err) {
        const message = err.response.data.message;
        alert(message);
    }
}


const updateForm = async () => {
    await new Promise(resolve => setTimeout(resolve, 100));

    let formData = new FormData(document.getElementById('newForms'));
    let imageFile = document.getElementById('coverUpload').files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }
    try {
        const newsId = getUrlId();
        const res = await axios.post(`/api/news/${newsId}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        alert(`${__['updateSuccess']}`);
        window.location.href = '/news';
    } catch (err) {
        const message = err.response.data.message;
        alert(message);
    }
}

const setAreaOption = (data) => {
    var areaSelect = $('select[name="area-ui"]');
    if (Array.isArray(data)) {
        data.forEach(function (area) {
            var option = $('<option>').attr('value', area._id).text(area.name);
            areaSelect.append(option);
        });
    }
}

const setMenuOption = (data) => {
    var menuSelect = $('select[name="menu"]');
    if (Array.isArray(data)) {
        data.forEach(function (menu) {
            var option = $('<option>').attr('value', menu._id).text(menu.name);
            menuSelect.append(option);
        });
    }
}

const setAreaOnChangeListner = () => {
    $('select[name="area-ui"]').on('change', function () {
        let selectedOption = {
            _id: $(this).val(),
            name: $(this).find('option:selected').text()
        };
        let index = areaSelect.findIndex(option => option._id == selectedOption._id);
        if (index > -1) {
            areaSelect.splice(index, 1);
        } else {
            areaSelect.push(selectedOption);
        }
        $('#result').html(areaSelect.map(area => `<span class="badge bg-secondary me-2 mt-4" style="cursor: pointer;" onClick="handleBadgeClickRemove('${area.id}')">${area.name} X</span>`).join(''));
        let areaIds = areaSelect.map(option => option._id);
        $('input[name="area"]').val(areaIds.join(','));
    });
}

const getNewsById = async (id) => {
    const news = await axios.get(`/api/news/${id}`);
    return news.data;
}

const handleBadgeClickRemove = (id) => {
    let index = areaSelect.findIndex(option => option._id == id);
    if (index > -1) {
        areaSelect.splice(index, 1);
    }
    $('#result').html(areaSelect.map(area => `<span class="badge bg-secondary me-2 mt-4" style="cursor: pointer;" onClick="handleBadgeClickRemove('${area.id}')">${area.name} X</span>`).join(''));
    let areaIds = areaSelect.map(option => option._id);
    $('input[name="area"]').val(areaIds.join(','));
}

const setNewsFormData = (data) => {
    $('input[name="start_at"]').val(data.start_at);
    $('input[name="end_at"]').val(data.end_at);
    if (data.status == 1) {
        $('#statusShow').prop('checked', true);
    } else {
        $('#statusHide').prop('checked', true);
    }
    $('input[name="title"]').val(data.title);
    $('select[name="menu"]').val(data.menu._id);
    areaSelect = data.area;
    $('#result').html(areaSelect.map(area => `<span class="badge bg-secondary me-2 mt-4" style="cursor: pointer;" onClick="handleBadgeClickRemove('${area._id}')">${area.name} X</span>`).join(''));
    const idArray = areaSelect.map(obj => obj._id);
    $('input[name="area"]').val(idArray.join(','));

    if (data.cover) {
        const domain = window.location.origin;
        const coverUrl = `${domain}/images/${data.cover}`;
        $('#coverPreview').attr('src', coverUrl);
    }
}

const getUrlQuery = () => {
    const url = window.location.href;
    const params = url.substring(url.lastIndexOf('?') + 1).split('&');
    const query = {};
    params.forEach(param => {
        const [key, value] = param.split('=');
        if (key === 'title') {
            query[key] = decodeURIComponent(value);
            return;
        }
        query[key] = value;
    });
    return query;
}

const handleQuery = async () => {
    const params = {
        areaId: $('#area').val(),
        menuId: $('#menu').val(),
        status: $('#status').val(),
        perPage: $('#perPage').val(),
        title: $('#title').val(),
    };

    const queryParams = [];

    for (const [key, value] of Object.entries(params)) {
        if (value !== "all" && value) {
            queryParams.push(`${key}=${value}`);
        }
    }

    const url = queryParams.length > 0
        ? `/news?${queryParams.join('&')}`
        : '/news';

    window.location.href = url;

}

const setQueryForm = (query) => {
    if (query.areaId) {
        $('#area').val(query.areaId);
    }

    if (query.menuId) {
        $('#menu').val(query.menuId);
    }

    if (query.status) {
        $('#status').val(query.status);
    }

    if (query.title) {
        $('#title').val(query.title);
    }
}

const setCoverUploadListener = () => {
    $('#coverUpload').on('change', function () {
        const file = $(this)[0].files[0];
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#coverPreview').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
    });
}

const initExportBtn = (query) => {
    const url = window.location.href;
    if (!url.includes('?')) return;
    const params = url.substring(url.lastIndexOf('?') + 1);

    const xlsxUrl = `/news/export/xlsx?${params}`;
    const csvUrl = `/news/export/csv?${params}`;
    $('#exportXlsxBtn').attr('href', xlsxUrl);
    $('#exportCsvBtn').attr('href', csvUrl);
}

const setImportListener = () => {
    $('#importForm').submit(async function (event) {
        event.preventDefault();
        var form = $(this);
        var formData = new FormData(form[0]);

        try {
            const response = await axios.post(form.attr('action'), formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                responseType: 'blob', // 設定回應的數據類型為 blob
            });

            // 使用 Blob 和 URL.createObjectURL 方法來下載檔案
            const blob = new Blob([response.data], { type: 'application/octet-stream' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = '匯入結果.xlsx';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);

            // 成功後關閉 Modal
            $('#exampleModal').modal('hide');
            await new Promise(resolve => setTimeout(resolve, 250));
            alert("匯入成功");
            window.location.reload();
        } catch (error) {
            // 處理錯誤情況
            console.error(error);
            alert("匯入失敗");
            window.location.reload();
        }
    });
}