const initDataTable = () => {
    $('#adminList').DataTable({
        language: {
            "lengthMenu": __['lengthMenu'],
            "info": __['info'],
            "paginate": {
                "previous": __['previous'],
                "next": __['next'],
            },
            "search": __['searchTable'],
            "zeroRecords": __['zeroRecords'],
            "infoEmpty": __['infoEmpty'],
            "emptyTable": __['emptyTable'],
            "infoFiltered": __['infoFiltered'],
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
    const confirmDelete = confirm(__['confirmDeleteData']);
    if (!confirmDelete) return;

    const res = await axios.delete('/api/admin/' + id);
    if (res.data.status == 200) {
        window.location.reload();
    } else {
        alert(__['deleteFail']);
    }
}

const editAdmin = async (id) => {
    window.location.href = '/admin/edit/' + id;
}

const setAdminList = (adminList) => {
    const table = $('#adminList').DataTable();
    table.clear().draw();
    adminList.forEach((admin, index) => {
        const { _id, username, name, role_permission, status, updated_at, created_at } = admin;
        table.row.add([
            username,
            name,
            role_permission.role_name,
            formatDateTime(created_at),
            formatDateTime(updated_at),
            status === '1' ? `<span class="badge bg-success">${__['enable']}</span>` : `<span class="badge bg-danger">${__['disable']}</span>`,
            `<button type="button" class="btn btn-warning" onclick="editAdmin('${_id}')">${__['modify']}</button>
            <button type="button" class="btn btn-danger" onclick="deleteAdmin('${_id}')">${__['delete']}</button>`
        ]).draw(false);
    });
}

const submitForm = async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    try {
        const res = await axios.post('/api/admin', formData);
        if (res.data.status == 200) {
            alert(__['addSuccess']);
            window.location.href = '/admin';
        } else {
            alert(__['addFail']);
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
            alert(__['modifySuccess']);
            window.location.href = '/admin';
        } else {
            alert(__['modifyFail']);
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
    console.log(admin);
    const { username, name, email, status, role_permission } = admin;
    $('#username').val(username);
    $('#name').val(name);
    $('#email').val(email);
    $(' input[name="status"][value="' + status + '"]').prop('checked', true);
    $('#rolePermission').val(role_permission._id);
    $('#resetPasswordLink').attr('href', '/admin/reset-password/' + id);
}

const submitResetPasswordForm = async (e) => {
    e.preventDefault();
    const id = window.location.pathname.split('/').pop();
    const formData = $(e.target).serialize();
    try {
        const res = await axios.post('/api/admin/reset-password/' + id, formData);
        if (res.data.status == 200) {
            alert(__['modifySuccess']);
            window.location.href = '/admin';
        } else {
            alert(__['modifyFail']);
        }
    } catch (err) {
        const message = err.response.data.message;
        alert(message);
    }
}

const fetchRolePermissionList = async () => {
    const res = await axios.get('/api/role-permission');
    return res.data;
}

const setRolePermissionOption = (rolePermissionList) => {
    const select = $('#rolePermission');
    rolePermissionList.forEach((rolePermission, index) => {
        const { _id, role_name } = rolePermission;
        select.append(`<option value="${_id}">${role_name}</option>`);
    });
}