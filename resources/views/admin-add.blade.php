<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
  <script src="/js/admin.js"></script>
</head>
<title>管理者設定 - 新增</title>
</head>

<x-layout>
  <div class="py-4 px-5">
    <h2>管理者設定 - 新增</h2>
    <div class="d-flex h-full rounded bg-white p-5 pt-3 mt-3 d-flex flex-column" style="max-height: 88vh;">
      <form id="newForms" onsubmit="submitForm(event)">
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">帳號</h5>
          </div>
          <div class="col-11">
            <input type="text" class="form-control form-control-lg" placeholder="帳號" name="username" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">密碼</h5>
          </div>
          <div class="col-11">
            <input type="password" class="form-control form-control-lg" placeholder="密碼" name="password" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">確認密碼</h5>
          </div>
          <div class="col-11">
            <input type="password" class="form-control form-control-lg" placeholder="確認密碼" name="confirmPassword" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">姓名名稱</h5>
          </div>
          <div class="col-11">
            <input type="text" class="form-control form-control-lg" placeholder="姓名名稱" name="name" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">電子郵件</h5>
          </div>
          <div class="col-11">
            <input type="email" class="form-control form-control-lg" placeholder="電子郵件" name="email" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">狀態</h5>
          </div>
          <div class="col-11">
            <input type="radio" name="status" value="1">
            <label class="text-success me-3">啟用</label>
            <input type="radio" name="status" value="0">
            <label class="text-danger">禁用</label>
          </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
          <button type="submit" class="btn btn-success me-3">新增</button>
          <a class="btn btn-light" href="/admin">返回</a>
        </div>
      </form>
    </div>
  </div>
</x-layout>

</html>