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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
  </script>
  <script src="/js/news.js"></script>
</head>
<title>{{ __('lang.news') }}</title>
</head>

<x-layout>
  @can('import', App\Models\News::class)
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">匯入最新消息</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" action="/news/import" enctype="multipart/form-data" id="importForm">
          <div class="modal-body">
            <div class="d-flex align-items-center mb-2">
              <p class="m-0">匯入檔案格式為 EXCEL。</p>
              <a class="btn btn-warning" href="/file/範本.xlsx">範本</a>
            </div>
            <p>檔案第一行保留作為標題，資料從第二行開始讀取。</p>
            <p>每行欄位皆為必填，由左至右依序：</p>
            <ul>
              <li>地區</li>
              <li>選單</li>
              <li>標題</li>
              <li>內容</li>
              <li>狀態</li>
            </ul>
            <p>上傳檔案</p>
            @csrf
            <input type="file" name="file" id="importFile">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">提交</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endcan
  <div class="py-4 px-5">
    <h2>{{ __('lang.news') }}</h2>
    <div class="d-flex h-full justify-content-end rounded bg-white p-3 mt-3 d-flex flex-column">
      <div class="d-flex justify-content-end mb-3">
        @can('import', App\Models\News::class)
        <button class="btn me-3 btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">匯入</button>
        @endcan
        @can('create', App\Models\News::class)
        <a class="btn me-3 btn-success" href="/news/add">{{ __('lang.add') }}</a>
        @endcan
        @can('export', App\Models\News::class)
        <a class="btn me-3 btn-warning" href="/news/export/xlsx" id="exportXlsxBtn">匯出EXCEL</a>
        <a class="btn me-3 btn-warning" href="/news/export/csv" id="exportCsvBtn">匯出CSV</a>
        @endcan
      </div>
      <div class="d-flex mb-3">
        <div class="d-flex align-items-center me-4">
          <label class="me-2">{{ __('lang.menu') }}</label>
          <select class="form-select form-select-lg" name="menu" id="menu">
            <option value="all">{{ __('lang.all') }}</option>
          </select>
        </div>
        <div class="d-flex align-items-center me-4">
          <label class="me-2">{{ __('lang.area') }}</label>
          <select class="form-select form-select-lg" name="area-ui" id="area">
            <option value="all">{{ __('lang.all') }}</option>
          </select>
        </div>
        <div class="d-flex align-items-center me-4">
          <label class="me-2">{{ __('lang.status') }}</label>
          <select class="form-select form-select-lg" name="status" id="status">
            <option value="all">{{ __('lang.all') }}</option>
            <option value="1">{{ __('lang.display') }}</option>
            <option value="0">{{ __('lang.hide') }}</option>
          </select>
        </div>
        <div class="d-flex align-items-center me-4">
          <label class="me-2">{{ __('lang.title') }}</label>
          <input type="text" class="form-control form-control-lg" placeholder="{{ __('lang.pleaseEnterTitle') }}"
            name="title" id="title" />
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
      <div>
        <table id="myTable" class="table table-striped text-center table-bordered">
          <thead>
            <tr>
              <th>{{ __('lang.area') }}</th>
              <th>{{ __('lang.menu') }}</th>
              <th>{{ __('lang.title') }}</th>
              <th>{{ __('lang.status') }}</th>
              <th>{{ __('lang.operation') }}</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="d-flex justify-content-between">
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
    const data = await getNews(urlQuery);
    setNewsList(data);
    initExportBtn(urlQuery);
    const menu = await getMenu();
    setMenuOption(menu);
    const area = await getArea();
    setAreaOption(area);
    setPagination(data.data);
    setQueryForm(urlQuery);
    setImportListener();
  });
</script>