@if(Session::has('message'))
    <div
        class="notification hidden-xs-up"
        data-notify="{{ Session::get('type') }}"
        data-message="{{ Session::get('message') }}"
        data-title="{{ is_null(Session::get('title')) ? 'CMS' : Session::get('title') }}"
        data-timeout="{{ is_null(Session::get('timeout')) ? 5 : Session::get('timeout') }}"
    >
    </div>
@endif

@if($errors->any())
    <div
        class="notification hidden-xs-up"
        data-notify="error"
        data-message="{{ $errors->first() }}"
        data-title="Error"
    >
    </div>
@endif
