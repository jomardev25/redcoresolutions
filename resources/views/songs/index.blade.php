@extends('layouts.app')
@section('title', 'Songs')
@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Songs</h1>
    @include('layouts.partials.breadcrumbs')
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('songs.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add New Song
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Song List
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table-songs" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center" width="20%">Action</th>
                                    <th class="text-center" width="20%">Title</th>
                                    <th class="text-center" width="30%">Artist</th>
                                    <th class="text-center" width="30%">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($songs as $song)
                                    <tr>
                                        <td
                                            class="d-flex justify-content-center flex-column flex-md-column flex-lg-row">
                                            <a
                                                href="{{ route('songs.edit', ['id' => $song->id ]) }}"
                                                class="btn btn-warning mr-0 mb-3 mr-lg-2"
                                            >
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <form method="POST" action="{{ route('songs.destroy', ['id' => $song->id ]) }}">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-block">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                            </a>
                                        </td>
                                        <td>{{ $song->title }}</td>
                                        <td>{{ $song->artist->name }}</td>
                                        <td class="text-center">{{ $song->created_at->format('F d, Y H:i:s') }}</td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/songs/index.js') }}"></script>
@endsection
