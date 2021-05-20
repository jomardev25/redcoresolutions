<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Http\Requests\ArtistRequest;

class ArtistController extends Controller
{
    const ENTITY = 'Artist';

    public function index()
    {
        $artists = Artist::orderBy('name')->get();
        return view('artist.index', compact('artists'));
    }

    public function create()
    {
        return view('artist.create');
    }

    public function store(ArtistRequest $request)
    {
        $validated = $request->validated();
        Artist::create($validated);

        $this->beginTransaction();

        try {
            Artist::create($validated);
            $this->commit();
            return redirect()->route('artists.index')->with(
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

    public function edit(Artist $artist)
    {
        return view('artist.edit', compact('artist'));
    }

    public function update(ArtistRequest $request, Artist $artist)
    {
        $validated = $request->validated();

        $this->beginTransaction();

        try {

            $artist->update($validated);

            $this->commit();
            return redirect()->route('artists.index')->with(
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

    public function destroy(Artist $artist)
    {
        $this->beginTransaction();

        try {

            $artist->delete();

            $this->commit();
            return redirect()->route('artists.index')->with(
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
