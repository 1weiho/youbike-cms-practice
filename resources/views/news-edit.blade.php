<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
  <script src="/js/news.js"></script>
</head>
<title>最新消息 - 修改</title>
</head>

<x-layout>
  <div class="p-5">
    <h1>最新消息 - 修改</h1>
    <div class="d-flex h-full justify-content-end rounded bg-white p-5 mt-3 d-flex flex-column">
      <form id="newForms" onsubmit="updateForm(); return false;">
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">區域</h5>
          </div>
          <div class="col-11">
            <select class="form-select form-select-lg" name="area-ui">
            </select>
            <input type="hidden" name="area">
            <p id="result"></p>
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">選單</h5>
          </div>
          <div class="col-11">
            <select class="form-select form-select-lg" name="menu">
            </select>
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">開始日期</h5>
          </div>
          <div class="col-11">
            <input type="date" class="form-control form-control-lg" placeholder="開始日期" name="start_at" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">結束日期</h5>
          </div>
          <div class="col-11">
            <input type="date" class="form-control form-control-lg" placeholder="結束日期" name="end_at" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">狀態</h5>
          </div>
          <div class="col-11">
            <input type="radio" name="status" id="statusShow" value="1">
            <label class="text-success me-3">顯示</label>
            <input type="radio" name="status" id="statusHide" value="0">
            <label class="text-danger">隱藏</label>
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">標題</h5>
          </div>
          <div class="col-11">
            <input type="text" class="form-control form-control-lg" placeholder="標題" name="title" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">內容</h5>
          </div>
          <div class="col-11">
            <textarea class="form-control form-control-lg" placeholder="內容" name="content" rows="6"></textarea>
          </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
          <button type="submit" class="btn btn-success me-3">修改</button>
          <a class="btn btn-light" href="/news">返回</a>
        </div>
      </form>
    </div>
  </div>
</x-layout>

</html>

<script>
  let areaSelect = [];
  $(document).ready(async function () {
    const id = getUrlId();
    const news = await getNewsById(id);
    const area = await getArea();
    setAreaOption(area);
    const menu = await getMenu();
    setMenuOption(menu);
    setNewsFormData(news);
    setAreaOnChangeListner();
  });
</script>