<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurtainCoversRequest;
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
        $covers = CurtainCover::all();
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
        $file = $request->file('photo');
        if($file != '') {
            $name = $file->getClientOriginalName();
            $input['photo'] = $name;
            $request->photo->storeAs('public/images/', $name);
        } else {
            $input['photo'] = 'default-avatar.png';
        }
        CurtainCover::create($input);
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
        $cover = CurtainCover::findOrFail($id);
        return view('admin.curtains.covers.edit', compact('cover'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CurtainCoversRequest $request, $id)
    {
        $cover = CurtainCover::findOrFail($id);
        $input = $request->all();
        $file = $request->file('photo');
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
        $cover = CurtainCover::findOrFail($id);
        $cover->delete();
        return redirect('/admin/covers')->withStatus(__('Cubierta eliminada correctamente'));
    }
}
