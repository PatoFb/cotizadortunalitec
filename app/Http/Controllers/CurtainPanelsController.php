<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurtainControlsRequest;
use App\Models\CurtainPanel;
use Illuminate\Http\Request;

class CurtainPanelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $panels = CurtainPanel::all();
        return view('admin.curtains.panels.index', compact('panels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('/admin/panels');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurtainControlsRequest $request)
    {
        $panel = $request->all();
        CurtainPanel::create($panel);
        return redirect()->back()->withStatus(__('Panel guardado correctamente'));
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
        $panel = CurtainPanel::findOrFail($id);
        return view('admin.curtains.panels.edit', compact('panel'));
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
        $panel = CurtainPanel::findOrFail($id);
        $input = $request->all();
        $panel->update($input);
        return redirect('/admin/panels')->withStatus(__('Panel editado correctamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $panel = CurtainPanel::findOrFail($id);
        $panel->delete();
        return redirect('/admin/panels')->withStatus(__('Panel eliminado correctamente'));
    }

}
