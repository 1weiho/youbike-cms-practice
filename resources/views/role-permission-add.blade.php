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
  <script src="/js/rolePermission.js"></script>
</head>
<title>{{ __('lang.rolePermission') }} - {{ __('lang.add') }}</title>
</head>

<x-layout>
  <div class="py-4 px-5">
    <h2>{{ __('lang.rolePermission') }} - {{ __('lang.add') }}</h2>
    <div class="d-flex h-full rounded bg-white p-5 pt-3 mt-3 d-flex flex-column" style="max-height: 88vh;">
      <form id="newForms" onsubmit="submitForm(event)">
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.roleName') }}</h5>
          </div>
          <div class="col-11">
            <input type="text" class="form-control form-control-lg" id="roleName"
              placeholder="{{ __('lang.roleName') }}" name="roleName" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.areaPermission') }}</h5>
          </div>
          <div class="col-11">
            <select class="select2 form-control form-contro-lg" id="areaPermission" name="area[]"
              multiple="multiple"></select>
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end pe-3">
            <h5 class="fw-medium">{{ __('lang.rolePermission') }}</h5>
          </div>
          <div class="col-11 d-flex flex-column">
            <div>
              <input type="checkbox" id="selectAllTable">
              <label>{{ __('lang.selectAll') }}</label>
            </div>
            <table class="table table-striped" id="checkboxTable">
              <thead>
                <tr>
                  <th>選單</th>
                  <th>權限</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>區域</td>
                  <td class="d-flex">
                    <div class="me-3">
                      <input type="checkbox" class="selectAll">
                      <label>全選</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>瀏覽</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>新增</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>修改</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>刪除</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>選單</td>
                  <td class="d-flex">
                    <div class="me-3">
                      <input type="checkbox" class="selectAll">
                      <label>全選</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>瀏覽</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>新增</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>修改</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>刪除</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>最新消息</td>
                  <td class="d-flex">
                    <div class="me-3">
                      <input type="checkbox" class="selectAll">
                      <label>全選</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>瀏覽</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>新增</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>修改</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>刪除</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>管理者設定</td>
                  <td class="d-flex">
                    <div class="me-3">
                      <input type="checkbox" class="selectAll">
                      <label>全選</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>瀏覽</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>新增</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>修改</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>刪除</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>角色權限</td>
                  <td class="d-flex">
                    <div class="me-3">
                      <input type="checkbox" class="selectAll">
                      <label>全選</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>瀏覽</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>新增</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>修改</label>
                    </div>
                    <div class="me-3">
                      <input type="checkbox" class="checkbox">
                      <label>刪除</label>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
          <button type="submit" class="btn btn-success me-3">{{ __('lang.add') }}</button>
          <a class="btn btn-light" href="/role-permission">{{ __('lang.back') }}</a>
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
    const area = await getArea();
    setAreaOption(area);
    initCheckboxTable();
  });
</script>