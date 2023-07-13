const initDataTable = () => {
    $('#adminList').DataTable({
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
        }
    });
}

const fetchAdminList = async () => {
    const res = await axios.get('/api/admin');
    return res.data;
}

const formatDateTime = (date) => {
    const d = new Date(date);
    const year = d.getFullYear();
    const month = d.getMonth() + 1;
    const day = d.getDate();
    const hour = (d.getHours() < 10) ? '0' + d.getHours() : d.getHours();
    const min = (d.getMinutes() < 10) ? '0' + d.getMinutes() : d.getMinutes();
    const sec = (d.getSeconds() < 10) ? '0' + d.getSeconds() : d.getSeconds();
    return `${year}-${month}-${day} ${hour}:${min}:${sec}`;
}

const deleteAdmin = async (id) => {
    const confirmDelete = confirm('確定要刪除嗎？');
    if (!confirmDelete) return;

    const res = await axios.delete('/api/admin/' + id);
    if (res.data.status == 200) {
        window.location.reload();
    } else {
        alert('刪除失敗');
    }
}

const editAdmin = async (id) => {
    window.location.href = '/admin/edit/' + id;
}

const setAdminList = (adminList) => {
    const table = $('#adminList').DataTable();
    table.clear().draw();
    adminList.forEach((admin, index) => {
        const { _id, username, name, status, updated_at, created_at } = admin;
        table.row.add([
            username,
            name,
            formatDateTime(updated_at),
            formatDateTime(created_at),
            status === '1' ? '<span class="badge bg-success">啟用</span>' : '<span class="badge bg-danger">停用</span>',
            `<button type="button" class="btn btn-warning" onclick="editAdmin('${_id}')">修改</button>
            <button type="button" class="btn btn-danger" onclick="deleteAdmin('${_id}')">刪除</button>`
        ]).draw(false);
    });
}

const submitForm = async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    try {
        const res = await axios.post('/api/admin', formData);
        if (res.data.status == 200) {
            alert('新增成功');
            window.location.href = '/admin';
        } else {
            alert('新增失敗');
        }
    } catch (err) {
        const message = err.response.data.message;
        alert(message);
    }
}

const submitEditForm = async (e) => {
    e.preventDefault();
    const id = window.location.pathname.split('/').pop();
    const formData = $(e.target).serialize();
    try {
        const res = await axios.put('/api/admin/' + id, formData);
        console.log(res);
        if (res.data.status == 200) {
            alert('修改成功');
            window.location.href = '/admin';
        } else {
            alert('修改失敗');
        }
    } catch (err) {
        const message = err.response.data.message;
        alert(message);
    }
}

const initEditForm = async () => {
    const id = window.location.pathname.split('/').pop();
    const res = await axios.get('/api/admin/' + id);
    const admin = res.data;
    const { username, name, email, status } = admin;
    $('#username').val(username);
    $('#name').val(name);
    $('#email').val(email);
    $(' input[name="status"][value="' + status + '"]').prop('checked', true);
    $('#resetPasswordLink').attr('href', '/admin/reset-password/' + id);
}

const submitResetPasswordForm = async (e) => {
    e.preventDefault();
    const id = window.location.pathname.split('/').pop();
    const formData = $(e.target).serialize();
    try {
        const res = await axios.post('/api/admin/reset-password/' + id, formData);
        if (res.data.status == 200) {
            alert('修改成功');
            window.location.href = '/admin';
        } else {
            alert('修改失敗');
        }
    } catch (err) {
        const message = err.response.data.message;
        alert(message);
    }
}