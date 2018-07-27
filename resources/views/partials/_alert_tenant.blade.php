@if(Session::has('flash_success'))
    <div class="container-fluid">
        <div class="alert alert-success" role="alert">
            <em> {!! session('flash_success') !!}</em>
        </div>
    </div>
@endif
@if(Session::has('flash_danger'))
    <div class="container-fluid">
        <div class="alert alert-danger" role="alert">
            <em> {!! session('flash_danger') !!}</em>
        </div>
    </div>
@endif
