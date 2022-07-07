<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurtainControlsRequest;
use App\Models\CurtainMechanism;
use Illuminate\Http\Request;

class CurtainMechanismsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mechanisms = CurtainMechanism::all();
        return view('admin.curtains.mechanisms.index', compact('mechanisms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('/admin/mechanisms');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurtainControlsRequest $request)
    {
        $mechanism = $request->all();
        CurtainMechanism::create($mechanism);
        return redirect()->back()->withStatus(__('Mecanismo guardado correctamente'));
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
        $mechanism = CurtainMechanism::findOrFail($id);
        return view('admin.curtains.mechanisms.edit', compact('mechanism'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CurtainControlsRequest $request, $id)
    {
        $mechanism = CurtainMechanism::findOrFail($id);
        $input = $request->all();
        $mechanism->update($input);
        return redirect('/admin/mechanisms')->withStatus(__('Mecanismo editado correctamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mechanism = CurtainMechanism::findOrFail($id);
        $mechanism->delete();
        return redirect('/admin/mechanisms')->withStatus(__('Mecanismo eliminado correctamente'));
    }

}
