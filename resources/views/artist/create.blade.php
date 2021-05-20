@extends('layouts.app')
@section('title', 'Create Artist')
@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Create Artist</h1>
    @include('layouts.partials.breadcrumbs')
    <div class="row mb-3 justify-content-center">
        <div class="col-sm-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <div class="caption">
                        <a href="{{ route('songs.index') }}"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            data-title="Back to song list"
                        >
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                    <div class="actions">
                        @include('layouts.partials.card-control-box')
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-create-artist" method="POST" action="{{ route('artists.store') }}">
                        @csrf
                        <div class="form-group">
                            <label class="small mb-1" for="name">Name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control"
                                required autofocus
                            />
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-center">
                            <button type="submit" class="btn btn-primary">
                               <i class="fa fa-save"></i> Save Artist
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\ArtistRequest', '#form-create-artist') !!}
@endsection

