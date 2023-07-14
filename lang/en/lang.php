<?php

return [
    // layout
    'siteName' => 'Official website backend system',
    'area' => 'Area',
    'menu' => 'Menu',
    'news' => 'Latest News',
    'adminSetting' => 'Admin Setting',
    'rolePermission' => 'Role Permission',
    'version' => 'Version',
    'logout' => 'Logout',

    // general
    'add' => 'Add',
    'operation' => 'Operation',
    'delete' => 'Delete',
    'modify' => 'Modify',
    'back' => 'Back',
    'all' => 'All',
    'status' => 'Status',
    'display' => 'Display',
    'hide' => 'Hide',
    'unknown' => 'Unknown',
    'addSuccess' => 'Add success',
    'addFail' => 'Add fail',
    'modifySuccess' => 'Modify success',
    'modifyFail' => 'Modify fail',
    'updateSuccess' => 'Update success',
    'deleteFail' => 'Delete fail',
    'startAt' => 'Start at',
    'endAt' => 'End at',
    'createAt' => 'Create at',
    'updateAt' => 'Update at',
    'confirmDeleteData' => 'Are you sure you want to delete this data?',
    'enable' => 'Enable',
    'disable' => 'Disable',
    'selectAll' => 'Select All',

    // data table
    'lengthMenu' => 'Display _MENU_ entries per page',
    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
    'previous' => 'Previous',
    'next' => 'Next',
    'searchTable' => 'Search:',
    'zeroRecords' => 'No matching records found',
    'infoEmpty' => 'Showing 0 to 0 of 0 entries',
    'emptyTable' => 'No data available',
    'infoFiltered' => '(filtered from _MAX_ total entries)',

    // area
    'areaName' => 'Area Name',
    'confirmDeleteArea' => 'Are you sure you want to delete this area?',
    'pleaseSelectArea' => 'Please select area',

    // menu
    'menuName' => 'Menu Name',
    'confirmDeleteMenu' => 'Are you sure you want to delete this menu?',
    'zeroMenu' => 'No menu',
    'pleaseSelectMenu' => 'Please select menu',

    // news
    'title' => 'Title',
    'pleaseEnterTitle' => 'Please enter title',
    'eachPageCount' => 'Each page count',
    'search' => 'Search',
    'count' => 'entries',
    'noSearchResult' => 'No search result',
    'cover' => 'Cover',
    'content' => 'Content',

    // admin
    'username' => 'Username',
    'name' => 'Name',
    'email' => 'Email',
    'password' => 'Password',
    'confirmPassword' => 'Confirm Password',
    'status' => 'Status',
    'modifyPassword' => 'Modify Password',

    // role permission
    'roleName' => 'Role Name',
    'areaPermission' => 'Area Permission',
    'rolePermission' => 'Role Permission',

    // login
    'login' => 'Login',
    'pleaseEnterUsernameAndPasswordToLogin' => 'Please enter username and password to login',
    'chooseLanguage' => 'Choose Language',
    'pleaseEnterUsername' => 'Please enter username',
    'pleaseEnterPassword' => 'Please enter password',

    // validation
    // [admin]
    'username.required' => 'Please enter a username',
    'username.unique' => 'The username already exists',
    'username.regex' => 'The username can only contain numbers, letters, and the _ and - symbols, with a length of 5-30 characters',
    'username.max' => 'The username length cannot exceed 255 characters',
    'password.required' => 'Please enter a password',
    'password.regex' => 'The password must contain letters and numbers, with a length of 8-20 characters',
    'confirmPassword.required' => 'Please enter the confirmation password',
    'confirmPassword.same' => 'The confirmation password does not match the password',
    'name.required' => 'Please enter a name',
    'name.regex' => 'The name can only contain Chinese characters, letters, and spaces, with a length of 3-10 characters',
    'email.required' => 'Please enter an email',
    'email.unique' => 'The email already exists',
    'email.email' => 'Invalid email format',
    'email.max' => 'The email length cannot exceed 50 characters',
    'status.required' => 'Please enter a status',
    // [news]
    'area.required' => 'Please enter an area',
    'menu.required' => 'Please enter a menu',
    'start_at.required' => 'Please enter a start time',
    'start_at.date' => 'Start time must be a valid date',
    'end_at.required' => 'Please enter an end time',
    'end_at.date' => 'End time must be a valid date',
    'end_at.after' => 'End time must be greater than the start time',
    'status.required' => 'Please enter a status',
    'status.numeric' => 'Status must be either visible or hidden',
    'status.in' => 'Status must be either visible or hidden',
    'title.required' => 'Please enter a title',
    'content.required' => 'Please enter the content',
    'cover.image' => 'The cover must be an image',
    'cover.mimes' => 'The cover must be in PNG, JPEG, or JPG format',
    'cover.max' => 'The cover size cannot exceed 2MB',
];
