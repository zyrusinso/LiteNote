<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Note;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $notes = Note::where('user_id', auth()->id())
        //             ->latest('updated_at')
        //             ->paginate(3);

        // $notes = auth()->user()->notes()->latest('updated_at')->paginate(3);

        $notes = Note::whereBelongsTo(auth()->user())->latest('updated_at')->paginate(3);
        $updatedNotes = $this->transformData($notes);

        return Inertia::render('Notes/Index', [
            'notes' => $updatedNotes,
        ]);
    }

    public function transformData($notes)
    {
        $updatedNotes =  $notes->getCollection()->map(function ($note) {
            return $this->transformNoteData($note);
        });
        return $notes->setCollection($updatedNotes);
    }

    public function transformNoteData($note)
    {
        return [
            'id' => $note->id,
            'uuid' => $note->uuid,
            'user' => $this->getUserData($note->user_id),
            'title' => $note->title,
            'text' => $note->text,
            'created_at' => Carbon::parse($note->created_at)->diffForHumans(),
            'updated_at' => Carbon::parse($note->updated_at)->diffForHumans()
        ];
    }

    public function getUserData($id)
    {
        $user = User::findOrFail($id);
        
        return [
            'name' => $user->name,
            'email' => $user->email,
            'updated_at' => $user->updated_at
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Notes/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:120',
            'text' => 'required' 
        ]);

        auth()->user()->notes()->create([
            'uuid' => Str::uuid(),
            'title' => $request->title,
            'text' => $request->text,
        ]);

        return to_route('notes.index')->with('message', 'Note created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        if(!$note->user()->is(auth()->user())){
            return abort(403);
        }

        return Inertia::render('Notes/Show', [
            'note' => $this->transformNoteData($note)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        if(!$note->user()->is(auth()->user())){
            return abort(403);
        }

        return Inertia::render('Notes/Edit', [
            'note' => $this->transformNoteData($note)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Note $note, Request $request)
    {
        if(!$note->user()->is(auth()->user())){
            return abort(403);
        }

        $request->validate([
            'title' => 'required|max:120',
            'text' => 'required' 
        ]);

        $note->update([
            'title' => $request->title,
            'text' => $request->text,
        ]);

        return to_route('notes.show', $note)->with('message', 'Note updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        if(!$note->user()->is(auth()->user())){
            return abort(403);
        }

        $note->delete();

        return to_route('notes.index')->with('message', 'Note successfully moved to trash!');
    }
}
