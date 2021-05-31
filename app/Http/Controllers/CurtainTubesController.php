<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurtainControlsRequest;
use App\Models\CurtainTube;
use Illuminate\Http\Request;

class CurtainTubesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tubes = CurtainTube::all();
        return view('admin.curtains.tubes.index', compact('tubes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('/admin/tubes');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurtainControlsRequest $request)
    {
        $tube = $request->all();
        CurtainTube::create($tube);
        return redirect()->back()->withStatus(__('Tubo guardado correctamente'));
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
        $tube = CurtainTube::findOrFail($id);
        return view('admin.curtains.tubes.edit', compact('tube'));
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
        $tube = CurtainTube::findOrFail($id);
        $input = $request->all();
        $tube->update($input);
        return redirect('/admin/tubes')->withStatus(__('tube editado correctamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tube = CurtainTube::findOrFail($id);
        $tube->delete();
        return redirect('/admin/tubes')->withStatus(__('Tubo eliminado correctamente'));
    }

}
