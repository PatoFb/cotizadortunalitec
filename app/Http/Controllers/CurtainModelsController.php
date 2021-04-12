<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurtainModelsEditRequest;
use App\Http\Requests\CurtainModelsRequest;
use App\Models\CurtainModel;
use App\Models\Type;
use Illuminate\Http\Request;

class CurtainModelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = CurtainModel::all();
        return view('admin.curtains.models.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::pluck('name', 'id')->all();
        return view('admin.curtains.models.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurtainModelsRequest $request)
    {
        $input = $request->all();
        //get file value from input
        $file = $request->file('photo');
        //check if file isn't null. If it is, assign a default value, if it isn't, get and store the name and then save the file in the disk
        if($file != '') {
            $name = $file->getClientOriginalName();
            $input['photo'] = $name;
            $request->photo->storeAs('public/images/', $name);
        } else {
            $input['photo'] = 'default-avatar.png';
        }
        CurtainModel::create($input);
        return redirect('/admin/models')->withStatus(__('Modelo agregado correctamente'));
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
        $types = Type::pluck('name', 'id')->all();
        $model = CurtainModel::findOrFail($id);
        return view('admin.curtains.models.edit', compact('types', 'model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CurtainModelsEditRequest $request, $id)
    {
        $model = CurtainModel::findOrFail($id);
        $input = $request->all();
        //get file value from input
        $file = $request->file('photo');
        //check if file isn't null. If it is, assign the same value it had, if it isn't, get and store the name and then save the file in the disk
        if($file != '') {
            $name = $file->getClientOriginalName();
            $input['photo'] = $name;
            $request->photo->storeAs('public/images/', $name);
        } else {
            $input['photo'] = $model->photo;
        }
        $model->update($input);
        return redirect('/admin/models')->withStatus(__('Modelo actualizado correctamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = CurtainModel::findOrFail($id);
        $model->delete();
        return redirect('/admin/models')->withStatus(__('Modelo eliminado correctamente'));
    }
}
