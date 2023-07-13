<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
  <script src="/js/admin.js"></script>
</head>
<title>{{ __('lang.adminSetting') }}</title>
</head>

<x-layout>
  <div class="py-4 px-5">
    <h2>{{ __('lang.adminSetting') }}</h2>
    <div class="d-flex h-full justify-content-end rounded bg-white p-3 mt-3 d-flex flex-column">
      <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-primary" href="/admin/add">{{ __('lang.add') }}</a>
      </div>
      <div>
        <table id="adminList" class="display">
          <thead>
            <tr>
              <th>{{ __('lang.username') }}</th>
              <th>{{ __('lang.name') }}</th>
              <th>{{ __('lang.createAt') }}</th>
              <th>{{ __('lang.updateAt') }}</th>
              <th>{{ __('lang.status') }}</th>
              <th>{{ __('lang.operation') }}</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</x-layout>

</html>

<script>
  const __ = {!! $lang !!};
  $(document).ready(async function () {
    initDataTable();
    const adminList = await fetchAdminList();
    setAdminList(adminList);
  });
</script>