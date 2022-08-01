<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Note;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::where('user_id', Auth::user()->id)->get();

        return view('note.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('note.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            ['note' => 'required|max:255']
        );
        $note = new Note;
        $note->note = $request->input('note');
        $note->user_id = Auth::user()->id;
        $note->save();
        
        return redirect('/home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $note = Note::find($id);
        if ($note->user_id == Auth::user()->id)
        {
            return view('note.edit', compact('note'));
        }
        else
        {
            return redirect('/home')->withErrors('Cannot edit a note that is not yours');
        }
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
        $request->validate(
            ['note' => 'required|max:255']
        );

        $note = Note::find($id);
        if ($note->user_id == Auth::user()->id)
        {
            $note->note = $request->input('note');
            $note->save();
        
            return redirect('/home')->with('message', 'Successfully updated note');
        }
        else
        {
            return redirect('/home')->withErrors('Cannot update a record that does not belong to you');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::find($id);
        if($note != null)
        {
            $note->delete();
        }
        else
        {
            return redirect('/home')->withErrors('Note cannot be found, perhaps it is already deleted');
        }
        return redirect('/home');
    }

    public function mark_done($id)
    {
        $note = Note::find($id);
        if ($note->user_id == Auth::user()->id)
        {
            $note->isDone = 1;
            $note->save();
        }
        else
        {
            return redirect('/home')->with('message', 'Cannot mark a note that is not yours');
        }

        return redirect('/home');
    }
}
