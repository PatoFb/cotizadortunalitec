<?php

namespace App\Http\Controllers;

use App\Models\Curtain;
use App\Models\CurtainCanopy;
use App\Models\CurtainControl;
use App\Models\CurtainCover;
use App\Models\CurtainHandle;
use App\Models\CurtainModel;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurtainsController extends Controller
{

    public function addModel(Request $request, $id)
    {
        $order_id = $id;
        $models = CurtainModel::all();
        $curtain = $request->session()->get('curtain');
        return view('curtains.model', compact('order_id', 'models', 'curtain'));
    }

    public function addModelPost(Request $request, $id)
    {
        $order_id = $id;
        $validatedData = $request->validate([
            'model_id' => 'required',
        ]);
        if(empty($request->session()->get('curtain'))){
            $curtain = new Curtain();
            $curtain['order_id'] = $order_id;
            $curtain->fill($validatedData);
            $request->session()->put('curtain', $curtain);
        }else{
            $curtain = $request->session()->get('curtain');
            $curtain->fill($validatedData);
            $request->session()->put('curtain', $curtain);
        }
        return redirect()->route('curtain.cover', $order_id);
    }

    public function addCover(Request $request, $id)
    {
        $order_id = $id;
        $covers = CurtainCover::all();
        $curtain = $request->session()->get('curtain');
        return view('curtains.cover', compact('order_id', 'covers', 'curtain'));
    }

    public function addCoverPost(Request $request, $id)
    {
        $order_id = $id;
        $validatedData = $request->validate([
            'cover_id' => 'required',
        ]);
        $curtain = $request->session()->get('curtain');
        $curtain->fill($validatedData);
        $request->session()->put('curtain', $curtain);
        return redirect()->route('curtain.data', $order_id);
    }

    public function addData(Request $request, $id)
{
    $order_id = $id;
    $curtain = $request->session()->get('curtain');
    return view('curtains.data', compact('order_id', 'curtain'));
}

    public function addDataPost(Request $request, $id)
    {
        $order_id = $id;
        $validatedData = $request->validate([
            'width' => 'required',
            'height' => 'required',
        ]);
        $curtain = $request->session()->get('curtain');
        $curtain->fill($validatedData);
        $request->session()->put('curtain', $curtain);
        return redirect()->route('curtain.features', $order_id);
    }

    public function addFeatures(Request $request, $id)
    {
        $order_id = $id;
        $handles = CurtainHandle::all();
        $canopies = CurtainCanopy::all();
        $controls = CurtainControl::all();
        $curtain = $request->session()->get('curtain');
        return view('curtains.features', compact('order_id', 'curtain', 'handles', 'canopies', 'controls'));
    }

    public function addFeaturesPost(Request $request, $id)
    {
        $order_id = $id;
        $validatedData = $request->validate([
            'handle_id' => 'required',
            'canopy_id' => 'required',
            'control_id' => 'required',
            'quantity' => 'required'
        ]);
        $curtain = $request->session()->get('curtain');
        $curtain->fill($validatedData);
        $request->session()->put('curtain', $curtain);
        $handle = CurtainHandle::where('id', $curtain['handle_id'])->first();
        $canopy = CurtainCanopy::where('id', $curtain['canopy_id'])->first();
        $control = CurtainControl::where('id', $curtain['control_id'])->first();
        $model = CurtainModel::where('id', $curtain['model_id'])->first();
        $cover = CurtainCover::where('id', $curtain['cover_id'])->first();
        $curtain['price'] = ($handle->price + $canopy->price + $control->price + $model->base_price + $cover->price) * $curtain['quantity'];
        return redirect()->route('curtain.review', $order_id);
    }

    public function review(Request $request, $id)
    {
        $order_id = $id;
        $curtain = $request->session()->get('curtain');
        return view('curtains.review', compact('order_id', 'curtain'));
    }

    public function reviewPost(Request $request, $id)
    {
        $curtain = $request->session()->get('curtain');
        $curtain->save();
        $request->session()->forget('curtain');
        return redirect()->route('orders.show', $curtain['order_id']);
    }
}
