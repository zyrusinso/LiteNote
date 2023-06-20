<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Note;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TrashedNoteController extends Controller
{
    public function index()
    {
        $notes = Note::whereBelongsTo(auth()->user())->onlyTrashed()->latest('updated_at')->paginate(3);
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
            'updated_at' => Carbon::parse($note->updated_at)->diffForHumans(),
            'deleted_at' => Carbon::parse($note->deleted_at)->diffForHumans()
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

    public function show(Note $note)
    {
        if(!$note->user()->is(auth()->user())){
            return abort(403);
        }
    }
}
