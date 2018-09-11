@extends('layouts.tenant')

@section('title', e(strip_tags($title)) ?? 'Datatables')

@section('breadcrumb')
   @isset($breadcrumbs)
       @isset($promotion)
           {{ Breadcrumbs::render($breadcrumbs, $branchOffice, $promotion) }}
       @elseif(isset($period))
           {{ Breadcrumbs::render($breadcrumbs, $branchOffice, $period) }}
       @else
           {{ Breadcrumbs::render($breadcrumbs, $branchOffice) }}
       @endisset
    @endisset
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">

            @box
            @slot('title', $title ?? 'Datatables')

            {!! $dataTable->table() !!}
            @endbox

        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js" defer></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js" defer></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/jqc-1.12.4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/r-2.2.2/datatables.min.js" defer></script>
    <script type="text/javascript" src="/vendor/datatables/buttons.server-side.js" defer></script>
    {!! $dataTable->scripts() !!}
@endpush
