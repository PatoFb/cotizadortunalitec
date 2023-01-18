<?php

namespace App\Http\Controllers;

use App\Models\Complement;
use App\Models\Curtain;
use App\Models\CurtainControl;
use App\Models\Cover;
use App\Models\CurtainHandle;
use App\Models\CurtainMechanism;
use App\Models\CurtainModel;
use App\Models\Order;
use App\Models\ModeloToldo;
use App\Models\RollWidth;
use App\Models\Sensor;
use App\Models\SistemaToldo;
use App\Models\Toldo;
use App\Models\VoiceControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ToldosController extends Controller
{
    public function add($id)
    {
        $order_id = $id;
        $order = Order::findOrFail($id);
        $covers = Cover::all();
        $controls = CurtainControl::all();
        $mechanisms = CurtainMechanism::all();
        $models = ModeloToldo::all();
        $voices = VoiceControl::all();
        $sensors =  Sensor::all();
        $handles = CurtainHandle::all();
        return view('toldos.create', compact('order_id',  'handles', 'covers', 'controls', 'order', 'mechanisms', 'models', 'voices', 'sensors'));
    }

    public function show($id){
        $toldo = Toldo::findOrFail($id);
        return view('toldos.show');
    }

    public function save(Request $request, $id){
        $input = $request->all();
        $order_id = $id;
        $order = Order::findOrFail($id);
        $user = Auth::user();
        $validatedData = $request->validate([
            'cover_id' => 'required',
            'width' => 'required',
            'projection' => 'required',
            'control_id' => 'required',
            'control_quantity'=>'required',
            'quantity' => 'required',
            'mechanism_id'=>'required',
            'modelo_toldo_id'=>'required',
            'canopy_id'=>'required',
            'sensor_id'=>'required',
            'sensor_quantity'=>'required',
            'bambalina'=>'required',
            'voice_id'=>'required',
            'voice_quantity'=>'required',
            'handle_id'=>'required',
            'handle_quantity'=>'required',
        ]);
        $toldo = new Toldo();
        $toldo['order_id'] = $order_id;
        $toldo['model_id'] = $input['modelo_toldo_id'];
        $toldo->fill($validatedData);
        $cover_id = $input['cover_id'];
        $cover = Cover::find($cover_id);

        $model_id = $input['modelo_toldo_id'];
        $model = ModeloToldo::find($model_id);

        $control_id = $input['control_id'];
        $control = CurtainControl::find($control_id);

        $mechanism_id = $input['mechanism_id'];

        $sensor_id = $input['sensor_id'];
        $sensor = Sensor::find($sensor_id);

        $voice_id = $input['voice_id'];
        $voice = VoiceControl::find($voice_id);

        $handle_id = $input['handle_id'];
        $handle = CurtainHandle::find($handle_id);

        $bambalina = $input['bambalina'];
        $canopy = $input['canopy_id'];

        $width = $input['width'];
        $projection = $input['projection'];
        $quantity = $input['quantity'];
        $cquant = $input['control_quantity'];
        $vquant = $input['voice_quantity'];
        $squant = $input['sensor_quantity'];
        $hquant = $input['handle_quantity'];

        //Calculates number of fabric needed for pricing
        $num_lienzos = ceil($width/$cover->roll_width);
        $measure = $projection + 0.75;
        $total_fabric = $measure * $num_lienzos;

        //Calculates total pricing of fabric plus handiwork plus IVA
        $cover_price = $cover->price * $total_fabric;
        $work_price = (40 * $total_fabric);
        $total_cover = ($cover_price + $work_price) / (1-0.30);

        //Control plus IVA
        $control_total = $control->price * $cquant * 1.16;
        $voice_total = $voice->price * $vquant * 1.16;
        $sensor_total = $sensor->price * $squant * 1.16;
        $handle_total = $handle->price * $hquant * 1.16;

        $ceiledWidth = ceil($width);
        $diff = $ceiledWidth - $width;
        if ($diff < 0.5 && $diff != 0) {
            $newWidth = $ceiledWidth - 0.5;
        } else if ($diff > 0.5 && $diff != 0) {
            $newWidth = $ceiledWidth;
        } else {
            $newWidth = $width;
        }

        $system = SistemaToldo::where('modelo_toldo_id', $model_id)->where('mechanism_id', $mechanism_id)->where('projection', $projection)->where('width', $newWidth)->first();
        $sprice = $system->price;

        if($canopy == 1) {
            if($width > 3.5) {
                $total_canopy = ((4268.18 / 5 * $width + 100) + 498.79 + (271.07 * $width) + (629.69 * 2))* 1.16 / 0.8;
            } else {
                $total_canopy = ((4268.18/5*$width+100) + 498.79 + (271.07*$width) + (629.69))* 1.16 / 0.8;
            }
        } else {
            $total_canopy = 0;
        }

        if($bambalina == 1) {
            $total_bambalina = 4384.60 + ($width * 1.5 * 50 * 1.16) + (626.4 * $width);
        } else {
            $total_bambalina = 0;
        }

        $utility = 0.40;

        //Pricing of user selected option
        switch($mechanism_id) {
            case 1:
                $accesories = $handle_total + $total_canopy + $total_bambalina;
                $toldo['price'] = ((((($sprice+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100))) + $accesories;
                break;
            case 2:
                $accesories = $control_total + $sensor_total + $voice_total + $total_canopy + $total_bambalina;
                $toldo['price'] = ((((($sprice+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100))) + $accesories;
                break;
            case 3:
                $accesories = $control_total + $handle_total + $sensor_total + $voice_total + $total_canopy + $total_bambalina;
                $toldo['price'] = ((((($sprice+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100))) + $accesories;
                break;
            case 4:
                $accesories = $handle_total + $voice_total + $total_canopy + $total_bambalina + $control_total;
                $toldo['price'] = ((((($sprice+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100))) + $accesories;
                break;
            default:
                $toldo['price'] = 0;
                break;
        }
        $toldo['voice_quantity'] = $input['voice_quantity'];
        $toldo['sensor_quantity'] = $input['sensor_quantity'];
        $toldo['handle_quantity'] = $input['handle_quantity'];
        $toldo->save();
        $order->price = $order->price + $toldo['price'];
        $order->total = $order->total + $toldo['price'];
        $order->save();
        return redirect()->route('orders.show', $order_id)->withStatus(__('Toldo agregado correctamente'));
    }

    public function fetchData(Request $request){
        $input = $request->all();
        $user = Auth::user();
        $cover_id = $input['cover_id'];
        $cover = Cover::find($cover_id);

        $model_id = $input['modelo_toldo_id'];
        $model = ModeloToldo::find($model_id);


        $mechanism_id = $input['mechanism_id'];

        $width = $input['width'];
        $projection = $input['projection'];
        $quantity = $input['quantity'];

        $measure = $projection + 0.75;
        $squared_meters = $measure * $width;

        if($cover->unions == 'Verticales') {
            //Calculates number of fabric needed for pricing
            $num_lienzos = ceil($width / $cover->roll_width);
            $total_fabric = $measure * $num_lienzos;

            //Calculates total pricing of fabric plus handiwork plus IVA
            $cover_price = $cover->price * $total_fabric;
        } else {
            $range = RollWidth::where('width', $cover->roll_width)->where('meters', $projection)->get('range');
            $num_lienzos = Complement::where('range', $range)->get('complete');
            $complement = Complement::where('range', $range)->get('complement');
            $total_fabric = $num_lienzos * $width;

            $full_price = $cover->price * $total_fabric;
            $complement_price = $cover->price / $cover->roll_width * 2.5 * $complement;
            $cover_price = $full_price + $complement_price;
        }


        $work_price = $squared_meters * (60/(1 - 0.3));
        $total_cover = ($cover_price + $work_price);


        $ceiledWidth = ceil($width);
        $diff = $ceiledWidth - $width;
        if ($diff < 0.5 && $diff != 0) {
            $newWidth = $ceiledWidth - 0.5;
        } else if ($diff > 0.5 && $diff != 0) {
            $newWidth = $ceiledWidth;
        } else {
            $newWidth = $width;
        }

        $system = SistemaToldo::where('modelo_toldo_id', $model_id)->where('mechanism_id', $mechanism_id)->where('projection', $projection)->where('width', $newWidth)->first();
        Log::info($system);
        $sprice = $system->price;

        $manual = SistemaToldo::where('modelo_toldo_id', $model_id)->where('mechanism_id', 1)->where('projection', $projection)->where('width', $newWidth)->first();
        $somfy = SistemaToldo::where('modelo_toldo_id', $model_id)->where('mechanism_id', 2)->where('projection', $projection)->where('width', $newWidth)->first();
        $cmo = SistemaToldo::where('modelo_toldo_id', $model_id)->where('mechanism_id', 3)->where('projection', $projection)->where('width', $newWidth)->first();
        $tube = SistemaToldo::where('modelo_toldo_id', $model_id)->where('mechanism_id', 4)->where('projection', $projection)->where('width', $newWidth)->first();

        $utility = 0.40;

        //Pricing of user selected option
        switch($mechanism_id) {
            case 1:
                //$accesories = $handle_total + $total_canopy + $total_bambalina;
                $price = ((((($sprice+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
                break;
            case 2:
                //$accesories = $control_total + $sensor_total + $voice_total + $total_canopy + $total_bambalina;
                $price = ((((($sprice+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
                break;
            case 3:
                //$accesories = $control_total + $handle_total + $sensor_total + $voice_total + $total_canopy + $total_bambalina;
                $price = ((((($sprice+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
                break;
            case 4:
                //$accesories = $handle_total + $voice_total + $total_canopy + $total_bambalina + $control_total;
                $price = ((((($sprice+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
                break;
            default:
                $price = 0;
                break;
        }
        $price = number_format($price, 2);

        //Pricing of manual mechanism
        //$accesories_manual = $handle_total + $total_canopy + $total_bambalina;
        $price_manual = ((((($manual->price+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
        $price_manual = number_format($price_manual, 2);

        //Pricing of somfy mechanism
        //$accesories_somfy = $control_total + $sensor_total + $voice_total + $total_canopy + $total_bambalina;
        $price_somfy = ((((($somfy->price+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
        $price_somfy = number_format($price_somfy, 2);

        //Pricing of cmo mechanism
        //$accesories_cmo = $control_total + $handle_total + $sensor_total + $voice_total + $total_canopy + $total_bambalina;
        $price_cmo = ((((($cmo->price+ $total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
        $price_cmo = number_format($price_cmo, 2);

        //Pricing of tube mechanism
        //$accesories_tube = $handle_total + $voice_total + $total_canopy + $total_bambalina + $control_total;
        $price_tube = ((((($tube->price+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
        $price_tube = number_format($price_tube,2);
        Log::info($system);
            echo "<div class='text-right'><h3><strong>Precio seleccionado: $$price</strong></h3></div>
            <div class='row text-right'>
            <div class='col-md-3 col-sm-6'>
            <strong>Manual-Eléctrico <br>$$price_cmo</strong>
</div>
<div class='col-md-3 col-sm-6'>
            <strong>Somfy <br>$$price_somfy</strong>
</div>
<div class='col-md-3 col-sm-6'>
            <strong>Tube <br>$$price_tube</strong>
</div>
<div class='col-md-3 col-sm-6'>
            <strong>Manual <br>$$price_manual</strong>
</div>
</div>
<hr>
<div>
<div class='row'>
                <div class='col-md-4 col-sm-12'>
                   <img src=" . asset('storage') . "/images/" . $model->photo . " style='width: 100%;' alt='Image not found'>
              </div>
              <div class='col-md-7 col-sm-12'>
            <h4>Detalles de sistema</h4>
            <div class='row'>
              <div class='col-md-12 col-sm-12'>
                   <h7 style='color: grey;'><strong>$model->description</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Máxima resistencia al viento de <strong>$model->max_resistance km/h</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Tiempo de producción: <strong>$model->production_time días hábiles</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Ancho máximo: <strong>$model->max_width m</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Ancho mínimo: <strong>$model->min_width m</strong></h7>
              </div>
              </div>
              <hr>
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
              </div>";
    }

    public function fetchNumbers(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = SistemaToldo::where($select, $value)->groupBy($dependent)->get();
        $output = '<option value="">Seleccionar opcion</option>';
        foreach($data as $row){
            $output .= '<option value="'.$row->$dependent.'">'.$row->$dependent.'</option>';
        }
        echo $output;
    }

    public function fetchProjection(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent2');
        $data = SistemaToldo::where($select, $value)->groupBy($dependent)->get();
        $output = '<option value="">Seleccionar opcion</option>';
        foreach($data as $row){
            $output .= '<option value="'.$row->$dependent.'">'.$row->$dependent.'</option>';
        }
        echo $output;
    }

    public function fetchControls(Request $request)
    {
        $value = $request->get('value');

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
        $value = $request->get('value');
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
        echo $output;
    }

    public function fetchAccesories(Request $request){
        $user = Auth::user();

        $input = $request->all();
        $quantity = $input['quantity'];

        $control_id = $input['control_id'];
        $control = CurtainControl::find($control_id);

        $mechanism_id = $input['mechanism_id'];

        $sensor_id = $input['sensor_id'];
        $sensor = Sensor::find($sensor_id);

        $voice_id = $input['voice_id'];
        $voice = VoiceControl::find($voice_id);

        $handle_id = $input['handle_id'];
        $handle = CurtainHandle::find($handle_id);

        $bambalina = $input['bambalina'];
        $canopy = $input['canopy_id'];

        $width = $input['width'];

        $cquant = $input['control_quantity'];
        $vquant = $input['voice_quantity'];
        $squant = $input['sensor_quantity'];
        $hquant = $input['handle_quantity'];

        //Control plus IVA
        $control_total = $control->price * $cquant * 1.16;
        $voice_total = $voice->price * $vquant * 1.16;
        $sensor_total = $sensor->price * $squant * 1.16;
        $handle_total = $handle->price * $hquant * 1.16;

        if($canopy == 1) {
            if($width > 3.5) {
                $total_canopy = ((4268.18 / 5 * $width + 100) + 498.79 + (271.07 * $width) + (629.69 * 2))* 1.16 / 0.8;
            } else {
                $total_canopy = ((4268.18/5*$width+100) + 498.79 + (271.07*$width) + (629.69))* 1.16 / 0.8;
            }
        } else {
            $total_canopy = 0;
        }

        if($bambalina == 1) {
            $total_bambalina = 4384.60 + ($width * 1.5 * 50 * 1.16) + (626.4 * $width);
        } else {
            $total_bambalina = 0;
        }

        //Pricing of user selected option
        switch($mechanism_id) {
            case 1:
                $accesories = (($handle_total + $total_canopy + $total_bambalina) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;;
                break;
            case 2:
                $accesories = (($control_total + $sensor_total + $voice_total + $total_canopy + $total_bambalina) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;;
                break;
            case 3:
                $accesories = (($control_total + $handle_total + $sensor_total + $voice_total + $total_canopy + $total_bambalina) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;;
                break;
            case 4:
                $accesories = (($handle_total + $voice_total + $total_canopy + $total_bambalina + $control_total) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;;
                break;
            default:
                $accesories = 0;
                break;
        }
        $accesories_price = number_format($accesories, 2);

        echo "<div class='text-right'><h3><strong>Total de accesorios: $$accesories_price</strong></h3></div>";
    }
}
