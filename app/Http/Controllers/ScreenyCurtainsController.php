<?php

namespace App\Http\Controllers;

use App\Models\Complement;
use App\Models\Cover;
use App\Models\Curtain;
use App\Models\CurtainControl;
use App\Models\CurtainHandle;
use App\Models\CurtainMechanism;
use App\Models\CurtainModel;
use App\Models\ModeloToldo;
use App\Models\Order;
use App\Models\RollWidth;
use App\Models\ScreenyCurtain;
use App\Models\Sensor;
use App\Models\SystemCurtain;
use App\Models\SystemScreenyCurtain;
use App\Models\VoiceControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ScreenyCurtainsController extends Controller
{
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
        $models = CurtainModel::whereIn('id', [4, 5])->get();
        $covers = Cover::all();
        $controls = CurtainControl::all();
        $mechanisms = CurtainMechanism::whereIn('id', [1, 2, 4])->get();
        $voices = VoiceControl::all();
        $sensors =  Sensor::all();
        $handles = CurtainHandle::all();
        return view('screeny.create', compact('order_id',  'handles', 'covers', 'controls', 'order', 'mechanisms', 'models', 'voices', 'sensors'));
    }

    /**
     * This function validates the data from the modal when you want to edit the product and saves it (the product id is sent in a hidden input form)
     *
     * @param Request $request
     * @return mixed
     */

    public function addData(Request $request)
    {
        $validatedData = $request->validate([
            'id'=>'required',
            'mechanism_side' => 'required',
            'installation_type' => 'required',
            'view_type' => 'required'
        ]);
        $curtain = ScreenyCurtain::findOrFail($validatedData['id']);
        $curtain->fill($validatedData);
        $curtain->save();
        return redirect()->back()->withStatus(__('Datos guardados correctamente'));
    }

    /**
     * This function validates the data for saving a curtain. It has two cases in which extra data is required if the order is made as "Pedido"
     * If it's made as "Oferta", those fields aren't shown.
     * It calculates the price by adding all the object prices (Needs correction) and saves it, then it redirects you to the order page.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function save(Request $request, $id)
    {
        $order_id = $id;
        $user = Auth::user();
        $order = Order::findOrFail($id);
        if($order->activity == "Pedido") {
            $validatedData = $request->validate([
                'model_id' => 'required',
                'cover_id' => 'required',
                'width' => 'required',
                'height' => 'required',
                'handle_id' => 'required',
                'canopy_id' => 'required',
                'control_id' => 'required',
                'control_quantity'=>'required',
                'quantity' => 'required',
                'installation_type' => 'required',
                'mechanism_side' => 'required',
                'view_type' => 'required',
                'mechanism_id'=>'required',
                'voice_id'=>'required',
                'voice_quantity'=>'required',
                'handle_quantity'=>'required',
                'sensor_id'=>'required',
                'sensor_quantity'=>'required'
            ]);
        } else {
            $validatedData = $request->validate([
                'model_id' => 'required',
                'cover_id' => 'required',
                'width' => 'required',
                'height' => 'required',
                'handle_id' => 'required',
                'canopy_id' => 'required',
                'control_id' => 'required',
                'control_quantity'=>'required',
                'quantity' => 'required',
                'mechanism_id'=>'required',
                'voice_id'=>'required',
                'voice_quantity'=>'required',
                'handle_quantity'=>'required',
                'sensor_id'=>'required',
                'sensor_quantity'=>'required'
            ]);
        }
        $curtain = new ScreenyCurtain();
        $curtain['order_id'] = $order_id;
        $curtain['model_id'] = $validatedData['model_id'];
        $curtain->fill($validatedData);
        $cover_id = $validatedData['cover_id'];
        $cover = Cover::find($cover_id);

        $model_id = $validatedData['model_id'];
        $model = CurtainModel::find($model_id);

        $control_id = $validatedData['control_id'];
        $control = CurtainControl::find($control_id);

        $mechanism_id = $validatedData['mechanism_id'];

        $sensor_id = $validatedData['sensor_id'];
        $sensor = Sensor::find($sensor_id);

        $voice_id = $validatedData['voice_id'];
        $voice = VoiceControl::find($voice_id);

        $handle_id = $validatedData['handle_id'];
        $handle = CurtainHandle::find($handle_id);

        $canopy = $validatedData['canopy_id'];

        $width = $validatedData['width'];
        $height = $validatedData['height'];
        $quantity = $validatedData['quantity'];
        $cquant = $validatedData['control_quantity'];
        $vquant = $validatedData['voice_quantity'];
        $squant = $validatedData['sensor_quantity'];
        $hquant = $validatedData['handle_quantity'];

        //Control plus IVA
        $control_total = $control->price * $cquant * 1.16;
        $voice_total = $voice->price * $vquant * 1.16;
        $sensor_total = $sensor->price * $squant * 1.16;
        $handle_total = $handle->price * $hquant * 1.16;

        $measure = $height + 0.4;
        $squared_meters = $measure * $width;

        if($cover->unions == 'Verticales') {
            //Calculates number of fabric needed for pricing
            $num_lienzos = ceil($width / $cover->roll_width);
            $total_fabric = $measure * $num_lienzos;

            //Calculates total pricing of fabric plus handiwork plus IVA
            $cover_price = $cover->price * $total_fabric;
        } else {
            $range = RollWidth::where('width', $cover->roll_width)->where('meters', $height)->get('range');
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

        $system = SystemScreenyCurtain::where('model_id', $model_id)->where('width', $newWidth)->where('height', $height)->first();
        $sprice = $system->price;

        //If user chooses canopy, it will calculate the price by width plus IVA
        if($canopy == 1) {
            if($width > 3.5) {
                $total_canopy = ((4268.18 / 5 * $width) + 498.79 + (271.07 * $width) + (629.69 * 2))* 1.16;
            } else {
                $total_canopy = ((4268.18/5*$width) + 498.79 + (271.07*$width) + (629.69))* 1.16;
            }
        } else {
            $total_canopy = 0;
        }

        $utility = 0.40;

        switch($mechanism_id) {
            case 1:
                $accesories = $handle_total + $total_canopy;
                $curtain['price'] = (((((($sprice+$total_cover)*1.16)  + $accesories) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
                break;
            case 2:
                $accesories = $control_total + $sensor_total + $voice_total + $total_canopy;
                $curtain['price'] = (((((($sprice+6321.96+$total_cover)*1.16) + $accesories) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
                break;
            case 4:
                $accesories = $handle_total + $voice_total + $total_canopy + $control_total;
                $curtain['price'] = (((((($sprice+2258.71+$total_cover)*1.16)  + $accesories) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
                break;
            default:
                $curtain['price'] = 0;
                break;
        }
        $curtain['voice_quantity'] = $validatedData['voice_quantity'];
        $curtain['sensor_quantity'] = $validatedData['sensor_quantity'];
        $curtain['handle_quantity'] = $validatedData['handle_quantity'];
        $curtain->save();
        $order->price = $order->price + $curtain['price'];
        $order->total = $order->total + $curtain['price'];
        $order->save();
        return redirect()->route('orders.show', $order_id)->withStatus(__('Cortina agregada correctamente'));
    }

    /**
     * This function recievies an ajax request from the model select in the curtain form, getting the id and retrieving the model from the database
     * It returns an html formatted string to display it every time the selected model changed.
     *
     * @param Request $request
     */
    public function fetchData(Request $request){
        $input = $request->all();
        $user = Auth::user();
        $model = CurtainModel::where('id', $input['model_id'])->first();
        $model_id = $model->id;
        $cover_id = $input['cover_id'];
        $cover = Cover::where('id', $cover_id)->first();

        $mechanism_id = $input['mechanism_id'];


        $width = $input['width'];
        $height = $input['height'];
        $quantity = $input['quantity'];


        $system = SystemScreenyCurtain::where('model_id', $model_id)->where('width', $width)->where('height', $height)->first();
        $sprice = $system->price;


        //Calculates number of fabric needed for pricing
        $measure = $height + 0.4;
        $squared_meters = $measure * $width;

        if($cover->unions == 'Verticales') {
            //Calculates number of fabric needed for pricing
            $num_lienzos = ceil($width / $cover->roll_width);
            $total_fabric = $measure * $num_lienzos;

            //Calculates total pricing of fabric plus handiwork plus IVA
            $cover_price = $cover->price * $total_fabric;
        } else {
            $rwidth = $cover->roll_width;
            $range = RollWidth::where('width', $rwidth)->where('meters', $height)->pluck('range');
            $num_lienzos = Complement::where('range', $range[0])->pluck('complete');
            $complement = Complement::where('range', $range[0])->pluck('complements');
            $total_fabric = $num_lienzos[0] * $width[0];

            $full_price = $cover->price * $total_fabric;
            $complement_price = $cover->price / $cover->roll_width * 2.5 * $complement[0];
            $cover_price = $full_price + $complement_price;
        }


        $work_price = $squared_meters * (60/(1 - 0.3));
        $total_cover = ($cover_price + $work_price);



        $utility = 0.40;

        //Pricing of user selected option
        switch($mechanism_id) {
            case 1:
                //$accesories = $handle_total + $total_canopy + $total_bambalina;
                $price = ((((($sprice+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
                break;
            case 2:
                //$accesories = $control_total + $sensor_total + $voice_total + $total_canopy + $total_bambalina;
                $price = ((((($sprice+6321.96+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
                break;
            case 3:
                //$accesories = $control_total + $handle_total + $sensor_total + $voice_total + $total_canopy + $total_bambalina;
                $price = ((((($sprice+8133.75+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
                break;
            case 4:
                //$accesories = $handle_total + $voice_total + $total_canopy + $total_bambalina + $control_total;
                $price = ((((($sprice+2258.71+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
                break;
            default:
                $price = 0;
                break;
        }
        $price = number_format($price, 2);

        //Pricing of manual mechanism
        //$accesories_manual = $handle_total + $total_canopy + $total_bambalina;
        $price_manual = ((((($sprice+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
        $price_manual = number_format($price_manual, 2);

        //Pricing of somfy mechanism
        //$accesories_somfy = $control_total + $sensor_total + $voice_total + $total_canopy + $total_bambalina;
        $price_somfy = ((((($sprice+6321.96+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
        $price_somfy = number_format($price_somfy, 2);


        //Pricing of tube mechanism
        //$accesories_tube = $handle_total + $voice_total + $total_canopy + $total_bambalina + $control_total;
        $price_tube = ((((($sprice+2258.71+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
        $price_tube = number_format($price_tube,2);


        echo "<div class='text-right'><div class='col-md-12 col-sm-12'><h3><strong>Precio seleccionado: $$price</strong></h3></div></div>
            <div class='row text-right'>
<div class='col-md-4 col-sm-4'>
            <strong>Somfy <br>$$price_somfy</strong>
</div>
<div class='col-md-4 col-sm-4'>
            <strong>Manual <br>$$price_manual</strong>
</div>
<div class='col-md-4 col-sm-4'>
            <strong>Tube <br>$$price_tube</strong>
</div>
</div>
<hr>
<div class='row'>
<div class='col-md-4 col-sm-12'>
                   <img src=".asset('storage')."/images/".$model->photo." style='width: 100%;' alt='Image not found'>
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
                   <h7 style='color: grey;'>Caída máxima: <strong>$model->max_height m</strong></h7>
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
        $data = SystemScreenyCurtain::where($select, $value)->groupBy($dependent)->get();
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
        $control = CurtainControl::where('id', $input['control_id'])->first();

        $mechanism_id = $input['mechanism_id'];

        $sensor = Sensor::where('id', $input['sensor_id'])->first();

        $voice_id = $input['voice_id'];
        $voice = VoiceControl::where('id', $voice_id)->first();

        $handle_id = $input['handle_id'];
        $handle = CurtainHandle::where('id', $handle_id)->first();

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
                $total_canopy = ((4268.18 / 5 * $width) + 498.79 + (271.07 * $width) + (629.69 * 2))* 1.16;
            } else {
                $total_canopy = ((4268.18/5*$width) + 498.79 + (271.07*$width) + (629.69))* 1.16;
            }
        } else {
            $total_canopy = 0;
        }

        //Pricing of user selected option
        switch($mechanism_id) {
            case 1:
                $accesories = (($handle_total + $total_canopy) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;
                break;
            case 2:
                $accesories = (($control_total + $sensor_total + $voice_total + $total_canopy) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;
                break;
            case 3:
                $accesories = (($control_total + $handle_total + $sensor_total + $voice_total + $total_canopy) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;
                break;
            case 4:
                $accesories = (($handle_total + $voice_total + $total_canopy + $control_total) / 0.6) * (1 - ($user->discount/100)) * $quantity * 1.16;
                break;
            default:
                $accesories = 0;
                break;
        }
        $accesories_price = number_format($accesories, 2);

        echo "<div class='text-right'><h3><strong>Total de accesorios: $$accesories_price</strong></h3></div>";
    }

    public function destroy($id)
    {
        $curtain = ScreenyCurtain::findOrFail($id);
        $order = Order::where('id', $curtain->order_id)->first();
        $order->price = $order->price - $curtain->price;
        $order->total = $order->price - ($order->price * ($order->discount/100));
        $order->save();
        $curtain->delete();
        return redirect()->back()->withStatus('Producto eliminado correctamente');
    }
}
