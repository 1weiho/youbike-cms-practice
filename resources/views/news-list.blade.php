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
  <script src="/js/news.js"></script>
</head>
<title>{{ __('lang.news') }}</title>
</head>

<x-layout>
  <div class="py-4 px-5">
    <h2>{{ __('lang.news') }}</h2>
    <div class="d-flex h-full justify-content-end rounded bg-white p-3 mt-3 d-flex flex-column">
      @can('create', App\Models\News::class)
      <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-primary" href="/news/add">{{ __('lang.add') }}</a>
      </div>
      @endcan
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
    const menu = await getMenu();
    setMenuOption(menu);
    const area = await getArea();
    setAreaOption(area);
    setPagination(data.data);
    setQueryForm(urlQuery);
  });
</script>