@extends('layouts.app')
@section('title', 'Songs')
@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Edit Song</h1>
    @include('layouts.partials.breadcrumbs')
    <div class="row mb-3 justify-content-center">
        <div class="col-12">
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
                    <form id="form-edit-song" method="POST" action="{{ route('songs.update', ['id' => $song->id ]) }}">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label class="small mb-1" for="email">Title</label>
                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title', $song->title) }}"
                                class="form-control"
                                required autofocus
                            />
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="artist_id">Artist</label>
                            <select id="artist_id" name="artist_id" class="form-control">
                                @forelse ($artists as $artist)
                                    <option
                                        value="{{ $artist->id }}"
                                        {{ old('lyrics', $song->artist_id) == $artist->id ? 'selected' : '' }}
                                    >
                                        {{ $artist->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="lyrics">Lyrics</label>
                            <textarea id="lyrics" name="lyrics" class="form-control" cols="8" row="4">
                                {{ old('lyrics', $song->lyrics) }}
                            </textarea>
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-center">
                            <button type="submit" class="btn btn-primary">
                               <i class="fa fa-save"></i> Save Song
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
    {!! JsValidator::formRequest('App\Http\Requests\SongRequest', '#form-edit-song') !!}
@endsection
