<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypesRequest;
use App\Models\Order;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::all();
        return view('admin.types.index', compact('types'));
    }

    public function productType($id)
    {
        $user = Auth::user();
        $order_id = $id;
        $types = Type::pluck('name', 'id')->all();
        return view('products.type', compact('order_id', 'types'));
    }

    /**
     * Funtion to select the type of product to add to order. For now it's only possible to add curtains but the switch is already implemented
     * for when I add the other types.
     *
     * In case you select a non valid one, you will be redirected back, if not, you'll go to the model selection page (CurtainsController)
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function productTypePost(Request $request, $id)
    {
        $order_id = $id;
        switch ($request['type_id']){
            case 1:
                //return redirect()->route('curtain.add', $order_id);
                $request->session()->forget('curtain');
                return redirect()->route('curtain.model', $order_id);
                break;
            case 3:
                $request->session()->forget('palilleria');
                return redirect()->route('palilleria.model', $order_id);
                break;
            case 4:
                $request->session()->forget('toldo');
                return redirect()->route('toldo.model', $order_id);
                break;
            default:
                return redirect()->route('orders.type', $order_id)->withStatus(__('Elija un producto válido'));
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('/admin/types');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypesRequest $request)
    {
        $type = $request->all();
        Type::create($type);
        return redirect()->back()->withStatus(__('Tipo guardado correctamente'));
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
        $type = Type::findOrFail($id);
        return view('admin.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TypesRequest $request, $id)
    {
        $type = Type::findOrFail($id);
        $input = $request->all();
        $type->update($input);
        return redirect('/admin/types')->withStatus(__('Tipo editado correctamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();
        return redirect('admin/types')->withStatus(__('Tipo eliminado correctamente'));
    }
}
