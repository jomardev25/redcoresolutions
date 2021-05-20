<?php

namespace App\Http\Controllers;

use App\Song;
use App\Artist;
use Illuminate\Http\Request;
use App\Http\Requests\SongRequest;

class SongController extends Controller
{
    const ENTITY = 'Song';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $songs = Song::with('artist:id,name')->orderBy('title')->get(['id', 'title', 'artist_id', 'created_at']);
        return view('songs.index', compact('songs'));
    }

    public function create()
    {
        $artists = Artist::orderBy('name')->get(['id', 'name']);
        return view('songs.create', compact('artists'));
    }

    public function store(SongRequest $request)
    {
        $validated = $request->validated();
        Song::create($validated);

        $this->beginTransaction();

        try {
            Song::create($validated);
            $this->commit();
            return redirect()->route('songs.index')->with(
                [
                    'message' => __('status.create', ['entity' => self::ENTITY]),
                    'type' => 'success',
                    'title' => 'Song Creation'
                ]
            );
        } catch (\Throwable $th) {
            $this->rollback();
            return back()->withInput()
                ->withErrors(__('error.500'));
        }

    }

    public function show(Song $song)
    {
        $song->load('artist');
        return view('songs.show', [$song]);
    }

    public function edit(Song $song)
    {
        $artists = Artist::orderBy('name')->get(['id', 'name']);
        return view('songs.edit', compact('artists', 'song'));
    }

    public function update(SongRequest $request, Song $song)
    {
        $validated = $request->validated();

        $this->beginTransaction();

        try {
            $song->update($validated);

            $this->commit();
            return redirect()->route('songs.index')->with(
                [
                    'message' => __('status.update', ['entity' => self::ENTITY]),
                    'type' => 'success',
                    'title' => 'Song Update'
                ]
            );
        } catch (\Throwable $th) {
            $this->rollback();
            return back()->withInput()
                ->withErrors(__('error.500'));
        }

    }

    public function destroy(Song $song)
    {
        $this->beginTransaction();

        try {
            $song->delete();

            $this->commit();
            return redirect()->route('songs.index')->with(
                [
                    'message' => __('status.delete', ['entity' => self::ENTITY]),
                    'type' => 'success',
                    'title' => 'Song Deletion'
                ]
            );
        } catch (\Throwable $th) {
            $this->rollback();
            return back()->withInput()
                ->withErrors(__('error.500'));
        }
    }
}
