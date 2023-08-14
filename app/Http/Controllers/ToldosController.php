<?php

namespace App\Http\Controllers;

use App\Models\Complement;
use App\Models\Curtain;
use App\Models\CurtainCanopy;
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
use Illuminate\Support\Facades\Session;

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
            'quantity' => 'required',
            'mechanism_id'=>'required',
            'modelo_toldo_id'=>'required',
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

        if($cover->unions == 'Vertical') {
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
        if($width > $model->max_width or $width < $model->min_width) {
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
             <h4 class='text-danger'>Sistema no entra en garantía!</h4>
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
        } else {
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
        $value = $request->get('value');
        $ceiledWidth = ceil($value);
        $diff = $ceiledWidth - $value;
        if ($diff < 0.5 && $diff != 0) {
            $newWidth = $ceiledWidth - 0.5;
        } else if ($diff > 0.5 && $diff != 0) {
            $newWidth = $ceiledWidth;
        } else {
            $newWidth = $value;
        }
        $toldo = $request->session()->get('toldo');
        $dependent = $request->get('dependent2');
        $data = SistemaToldo::where('modelo_toldo_id', $toldo->model_id)->where('width', $newWidth)->groupBy('projection')->get();
        $output = '<option value="">Seleccionar opcion</option>';
        foreach($data as $row){
            $output .= '<option value="'.$row->projection.'">'.$row->projection.'</option>';
        }
        Log::info($output);
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

    public function fetchCover(Request $request){
        $value = $request->get('cover_id');
        $toldo = $request->session()->get('toldo');
        $cover = Cover::findOrFail($value);
        $width = $toldo['width'];
        $projection = $toldo['height'];
        $num_lienzos = ceil($width/$cover->roll_width);
        $measure = $projection + 0.75;
        $total_fabric = $measure * $num_lienzos;

        if($cover->unions == 'Vertical') {
            //Calculates number of fabric needed for pricing
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
                   <h7 style='color: grey;'>Total de textil: <strong>$total_fabric mts</strong></h7>
              </div>
                </div>
              ";
            //Calculates total pricing of fabric plus handiwork plus IVA
        } else {
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
                   <h7 style='color: grey;'>Total de textil: <strong>$total_fabric mts</strong></h7>
              </div>
                </div>
              ";
        }
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
        $models = ModeloToldo::all();
        $toldo = $request->session()->get('toldo');
        return view('toldos.model', compact('order_id', 'models', 'toldo'));
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
        if(empty($request->session()->get('toldo'))){
            $toldo = new Toldo();
            $toldo['order_id'] = $order_id;
            $toldo->fill($validatedData);
            $request->session()->put('toldo', $toldo);
        }else{
            $toldo = $request->session()->get('toldo');
            $toldo->fill($validatedData);
            $request->session()->put('toldo', $toldo);
        }
        return redirect()->route('toldo.data', $order_id);
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
        $toldo = $request->session()->get('toldo');
        return view('toldos.cover', compact('order_id', 'cov', 'toldo'));
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
        $toldo = $request->session()->get('toldo');
        $toldo->cover_id = $validatedData['cover_id'];
        $request->session()->put('toldo', $toldo);
        return redirect()->route('toldo.features', $order_id);
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
        $toldo = $request->session()->get('toldo');
        $mechs = CurtainMechanism::all();
        return view('toldos.data', compact('order_id', 'toldo', 'mechs'));
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
            'projection' => 'required',
            'mechanism_id' => 'required',
            'quantity' => 'required',
        ]);
        $toldo = $request->session()->get('toldo');
        $toldo->fill($validatedData);
        if($toldo['mechanism_id'] == 1) {
            $toldo->control_id = 9999;
            $toldo->voice_id = 9999;
            $toldo->sensor_id = 9999;
            $toldo->handle_id = 1;
        } elseif ($toldo['mechanism_id'] == 4) {
            $toldo->sensor_id = 9999;
            $toldo->handle_id = 9999;
            $toldo->control_id = 1;
            $toldo->voice_id = 1;
        } elseif ($toldo['mechanism_id'] == 2) {
            $toldo->handle_id = 9999;
            $toldo->sensor_id = 1;
            $toldo->control_id = 1;
            $toldo->voice_id = 1;
        } else {
            $toldo->sensor_id = 1;
            $toldo->handle_id = 1;
            $toldo->control_id = 1;
            $toldo->voice_id = 1;
        }
        $request->session()->put('toldo', $toldo);
        return redirect()->route('toldo.cover', $order_id);
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
        $canopy = CurtainCanopy::all();
        $toldo = $request->session()->get('toldo');
        if($toldo->mechanism_id == 1){
            $controls = CurtainControl::where('type', 'Manual')->get();
            $voices = VoiceControl::where('type', 'Manual')->get();
            $handles = CurtainHandle::all();
            $sensors = Sensor::where('id', 9999)->get();
        } elseif ($toldo->mechanism_id == 4) {
            $controls = CurtainControl::where('type', 'Tube')->get();
            $voices = VoiceControl::where('type', 'Tube')->get();
            $handles = CurtainHandle::where('id', 9999)->get();
            $sensors = Sensor::where('id', 9999)->get();
        } else {
            if($toldo->mechanism_id == 3){
                $handles = CurtainHandle::all();
            } else {
                $handles = CurtainHandle::where('id', 9999)->get();
            }
            $controls = CurtainControl::where('type', 'Somfy')->get();
            $voices = VoiceControl::where('type', 'Somfy')->get();
            $sensors = Sensor::where('type', 'T')->get();
        }
        return view('toldos.features', compact('order_id', 'toldo', 'handles', 'controls', 'sensors', 'voices', 'canopy'));
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
            'handle_id' => 'required',
            'bambalina' => 'required',
            'control_id' => 'required',
            'canopy_id' => 'required',
            'sensor_id' => 'required',
            'voice_id' => 'required',
            'control_quantity' => 'required',
            'handle_quantity' => 'required',
            'sensor_quantity' => 'required',
            'voice_quantity' => 'required'
        ]);
        $toldo = $request->session()->get('toldo');
        if($toldo->model){
            $keys = ['model', 'cover', 'mechanism', 'handle', 'control', 'voice', 'sensor', 'canopy'];
            foreach ($keys as $key) {
                unset($toldo[$key]);
            }
            Session::forget('toldo');
        }
        $toldo->fill($validatedData);

        $cover_id = $toldo['cover_id'];
        $cover = Cover::find($cover_id);

        $model_id = $toldo['model_id'];
        $model = ModeloToldo::find($model_id);

        $control_id = $toldo['control_id'];
        $control = CurtainControl::find($control_id);

        $mechanism_id = $toldo['mechanism_id'];

        $sensor_id = $toldo['sensor_id'];
        $sensor = Sensor::find($sensor_id);

        $voice_id = $toldo['voice_id'];
        $voice = VoiceControl::find($voice_id);

        $handle_id = $toldo['handle_id'];
        $handle = CurtainHandle::find($handle_id);

        $bambalina = $toldo['bambalina'];
        $canopy = $toldo['canopy_id'];

        $width = $toldo['width'];
        $projection = $toldo['projection'];
        $quantity = $toldo['quantity'];
        $cquant = $toldo['control_quantity'];
        $vquant = $toldo['voice_quantity'];
        $squant = $toldo['sensor_quantity'];
        $hquant = $toldo['handle_quantity'];

        //Control plus IVA
        $control_total = $control->price * $cquant * 1.16;
        $voice_total = $voice->price * $vquant * 1.16;
        $sensor_total = $sensor->price * $squant * 1.16;
        $handle_total = $handle->price * $hquant * 1.16;

        $num_lienzos = ceil($width/$cover->roll_width);
        $measure = $projection + 0.75;
        $total_fabric = $measure * $num_lienzos;

        //Calculates total pricing of fabric plus handiwork plus IVA
        $cover_price = $cover->price * $total_fabric;
        $work_price = (40 * $total_fabric);
        $total_cover = ($cover_price + $work_price) / (1-0.30);


        $ceiledWidth = ceil($width);
        $diff = $ceiledWidth - $width;
        if ($diff > 0.5 && $diff != 0) {
            $newWidth = $ceiledWidth - 0.5;
        } else if ($diff < 0.5 && $diff != 0) {
            $newWidth = $ceiledWidth;
        } else {
            $newWidth = $width;
        }

        $system = SistemaToldo::where('modelo_toldo_id', $model_id)->where('mechanism_id', $mechanism_id)->where('projection', $projection)->where('width', $newWidth)->first();
        $sprice = $system->price;

        //If user chooses canopy, it will calculate the price by width plus IVA
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
        $request->session()->put('toldo', $toldo);
        return redirect()->route('toldo.review', $order_id);
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
        $toldo = $request->session()->get('toldo');
        return view('toldos.review', compact('order_id', 'toldo'));
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
        $toldo = $request->session()->get('toldo');
        $toldo->save();
        $order = Order::findOrFail($id);
        $order->price = $order->price + $toldo['price'];
        $order->total = $order->total + $toldo['price'];
        $order->save();
        $request->session()->forget('toldo');
        return redirect()->route('orders.show', $order_id);
    }
}
