<?php

namespace App\Http\Controllers;

use App\Models\Curtain;
use App\Models\Order;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Call to post view to make order
     *
     * @return \Illuminate\Http\Response
     */
    public function newOrder()
    {
        $types = Type::pluck('name', 'id')->all();
        return view('orders.new', compact('types'));
    }

    /**
     * Function to create a new order, get the ID and pass it on the URI
     *
     * Forget a session (used for testing but left it just in case)
     *
     * You will be sent to the next step, selecting a type of product (TypesController)
     *
     * Added some validation
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function newOrderPost(Request $request)
    {
        $request->validate([
            'invoice_data' => 'required',
            'activity'=>'required',
            'project'=>'required'
        ]);
        $user = Auth::user();
        $order = $request->all();
        $order['user_id'] = $user->id;
        Order::create($order);
        $orderObj = Order::where('user_id', $user->id)->orderBy('id', 'DESC')->first();
        $order_id = $orderObj->id;
        $request->session()->forget('curtain');
        return redirect()->route('orders.type', $order_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $input = $request->all();
        $order->update($input);
        return redirect('orders/'.$id)->withStatus('Orden editada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $curtains = Curtain::where('order_id', $id)->get();
        foreach($curtains as $curtain){
            $curtain->delete();
        }
        $order->delete();
        return redirect('orders/')->withStatus('Orden eliminada correctamente');
    }
}
