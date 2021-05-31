<?php

namespace App\Http\Controllers;

use App\Mail\OrdenAProduccion;
use App\Models\Curtain;
use App\Models\Order;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

    public function all()
    {
        $orders = Order::where('activity', 'Pedido')->get();
        $offers = Order::where('activity', 'Oferta')->get();
        $prods = Order::where('activity', 'Produccion')->get();
        return view('admin.orders.index', compact('orders', 'offers', 'prods'));
    }

    public function production($id)
    {
        $order = Order::findOrFail($id);
        $user = User::findOrFail($order->user_id);
        $order->activity = 'Produccion';
        $order->save();
        Mail::to($user->email)->send(new OrdenAProduccion($user, $order));
        return redirect()->back()->withStatus(__('La orden fue autorizada'));
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
            'activity'=>'required',
            'project'=>'required',
            'discount' => 'required'
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

    public function details($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.show', compact('order'));
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

    public function upload(Request $request, $id){
        $order = Order::findOrFail($id);
        //get file value from input
        $file = $request->file('file');
        $date = Carbon::now()->format('YmdHs');
        //check if file isn't null. If it is, assign a default value, if it isn't, get and store the name and then save the file in the disk
        if($file != '') {
            $name = $date.$file->getClientOriginalName();
            $order->file = $name;
            $request->file->storeAs('comprobantes/', $name);
        } else {
            $order->file = '';
        }
        $order->save();
        return redirect()->back()->withStatus(__('Comprobante subido correctamente'));
    }

    public function download($id)
    {
        $order = Order::findOrFail($id);
        $pathToFile = storage_path('app/comprobantes/' . $order->file);
        return response()->download($pathToFile);
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
