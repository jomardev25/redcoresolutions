<ol class="breadcrumb">
    @foreach (get_breadcrumbs() as $key => $url)
        <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
            <a href="javascript:void(0);">
                {{ str_replace('-',' ',ucwords(str_replace('-',' ',$key))) }}
            </a>
        </li>
    @endforeach
</ol>
