const getNews = async () => {
    const news = await axios.get('/api/news');
    return news.data;
}

const initDataTable = () => {
    $('#myTable').DataTable({
        language: {
            "lengthMenu": "每頁 _MENU_ 筆資料",
            "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
            "paginate": {
                "previous": "上一頁",
                "next": "下一頁"
            },
            "search": "查詢:",
            "zeroRecords": "無符合資料",
            "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
            "emptyTable": "沒有資料",
            "infoFiltered": "(從 _MAX_ 筆資料中過濾)",
        },
        autoWidth: false,
    });
}
const handleDeleteNews = async (id) => {
    if (!confirm('確定要刪除此筆資料？')) return;

    const res = await axios.delete('/api/news/' + id);
    if (res.data.status == "success") {
        window.location.reload();
    } else {
        alert('刪除失敗');
    }
}

const setNewsList = (data) => {
    let html = '';
    data.forEach(item => {
        let statusBadge;
        if (item.status == 0) {
            statusBadge = '<span class="badge bg-danger">隱藏</span>';
        } else if (item.status == 1) {
            statusBadge = '<span class="badge bg-success">顯示</span>';
        } else {
            statusBadge = '<span class="badge bg-warning">未知</span>';
        }

        html += `
            <tr>
              <td>
                ${item.area.map(area => `<span class="badge bg-secondary me-2">${area}</span>`).join('')}
              </td>
              <td>${item.menu}</td>
              <td>${item.title}</td>
              <td>${statusBadge}</td>
              <td class="d-flex">
                <a class="btn btn-warning me-3" href=${"/news/edit/" + item._id}>修改</a>
                <button type="button" class="btn btn-danger delete-btn" id=${item._id}>刪除</button>
              </td>
            </tr>
          `;
    });
    $('tbody').html(html);
    initDataTable();
    $('.delete-btn').on('click', function () {
        const id = $(this).attr('id');
        handleDeleteNews(id);
    })
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
            var option = $('<option>').attr('value', area._id).text(area.name);
            areaSelect.append(option);
        });
    }
}

const setMenuOption = (data) => {
    var menuSelect = $('select[name="menu"]');
    menuSelect.append("<option disabled selected>請選擇選單</option>");
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
            id: $(this).val(),
            name: $(this).find('option:selected').text()
        };
        // check if the option is already selected, if yes, delete it
        let index = areaSelect.findIndex(option => option.id == selectedOption.id);
        if (index > -1) {
            areaSelect.splice(index, 1);
        } else {
            areaSelect.push(selectedOption);
        }
        $('#result').html(areaSelect.map(area => `<span class="badge bg-secondary me-2 mt-4">${area.name}</span>`).join(''));
        let areaIds = areaSelect.map(option => option.id);
        $('input[name="area"]').val(areaIds.join(','));
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
    $('#result').html(areaSelect.map(area => `<span class="badge bg-secondary me-2 mt-4">${area.name}</span>`).join(''));
    $('input[name="area"]').val(areaSelect.join(','));
}