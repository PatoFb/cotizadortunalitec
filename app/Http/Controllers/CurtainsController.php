<?php

namespace App\Http\Controllers;

use App\Models\Complement;
use App\Models\Cover;
use App\Models\Curtain;
use App\Models\CurtainCanopy;
use App\Models\CurtainControl;
use App\Models\CurtainHandle;
use App\Models\CurtainMechanism;
use App\Models\CurtainModel;
use App\Models\ModeloToldo;
use App\Models\Order;
use App\Models\RollWidth;
use App\Models\Sensor;
use App\Models\SystemCurtain;
use App\Models\SystemScreenyCurtain;
use App\Models\VoiceControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CurtainsController extends Controller
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
        $models = CurtainModel::whereIn('id', [1, 2, 3])->get();
        $covers = Cover::all();
        $controls = CurtainControl::all();
        $mechanisms = CurtainMechanism::all();
        $voices = VoiceControl::all();
        $sensors =  Sensor::all();
        $handles = CurtainHandle::all();
        return view('curtains.create', compact('order_id',  'handles', 'covers', 'controls', 'order', 'mechanisms', 'models', 'voices', 'sensors'));
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
        $curtain = Curtain::findOrFail($validatedData['id']);
        $curtain->fill($validatedData);
        $curtain->save();
        return redirect()->back()->withStatus(_('Datos guardados correctamente'));
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
                'quantity' => 'required',
                'installation_type' => 'required',
                'mechanism_side' => 'required',
                'view_type' => 'required',
                'mechanism_id'=>'required',
            ]);
        } else {
            $validatedData = $request->validate([
                'model_id' => 'required',
                'cover_id' => 'required',
                'width' => 'required',
                'height' => 'required',
                'quantity' => 'required',
                'mechanism_id'=>'required',
            ]);
        }
        $curtain = new Curtain();
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
            $complement = Complement::where('range', $range)->get('complements');
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

        $system = SystemCurtain::where('model_id', $model_id)->where('width', $newWidth)->first();
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
            case 3:
                $accesories = $control_total + $handle_total + $sensor_total + $voice_total + $total_canopy;
                $curtain['price'] = (((((($sprice+8133.75+$total_cover)*1.16)  + $accesories) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
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
        $model_id = $input['model_id'];
        $model = CurtainModel::find($model_id);

        $cover_id = $input['cover_id'];
        $cover = Cover::find($cover_id);

        $mechanism_id = $input['mechanism_id'];


        $width = $input['width'];
        $height = $input['height'];
        $quantity = $input['quantity'];

        $ceiledWidth = ceil($width);
        $diff = $ceiledWidth - $width;
        if ($diff < 0.5 && $diff != 0) {
            $newWidth = $ceiledWidth - 0.5;
        } else if ($diff > 0.5 && $diff != 0) {
            $newWidth = $ceiledWidth;
        } else {
            $newWidth = $width;
        }

        $system = SystemCurtain::where('model_id', $model_id)->where('width', $newWidth)->first();
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

        //Pricing of cmo mechanism
        //$accesories_cmo = $control_total + $handle_total + $sensor_total + $voice_total + $total_canopy + $total_bambalina;
        $price_cmo = ((((($sprice+8133.75 + $total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
        $price_cmo = number_format($price_cmo, 2);

        //Pricing of tube mechanism
        //$accesories_tube = $handle_total + $voice_total + $total_canopy + $total_bambalina + $control_total;
        $price_tube = ((((($sprice+2258.71+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
        $price_tube = number_format($price_tube,2);
        if($width > $model->max_width or $height > $model->max_height) {
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
    }

    /**
     * This function works exactly as the model one but retrieves the cover
     *
     * @param Request $request
     */
    public function fetchCover(Request $request){
        $value = $request->get('cover_id');
        $curtain = $request->session()->get('curtain');
        $cover = Cover::findOrFail($value);
        $width = $curtain['width'];
        $height = $curtain['height'];
        $measure = $height + 0.4;

        if($cover->unions == 'Verticales') {
            //Calculates number of fabric needed for pricing
            $num_lienzos = ceil($width / $cover->roll_width);
            $total_fabric = $measure * $num_lienzos;
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
     * Function that retrieves the data in the height and width fields (In progress)
     *
     * @param Request $request
     */

    public function fetchNumbers(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = SystemCurtain::where($select, $value)->groupBy($dependent)->get();
        $output = '<option value="">Seleccionar opcion</option>';
        foreach($data as $row){
            $output .= '<option value="'.$row->$dependent.'">'.$row->$dependent.'</option>';
        }
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
            $curtain['model_id'] = $validatedData['model_id'];
            $request->session()->put('curtain', $curtain);
        }else{
            $curtain = Session::get('curtain');
            $curtain->model_id = $validatedData['model_id'];
            Session::put('curtain', $curtain);
        }
        Log::info(Session::get('curtain'));
        return redirect()->route('curtain.data', $order_id);
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
        $curtain = Session::get('curtain');
        return view('curtains.cover', compact('order_id', 'cov', 'curtain'));
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
        $curtain = Session::get('curtain');
        $curtain->cover_id = $validatedData['cover_id'];
        Session::put('curtain', $curtain);
        Log::info(Session::get('curtain'));
        return redirect()->route('curtain.features', $order_id);
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
        $curtain = $request->session()->get('curtain');
        $mechs = CurtainMechanism::all();
        return view('curtains.data', compact('order_id', 'curtain', 'mechs'));
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
            'mechanism_id' => 'required',
            'quantity' => 'required',
        ]);
        $curtain = $request->session()->get('curtain');
        $curtain->fill($validatedData);
        if($curtain['mechanism_id'] == 1){
            $curtain->control_id = 9999;
            $curtain->voice_id = 9999;
            $curtain->handle_id = 1;
        } elseif ($curtain['mechanism_id'] == 2) {
            $curtain->handle_id = 9999;
            $curtain->control_id = 1;
            $curtain->voice_id = 1;
        } else {
            $curtain->handle_id = 1;
            $curtain->control_id = 1;
            $curtain->voice_id = 1;
        }
        Session::put('curtain', $curtain);
        return redirect()->route('curtain.cover', $order_id);
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
        $curtain = Session::get('curtain');
        if($curtain->mechanism_id == 1){
            $controls = CurtainControl::where('type', 'Manual')->get();
            $voices = VoiceControl::where('type', 'Manual')->get();
            $handles = CurtainHandle::all();
        } elseif ($curtain->mechanism_id == 4) {
            $controls = CurtainControl::where('type', 'Tube')->get();
            $voices = VoiceControl::where('type', 'Tube')->get();
            $handles = CurtainHandle::all();
        } else {
            if($curtain->mechanism_id == 3){
                $handles = CurtainHandle::all();
            } else {
                $handles = CurtainHandle::where('id', 9999)->get();
            }
            $controls = CurtainControl::where('type', 'Somfy')->get();
            $voices = VoiceControl::where('type', 'Somfy')->get();
        }
        $canopies = CurtainCanopy::all();
        return view('curtains.features', compact('order_id', 'curtain', 'handles', 'canopies', 'controls', 'voices'));
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
            'canopy_id' => 'required',
            'control_id' => 'required',
            'voice_id' => 'required',
            'control_quantity' => 'required',
            'handle_quantity' => 'required',
            'voice_quantity' => 'required'
        ]);
        $curtain = Session::get('curtain');
        if($curtain->model){
            $keys = ['model', 'cover', 'mechanism', 'handle', 'control', 'voice'];
            foreach ($keys as $key) {
                unset($curtain[$key]);
            }
            Session::forget('curtain');
        }
        $curtain->fill($validatedData);

        $cover = Cover::find($curtain['cover_id']);

        $model_id = $curtain['model_id'];

        $control = CurtainControl::find($curtain['control_id']);

        $mechanism_id = $curtain['mechanism_id'];

        $voice = VoiceControl::find($curtain['voice_id']);

        $handle = CurtainHandle::find($curtain['handle_id']);

        $canopy = $curtain['canopy_id'];

        $width = $curtain['width'];
        $height = $curtain['height'];
        $quantity = $curtain['quantity'];
        $cquant = $curtain['control_quantity'];
        $vquant = $curtain['voice_quantity'];
        $hquant = $curtain['handle_quantity'];

        //Control plus IVA
        $control_total = $control->price * $cquant * 1.16;
        $voice_total = $voice->price * $vquant * 1.16;
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
            $range = RollWidth::where('width', $cover->roll_width)->where('meters', $height)->value('range');
            $num_lienzos = Complement::where('range', $range)->value('complete');
            $complement = Complement::where('range', $range)->value('complements');
            $total_fabric = $num_lienzos * $width;

            $full_price = $cover->price * $total_fabric;
            $complement_price = $cover->price / $cover->roll_width * 2.5 * $complement;
            $cover_price = $full_price + $complement_price;
        }


        $work_price = $squared_meters * (60/(1 - 0.3));
        $total_cover = ($cover_price + $work_price);

        $ceiledWidth = ceil($width);
        $diff = $ceiledWidth - $width;
        if ($diff > 0.5 && $diff != 0) {
            $newWidth = $ceiledWidth - 0.5;
        } else if ($diff < 0.5 && $diff != 0) {
            $newWidth = $ceiledWidth;
        } else {
            $newWidth = $width;
        }

        if($model_id > 3 && $model_id < 7){
            $ceiledHeight = ceil($height);
            if($height <= 1.5) {
                $diffh = $ceiledHeight - $height;
                if ($diffh > 0.5 && $diffh != 0) {
                    $newHeight = $ceiledHeight - 0.5;
                } else if ($diffh < 0.5 && $diffh != 0) {
                    $newHeight = $ceiledHeight;
                } else {
                    $newHeight = $height;
                }
            } else {
                $newHeight = $ceiledHeight;
            }
            $system = SystemScreenyCurtain::where('model_id', $model_id)->where('width', $width)->where('height', $newHeight)->first();
        } else{
            $system = SystemCurtain::where('model_id', $model_id)->where('width', $newWidth)->first();
        }
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
                $curtain->price = (((((($sprice+$total_cover)*1.16)  + $accesories) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
                break;
            case 2:
                $accesories = $control_total + $voice_total + $total_canopy;
                $curtain->price = (((((($sprice+6321.96+$total_cover)*1.16) + $accesories) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
                break;
            case 3:
                $accesories = $control_total + $handle_total + $voice_total + $total_canopy;
                $curtain->price = (((((($sprice+8133.75+$total_cover)*1.16)  + $accesories) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
                break;
            case 4:
                $accesories = $handle_total + $voice_total + $total_canopy + $control_total;
                $curtain->price = (((((($sprice+2258.71+$total_cover)*1.16)  + $accesories) / (1-$utility)) * $quantity) * (1-($user->discount/100)));
                break;
            default:
                $curtain->price = 0;
                break;
        }
        $request->session()->put('curtain', $curtain);
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
        $curtain = Session::get('curtain');
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
        $curtain = Session::get('curtain');
        $curtain->save();
        $order = Order::findOrFail($id);
        $order->price = $order->price + $curtain['price'];
        $order->total = $order->total + $curtain['price'];
        $order->save();
        Session::forget('curtain');
        return redirect()->route('orders.show', $order_id);
    }


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
