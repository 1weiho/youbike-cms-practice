<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<title>{{ __('lang.area') }} - {{ __('lang.add') }}</title>
</head>

<x-layout>
  <div class="p-5">
    <h1>{{ __('lang.area') }} - {{ __('lang.add') }}</h1>
    <div class="d-flex h-full justify-content-end rounded bg-white p-5 mt-5 d-flex flex-column">
      <h3>{{ __('lang.areaName') }}</h3>
      <form method="POST" action="{{ route('area.create') }}">
        @csrf
        <div class="form-outline mt-3">
          <input type="text" class="form-control form-control-lg" placeholder="{{ __('lang.areaName') }}" name="name" autofocus />
        </div>
        @error('name')
        <div class="d-flex mt-3">
          <div class="alert alert-danger">{{ $message }}</div>
        </div>
        @enderror
        <div class="d-flex justify-content-center mt-3">
          <button type="submit" class="btn btn-success me-3">{{ __('lang.add') }}</button>
          <a class="btn btn-light" href="/area">{{ __('lang.back') }}</a>
        </div>
      </form>
    </div>
  </div>
</x-layout>

</html>