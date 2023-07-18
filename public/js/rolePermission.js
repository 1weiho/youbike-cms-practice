const initDataTable = () => {
    $('#rolePermissionList').DataTable({
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

const fetchRolePermissionList = async () => {
    const res = await axios.get('/api/role-permission');
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

const deleteRolePermission = async (id) => {
    const confirmDelete = confirm(__['confirmDeleteData']);
    if (!confirmDelete) return;

    try {
        const res = await axios.delete('/api/role-permission/' + id);
        if (res.data.status == 200) {
            window.location.reload();
        } else {
            alert(__['deleteFail']);
        }
    } catch (err) {
        const message = err.response.data.message;
        alert(message);
    }
}

const editRolePermission = async (id) => {
    window.location.href = '/role-permission/edit/' + id;
}

const setRolePermissionList = (rolePermissionList) => {
    const table = $('#rolePermissionList').DataTable();
    const canUpdate = rolePermissionList.canUpdate;
    const canDelete = rolePermissionList.canDelete;
    table.clear().draw();
    rolePermissionList.data.forEach((rolePermission, index) => {
        const { _id, role_name, account, updated_at, created_at } = rolePermission;
        table.row.add([
            role_name,
            `${account.map(account => `<span class="badge bg-secondary me-2">${account.username}</span>`).join('')}`,
            formatDateTime(created_at),
            formatDateTime(updated_at),
            (canUpdate ? `<button type="button" class="btn btn-warning" onclick="editRolePermission('${_id}')">${__['modify']}</button>` : '') +
            (canDelete ? `<button type="button" class="btn btn-danger ms-2" onclick="deleteRolePermission('${_id}')">${__['delete']}</button>` : '')
        ]).draw(false);
    });
}

const submitForm = async (e) => {
    e.preventDefault();
    const data = {
        role_name: $('#roleName').val(),
        area_permission_id: $('#areaPermission').val(),
        access_permission: getSelectTableData()
    }
    try {
        const res = await axios.post('/api/role-permission', data);
        if (res.data.status == 200) {
            alert(__['addSuccess']);
            window.location.href = '/role-permission';
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
    const data = {
        role_name: $('#roleName').val(),
        area_permission_id: $('#areaPermission').val(),
        access_permission: getSelectTableData()
    }
    try {
        const res = await axios.put('/api/role-permission/' + id, data);
        if (res.data.status == 200) {
            alert(__['modifySuccess']);
            window.location.href = '/role-permission';
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
    const res = await axios.get('/api/role-permission/' + id);
    const rolePermissionData = res.data;
    const { role_name, area_permission_id, access_permission } = rolePermissionData;
    $('#roleName').val(role_name);
    $('#areaPermission').val(area_permission_id);
    setCheckboxTable(access_permission);
}

const initCheckboxTable = () => {
    // 欄位全選按鈕點擊後，更新同一排的 checkbox 的狀態
    $('.selectAll').change(function () {
        let checkboxes = $(this).parents('tr').find('.checkbox');
        checkboxes.prop('checked', $(this).prop('checked'));
    });
    // 表單全選按鈕點擊後，更新所有 checkbox 的狀態
    $('#selectAllTable').change(function () {
        let checkboxes = $('#checkboxTable').find('.checkbox, .selectAll');
        checkboxes.prop('checked', $(this).prop('checked'));
    });
    $('.checkbox').change(function () {
        // 檢查同一排的 checkbox 是否都被勾選，更新全選的狀態
        let checkboxes = $(this).parents('tr').find('.checkbox');
        let selectAll = $(this).parents('tr').find('.selectAll');
        let isAllChecked = true;
        checkboxes.each(function () {
            if (!$(this).prop('checked')) {
                isAllChecked = false;
            }
        });
        selectAll.prop('checked', isAllChecked);
    })
    $('.checkbox, .selectAll').change(function () {
        // 檢查所有 checkbox 是否都被勾選，更新最外層的全選 checkbox 狀態
        checkboxes = $('#checkboxTable').find('.checkbox');
        selectAll = $('#selectAllTable');
        isAllChecked = true;
        checkboxes.each(function () {
            if (!$(this).prop('checked')) {
                isAllChecked = false;
            }
        });
        selectAll.prop('checked', isAllChecked);
    })
}

const setCheckboxTable = (data) => {
    let permissionTexts = {
        create: __['add'],
        read: __['browse'],
        update: __['modify'],
        delete: __['delete']
    };

    let permissionCategoryTexts = {
        area: __['area'],
        menu: __['menu'],
        news: __['news'],
        admin_setting: __['adminSetting'],
        role_permission: __['rolePermission'],
        log: '操作紀錄'
    };

    // 迭代每個欄位的全選按鈕
    $('#checkboxTable .selectAll').each(function () {
        let category = $(this).closest('tr').find('td:first-child').text().trim();

        // 使用對應表進行文字轉換
        category = Object.keys(permissionCategoryTexts).find(key => permissionCategoryTexts[key] === category);

        // 檢查 responseData 是否有該欄位的勾選資料
        if (data.hasOwnProperty(category)) {
            let permissions = data[category];

            // 迭代同一行中的其他 checkbox
            $(this).closest('td').find('.checkbox').each(function () {
                let permission = $(this).siblings('label').text().trim();

                // 使用對應表進行文字轉換
                permission = Object.keys(permissionTexts).find(key => permissionTexts[key] === permission);

                // 檢查 permissions 是否有該權限的勾選狀態
                if (permissions.hasOwnProperty(permission)) {
                    let value = permissions[permission];

                    // 根據勾選狀態設定勾選框
                    $(this).prop('checked', value === 1);
                }
            });
        }
    });

    // 檢查每排全選選項是否應該勾選
    $('#checkboxTable .selectAll').each(function () {
        let checkboxes = $(this).parents('tr').find('.checkbox');
        let isAllChecked = true;
        checkboxes.each(function () {
            if (!$(this).prop('checked')) {
                isAllChecked = false;
            }
        });
        $(this).prop('checked', isAllChecked);
    });

    // 檢查表單全選選項是否應該勾選
    let checkboxes = $('#checkboxTable').find('.checkbox');
    let isAllChecked = true;
    checkboxes.each(function () {
        if (!$(this).prop('checked')) {
            isAllChecked = false;
        }
    }
    );
    $('#selectAllTable').prop('checked', isAllChecked);

}

const getSelectTableData = () => {
    // 建立一個空物件來儲存勾選狀態
    let postData = {};

    // 權限對應的文字對照表
    let permissionTexts = {
        create: __['add'],
        read: __['browse'],
        update: __['modify'],
        delete: __['delete']
    };

    let permissionCategoryTexts = {
        area: __['area'],
        menu: __['menu'],
        news: __['news'],
        admin_setting: __['adminSetting'],
        role_permission: __['rolePermission'],
        log: '操作紀錄'
    }

    // 迭代每個欄位的全選按鈕
    $('#checkboxTable .selectAll').each(function () {
        let category = $(this).closest('tr').find('td:first-child').text().trim();
        let permissions = {};

        // 迭代同一行中的其他 checkbox
        $(this).closest('td').find('.checkbox').each(function () {
            let permission = $(this).siblings('label').text().trim();
            let value = $(this).prop('checked') ? 1 : 0;
            let permissionText = Object.keys(permissionTexts).find(key => permissionTexts[key] === permission);
            permissions[permissionText] = value;
        });
        let categoryText = Object.keys(permissionCategoryTexts).find(key => permissionCategoryTexts[key] === category);
        postData[categoryText] = permissions;
    });

    return postData;
}

const getArea = async () => {
    const area = await axios.get('/api/area');
    return area.data;
}

const setAreaOption = (data) => {
    let areaPermission = $('#areaPermission');
    if (Array.isArray(data)) {
        data.forEach(function (area) {
            let option = $('<option>').attr('value', area._id).text(area.name);
            areaPermission.append(option);
        });
    }
}