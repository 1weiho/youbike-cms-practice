<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<title>選單</title>
</head>

<x-layout>
  <div class="py-4 px-5 min-vh-100">
    <h2>選單</h2>
    <div class="d-flex rounded bg-white p-5 mt-3 flex-column">
      <div class="d-flex mb-5 w-100 justify-content-between align-items-center">
        <h3>選單名稱</h3>
        <a class="btn btn-primary btn-lg" href="/menu/add">新增</a>
      </div>
      <ul class="ps-0 mh-25 px-3 overflow-y-scroll" style="max-height: 65vh;">
        @if(count($menu) > 0)
        <ul class="ps-0">
          @foreach($menu as $item)
          <li class="d-flex justify-content-between border-bottom mb-5 py-3">
            <h5>{{ $loop->iteration }}. {{ $item->name }}</h5>
            <div class="d-flex">
              <a class="btn btn-warning me-3" href={{ "/menu/edit/" . $item->_id }}>修改</a>
              <form id="delete-form-{{ $item->_id }}" action="{{ route('menu.delete', ['id' => $item->_id]) }}"
                method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('確定要刪除此選單嗎？')">刪除</button>
              </form>
            </div>
          </li>
          @endforeach
        </ul>
        @else
        <p>無選單</p>
        @endif
      </ul>
    </div>
  </div>
</x-layout>

</html>

<script>
  @if (session('error'))
      var errorMessage = "{{ session('error') }}";
      alert(errorMessage);
  @endif
</script>