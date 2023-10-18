<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\OrdersEditRequest;
use App\Mail\OrdenAProduccion;
use App\Mail\PedidoCerrado;
use App\Models\Curtain;
use App\Models\Order;
use App\Models\Palilleria;
use App\Models\Toldo;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function record()
    {
        $orders = Order::where('activity', 'Cerrada')->get();;
        return view('admin.orders.record', compact('orders'));
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

    public function makeOrder($id)
    {
        $order = Order::findOrFail($id);
        foreach ($order->curtains as $curtain) {
            if(!$curtain->installation_type || !$curtain->mechanism_side || $curtain->cover_id <= 10) {
                if($curtain->installation_type == '' || $curtain->mechanism_side == '') {
                    $status = 'Asegurese de ingresar los datos para producción de cada sistema antes de realizar el pedido.';
                    return redirect()->back()->withError(__($status));
                }
                if($curtain->cover_id <= 10) {
                    $status = 'Asegurese de no tener estilos pendientes antes de realizar el pedido.';
                    return redirect()->back()->withError(__($status));
                }
            } else {
                $status = 'Su pedido fue realizado exitosamente, pasará a revisión del equipo para confirmar su pago. Gracias!';
                $order->activity = 'Pedido';
                $order->save();
                return redirect()->back()->withStatus(__($status));
            }
        }
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $user = User::findOrFail($order->user_id);
        $order->activity = 'Pedido';
        $order->save();
        return redirect()->back()->withStatus(__('La orden fue devuelta a pedido'));
    }

    public function close($id)
    {
        $order = Order::findOrFail($id);
        $user = User::findOrFail($order->user_id);
        $order->activity = 'Cerrada';
        $order->save();
        Mail::to($user->email)->send(new PedidoCerrado($user, $order));
        return redirect()->back()->withStatus(__('La orden fue cerrada exitosamente'));
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
     * @throws AuthorizationException
     */
    public function newOrderPost(Request $request)
    {
        $order_id = $this->saveOrder($request);
        return redirect()->route('orders.type', $order_id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     * @throws AuthorizationException
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $user = Auth::user();
        if(!auth()->user()->isAdmin()) {
            $this->authorize('checkUser', $order);
        }
        $role = $user->role_id;
        return view('orders.show', compact('order', 'role'));
    }

    /**
     * @throws AuthorizationException
     */
    public function details($id)
    {
        $order = Order::findOrFail($id);
        if(!auth()->user()->isAdmin()) {
            $this->authorize('checkUser', $order);
        }
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  $id
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function update(OrdersEditRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        if(!auth()->user()->isAdmin()) {
            $this->authorize('checkUser', $order);
        }
        $input = $request->all();
        $order->update($input);
        return redirect('orders/'.$id)->withStatus('Orden editada correctamente');
    }

    public function upload(Request $request, $id){
        //get file value from input
        $this->fileValidation($id, $request);
        return redirect()->back()->withStatus(__('Comprobante subido correctamente'));
    }

    public function orderPdf($order_id)
    {
        // Fetch order details from the database
        $order = Order::find($order_id);

        if (!$order) {
            abort(404); // Handle order not found
        }

        // Load the PDF template
        $pdf = Pdf::setOption('is-html5-parser-enabled', true)
            ->loadView('orders.pdf', compact('order'));

        // Generate the PDF
        return $pdf->stream('Detalles proyecto ' . $order->id . '.pdf');
    }

    /**
     * @throws AuthorizationException
     */
    public function download($id)
    {
        $order = Order::findOrFail($id);
        if(!auth()->user()->isAdmin()) {
            $this->authorize('checkUser', $order);
        }
        $pathToFile = storage_path('app/comprobantes/' . $order->file);
        return response()->download($pathToFile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if(!auth()->user()->isAdmin()) {
            $this->authorize('checkUser', $order);
        }
        $order->delete();
        return redirect('orders/')->withStatus('Orden eliminada correctamente');
    }

    /**
     * @throws AuthorizationException
     */
    private function saveOrder(Request $request): int {
        $user = Auth::user();
        $customMessages = [
            'project.required' => 'El campo proyecto es obligatorio.',
            'project.max' => 'El campo proyecto debe tener máximo :max caracteres.',
            'project.min' => 'El campo proyecto debe tener mínimo :min caracteres.',
            'project.string' => 'El campo proyecto debe ser una cadena de texto.',
            'discount.required' => 'El campo descuento es obligatorio.',
            'discount.min' => 'El descuento debe ser al menos :min.',
            'discount.max' => 'El descuento debe ser como máximo :max.',
            'discount.numeric' => 'El descuento debe ser un número.',
            'comment.string' => 'El comentario debe ser una cadena de texto.',
            'city.required' => 'El campo ciudad es obligatorio.',
            'state.required' => 'El campo estado es obligatorio.',
            'zip_code.required' => 'El campo código postal es obligatorio.',
            'zip_code.digits' => 'El código postal debe tener :digits dígitos.',
            'zip_code.integer' => 'El código postal debe ser un número entero.',
            'line1.required' => 'El campo dirección (línea 1) es obligatorio.',
            'line2.required' => 'El campo dirección (línea 2) es obligatorio.',
            'reference.string' => 'La referencia debe ser una cadena de texto.',
        ];
        if($request->get('addressCheck') == 1) {
            $request->validate([
                'project' => ['required', 'max:255', 'min:3', 'string'],
                'discount' => ['required', 'min:0', 'max:100', 'numeric'],
                'comment' => ['nullable','string']
            ], $customMessages);
            $order = $request->all();
            $order['city'] = $user->city;
            $order['state'] = $user->state;
            $order['zip_code'] = $user->zip_code;
            $order['line1'] = $user->line1;
            $order['line2'] = $user->line2;
            $order['reference'] = $user->reference;
        } else {
            $request->validate([
                'project' => ['required', 'max:255', 'min:3', 'string'],
                'discount' => ['required', 'min:0', 'max:100', 'numeric'],
                'comment' => ['nullable','string'],
                'city' => ['required'],
                'state' => ['required'],
                'zip_code' => ['required', 'digits:5', 'integer'],
                'line1' => ['required'],
                'line2' => ['required'],
                'reference' => ['nullable','string'],
            ], $customMessages);
            $order = $request->all();
        }
        $order['user_id'] = $user->id;
        $order['activity'] = 'Oferta';
        Order::create($order);
        $orderObj = Order::where('user_id', $user->id)->orderBy('id', 'DESC')->first();
        return $orderObj->id;
    }

    private function fileValidation($id, Request $request) {
        $file = $request->file('file');
        $order = Order::findOrFail($id);
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
    }
}
