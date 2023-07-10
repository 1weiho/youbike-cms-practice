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
  <script src="/js/news.js"></script>
</head>
<title>最新消息</title>
</head>

<body class="bg-light">
  <div class="container p-5">
    <h1>最新消息</h1>
    <div class="d-flex h-full justify-content-end rounded bg-white p-5 mt-5 d-flex flex-column">
      <div class="d-flex justify-content-end">
        <a class="btn btn-primary btn-lg" href="/news/add">新增</a>
      </div>
      <div class="p-5">
        <table id="myTable" class="display">
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
    </div>
  </div>
</body>

</html>

<script>
  $(document).ready(async function () {
    const news = await getNews();
    setNewsList(news);
  });
</script>