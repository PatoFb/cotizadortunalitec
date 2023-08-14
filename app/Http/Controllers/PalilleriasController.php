<?php

namespace App\Http\Controllers;

use App\Models\Complement;
use App\Models\Cover;
use App\Models\Curtain;
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
use App\Models\RollWidth;
use App\Models\Sensor;
use App\Models\SystemCurtain;
use App\Models\VoiceControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
        $models = PalilleriaModel::all();
        $palilleria = $request->session()->get('palilleria');
        return view('palillerias.model', compact('order_id', 'models', 'palilleria'));
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
        if(empty($request->session()->get('palilleria'))){
            $palilleria = new Palilleria();
            $palilleria['order_id'] = $order_id;
            $palilleria->fill($validatedData);
            $request->session()->put('palilleria', $palilleria);
        }else{
            $palilleria = $request->session()->get('palilleria');
            $palilleria->fill($validatedData);
            $request->session()->put('palilleria', $palilleria);
        }
        return redirect()->route('palilleria.data', $order_id);
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
        $cov = Cover::all();
        $palilleria = $request->session()->get('palilleria');
        return view('palillerias.cover', compact('order_id', 'cov', 'palilleria'));
    }

    /**
     * It works exactly the same as the model post function, but without the if statement since
     * thanks to the validation, the session won't be empty once you reach this point
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
        $palilleria = $request->session()->get('palilleria');
        $palilleria->cover_id = $validatedData['cover_id'];
        $request->session()->put('palilleria', $palilleria);
        return redirect()->route('palilleria.features', $order_id);
    }

    /**
     * Works the same as the model and cover functions, but since we don't need any data for a radio list,
     * we won't send any objects but the curtain stored in session
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function addDat(Request $request, $id)
    {
        $order_id = $id;
        $palilleria = $request->session()->get('palilleria');
        $mechs = CurtainMechanism::all()->except(3);
        return view('palillerias.data', compact('order_id', 'palilleria', 'mechs'));
    }

    /**
     * Validation for the two numeric fields, store in session and then go to next step
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function addDataPost(Request $request, $id) {
        $order_id = $id;
        $validatedData = $request->validate([
            'width' => 'required',
            'height' => 'required',
            'mechanism_id' => 'required',
            'quantity' => 'required',
        ]);
        $palilleria = $request->session()->get('palilleria');
        $palilleria->fill($validatedData);
        if($palilleria['mechanism_id'] == 1) {
            $palilleria->control_id = 9999;
            $palilleria->voice_id = 9999;
            $palilleria->sensor_id = 9999;
        } elseif ($palilleria['mechanism_id'] == 4) {
            $palilleria->sensor_id = 9999;
            $palilleria->control_id = 1;
            $palilleria->voice_id = 1;
        } else {
            $palilleria->sensor_id = 1;
            $palilleria->control_id = 1;
            $palilleria->voice_id = 1;
        }
        $request->session()->put('palilleria', $palilleria);
        return redirect()->route('palilleria.cover', $order_id);
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

    public function addFeatures(Request $request, $id) {
        $order_id = $id;
        $reinforcements = Reinforcement::all();
        $palilleria = $request->session()->get('palilleria');
        if($palilleria->mechanism_id == 1) {
            $controls = CurtainControl::where('type', 'Manual')->get();
            $voices = VoiceControl::where('type', 'Manual')->get();
            $sensors = Sensor::where('id', 9999)->get();
        } elseif ($palilleria->mechanism_id == 4) {
            $controls = CurtainControl::where('type', 'Tube')->get();
            $voices = VoiceControl::where('type', 'Tube')->get();
            $sensors = Sensor::where('id', 9999)->get();
        } else {
            $controls = CurtainControl::where('type', 'Somfy')->get();
            $voices = VoiceControl::where('type', 'Somfy')->get();
            $sensors = Sensor::where('type', 'P')->get();
        }
        return view('palillerias.features', compact('order_id', 'palilleria', 'sensors', 'voices', 'reinforcements', 'controls'));
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
        $user = Auth::user();
        $validatedData = $request->validate([
            'control_id' => 'required',
            'sensor_id' => 'required',
            'voice_id' => 'required',
            'reinforcement_id' => 'required',
            'trave' => 'required',
            'goal' => 'required',
            'semigoal' => 'required',
            'control_quantity' => 'required',
            'sensor_quantity' => 'required',
            'voice_quantity' => 'required',
            'reinforcement_quantity' => 'required',
            'trave_quantity' => 'required',
            'semigoal_quantity' => 'required',
            'goal_quantity' => 'required',
        ]);
        $palilleria = $request->session()->get('palilleria');
        $palilleria->fill($validatedData);

        if($palilleria->model){
            $keys = ['model', 'cover', 'mechanism', 'control', 'voice', 'sensor', 'reinforcement'];
            foreach ($keys as $key) {
                unset($palilleria[$key]);
            }
            Session::forget('palilleria');
        }
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
        $request->session()->put('palilleria', $palilleria);
        return redirect()->route('palilleria.review', $order_id);
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
        $palilleria = $request->session()->get('palilleria');
        return view('palillerias.review', compact('order_id', 'palilleria'));
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
        $palilleria = $request->session()->get('palilleria');
        $palilleria->save();
        $order = Order::findOrFail($id);
        $order->price = $order->price + $palilleria['price'];
        $order->total = $order->total + $palilleria['price'];
        $order->save();
        $request->session()->forget('palilleria');
        return redirect()->route('orders.show', $order_id);
    }

    public function fetchCover(Request $request){
        $value = $request->get('cover_id');
        $palilleria = $request->session()->get('palilleria');
        $cover = Cover::findOrFail($value);
        $width = $palilleria['width'];
        $height = $palilleria['height'];
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

        if($cover->unions == 'Vertical') {
            //Calculates number of fabric needed for pricing
            $total_fabric = $measure * $full_rolls;
            echo "<div class='col-12'>
                <h4>Detalles de cubierta</h4>
               </div>
                <div class='row'>
                <div class='col-md-6 col-sm-12'>
                   <img src=".asset('storage')."/images/".$cover->photo." style='width: 100%;'>
              </div>
              <div class='col-md-6 col-sm-12'>
                   <h7 style='color: grey;'><strong>$cover->name</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Ancho de rollo: <strong>$cover->roll_width mts</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Uniones: <strong>$cover->unions</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Medida de lienzos: <strong>$measure mts</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Número de sublienzos: <strong>$sub_rolls</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Número de lienzos: <strong>$full_rolls</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Total de textil: <strong>$total_fabric mts</strong></h7>
              </div>
                </div>
              ";
            //Calculates total pricing of fabric plus handiwork plus IVA
        } else {
            $range = RollWidth::where('width', $cover->roll_width)->where('meters', $height)->value('range');
            $num_lienzos = Complement::where('range', $range)->value('complete');
            $complement = Complement::where('range', $range)->value('complements');
            $total_fabric = $num_lienzos * $width;
            echo "<div class='col-12'>
                <h4>Detalles de cubierta</h4>
               </div>
                <div class='row'>
                <div class='col-md-6 col-sm-12'>
                   <img src=".asset('storage')."/images/".$cover->photo." style='width: 100%;'>
              </div>
              <div class='col-md-6 col-sm-12'>
                   <h7 style='color: grey;'><strong>$cover->name</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Ancho de rollo: <strong>$cover->roll_width mts</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Uniones: <strong>$cover->unions</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Número de lienzos: <strong>$num_lienzos</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Medida de lienzos: <strong>$measure mts</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Complementos: <strong>$complement</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Total de textil: <strong>$total_fabric mts</strong></h7>
              </div>
                </div>
              ";
        }
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
