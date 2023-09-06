<?php

namespace App\Http\Controllers;

use App\Models\Cover;
use App\Models\Control;
use App\Models\Mechanism;
use App\Models\Order;
use App\Models\Palilleria;
use App\Models\PalilleriaModel;
use App\Models\PalilleriasPrice;
use App\Models\Sensor;
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
    public function show($id)
    {
        $palilleria = Palilleria::findOrFail($id);
        return view('palillerias.show', compact('palilleria'));
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
        $mechs = Mechanism::all()->except(3);
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
        $palilleria = $request->session()->get('palilleria');
        if($palilleria->mechanism_id == 1) {
            $controls = Control::where('mechanism_id', 1)->get();
            $voices = VoiceControl::where('mechanism_id', 1)->get();
            $sensors = Sensor::where('id', 9999)->get();
        } elseif ($palilleria->mechanism_id == 4) {
            $controls = Control::where('mechanism_id', 4)->get();
            $voices = VoiceControl::where('mechanism_id', 4)->get();
            $sensors = Sensor::where('id', 9999)->get();
        } else {
            $controls = Control::where('mechanism_id', 2)->get();
            $voices = VoiceControl::where('mechanism_id', 2)->get();
            $sensors = Sensor::where('type', 'P')->get();
        }
        return view('palillerias.features', compact('order_id', 'palilleria', 'sensors', 'voices', 'controls'));
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
            'guide' => 'required',
            'trave' => 'required',
            'goal' => 'required',
            'semigoal' => 'required',
            'control_quantity' => 'required',
            'sensor_quantity' => 'required',
            'voice_quantity' => 'required',
            'guide_quantity' => 'required',
            'trave_quantity' => 'required',
            'semigoal_quantity' => 'required',
            'goal_quantity' => 'required',
        ]);
        $palilleria = $request->session()->get('palilleria');
        $palilleria->fill($validatedData);

        if($palilleria->model){
            $keys = ['model', 'cover', 'mechanism', 'control', 'voice', 'sensor'];
            foreach ($keys as $key) {
                unset($palilleria[$key]);
            }
            Session::forget('palilleria');
        }
        $cover = Cover::where('id', $palilleria['cover_id'])->first();

        $control = Control::where('id', $palilleria['control_id'])->first();

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
        $guide = $palilleria['guide'];

        $cquant = $palilleria['control_quantity'];
        $rquant = $palilleria['guide_quantity'];
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
        $measure = $width + 0.07;
        $total_fabric = $measure * $full_rolls;
        $total_cover = $cover->price * $total_fabric;

        $work_price = 50 * (ceil($width * $height));
        $bubble_price = (900/35) * ($width*6);
        $added = $bubble_price/3;
        $total_bubble = $bubble_price + $added;
        $operation_costs = $work_price + $total_bubble;

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
