<?php

namespace App\Http\Controllers;

use App\Models\Cover;
use App\Models\CurtainCanopy;
use App\Models\CurtainControl;
use App\Models\CurtainCover;
use App\Models\CurtainHandle;
use App\Models\CurtainMechanism;
use App\Models\CurtainModel;
use App\Models\Order;
use App\Models\Palilleria;
use App\Models\PalilleriaModel;
use App\Models\PalilleriasPrice;
use App\Models\Reinforcement;
use App\Models\Sensor;
use App\Models\VoiceControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $covers = Cover::all();
        $controls = CurtainControl::all();
        $mechanisms = CurtainMechanism::whereIn('id', [1, 2, 4])->get();
        $reinforcements = Reinforcement::all();
        $sensors = Sensor::where('type', 'P')->get();
        $models = PalilleriaModel::all();
        return view('palillerias.create', compact('order_id',  'covers', 'controls', 'order', 'mechanisms', 'reinforcements', 'sensors', 'models'));
    }

    public function save(Request $request, $id)
    {
        $order_id = $id;
        $user = Auth::user();
        $order = Order::findOrFail($id);
            $validatedData = $request->validate([
                'cover_id' => 'required',
                'width' => 'required',
                'height' => 'required',
                'quantity' => 'required',
                'mechanism_id'=>'required',
                'model_id'=>'required',
            ]);
        $palilleria = new Palilleria();
        $palilleria['order_id'] = $order_id;
        $palilleria->fill($validatedData);
        $cover = Cover::where('id', $palilleria['cover_id'])->first();

        $control = CurtainControl::where('id', $palilleria['control_id'])->first();

        $mechanism_id = $palilleria['mechanism_id'];

        $model = PalilleriaModel::where('id', $palilleria['model_id'])->first();
        $sensor = Sensor::where('id', $palilleria['sensor_id'])->first();

        $voice = VoiceControl::where('id', $palilleria['voice_id'])->first();

        $width = $palilleria['width'];
        $height = $palilleria['height'];
        $quantity = $palilleria['quantity'];

        $goal = $palilleria['goal'];
        $semigoal= $palilleria['semigoal'];
        $trave = $palilleria['trave'];
        $guide = $palilleria['reinforcement_id'];

        $cquant = $palilleria['control_quantity'];
        $rquant = $palilleria['reinforcement_quantity'];
        $squant = $palilleria['sensor_quantity'];
        $tquant = $palilleria['trave_quantity'];
        $gquant = $palilleria['goal_quantity'];
        $sgquant = $palilleria['semigoal_quantity'];
        $vquant = $palilleria['voice_quantity'];
        if($cover->roll_width == 1.16 || $cover->roll_width == 1.2) {
            $useful_subrolls = 2;
        } elseif ($cover->roll_width == 1.52 || $cover->roll_width == 1.77) {
            $useful_subrolls = 3;
        } elseif ($cover->roll_width == 2.67 || $cover->roll_width == 3.04) {
            $useful_subrolls = 5;
        } elseif ($cover->roll_width == 2.5) {
            $useful_subrolls = 4;
        } else {
            $useful_subrolls = 6;
        }


        if($cover->roll_width == 1.16 || $cover->roll_width == 1.2 || $cover->roll_width == 3.2 || $cover->roll_width == 1.77) {
            $factor = 0.45;
        } else {
            $factor = 0.4;
        }

        $sub_rolls = ceil($height/$factor);
        $full_rolls = ceil($sub_rolls/$useful_subrolls);
        $measure = $height + 0.07;
        $total_fabric = $measure * $full_rolls;
        $total_cover = $cover->price * $total_fabric;

        $work_price = 50 * (ceil($width * $height));
        $bubble_price = (900/35) * ($width*6) + (($width*6)/3) + 257.14;
        $operation_costs = $work_price + $bubble_price;

        //Control plus IVA
        $control_total = $control->price * $cquant;
        $sensor_total = $sensor->price * $squant;
        $voice_total = $voice->price * $vquant;
        Log::info($total_cover);
        Log::info($operation_costs);

        if($height <= 5) {
            $sop_quant = 2;
        } elseif($height >= 9) {
            $sop_quant = 4;
        } else {
            $sop_quant = 3;
        }

        if($guide != 0){
            $extra_guides  = ((462.89*$height+400) + (136.14 * $sop_quant) + (129.23) + (46.46*$sub_rolls)) * $rquant;
        } else {
            $extra_guides  = 0;
        }

        if($goal != 0){
            $total_goals = 6361 * $gquant;
        } else {
            $total_goals = 0;
        }

        if($semigoal != 0){
            $total_semigoals = 4550 * $sgquant;
        } else {
            $total_semigoals = 0;
        }

        if($trave != 0){
            $total_trave = 2996.45 * $tquant;
        } else {
            $total_trave = 0;
        }

        $reinforcement_total = $total_trave + $total_semigoals + $total_goals + $extra_guides;
        $goals_total = $model->price;

        $palilleria_price = PalilleriasPrice::where('width', ceil($width))->where('height', ceil($height))->first();
        $pprice = $palilleria_price->price;


        //Pricing of user selected option
        switch($mechanism_id) {
            case 1:
                $acc = $reinforcement_total;
                $p = $pprice + $goals_total + $total_cover + $operation_costs;
                $palilleria['price'] = ($acc + $p) / 0.6 * (1 - ($user->discount/100)) * $quantity * 1.16;
                break;
            case 2:
                $acc = $reinforcement_total + $control_total + $voice_total + $sensor_total;
                $p = $pprice + $goals_total + $total_cover + $operation_costs + 15021;
                $palilleria['price'] = ($acc + $p) / 0.6 * (1 - ($user->discount/100)) * $quantity * 1.16;
                break;
            case 4:
                $acc = $reinforcement_total + $control_total + $voice_total;
                $p = $pprice + $goals_total + $total_cover + $operation_costs + 10416;
                $palilleria['price'] = ($acc + $p) / 0.6 * (1 - ($user->discount/100)) * $quantity * 1.16;
                break;
            default:
                $palilleria['price'] = 0;
                break;
        }
        $palilleria->save();
        $order->price = $order->price + $palilleria['price'];
        $order->total = $order->total + ($palilleria['price'] * (1 - ($order->discount/100)));
        $order->user_id = $user->getAuthIdentifier();
        $order->save();
        return redirect()->route('orders.show', $order_id)->withStatus(__('Palillería agregada correctamente'));
    }

    public function fetchData(Request $request){
        $user = Auth::user();
        $input = $request->all();

        $cover = Cover::where('id', $input['cover_id'])->first();

        $mechanism_id = $input['mechanism_id'];

        $model = PalilleriaModel::where('id', $input['model_id'])->first();

        $width = $input['width'];
        $height = $input['height'];
        $quantity = $input['quantity'];

        $rquant = $input['reinforcement_quantity'];
        if($cover->roll_width == 1.16 || $cover->roll_width == 1.2) {
            $useful_subrolls = 2;
        } elseif ($cover->roll_width == 1.52 || $cover->roll_width == 1.77) {
            $useful_subrolls = 3;
        } elseif ($cover->roll_width == 2.67 || $cover->roll_width == 3.04) {
            $useful_subrolls = 5;
        } elseif ($cover->roll_width == 2.5) {
            $useful_subrolls = 4;
        } else {
            $useful_subrolls = 6;
        }


        if($cover->roll_width == 1.16 || $cover->roll_width == 1.2 || $cover->roll_width == 3.2 || $cover->roll_width == 1.77) {
            $factor = 0.45;
        } else {
            $factor = 0.4;
        }

        $sub_rolls = ceil($height/$factor);
        $full_rolls = ceil($sub_rolls/$useful_subrolls);
        $measure = $height + 0.07;
        $total_fabric = $measure * $full_rolls;
        $total_cover = $cover->price * $total_fabric;

        $work_price = 50 * (ceil($width * $height));
        $bubble_price = (900/35) * ($width*6) + (($width*6)/3) + 257.14;
        $operation_costs = $work_price + $bubble_price;


        if($width <= 5) {
            $guide_t = 2;
        } else {
            $guide_t = 3;
        }

        $total_guides = $guide_t + $rquant;

        $goals_total = $model->price;

        $palilleria_price = PalilleriasPrice::where('width', ceil($width))->where('height', ceil($height))->first();
        $pprice = $palilleria_price->price;

        //Pricing of user selected option
        switch($mechanism_id) {
            case 1:
                $price = (($pprice + $goals_total + $total_cover + $operation_costs) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;
                break;
            case 2:
                $price = (($pprice + $goals_total + $total_cover + $operation_costs + 15021) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;
                break;
            case 4:
                $price = (($pprice + $goals_total + $total_cover + $operation_costs + 10416) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;
                break;
            default:
                $price = 0;
                break;
        }
        $price = number_format($price, 2);

        //Pricing of manual mechanism
        $price_manual = (($pprice + $goals_total + $total_cover + $operation_costs) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;
        $price_manual = number_format($price_manual, 2);

        //Pricing of somfy mechanism
        $price_somfy = (($pprice + $goals_total + $total_cover + $operation_costs + 15021) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;
        $price_somfy = number_format($price_somfy, 2);

        //Pricing of tube mechanism
        $price_tube = (($pprice + $goals_total + $total_cover + $operation_costs + 10416) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;
        $price_tube = number_format($price_tube,2);
        if($width > 5 or $height > 5) {
            echo "<div class='text-right'>
<div class='col-md-12 col-sm-12'><h3><strong>Precio seleccionado: $$price</strong></h3></div></div>
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
<br>
<div class='row'>
<div class='col-md-4 col-sm-12'>
                   <img src=" . asset('storage') . "/images/" . $model->photo . " style='width: 100%;' alt='Image not found'>
              </div>
              <div class='col-md-7 col-sm-12'>
            <h4>Detalles de sistema</h4>
             <h4 class='text-danger'>Sistema no entra en garantía!</h4>
            <div class='row'>
              <div class='col-md-12 col-sm-12'>
                   <h7 style='color: grey;'>Número de guías calculadas: <strong>$total_guides</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Máxima resistencia al viento de <strong>38 km/h</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Tiempo de producción: <strong>7 días hábiles</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Ancho máximo: <strong>5.00 m</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Salida máxima: <strong>5.00 m</strong></h7>
              </div>
              </div>
              <hr>
                <div class='row'>
              <div class='col-md-12 col-sm-12'>
                   <h7 style='color: grey;'><strong>$cover->name</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Ancho de rollo: <strong>$cover->roll_width mts</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Número de sublienzos: <strong>$sub_rolls</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Uniones: <strong>$cover->unions</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Número de lienzos: <strong>$full_rolls</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Medida de lienzos: <strong>$measure</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Total de textil: <strong>$total_fabric</strong></h7>
              </div>
                </div>
              </div>
              </div>";
        } else {
            echo "<div class='text-right'>
<div class='col-md-12 col-sm-12'><h3><strong>Precio seleccionado: $$price</strong></h3></div></div>
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
<br>
<div class='row'>
<div class='col-md-4 col-sm-12'>
                   <img src=" . asset('storage') . "/images/" . $model->photo . " style='width: 100%;' alt='Image not found'>
              </div>
              <div class='col-md-7 col-sm-12'>
            <h4>Detalles de sistema</h4>
            <div class='row'>
              <div class='col-md-12 col-sm-12'>
                   <h7 style='color: grey;'>Número de guías calculadas: <strong>$total_guides</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Máxima resistencia al viento de <strong>38 km/h</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Tiempo de producción: <strong>7 días hábiles</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Ancho máximo: <strong>5.00 m</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Salida máxima: <strong>5.00 m</strong></h7>
              </div>
              </div>
              <hr>
                <div class='row'>
              <div class='col-md-12 col-sm-12'>
                   <h7 style='color: grey;'><strong>$cover->name</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Ancho de rollo: <strong>$cover->roll_width mts</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Número de sublienzos: <strong>$sub_rolls</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Uniones: <strong>$cover->unions</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Número de lienzos: <strong>$full_rolls</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Medida de lienzos: <strong>$measure</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Total de textil: <strong>$total_fabric</strong></h7>
              </div>
                </div>
              </div>
              </div>";
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchAccessories(Request $request){
        $user = Auth::user();
        $input = $request->all();
        $mechanism_id = $input['mechanism_id'];
        $cover = Cover::where('id', $input['cover_id'])->first();
        $quantity = $input['quantity'];

        $control = CurtainControl::where('id', $input['control_id'])->first();

        $sensor = Sensor::where('id', $input['sensor_id'])->first();

        $voice = VoiceControl::where('id', $input['voice_id'])->first();

        $height = $input['height'];

        $goal = $input['goal'];
        $semigoal= $input['semigoal'];
        $trave = $input['trave'];
        $guide = $input['reinforcement_id'];

        $cquant = $input['control_quantity'];
        $rquant = $input['reinforcement_quantity'];
        $squant = $input['sensor_quantity'];
        $tquant = $input['trave_quantity'];
        $gquant = $input['goal_quantity'];
        $sgquant = $input['semigoal_quantity'];
        $vquant = $input['voice_quantity'];


        if($cover->roll_width == 1.16 || $cover->roll_width == 1.2 || $cover->roll_width == 3.2 || $cover->roll_width == 1.77) {
            $factor = 0.45;
        } else {
            $factor = 0.4;
        }

        $sub_rolls = ceil($height/$factor);

        //Control plus IVA
        $control_total = $control->price * $cquant;
        $sensor_total = $sensor->price * $squant;
        $voice_total = $voice->price * $vquant;


        if($height <= 5) {
            $sop_quant = 2;
        } elseif($height >= 9) {
            $sop_quant = 4;
        } else {
            $sop_quant = 3;
        }

        if($guide != 0){
            $extra_guides  = ((462.89*$height+400) + (136.14 * $sop_quant) + (129.23) + (46.46*$sub_rolls)) * $rquant;
        } else {
            $extra_guides  = 0;
        }

        if($goal != 0){
            $total_goals = 6361 * $gquant;
        } else {
            $total_goals = 0;
        }

        if($semigoal != 0){
            $total_semigoals = 4550 * $sgquant;
        } else {
            $total_semigoals = 0;
        }

        if($trave != 0){
            $total_trave = 2996.45 * $tquant;
        } else {
            $total_trave = 0;
        }

        $reinforcement_total = $total_trave + $total_semigoals + $total_goals + $extra_guides;


        //Pricing of user selected option
        switch($mechanism_id) {
            case 1:
                $price = (($reinforcement_total) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;
                break;
            case 2:
                $price = (($reinforcement_total + $control_total + $voice_total + $sensor_total) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;
                break;
            case 4:
                $price = (($reinforcement_total + $control_total + $voice_total) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;
                break;
            default:
                $price = 0;
                break;
        }
        $accp = number_format($price, 2);
        echo "<div class='text-right'><h3><strong>Total de accesorios: $$accp</strong></h3></div>";
    }

    public function fetchControls(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependentP1');
        if($value == '4' or $value == '1'){
            $type = 'Tube';
        } else {
            $type = 'Somfy';
        }
        $data = CurtainControl::where('type', $type)->get();
        $output = '<option value="">Seleccionar control</option>';
        foreach($data as $row){
            $output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        echo $output;
    }

    public function fetchVoices(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependentP2');
        if($value == '4' or $value == '1'){
            $type = 'Tube';
        } else {
            $type = 'Somfy';
        }
        $data = VoiceControl::where('type', $type)->get();

        $output = '<option value="">Seleccionar control de voz</option>';
        foreach($data as $row){
            $output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        Log::info($output);
        echo $output;
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
