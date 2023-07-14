<?php

return [
    // layout
    'siteName' => '官網後台系統',
    'area' => '區域',
    'menu' => '選單',
    'news' => '最新消息',
    'adminSetting' => '管理者設定',
    'rolePermission' => '角色權限',
    'version' => '版本',
    'logout' => '登出',

    // general
    'add' => '新增',
    'operation' => '操作',
    'delete' => '刪除',
    'modify' => '修改',
    'back' => '返回',
    'all' => '全部',
    'status' => '狀態',
    'display' => '顯示',
    'hide' => '隱藏',
    'unknown' => '未知',
    'addSuccess' => '新增成功',
    'addFail' => '新增失敗',
    'modifySuccess' => '修改成功',
    'modifyFail' => '修改失敗',
    'updateSuccess' => '更新成功',
    'deleteFail' => '刪除失敗',
    'startAt' => '開始日期',
    'endAt' => '結束日期',
    'createAt' => '建立時間',
    'updateAt' => '修改時間',
    'confirmDeleteData' => '確定要刪除嗎？',
    'enable' => '啟用',
    'disable' => '禁用',
    'selectAll' => '全選',

    // data table
    'lengthMenu' => '每頁 _MENU_ 筆資料',
    'info' => '顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項',
    'previous' => '上一頁',
    'next' => '下一頁',
    'searchTable' => '查詢:',
    'zeroRecords' => '無符合資料',
    'infoEmpty' => '顯示第 0 至 0 項結果，共 0 項',
    'emptyTable' => '沒有資料',
    'infoFiltered' => '(從 _MAX_ 筆資料中過濾)',

    // area
    'areaName' => '區域名稱',
    'confirmDeleteArea' => '確定要刪除此區域嗎？',
    'pleaseSelectArea' => '請選擇區域',

    // menu
    'menuName' => '選單名稱',
    'confirmDeleteMenu' => '確定要刪除此選單嗎？',
    'zeroMenu' => '無選單',
    'pleaseSelectMenu' => '請選擇選單',

    // news
    'title' => '標題',
    'pleaseEnterTitle' => '請輸入標題',
    'eachPageCount' => '每頁筆數',
    'search' => '搜尋',
    'count' => '筆資料',
    'noSearchResult' => '查無資料',
    'cover' => '封面圖片',
    'content' => '內容',

    // admin
    'username' => '帳號',
    'name' => '姓名名稱',
    'email' => '信箱',
    'password' => '密碼',
    'confirmPassword' => '確認密碼',
    'status' => '狀態',
    'modifyPassword' => '修改密碼',

    // role permission
    'roleName' => '角色名稱',
    'areaPermission' => '區域權限',
    'rolePermission' => '角色權限',

    // login
    'login' => '登入',
    'pleaseEnterUsernameAndPasswordToLogin' => '請輸入帳號密碼登入系統',
    'chooseLanguage' => '選擇語言',
    'pleaseEnterUsername' => '請輸入帳號',
    'pleaseEnterPassword' => '請輸入密碼',

    // validation
    // [admin]
    'username.required' => '請填入帳號',
    'username.unique' => '帳號已存在',
    'username.regex' => '帳號僅能輸入數字、英文及_-符號，且長度為 5-30 個字元',
    'username.max' => '帳號長度不能超過 255 個字元',
    'password.required' => '請填入密碼',
    'password.regex' => '密碼必須包含英文及數字，且長度為 8-20 個字元',
    'confirmPassword.required' => '請填入確認密碼',
    'confirmPassword.same' => '確認密碼與密碼不相符',
    'name.required' => '請填入姓名',
    'name.regex' => '姓名僅能輸入中文、英文及空白，且長度為 3-10 個字元',
    'email.required' => '請填入信箱',
    'email.unique' => '信箱已存在',
    'email.email' => '信箱格式錯誤',
    'email.max' => '信箱長度不能超過 50 個字元',
    'status.required' => '請填入狀態',
    // [news]
    'area.required' => '請填入區域',
    'menu.required' => '請填入選單',
    'start_at.required' => '請填入開始時間',
    'start_at.date' => '開始時間必須是一個有效日期',
    'end_at.required' => '請填入結束時間',
    'end_at.date' => '結束時間必須是一個有效日期',
    'end_at.after' => '結束時間必須大於開始時間',
    'status.required' => '請填入狀態',
    'status.numeric' => '狀態必須是顯示或隱藏',
    'status.in' => '狀態必須是顯示或隱藏',
    'title.required' => '請填入標題',
    'content.required' => '請填入內容',
    'cover.image' => '封面必須是一個圖片',
    'cover.mimes' => '封面必須是 png, jpeg, jpg 格式',
    'cover.max' => '封面大小不能超過 2MB',
];
