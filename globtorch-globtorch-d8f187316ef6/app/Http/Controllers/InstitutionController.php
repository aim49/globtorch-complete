<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Institution;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institutions = Institution::all();
        return view('institution.index', compact('institutions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('institution.create');
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
            'name' => 'required|string|max:255',
            'address' => 'string|max:255',
            'phone' => 'string|max:255',
            'email' => 'string|max:255',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable'
        ]);

        $image_name_to_store = null;
        if($file=$request->file('logo'))
        {
            $full_file_name = $file->getClientOriginalName();
            $name = pathinfo($full_file_name, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $image_name_to_store = $name.'_'.time().'.'.$extension;
            $path = $file->storeAs('public/institution/images', $image_name_to_store);
        }

        $institution = new Institution;
        $institution->name = $request->input('name');
        $institution->address = $request->input('address');
        $institution->phone = $request->input('phone');
        $institution->email = $request->input('email');
        $institution->logo = $image_name_to_store;
        $institution->save();

        return redirect()->route('institution.index')->with('status', 'Successfully created institution');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $institution = Institution::find($id);
        return view('institution.show', compact('institution'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $institution = Institution::find($id);
        return view('institution.edit', compact('institution'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'string|max:255',
            'phone' => 'string|max:255',
            'email' => 'string|max:255',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable'
        ]);

        $institution = Institution::find($id);
        $image_name_to_store = $institution->logo;
        if($file=$request->file('logo'))
        {
            Storage::delete('public/institution/images/'.$institution->logo);
            $full_file_name = $file->getClientOriginalName();
            $name = pathinfo($full_file_name, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $image_name_to_store = $name.'_'.time().'.'.$extension;
            $path = $file->storeAs('public/institution/images', $image_name_to_store);
        }

        $institution->name = $request->input('name');
        $institution->address = $request->input('address');
        $institution->phone = $request->input('phone');
        $institution->email = $request->input('email');
        $institution->logo = $image_name_to_store;
        $institution->save();

        return redirect()->route('institution.index')->with('status', 'Successfully updated institution');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institution = Institution::find($id);
        Storage::delete('public/institution/images/'.$institution->logo);
        $institution->delete();
        return redirect()->route('institution.index')->with('status', 'Successfully deleted institution');
    }
}
