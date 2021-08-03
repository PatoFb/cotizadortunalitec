<?php

namespace App\Http\Controllers;

use App\Models\CurtainCanopy;
use App\Models\CurtainControl;
use App\Models\CurtainCover;
use App\Models\CurtainHandle;
use App\Models\CurtainMechanism;
use App\Models\CurtainModel;
use App\Models\Order;
use App\Models\Palilleria;
use App\Models\PalilleriasPrice;
use App\Models\Reinforcement;
use Illuminate\Http\Request;

class PalilleriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * This function recieves the order_id through the URI and returns a view containing the form for the curtain creation.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function add($id)
    {
        $order_id = $id;
        $order = Order::findOrFail($id);
        $covers = CurtainCover::all();
        $controls = CurtainControl::all();
        $mechanisms = CurtainMechanism::all();
        $reinforcements = Reinforcement::all();
        return view('palillerias.create', compact('order_id',  'covers', 'controls', 'order', 'mechanisms', 'reinforcements'));
    }

    public function save(Request $request, $id)
    {
        $order_id = $id;
        $order = Order::findOrFail($id);
            $validatedData = $request->validate([
                'cover_id' => 'required',
                'width' => 'required',
                'height' => 'required',
                'control_id' => 'required',
                'control_quantity'=>'required',
                'quantity' => 'required',
                'mechanism_id'=>'required',
                'reinforcement_id'=>'required',
                'reinforcement_quantity'=>'required',
                'goals'=>'required'
            ]);
        $palilleria = new Palilleria();
        $palilleria['order_id'] = $order_id;
        $palilleria->fill($validatedData);
        $control = CurtainControl::where('id', $palilleria['control_id'])->first();
        $cover = CurtainCover::where('id', $palilleria['cover_id'])->first();
        $mechanism = CurtainMechanism::where('id', $palilleria['mechanism_id'])->first();
        $reinforcement = Reinforcement::where('id', $palilleria['reinforcement_id'])->first();

        $width = $palilleria['width'];
        $height = $palilleria['height'];
        $quantity = $palilleria['quantity'];
        $cquant = $palilleria['control_quantity'];
        $rquant = $palilleria['reinforcement_quantity'];
        $goals = $palilleria['goals'];

        //Calculates number of fabric needed for pricing
        $num_lienzos = ceil($width/$cover->roll_width);
        $measure = $height + 0.45;
        $total_fabric = $measure * $num_lienzos;

        $reinforcement_total = (($reinforcement->guide_price * $height + 400) + ($reinforcement->sop_price * 3) + ($reinforcement->hook_price) + (ceil($height * 0.45) * 42.68)) * $rquant;

        $goals_total= 5172.04 * 1.16 * $goals;

        //Calculates total pricing of fabric plus handiwork plus IVA
        $cover_price = $cover->price * $total_fabric;
        $work_price = (53 * $total_fabric)/(1 - 0.40);
        $total_cover = ($cover_price + $work_price) * 1.16;

        //Control plus IVA
        $control_total = $control->price * $cquant * 1.16;

        $palilleria_price = PalilleriasPrice::where('width', ceil($width))->where('height', ceil($height))->first();
        $pprice = $palilleria_price->price;
        //Pricing of user selected option
        $palilleria['price'] = ($pprice + $reinforcement_total + $goals_total + $control_total + $total_cover + ($mechanism->price * 1.16)) * $quantity;
        $palilleria->save();
        $order->price = $order->price + $palilleria['price'];
        $order->total = $order->total + ($palilleria['price'] * (1 - ($order->discount/100)));
        $order->save();
        return redirect()->route('orders.show', $order_id)->withStatus(__('Palillería agregada correctamente'));
    }

    public function fetchData(Request $request){
        $input = $request->all();

        $cover_id = $input['cover_id'];
        $cover = CurtainCover::find($cover_id);


        $control_id = $input['control_id'];
        $control = CurtainControl::find($control_id);

        $mechanism_id = $input['mechanism_id'];
        $mechanism = CurtainMechanism::find($mechanism_id);

        $reinforcement = Reinforcement::where('id', $input['reinforcement_id'])->first();

        //Gets all mechanisms for the comparison
        $manual = CurtainMechanism::find(1);
        $somfy = CurtainMechanism::find(2);
        $tube = CurtainMechanism::find(4);

        $width = $input['width'];
        $height = $input['height'];
        $quantity = $input['quantity'];

        $cquant = $input['control_quantity'];
        $rquant = $input['reinforcement_quantity'];
        $goals = $input['goals'];

        //Calculates number of fabric needed for pricing
        $num_lienzos = ceil($width/$cover->roll_width);
        $measure = $height + 0.45;
        $total_fabric = $measure * $num_lienzos;

        //Calculates total pricing of fabric plus handiwork plus IVA
        $cover_price = $cover->price * $total_fabric;
        $work_price = (53 * $total_fabric)/(1 - 0.40);
        $total_cover = ($cover_price + $work_price) * 1.16;

        //Control plus IVA
        $control_total = $control->price * $cquant * 1.16;

        $reinforcement_total = (($reinforcement->guide_price * $height + 400) + ($reinforcement->sop_price * 3) + ($reinforcement->hook_price) + (ceil($height * 0.45) * 42.68)) * $rquant;

        $goals_total= 5172.04 * 1.16 * $goals;

        $total_guides = 0;
        if ($width <= 7 && $width > 0) {
            $guides = 2;
        } else if ($width > 7) {
            $guides = 3;
        } else {
            $guides = 0;
        }

        $total_guides = $guides + $rquant;

        $palilleria_price = PalilleriasPrice::where('width', ceil($width))->where('height', ceil($height))->first();
        $pprice = $palilleria_price->price;

        //Pricing of user selected option
        switch($mechanism->id) {
            case 1:
                $price = ($pprice + $reinforcement_total + $goals_total + $total_cover + ($manual->price * 1.16)) * $quantity;
                break;
            case 2:
                $price = ($pprice + $reinforcement_total + $goals_total + $control_total + $total_cover + (($somfy->price + 6575) * 1.16)) * $quantity;
                break;
            case 4:
                $price = ($pprice + $reinforcement_total + $goals_total + $total_cover + (($tube->price + 6575) * 1.16)) * $quantity;
                break;
            default:
                $price = 0;
                break;
        }
        $price = number_format($price, 2);

        //Pricing of manual mechanism
        $price_manual = ($pprice + $reinforcement_total + $goals_total + $total_cover + ($manual->price * 1.16)) * $quantity;
        $price_manual = number_format($price_manual, 2);

        //Pricing of somfy mechanism
        $price_somfy = ($pprice + $reinforcement_total + $goals_total + $control_total + $total_cover + (($somfy->price + 6575) * 1.16)) * $quantity;
        $price_somfy = number_format($price_somfy, 2);

        //Pricing of tube mechanism
        $price_tube = ($pprice + $reinforcement_total + $goals_total + $total_cover + (($tube->price + 6575) * 1.16)) * $quantity;
        $price_tube = number_format($price_tube,2);
        echo "<div class='text-right'><h3><strong>Precio seleccionado: $$price</strong></h3></div>
            <div class='row text-right'>
<div class='col-md-4 col-sm-6'>
            <strong>Somfy <br>$$price_somfy</strong>
</div>
<div class='col-md-4 col-sm-6'>
            <strong>Tube <br>$$price_tube</strong>
</div>
<div class='col-md-4 col-sm-6'>
            <strong>Manual <br>$$price_manual</strong>
</div>
</div>
<hr>
<div class='row'>
<div class='col-md-5 col-sm-12'>
                   <img src=".asset('storage')."/images/".$cover->photo." style='width: 100%;'>
              </div>
              <div class='col-md-7 col-sm-12'>
<div>
            <h4>Detalles de sistema</h4>
            <div class='row'>
              <div class='col-md-12 col-sm-12'>
                   <h7 style='color: grey;'>Número de guías calculadas: <strong>$total_guides</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Máxima resistencia al viento de <strong>38 km/h</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Tiempo de producción: <strong>7 días hábiles</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Ancho máximo: <strong>7.00 m</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Salida máxima: <strong>7.00 m</strong></h7>
              </div>
              </div>
              <br>
              </div>
              <div>
                <div class='row'>
              <div class='col-md-12 col-sm-12'>
                   <h7 style='color: grey;'><strong>$cover->name</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Ancho de rollo: <strong>$cover->roll_width mts</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Uniones: <strong>$cover->unions</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Número de lienzos: <strong>$num_lienzos</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Medida de lienzos: <strong>$measure</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Total de textil: <strong>$total_fabric</strong></h7>
              </div>
                </div>
              </div>
              </div>
              </div>";
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $palilleria = Palilleria::findOrFail($id);
        $order = Order::where('id', $palilleria->order_id)->first();
        $order->price = $order->price - $palilleria->price;
        $order->total = $order->price - ($order->price * ($order->discount/100));
        $order->save();
        $palilleria->delete();
        return redirect()->back()->withStatus('Producto eliminado correctamente');
    }
}
