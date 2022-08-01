<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Directory;

class DirectoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directories = Directory::orderBy('id', 'desc')->get();
        return view('directory.index', compact('directories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('directory.create');
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
            'name' => 'required|max:255',
            'level' => 'required|max:255',
            'description' => 'required|max:255',
            'url' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($file=$request->file('logo'))
        {
            $full_file_name = $file->getClientOriginalName();
            $name = pathinfo($full_file_name, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $image_name_to_store = $name.'_'.time().'.'.$extension;
            $path = $file->storeAs('public/directory/images', $image_name_to_store);
        }

        $directory = new Directory;
        $directory->name = $request->input('name');
        $directory->level = $request->input('level');
        $directory->description = $request->input('description');
        $directory->url = $request->input('url');
        $directory->phone = $request->input('phone');
        $directory->email = $request->input('email');
        $directory->logo = $image_name_to_store;
        $directory->save();

        return redirect('/directories')->with('message', 'Successfully listed directory');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verify($id)
    {
        $directory = Directory::find($id);
        $directory->isVerified = 1;
        $directory->save();

        return redirect()->route('directory.index')->with('message', 'Successfully marked as verified');
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
        $directory = Directory::find($id);
        $directory->delete();

        return redirect()->route('directory.index')->with('message', 'Successfully deleted directory');
    }
}
