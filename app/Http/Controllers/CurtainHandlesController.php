<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurtainHandlesRequest;
use App\Models\CurtainHandle;
use Illuminate\Http\Request;

class CurtainHandlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $handles = CurtainHandle::all();
        return view('admin.curtains.handles.index', compact('handles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurtainHandlesRequest $request)
    {
        $handle = $request->all();
        CurtainHandle::create($handle);
        return redirect()->back()->withStatus(__('Manivela guardada correctamente'));
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
        $handle = CurtainHandle::findOrFail($id);
        return view('admin.curtains.handles.edit', compact('handle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CurtainHandlesRequest $request, $id)
    {
        $handle = CurtainHandle::findOrFail($id);
        $input = $request->all();
        $handle->update($input);
        return redirect('/admin/handles')->withStatus(__('Manivela editada correctamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $handle = CurtainHandle::findOrFail($id);
        $handle->delete();
        return redirect('/admin/handles')->withStatus(__('Manivela eliminada correctamente'));
    }
}