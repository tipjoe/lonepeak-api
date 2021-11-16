<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NoteController extends Controller
{
    /**
     * Get the notes for current user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $all = Note::select(['location_id', 'note'])
            ->where('user_id', $user_id)->get();

        $notes = $all->map(function($item) {
            return [
                $item->location_id,
                [
                    'note' => $item->note
                ]
            ];
        });
        return response()->json($notes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }



    /**
     * Save a note.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $location_id = $request->input("location_id");
        $content = $request->input("note");
        $now= Carbon::now();

        // Upsert the note.
        $note = Note::updateOrCreate(
            ["note" => $content],
            ["location_id" => $location_id, "user_id" => $user->id]
        );

        if ($note) {
            return response()->json([
                "code" => 200,
                "status" => "success"
            ]);
        } else {
            // TODO - throw httpexception.
            return response()->json([
                "code" => 404,
                "status" => "problem"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        //
    }
}
