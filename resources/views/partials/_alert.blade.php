@if(Session::has('flash_success'))
    <div class="container-fluid">
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <em> {!! session('flash_success') !!}</em>
        </div>
    </div>
@endif
@if(Session::has('flash_danger'))
    <div class="container-fluid">
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <em> {!! session('flash_danger') !!}</em>
        </div>
    </div>
@endif
