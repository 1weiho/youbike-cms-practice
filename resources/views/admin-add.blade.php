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
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="/js/admin.js"></script>
</head>
<title>{{ __('lang.adminSetting') }} - {{ __('lang.add') }}</title>
</head>

<x-layout>
  <div class="py-4 px-5">
    <h2>{{ __('lang.adminSetting') }} - {{ __('lang.add') }}</h2>
    <div class="d-flex h-full rounded bg-white p-5 pt-3 mt-3 d-flex flex-column" style="max-height: 88vh;">
      <form id="newForms" onsubmit="submitForm(event)">
        <div class="row form-outline mt-3">
          <div class="col-2 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.username') }}</h5>
          </div>
          <div class="col-10">
            <input type="text" class="form-control form-control-lg" placeholder="{{ __('lang.username') }}"
              name="username" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-2 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.password') }}</h5>
          </div>
          <div class="col-10">
            <input type="password" class="form-control form-control-lg" placeholder="{{ __('lang.password') }}"
              name="password" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-2 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.confirmPassword') }}</h5>
          </div>
          <div class="col-10">
            <input type="password" class="form-control form-control-lg" placeholder="{{ __('lang.confirmPassword') }}"
              name="confirmPassword" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-2 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.name') }}</h5>
          </div>
          <div class="col-10">
            <input type="text" class="form-control form-control-lg" placeholder="{{ __('lang.name') }}" name="name" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-2 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.email') }}</h5>
          </div>
          <div class="col-10">
            <input type="email" class="form-control form-control-lg" placeholder="{{ __('lang.email') }}"
              name="email" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-2 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.status') }}</h5>
          </div>
          <div class="col-10">
            <input type="radio" name="status" value="1">
            <label class="text-success me-3">{{ __('lang.enable') }}</label>
            <input type="radio" name="status" value="0">
            <label class="text-danger">{{ __('lang.disable') }}</label>
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-2 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">請選擇角色權限</h5>
          </div>
          <div class="col-10">
            <select name="role_permission_id" class="select2 form-control form-control-lg" id="rolePermission">
            </select>
          </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
          <button type="submit" class="btn btn-success me-3">{{ __('lang.add') }}</button>
          <a class="btn btn-light" href="/admin">{{ __('lang.back') }}</a>
        </div>
      </form>
    </div>
  </div>
</x-layout>

</html>

<script>
  const __ = {!! $lang !!};
  $(document).ready(async function () {
    $('.select2').select2();
    const rolePermission = await fetchRolePermissionList();
    setRolePermissionOption(rolePermission.data);
  });
</script>