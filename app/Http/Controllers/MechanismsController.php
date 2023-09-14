<?php

namespace App\Http\Controllers;

use App\Http\Requests\ControlRequest;
use App\Models\Mechanism;
use Illuminate\Http\Request;

class MechanismsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mechanisms = Mechanism::all();
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
    public function store(ControlRequest $request)
    {
        $mechanism = $request->all();
        Mechanism::create($mechanism);
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
        $mechanism = Mechanism::findOrFail($id);
        return view('admin.curtains.mechanisms.edit', compact('mechanism'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ControlRequest $request, $id)
    {
        $mechanism = Mechanism::findOrFail($id);
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
        $mechanism = Mechanism::findOrFail($id);
        $mechanism->delete();
        return redirect('/admin/mechanisms')->withStatus(__('Mecanismo eliminado correctamente'));
    }

}
