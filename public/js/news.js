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
    let data = $('#newForms').serialize();
    try {
        const res = await axios.post('/api/news', data);
        alert('新增成功');
        window.location.href = '/news';
    } catch (err) {
        const message = err.response.data.message;
        alert(message);
    }
}

const updateForm = async () => {
    let data = $('#newForms').serialize();
    try {
        const res = await axios.put('/api/news/' + getUrlId(), data);
        alert('更新成功');
        window.location.href = '/news';
    } catch (err) {
        const message = err.response.data.message;
        alert(message);
    }
}

const setAreaOption = (data) => {
    var areaSelect = $('select[name="area-ui"]');
    areaSelect.append("<option disabled selected>請選擇區域</option>");
    if (Array.isArray(data)) {
        data.forEach(function (area) {
            var option = $('<option>').attr('value', area.id).text(area.name);
            areaSelect.append(option);
        });
    }
}

const setMenuOption = (data) => {
    var menuSelect = $('select[name="menu"]');
    menuSelect.append("<option disabled selected>請選擇選單</option>");
    if (Array.isArray(data)) {
        data.forEach(function (menu) {
            var option = $('<option>').attr('value', menu.id).text(menu.name);
            menuSelect.append(option);
        });
    }
}

const setAreaOnChangeListner = () => {
    $('select[name="area-ui"]').on('change', function () {
        var selectedOption = $(this).val();
        if (selectedOption) {
            if (areaSelect.indexOf(selectedOption) === -1) {
                areaSelect.push(selectedOption);
            } else {
                areaSelect.splice(areaSelect.indexOf(selectedOption), 1);
            }
        }
        $('#result').html(areaSelect.map(area => `<span class="badge bg-secondary me-2 mt-4">${area}</span>`).join(''));
        $('input[name="area"]').val(areaSelect.join(','));
    });
}

const getNewsById = async (id) => {
    const news = await axios.get(`/api/news/${id}`);
    return news.data;
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
    $('textarea[name="content"]').val(data.content);
    $('select[name="menu"]').val(data.menu);
    areaSelect = data.area;
    $('#result').html(areaSelect.map(area => `<span class="badge bg-secondary me-2 mt-4">${area}</span>`).join(''));
    $('input[name="area"]').val(areaSelect.join(','));
}