<?php

namespace App\Http\Controllers;

use App\Models\Complement;
use App\Models\Control;
use App\Models\Cover;
use App\Models\Handle;
use App\Models\Mechanism;
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
    public function show($id){
        $toldo = Toldo::findOrFail($id);
        return view('toldos.show');
    }

    public function fetchProjection(Request $request)
    {
        $value = $request->get('value');
        $newWidth = ceilMeasure($value, 1);
        $toldo = $request->session()->get('toldo');
        $data = SistemaToldo::where('modelo_toldo_id', $toldo->model_id)->where('width', $newWidth)->groupBy('projection')->get();
        $output = '<option value="">Seleccionar proyección</option>';
        foreach($data as $row){
            $output .= '<option value="'.$row->projection.'">'.$row->projection.'</option>';
        }
        echo $output;
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

    public function addModelPost(Request $request, $order_id)
    {
        $validatedData = $request->validate([
            'model_id' => 'required',
        ]);
        createSession($validatedData['model_id'], $order_id, 'Toldo');
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
        $system = SistemaToldo::where('modelo_toldo_id', $toldo->model_id)->groupBy('mechanism_id')->get('mechanism_id');
        $mechs = Mechanism::whereIn('id', $system)->get();
        $model = ModeloToldo::find($toldo->model_id);
        return view('toldos.data', compact('order_id', 'toldo', 'mechs', 'model'));
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
            $toldo->handle_id = 999;
        } elseif ($toldo['mechanism_id'] == 4) {
            $toldo->sensor_id = 9999;
            $toldo->handle_id = 9999;
            $toldo->control_id = 999;
            $toldo->voice_id = 999;
        } elseif ($toldo['mechanism_id'] == 2) {
            $toldo->handle_id = 9999;
            $toldo->sensor_id = 999;
            $toldo->control_id = 999;
            $toldo->voice_id = 999;
        } else {
            $toldo->sensor_id = 999;
            $toldo->handle_id = 999;
            $toldo->control_id = 999;
            $toldo->voice_id = 999;
        }
        $keys = ['sensor_quantity', 'handle_quantity', 'control_quantity', 'voice_quantity'];
        removeKeys($toldo, $keys);
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
        $toldo = $request->session()->get('toldo');
        if($toldo->mechanism_id == 1){
            $controls = Control::where('id', 9999)->get();
            $voices = VoiceControl::where('id', 9999)->get();
            $handles = Handle::where('mechanism_id', 1)->get();
            $sensors = Sensor::where('id', 9999)->get();
        } elseif ($toldo->mechanism_id == 4) {
            $controls = Control::where('mechanism_id', 4)->get();
            $voices = VoiceControl::where('mechanism_id', 4)->get();
            $handles = Handle::where('id', 9999)->get();
            $sensors = Sensor::where('id', 9999)->get();
        } else {
            if($toldo->mechanism_id == 3){
                $handles = Handle::where('mechanism_id', 1)->get();
            } else {
                $handles = Handle::where('id', 9999)->get();
            }
            $controls = Control::where('mechanism_id', 2)->get();
            $voices = VoiceControl::where('mechanism_id', 2)->get();
            $sensors = Sensor::where('type', 'T')->get();
        }
        return view('toldos.features', compact('order_id', 'toldo', 'handles', 'controls', 'sensors', 'voices'));
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
            'canopy' => 'required',
            'sensor_id' => 'required',
            'voice_id' => 'required',
            'control_quantity' => 'required',
            'handle_quantity' => 'required',
            'sensor_quantity' => 'required',
            'voice_quantity' => 'required'
        ]);
        $toldo = $request->session()->get('toldo');
        if($toldo->model){
            $keys = ['model', 'cover', 'mechanism', 'handle', 'control', 'voice', 'sensor'];
            removeKeys($toldo, $keys);
            Session::forget('toldo');
        }
        $toldo->fill($validatedData);

        $cover_id = $toldo['cover_id'];
        $cover = Cover::find($cover_id);

        $model_id = $toldo['model_id'];

        $control_id = $toldo['control_id'];
        $control = Control::find($control_id);

        $mechanism_id = $toldo['mechanism_id'];

        $sensor_id = $toldo['sensor_id'];
        $sensor = Sensor::find($sensor_id);

        $voice_id = $toldo['voice_id'];
        $voice = VoiceControl::find($voice_id);

        $handle_id = $toldo['handle_id'];
        $handle = Handle::find($handle_id);

        $bambalina = $toldo['bambalina'];
        $canopy = $toldo['canopy'];

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
        if($model_id == 1){
            $measure = $projection + 1.2;
        } elseif ($model_id == 2) {
            $measure = $projection * 2 + 0.75;
        } else {
            $measure = $projection + 0.75;
        }
        $total_fabric = $measure * $num_lienzos;

        //Calculates total pricing of fabric plus handiwork plus IVA
        $cover_price = $cover->price * $total_fabric;
        $work_price = (40 * $measure * $width);
        $total_cover = ($cover_price + $work_price) / (1-0.30);

        $newWidth = ceilMeasure($width, 1);

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

        $accessories = 0;

        switch($mechanism_id) {
            case 1:
                $accessories = $handle_total + $total_canopy + $total_bambalina;
                break;
            case 2:
                $accessories = $control_total + $sensor_total + $voice_total + $total_canopy + $total_bambalina;
                break;
            case 3:
                $accessories = $control_total + $handle_total + $sensor_total + $voice_total + $total_canopy + $total_bambalina;
                break;
            case 4:
                $accessories = $handle_total + $voice_total + $total_canopy + $total_bambalina + $control_total;
                break;
        }
        $toldo['price'] = ((((($sprice+$total_cover)*1.16) / (1-$utility)) * $quantity) * (1-($user->discount/100))) + $accessories;
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
        $toldo = $request->session()->get('toldo');
        saveSystem($toldo, $id);
        $request->session()->forget('toldo');
        return redirect()->route('orders.show', $id);
    }

    public function destroy($id)
    {
        $toldo = Toldo::findOrFail($id);
        deleteSystem($toldo);
        return redirect()->back()->withStatus('Sistema eliminado correctamente');
    }
}
