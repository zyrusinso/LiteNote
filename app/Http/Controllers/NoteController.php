<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Note;
use App\Models\User;
use Inertia\Inertia;
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
        $notes = Note::where('user_id', auth()->id())
                    ->latest('updated_at')
                    ->paginate(3);
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
            'user' => $this->getUserData($note->user_id),
            'title' => $note->title,
            'text' => $note->text,
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

        Note::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'text' => $request->text,
        ]);

        return to_route('notes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
