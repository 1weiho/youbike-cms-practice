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
  const initDataTable = () => {
    $('#myTable').DataTable({
      language: {
        "lengthMenu": "每頁 _MENU_ 筆資料",
        "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
        "paginate": {
          "previous": "上一頁",
          "next": "下一頁"
        },
        "search": "查詢:",
        "zeroRecords": "無符合資料",
        "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
        "emptyTable": "沒有資料",
        "infoFiltered": "(從 _MAX_ 筆資料中過濾)",
      },
      autoWidth: false,
    });
  }

  const handleDeleteNews = (id) => {
    $.ajax({
      url: '/api/news/' + id,
      type: 'DELETE',
      dataType: 'json',
      success: function (data) {
        if (data.status == "success") {
          alert('刪除成功');
          window.location.reload();
        } else {
          alert('刪除失敗');
        }
      },
      error: function (err) {
        console.log(err);
      }
    });
  }

  const getNews = () => {
    $.ajax({
      url: '/api/news',
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        let html = '';
        data.forEach(item => {
          let statusBadge;
          if (item.status == 0) {
            statusBadge = '<span class="badge bg-danger">隱藏</span>';
          } else if (item.status == 1) {
            statusBadge = '<span class="badge bg-success">顯示</span>';
          } else {
            statusBadge = '<span class="badge bg-warning">未知</span>';
          }

          html += `
            <tr>
              <td>
                ${item.area.map(area => `<span class="badge bg-secondary me-2">${area}</span>`).join('')}
              </td>
              <td>${item.menu}</td>
              <td>${item.title}</td>
              <td>${statusBadge}</td>
              <td class="d-flex">
                <a class="btn btn-warning me-3" href=${"/news/edit/" + item._id.$oid}>修改</a>
                <button type="button" class="btn btn-danger delete-btn" id=${item._id.$oid}>刪除</button>
              </td>
            </tr>
          `;
        });
        $('tbody').html(html);
        initDataTable();
        $('.delete-btn').on('click', function() {
          const id = $(this).attr('id');
          handleDeleteNews(id);
        })
      },
      error: function (err) {
        console.log(err);
      }
    });
  }

  $(document).ready(function () {
    getNews();
  });
</script>