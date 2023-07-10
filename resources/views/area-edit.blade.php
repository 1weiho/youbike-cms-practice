<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<title>區域 - 修改</title>
</head>

<x-layout>
  <div class="p-5">
    <h1>區域 - 修改</h1>
    <div class="d-flex h-full justify-content-end rounded bg-white p-5 mt-5 d-flex flex-column">
      <h3>區域名稱</h3>
      <form action="{{ route('area.update', ['id' => $area->_id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-outline mt-3">
          <input type="text" class="form-control form-control-lg" placeholder="區域名稱" name="name" autofocus value={{
            $area->name }}
          />
        </div>
        @error('name')
        <div class="d-flex mt-3">
          <div class="alert alert-danger">{{ $message }}</div>
        </div>
        @enderror
        <div class="d-flex justify-content-center mt-3">
          <button type="submit" class="btn btn-warning me-3">修改</button>
          <a class="btn btn-light" href="/area">返回</a>
        </div>
      </form>
    </div>
  </div>
</x-layout>

</html>