@if (Session::has('success'))
    <div class="toast align-items-center bg-success bg-gradient position-absolute @if(Session::has('success')) show @endif top-0 end-0 me-2 mt-2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header flex align-items-center bg-success justify-between" style="font-size:14px;">
            <i class="fa text-white fa-check" aria-hidden="true"></i>
            <div class="text-white toast-body px-2">
                {{ Session::get('success') }}
            </div>
        </div>
    </div>
@endif

@if (Session::has('error'))
    <div class="toast align-items-center bg-danger bg-gradient position-absolute @if(Session::has('error')) show @endif top-0 end-0 me-2 mt-2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header flex align-items-center bg-danger justify-between" style="font-size:14px;">
            <i class="fa text-white fa-exclamation-circle" aria-hidden="true"></i>
            <div class="text-white toast-body px-2">
                {{ Session::get('error') }}
            </div>
        </div>
    </div>
@endif