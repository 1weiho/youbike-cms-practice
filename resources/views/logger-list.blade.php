<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <script src="/js/logger.js"></script>
</head>
<title>操作紀錄</title>
</head>

<style>
  .break-word {
    min-width: 200px;
    max-width: 200px;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
  }

  .break-word:hover {
    white-space: normal;
    text-overflow: clip;
    word-wrap: break-word;
  }
</style>



<x-layout>
  <div class="py-4 px-5">
    <h2>操作紀錄</h2>
    <div class="d-flex h-full justify-content-end rounded bg-white p-3 mt-3 d-flex flex-column">
      <div class="d-flex mb-3">
        <div class="d-flex align-items-center me-4">
          <label class="me-2">帳號</label>
          <input type="text" class="form-control form-control-lg" placeholder="請輸入帳號" name="username" id="username" />
        </div>
        <div class="d-flex align-items-center me-4">
          <label class="me-2">頁面</label>
          <select class="form-select form-select-lg" name="route" id="route">
            <option value="all">{{ __('lang.all') }}</option>
          </select>
        </div>
        <div class="d-flex align-items-center me-4">
          <label class="me-2">功能</label>
          <select class="form-select form-select-lg" name="method" id="method">
            <option value="all">{{ __('lang.all') }}</option>
            <option value="GET">GET</option>
            <option value="POST">POST</option>
            <option value="PUT">PUT</option>
            <option value="DELETE">DELETE</option>
          </select>
        </div>
        <div class="d-flex align-items-center me-4">
          <label class="me-2">時間範圍</label>
          <input type="text" name="datetimes" id="datetimes" class="form-control form-control-lg" />
        </div>
        <div class="d-flex align-items-center me-4">
          <label class="me-2">{{ __('lang.eachPageCount') }}</label>
          <select class="form-select form-select-lg" name="perPage" id="perPage">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>
        <button class="btn btn-info ms-3" id="search" onclick="handleQuery()">{{ __('lang.search') }}</button>
      </div>
      <div style="max-height: 68vh; overflow-y: scroll;">
        <table id="myTable" class="table table-striped text-center table-bordered">
          <thead>
            <tr>
              <th>帳號</th>
              <th>IP</th>
              <th>頁面</th>
              <th>功能</th>
              <th>請求</th>
              <th>回應</th>
              <th>操作時間</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="d-flex justify-content-between mt-3">
        <p><span id="dataCount"></span> {{ __('lang.count') }}</p>
        <nav aria-label="Page navigation example">
          <ul class="pagination" id="pagination">
          </ul>
        </nav>
      </div>
    </div>
  </div>
</x-layout>

</html>

<script>
  const __ = {!! $lang !!};
  $(document).ready(async function () {
    const urlQuery = getUrlQuery();
    const data = await getLog(urlQuery);
    setLogList(data);
    initDateRangePicker();
    setRouteSelectOption();
    setPagination(data);
    setQueryForm(urlQuery);
  });
</script>