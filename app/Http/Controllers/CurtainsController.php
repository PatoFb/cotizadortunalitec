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

    /**
     * Receives order id through URI and sends it to the next step.
     *
     * Sends all models to the view
     *
     * Creates a session for the product in which information will be stored and sends it
     * to the view so the data the user enters is saved as well
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addModel(Request $request, $id)
    {
        $order_id = $id;
        $models = CurtainModel::all();
        $curtain = $request->session()->get('curtain');
        return view('curtains.model', compact('order_id', 'models', 'curtain'));
    }

    /**
     * Post route
     *
     * Gets order id from URI and sends it again to the view
     *
     * Validation requirement for the model
     *
     * If session is empty it will create a new Curtain object, save the order id there and the validated data
     *
     * If session isn't empty it will just update the data
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

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

    /**
     * Works exactly the same as the model function, but with covers
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function addCover(Request $request, $id)
    {
        $order_id = $id;
        $covers = CurtainCover::all();
        $curtain = $request->session()->get('curtain');
        return view('curtains.cover', compact('order_id', 'covers', 'curtain'));
    }

    /**
     * It works exactly the same as the model post function, but without the if statement since
     * thanks to the validation, the session wont be empty once you reach this point
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

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

    /**
     * Works the same as the model and cover functions, but since we don't need any data for a radio list,
     * we won't send any objects but the curtain stored in session
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function addData(Request $request, $id)
    {
        $order_id = $id;
        $curtain = $request->session()->get('curtain');
        return view('curtains.data', compact('order_id', 'curtain'));
    }

    /**
     * Validation for the two numeric fields, store in session and then go to next step
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

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

    /**
     * We have three fields with relationships, we will get these with select forms, so we have to send the object
     * to the view.
     *
     * We keep sending the session
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function addFeatures(Request $request, $id)
    {
        $order_id = $id;
        $handles = CurtainHandle::all();
        $canopies = CurtainCanopy::all();
        $controls = CurtainControl::all();
        $curtain = $request->session()->get('curtain');
        return view('curtains.features', compact('order_id', 'curtain', 'handles', 'canopies', 'controls'));
    }

    /**
     * Validation for the four fields asked on this step, store in session
     *
     * We get the prices of the other objects from other tables using all the ids stored in the session
     *
     * For now, price calculating is just a simple sum multiplied by the quantity selected
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

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

    /**
     * This is the last step and you will be able to review all the details of your product
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function review(Request $request, $id)
    {
        $order_id = $id;
        $curtain = $request->session()->get('curtain');
        return view('curtains.review', compact('order_id', 'curtain'));
    }

    /**
     * Here it will save the product once you hit submit
     *
     * It will calculate the price and total with discount here to display it with your order,
     * updating the object after calculating it
     *
     * You can go back to any previous step at any point until you save the product
     *
     * It will clean the object in the session once you save it
     *
     * It will redirect you to a view with your order details (OrdersController)
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function reviewPost(Request $request, $id)
    {
        $order_id = $id;
        $curtain = $request->session()->get('curtain');
        $curtain->save();
        $order = Order::findOrFail($id);
        $order->price = $order->price + $curtain['price'];
        $order->total = $order->total + ($curtain['price']*(1 - ($order->discount/100)));
        $order->save();
        $request->session()->forget('curtain');
        return redirect()->route('orders.show', $order_id);
    }

    /**
     * Delete a curtain from an order and subtract the total price
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $curtain = Curtain::findOrFail($id);
        $order = Order::where('id', $curtain->order_id)->first();
        $order->price = $order->price - $curtain->price;
        $order->total = $order->price - ($order->price * ($order->discount/100));
        $order->save();
        $curtain->delete();
        return redirect()->back()->withStatus('Producto eliminado correctamente');
    }
}
