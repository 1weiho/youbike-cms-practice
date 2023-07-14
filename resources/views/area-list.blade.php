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
<title>{{ __('lang.area') }}</title>
</head>

<x-layout>
  <div class="py-4 px-5">
    <h2>{{ __('lang.area') }}</h2>
    <div class="d-flex h-full justify-content-end rounded bg-white p-3 mt-3 d-flex flex-column">
      @can('create', App\Models\Area::class)
      <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-primary" href="/area/add">{{ __('lang.add') }}</a>
      </div>
      @endcan
      <div>
        <table id="myTable" class="display">
          <thead>
            <tr>
              <th>{{ __('lang.areaName') }}</th>
              <th>{{ __('lang.operation') }}</th>
            </tr>
          </thead>
          <tbody>

            @foreach($area as $item)
            <tr>
              <td>{{ $item->name }}</td>
              <td class="d-flex">
                @can('update', App\Models\Area::class)
                <a class="btn btn-warning me-3" href={{ "/area/edit/" . $item->_id }}>{{ __('lang.modify') }}</a>
                @endcan
                @can('delete', App\Models\Area::class)
                <form id="delete-form-{{ $item->_id }}" action="{{ route('area.delete', ['id' => $item->_id]) }}"
                  method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('lang.confirmDeleteArea') }}')">{{ __('lang.delete') }}</button>
                </form>
                @endcan
              </td>
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
</x-layout>

</html>

<script>
  @if (session('error'))
      var errorMessage = "{{ session('error') }}";
      alert(errorMessage);
  @endif

  $(document).ready(function () {
    $('#myTable').DataTable({
      language: {
        "lengthMenu": "{{ __('lang.lengthMenu') }}",
        "info": "{{ __('lang.info') }}",
        "paginate": {
          "previous": "{{ __('lang.previous') }}",
          "next": "{{ __('lang.next') }}"
        },
        "search": "{{ __('lang.searchTable') }}",
        "zeroRecords": "{{ __('lang.zeroRecords') }}",
        "infoEmpty": "{{ __('lang.infoEmpty') }}",
        "emptyTable": "{{ __('lang.emptyTable') }}",
        "infoFiltered": "{{ __('lang.infoFiltered') }}",
      }
    });
  });
</script>