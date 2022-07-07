<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurtainCanopiesRequest;
use App\Models\CurtainCanopy;
use Illuminate\Http\Request;

class CurtainCanopiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $canopies = CurtainCanopy::all();
        return view('admin.curtains.canopies.index', compact('canopies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('/admin/canopies');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurtainCanopiesRequest $request)
    {
        $canopy = $request->all();
        CurtainCanopy::create($canopy);
        return redirect()->back()->withStatus(__('Tejadillo guardado correctamente'));
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
        $canopy = CurtainCanopy::findOrFail($id);
        return view('admin.curtains.canopies.edit', compact('canopy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CurtainCanopiesRequest $request, $id)
    {
        $canopy = CurtainCanopy::findOrFail($id);
        $input = $request->all();
        $canopy->update($input);
        return redirect('/admin/canopies')->withStatus(__('Tejadillo editado correctamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $canopy = CurtainCanopy::findOrFail($id);
        $canopy->delete();
        return redirect('/admin/canopies')->withStatus(__('Tejadillo eliminado correctamente'));
    }
}
