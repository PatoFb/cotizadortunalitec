<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurtainCoversEditRequest;
use App\Http\Requests\CurtainCoversRequest;
use App\Models\Cover;
use App\Models\CurtainCover;
use Illuminate\Http\Request;

class CurtainCoversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $covers = Cover::all();
        return view('admin.curtains.covers.index', compact('covers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.curtains.covers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurtainCoversRequest $request)
    {
        $input = $request->all();
        //get file from the input
        $file = $request->file('photo');
        //check if file isn't null. If it is, assign a default value, if it isn't, get and store the name and then save the file in the disk
        if($file != '') {
            $name = $file->getClientOriginalName();
            $input['photo'] = $name;
            $request->photo->storeAs('public/images/', $name);
        } else {
            $input['photo'] = 'default-avatar.png';
        }
        Cover::create($input);
        return redirect('/admin/covers')->withStatus(__('Cubierta guardada correctamente'));
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
        $cover = Cover::findOrFail($id);
        return view('admin.curtains.covers.edit', compact('cover'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CurtainCoversEditRequest $request, $id)
    {
        $cover = Cover::findOrFail($id);
        $input = $request->all();
        //get file value from input
        $file = $request->file('photo');
        //check if file isn't null. If it is, assign the same value it had, if it isn't, get and store the name and then save the file in the disk
        if($file != '') {
            $name = $file->getClientOriginalName();
            $input['photo'] = $name;
            $request->photo->storeAs('public/images/', $name);
        } else {
            $input['photo'] = $cover->photo;
        }
        $cover->update($input);
        return redirect('/admin/covers')->withStatus(__('Cubierta actualizada correctamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cover = Cover::findOrFail($id);
        $cover->delete();
        return redirect('/admin/covers')->withStatus(__('Cubierta eliminada correctamente'));
    }
}
