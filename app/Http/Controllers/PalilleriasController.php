<?php

namespace App\Http\Controllers;

use App\Http\Requests\addDataRequest;
use App\Http\Requests\CoverRequest;
use App\Http\Requests\ModelRequest;
use App\Http\Requests\pAddDataRequest;
use App\Http\Requests\PalilleriaDataRequest;
use App\Http\Requests\PalilleriaFeaturesRequest;
use App\Http\Requests\PalilleriaModelRequest;
use App\Models\Cover;
use App\Models\Control;
use App\Models\Mechanism;
use App\Models\Order;
use App\Models\Palilleria;
use App\Models\PalilleriaModel;
use App\Models\PalilleriasPrice;
use App\Models\Sensor;
use App\Models\VoiceControl;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Polyfill\Intl\Idn\Info;

class PalilleriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $palilleria = Palilleria::findOrFail($id);
        return view('palillerias.show', compact('palilleria'));
    }

    public function copy($id)
    {
        $palilleria = Palilleria::findOrFail($id);
        $order = Order::findOrFail($palilleria->order_id);
        if(!auth()->user()->isAdmin()) {
            $this->authorize('checkUser', $order);
        }
        copySystem($palilleria, $order);
        return redirect()->back()->withStatus('Copia generada correctamente');
    }

    public function addData(Request $request)
    {
        $palilleria = Palilleria::findOrFail($request->get('palilleria_id'));
        Log::info($request->all());
        $order = Order::findOrFail($palilleria->order_id);
        $order->price = $order->price - $palilleria->price;
        $order->total = $order->total - $palilleria->price;
        $palilleria->fill($request->all());
        $palilleria->systems_total = $this->calculatePalilleriaPrice($palilleria, $order->discount);
        $palilleria->accessories_total = $this->calculateAccessoriesPrice($palilleria);
        $palilleria->price = $palilleria->systems_total + $palilleria->accessories_total;
        $order->price = $order->price + $palilleria->price;
        $order->total = $order->total + $palilleria->price;
        $palilleria->save();
        if($order->delivery == 1) {
            addPackages($order);
        }
        $order->save();
        return redirect()->back()->withStatus('Datos guardados correctamente');
    }

    /**
     * Receives order id through URI and sends it to the next step.
     *
     * Sends all models to the view
     *
     * Creates a session for the product in which information will be stored and sends it
     * to the view so the data the user enters is saved as well
     *
     * @param $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addModel($order_id)
    {
        $models = PalilleriaModel::all();
        $palilleria = Session::get('palilleria');
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
     * @param PalilleriaModelRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function addModelPost(PalilleriaModelRequest $request, $order_id)
    {
        createSession($request['model_id'], $order_id, Palilleria::class, 'palilleria');
        return redirect()->route('palilleria.data', $order_id);
    }

    /**
     * Works exactly the same as the model function, but with covers
     *
     * @param $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function addCover($order_id)
    {
        $cov = Cover::all();
        $palilleria = Session::get('palilleria');
        return view('palillerias.cover', compact('order_id', 'cov', 'palilleria'));
    }

    /**
     * It works exactly the same as the model post function, but without the if statement since
     * thanks to the validation, the session won't be empty once you reach this point
     *
     * @param CoverRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function addCoverPost(CoverRequest $request, $order_id)
    {
        $palilleria = Session::get('palilleria');
        $palilleria->cover_id = $request['cover_id'];
        Session::put('palilleria', $palilleria);
        return redirect()->route('palilleria.features', $order_id);
    }

    /**
     * Works the same as the model and cover functions, but since we don't need any data for a radio list,
     * we won't send any objects but the curtain stored in session
     *
     * @param $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function addDat($order_id)
    {
        $palilleria = Session::get('palilleria');
        $mechs = Mechanism::all()->except(3);
        return view('palillerias.data', compact('order_id', 'palilleria', 'mechs'));
    }

    /**
     * Validation for the data fields, store in session and then go to next step
     *
     * @param PalilleriaDataRequest $request
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function addDataPost(PalilleriaDataRequest $request, $order_id) {
        $palilleria = Session::get('palilleria');
        $oldMechanismId = $palilleria->mechanism_id;
        $newMechanismId = $request['mechanism_id'];
        $palilleria->fill($request->all());
        $this->resetAccessories($palilleria, $oldMechanismId, $newMechanismId);
        return redirect()->route('palilleria.cover', $order_id);
    }

    /**
     * Function to reset accessory values if there's a mechanism change
     *
     * @param Palilleria $palilleria
     * @param $oldMechanismId
     * @param int $newMechanismId
     */

    private function resetAccessories(Palilleria $palilleria, $oldMechanismId, int $newMechanismId) {
        if($oldMechanismId != $newMechanismId) {
            if($palilleria['mechanism_id'] == 1) {
                $palilleria->control_id = 9999;
                $palilleria->voice_id = 9999;
                $palilleria->sensor_id = 9999;
            } elseif ($palilleria['mechanism_id'] == 4) {
                $palilleria->sensor_id = 9999;
                $palilleria->control_id = 999;
                $palilleria->voice_id = 999;
            } else {
                $palilleria->sensor_id = 999;
                $palilleria->control_id = 999;
                $palilleria->voice_id = 999;
            }
            $palilleria->sensor_quantity = 0;
            $palilleria->control_quantity = 0;
            $palilleria->voice_quantity = 0;
        }
        Session::put('palilleria', $palilleria);
    }

    /**
     * We have three fields with relationships, we will get these with select forms, so we have to send the object
     * to the view.
     *
     * We keep sending the session
     *
     * @param $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function addFeatures($order_id) {
        $palilleria = Session::get('palilleria');
        if($palilleria->mechanism_id == 1) {
            $controls = Control::where('id', 9999)->get();
            $voices = VoiceControl::where('id', 9999)->get();
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
     * Validation for the fields asked on this step, store in session
     *
     * We get the prices of the other objects from other tables using all the ids stored in the session
     *
     * @param PalilleriaFeaturesRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */

    public function addFeaturesPost(PalilleriaFeaturesRequest $request, $order_id)
    {
        $palilleria = Session::get('palilleria');
        $this->authorize('checkUser', $palilleria);
        $palilleria->fill($request->all());
        if($palilleria->model){
            $keys = ['model', 'cover', 'mechanism', 'control', 'voice', 'sensor'];
            removeKeys($palilleria, $keys, 'palilleria');
        }
        $palilleria->systems_total = $this->calculatePalilleriaPrice($palilleria, Auth::user()->discount);
        $palilleria->accessories_total = $this->calculateAccessoriesPrice($palilleria);
        $palilleria->price = $palilleria->systems_total + $palilleria->accessories_total;
        Session::put('palilleria', $palilleria);
        return redirect()->route('palilleria.review', $order_id);
    }

    /**
     * Function to calculate the total price of the system
     *
     * @param Palilleria $palilleria
     * @return float
     */

    private function calculatePalilleriaPrice(Palilleria $palilleria, float $discount): float {
        $cover = Cover::find($palilleria['cover_id']);

        $width = $palilleria['width'];
        $height = $palilleria['height'];
        $quantity = $palilleria['quantity'];

        $factor = $this->factor($cover->roll_width);

        $somfy =  15021*1.1;
        $tube = 10416*1.1;

        switch($palilleria['mechanism_id']) {
            case 1:
                $model_price = $this->calculateModelPrice($palilleria['model_id'], $width, $height);
                break;
            case 2:
                $model_price = $this->calculateModelPrice($palilleria['model_id'], $width, $height) + $somfy;
                break;
            case 4:
                $model_price = $this->calculateModelPrice($palilleria['model_id'], $width, $height) + $tube;
                break;
            default:
                $model_price = 0;
                break;
        }

        $total_cover = $this->calculateCoverPrice($cover, $width, $height, $factor);

        return ($model_price + $total_cover) / 0.6 * 1.16 * (1 - ($discount/100)) * $quantity;
    }

    /**
     * Function to retrieve and calculate the total price of the model
     *
     * @param int $model_id
     * @param float $width
     * @param float $height
     * @return float
     */
    private function calculateModelPrice(int $model_id, float $width, float $height): float {
        $model = PalilleriaModel::find($model_id);
        $goals_total = $model->price;
        $pprice = PalilleriasPrice::where('width', ceil($width))->where('height', ceil($height))->value('price');
        Log::info($pprice);
        return $goals_total + $pprice;
    }

    /**
     * Function to calculate the price of the cover
     *
     * @param Cover $cover
     * @param float $width
     * @param float $height
     * @param float $factor
     * @return float
     */

    private function calculateCoverPrice(Cover $cover, float $width, float $height, float $factor): float
    {
        $useful_subrolls = $this->usefulSubrolls($cover->roll_width);

        $sub_rolls = ceil($height/$factor);
        $full_rolls = ceil($sub_rolls/$useful_subrolls);
        $measure = $width + 0.07;
        $total_fabric = $measure * $full_rolls;
        $total_cover = $cover->price * $total_fabric;

        $work_price = 50 * (ceil($width * $height));
        $bubble_price = (900/35) * ($width*6);
        $added = $bubble_price/3;
        $total_bubble = $bubble_price + $added;
        $operation_costs = ($work_price + $total_bubble)*1.1;

        return $total_cover + $operation_costs;
    }

    /**
     * Function to calculate prices of reinforcements
     *
     * @param Palilleria $palilleria
     * @param float $height
     * @param float $factor
     * @return float
     */

    private function calculateReinforcementsPrice(Palilleria $palilleria, float $height, float $factor): float
    {
        $goal = $palilleria['goal'];
        $semigoal= $palilleria['semigoal'];
        $trave = $palilleria['trave'];
        $guide = $palilleria['guide'];
        $rquant = $palilleria['guide_quantity'];
        $tquant = $palilleria['trave_quantity'];
        $gquant = $palilleria['goal_quantity'];
        $sgquant = $palilleria['semigoal_quantity'];

        $sub_rolls = ceil($height/$factor);

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

        return ($total_trave + $total_semigoals + $total_goals + $extra_guides)*1.1;
    }

    /**
     * Function to calculate prices of all accessories
     *
     * @param Palilleria $palilleria
     * @return float
     */

    private function calculateAccessoriesPrice(Palilleria $palilleria): float {
        $voice = VoiceControl::find($palilleria['voice_id']);
        $control = Control::find($palilleria['control_id']);
        $mechanism_id = $palilleria['mechanism_id'];
        $sensor = Sensor::find($palilleria['sensor_id']);

        $cquant = $palilleria['control_quantity'];
        $squant = $palilleria['sensor_quantity'];
        $vquant = $palilleria['voice_quantity'];

        $cover = Cover::find($palilleria['cover_id']);

        $height = $palilleria['height'];

        //Accessories plus IVA
        $control_total = $control->price * $cquant;
        $sensor_total = $sensor->price * $squant;
        $voice_total = $voice->price * $vquant;

        $factor = $this->factor($cover->roll_width);

        $reinforcement_total = $this->calculateReinforcementsPrice($palilleria, $height, $factor);

        //Pricing of user selected option
        switch($mechanism_id) {
            case 2:
                return ($control_total + $voice_total + $sensor_total + $reinforcement_total)*1.16;
            case 4:
                return ($control_total + $voice_total + $reinforcement_total)*1.16;
            default:
                return 0;
        }
    }

    /**
     * This is the last step, and you will be able to review all the details of your product
     *
     * @param $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function review($order_id)
    {
        $palilleria = Session::get('palilleria');
        $order = Order::findOrFail($order_id);
        return view('palillerias.review', compact('order_id', 'palilleria', 'order'));
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
        $palilleria = $request->session()->get('palilleria');
        saveSystem($palilleria, $id);
        $request->session()->forget('palilleria');
        return redirect()->route('orders.show', $id);
    }

    /**
     * Function to return data of the cover
     *
     * @param Request $request
     * @return void
     */
    public function fetchCover(Request $request){
        $value = $request->get('cover_id');
        $palilleria = Session::get('palilleria');
        $this->echoPalilleria($palilleria, $value);
    }

    public function fetchCover2(Request $request){
        $value = $request->get('cover_id');
        $id = $request->get('palilleria_id');
        $palilleria = Palilleria::findOrFail($id);
        $this->echoPalilleria($palilleria, $value);
    }

    private function echoPalilleria(Palilleria $palilleria, int $value) {
        $cover = Cover::find($value);
        $height = $palilleria['height'];

        $useful_subrolls = $this->usefulSubrolls($cover->roll_width);

        $factor = $this->factor($cover->roll_width);

        $sub_rolls = ceil($height/$factor);
        $full_rolls = ceil($sub_rolls/$useful_subrolls);
        $measure = $height + 0.07;

        $total_fabric = $measure * $full_rolls;
        echo "<div class='col-12'>
            <h4>Detalles de cubierta</h4>
           </div>
            <div class='row'>
            <div class='col-md-6 col-sm-12'>
               <img src=".asset('storage')."/images/covers/".$cover->photo." style='width: 100%;'>
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
    }

    /**
     * Function to calculate the useful subrolls of the selected cover
     *
     * @param float $roll_width
     * @return int
     */
    public function usefulSubrolls(float $roll_width): int
    {
        if($roll_width == 1.16 || $roll_width == 1.2) {
            $useful_subrolls = 2;
        } elseif ($roll_width == 1.52 || $roll_width == 1.77) {
            $useful_subrolls = 3;
        } elseif ($roll_width == 2.67 || $roll_width == 3.04) {
            $useful_subrolls = 5;
        } elseif ($roll_width == 2.5) {
            $useful_subrolls = 4;
        } else {
            $useful_subrolls = 6;
        }
        return $useful_subrolls;
    }

    /**
     * Function to calculate the factor of the selected cover
     *
     * @param float $roll_width
     * @return float
     */
    public function factor(float $roll_width): float
    {
        if($roll_width == 1.16 || $roll_width == 1.2 || $roll_width == 3.2 || $roll_width == 1.77) {
            $factor = 0.45;
        } else {
            $factor = 0.4;
        }
        return $factor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return mixed
     */
    public function destroy($id) {
        $palilleria = Palilleria::findOrFail($id);
        $this->authorize('checkUser', $palilleria);
        deleteSystem($palilleria);
        return redirect()->back()->withStatus('Sistema eliminado correctamente');
    }
}
