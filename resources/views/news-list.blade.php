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
<title>最新消息</title>
</head>

<x-layout>
  <div class="py-4 px-5">
    <h2>最新消息</h2>
    <div class="d-flex h-full justify-content-end rounded bg-white p-3 mt-3 d-flex flex-column">
      <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-primary" href="/news/add">新增</a>
      </div>
      <div class="d-flex mb-3">
        <div class="d-flex align-items-center me-4">
          <label class="me-2">選單</label>
          <select class="form-select form-select-lg" name="menu" id="menu">
            <option value="all">全部</option>
          </select>
        </div>
        <div class="d-flex align-items-center me-4">
          <label class="me-2">區域</label>
          <select class="form-select form-select-lg" name="area-ui" id="area">
            <option value="all">全部</option>
          </select>
        </div>
        <div class="d-flex align-items-center me-4">
          <label class="me-2">狀態</label>
          <select class="form-select form-select-lg" name="status" id="status">
            <option value="all">全部</option>
            <option value="1">顯示</option>
            <option value="0">隱藏</option>
          </select>
        </div>
        <div class="d-flex align-items-center me-4">
          <label class="me-2">標題</label>
          <input type="text" class="form-control form-control-lg" placeholder="請輸入標題" name="title" id="title" />
        </div>
        <div class="d-flex align-items-center me-4">
          <label class="me-2">每頁筆數</label>
          <select class="form-select form-select-lg" name="perPage" id="perPage">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>
        <button class="btn btn-info ms-3" id="search" onclick="handleQuery()">搜尋</button>
      </div>
      <div>
        <table id="myTable" class="table table-striped text-center table-bordered">
          <thead>
            <tr>
              <th>區域</th>
              <th>選單</th>
              <th>標題</th>
              <th>狀態</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="d-flex justify-content-between">
        <p><span id="dataCount"></span> 筆資料</p>
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
  $(document).ready(async function () {
    const urlQuery = getUrlQuery();
    const data = await getNews(urlQuery);
    setNewsList(data);
    const menu = await getMenu();
    setMenuOption(menu);
    const area = await getArea();
    setAreaOption(area);
    setPagination(data);
    setQueryForm(urlQuery);
  });
</script>