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
<title>區域</title>
</head>

<body class="bg-light">
  <div class="container p-5">
    <h1>區域</h1>
    <div class="d-flex h-full justify-content-end rounded bg-white p-5 mt-5 d-flex flex-column">
      <div class="d-flex justify-content-end">
        <a class="btn btn-primary btn-lg" href="/area/add">新增</a>
      </div>
      <div class="p-5">
        <table id="myTable" class="display">
          <thead>
            <tr>
              <th>區域名稱</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>

            @foreach($area as $item)
            <tr>
              <td>{{ $item->name }}</td>
              <td class="d-flex">
                <a class="btn btn-warning me-3" href={{ "/area/edit/" . $item->_id }}>修改</a>
                <form id="delete-form-{{ $item->_id }}" action="{{ route('area.delete', ['id' => $item->_id]) }}"
                  method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" onclick="return confirm('確定要刪除此區域嗎？')">刪除</button>
                </form>
              </td>
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>

<script>
  $(document).ready(function () {
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
      }
    });
  });
</script>