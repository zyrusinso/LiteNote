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
        $notes = Note::where('user_id', auth()->id())->latest('updated_at')->get();
        return Inertia::render('Notes/Index', [
            'notes' => $this->transformData($notes),
        ]);
    }

    public function transformData($data)
    {
        $updatedData = new Collection();
        foreach($data as $item){
            $updatedData->push([
                'id' => $item->id,
                'user' => $this->getUserData($item->user_id),
                'title' => $item->title,
                'text' => $item->text,
                'updated_at' => Carbon::parse($item->updated_at)->diffForHumans()
            ]);
        }
        return $updatedData;
    }

    public function getUserData($id)
    {
        $user = User::where('id', $id)->first();
        
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'updated_at' => $user->updated_at
        ];
        return $data;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
