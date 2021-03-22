<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurtainControlsRequest;
use App\Models\CurtainControl;
use Illuminate\Http\Request;

class CurtainControlsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $controls = CurtainControl::all();
        return view('admin.curtains.controls.index', compact('controls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('/admin/controls');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurtainControlsRequest $request)
    {
        $control = $request->all();
        CurtainControl::create($control);
        return redirect()->back()->withStatus(__('Control guardado correctamente'));
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
        $control = CurtainControl::findOrFail($id);
        return view('admin.curtains.controls.edit', compact('control'));
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
        $control = CurtainControl::findOrFail($id);
        $input = $request->all();
        $control->update($input);
        return redirect('/admin/controls')->withStatus(__('Control editado correctamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $control = CurtainControl::findOrFail($id);
        $control->delete();
        return redirect('/admin/controls')->withStatus(__('Control eliminado correctamente'));
    }
}
