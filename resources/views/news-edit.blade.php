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
  <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
  <script src="/js/news.js"></script>
</head>
<title>{{ __('lang.news') }} - {{ __('lang.modify') }}</title>
</head>

<x-layout>
  <div class="py-4 px-5">
    <h1>{{ __('lang.news') }} - {{ __('lang.modify') }}</h1>
    <div class="d-flex h-full rounded bg-white p-5 pt-3 mt-3 d-flex flex-column overflow-y-scroll"
      style="max-height: 88vh;">
      <form id="newForms" onsubmit="updateForm(); return false;">
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.cover') }}</h5>
          </div>
          <div class="col-11">
            <input type="file" class="form-control form-control-lg" id="coverUpload" name="cover"
              accept="image/png, image/jpeg, image/jpg" />
            <div class="mt-3">
              <img id="coverPreview" style="max-width: 100%; max-height: 200px;">
            </div>
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.area') }}</h5>
          </div>
          <div class="col-11">
            <select class="form-select form-select-lg" name="area-ui">
              <option disabled selected>{{ __('lang.pleaseSelectArea') }}</option>
            </select>
            <input type="hidden" name="area">
            <p id="result"></p>
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.menu') }}</h5>
          </div>
          <div class="col-11">
            <select class="form-select form-select-lg" name="menu">
              <option disabled selected>{{ __('lang.pleaseSelectMenu') }}</option>
            </select>
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.startAt') }}</h5>
          </div>
          <div class="col-11">
            <input type="date" class="form-control form-control-lg" placeholder="{{ __('lang.startAt') }}"
              name="start_at" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.endAt') }}</h5>
          </div>
          <div class="col-11">
            <input type="date" class="form-control form-control-lg" placeholder="{{ __('lang.endAt') }}"
              name="end_at" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.status') }}</h5>
          </div>
          <div class="col-11">
            <input type="radio" name="status" id="statusShow" value="1">
            <label class="text-success me-3">{{ __('lang.display') }}</label>
            <input type="radio" name="status" id="statusHide" value="0">
            <label class="text-danger">{{ __('lang.hide') }}</label>
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.title') }}</h5>
          </div>
          <div class="col-11">
            <input type="text" class="form-control form-control-lg" placeholder="{{ __('lang.title') }}" name="title" />
          </div>
        </div>
        <div class="row form-outline mt-3">
          <div class="col-1 d-flex justify-content-end align-items-center pe-3">
            <h5 class="fw-medium">{{ __('lang.content') }}</h5>
          </div>
          <div class="col-11">
            <textarea name="content" id="editor"></textarea>
          </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
          <button type="submit" class="btn btn-success me-3">{{ __('lang.modify') }}</button>
          <a class="btn btn-light" href="/news">{{ __('lang.back') }}</a>
        </div>
      </form>
    </div>
  </div>
</x-layout>

</html>

<script>
  const __ = {!! $lang !!};
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
    await initEditor(news.content);
    setCoverUploadListener();
  });
</script>