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
use App\Rules\ValidateProjection;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ToldosController extends Controller
{
    /**
     * Function to return a listing of the resource
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id){
        $toldo = Toldo::findOrFail($id);
        return view('toldos.show', compact('toldo'));
    }

    /**
     * Function to return the projection depending on the width and model selected
     *
     * @param Request $request
     * @return void
     */
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

    /**
     * Function to return the info of the cover
     *
     * @param Request $request
     * @return void
     */
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
     * @param $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addModel($order_id)
    {
        $models = ModeloToldo::all();
        $toldo = Session::get('toldo');
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
            'model_id' => ['required', 'exists:curtain_models,id', 'integer']
        ]);
        createSession($validatedData['model_id'], $order_id, Toldo::class, 'toldo');
        return redirect()->route('toldo.data', $order_id);
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
        $toldo = Session::get('toldo');
        return view('toldos.cover', compact('order_id', 'cov', 'toldo'));
    }

    /**
     * It works exactly the same as the model post function, but without the if statement since
     * thanks to the validation, the session won't be empty once you reach this point
     *
     * @param Request $request
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function addCoverPost(Request $request, $order_id)
    {
        $validatedData = $request->validate([
            'cover_id' => ['exists:covers,id', 'required', 'integer']
        ]);
        $toldo = Session::get('toldo');
        $toldo->cover_id = $validatedData['cover_id'];
        Session::put('toldo', $toldo);
        return redirect()->route('toldo.features', $order_id);
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
        $toldo = Session::get('toldo');
        $system = SistemaToldo::where('modelo_toldo_id', $toldo->model_id)->groupBy('mechanism_id')->get('mechanism_id');
        $mechs = Mechanism::whereIn('id', $system)->get();
        $model = ModeloToldo::find($toldo->model_id);
        return view('toldos.data', compact('order_id', 'toldo', 'mechs', 'model'));
    }

    /**
     * Validation for the two numeric fields, store in session and then go to next step
     *
     * @param Request $request
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function addDataPost(Request $request, $order_id)
    {
        $toldo = Session::get('toldo');
        $data = ['toldo' => $toldo];
        $validatedData = $request->validate([
            'width' => ['required', 'min:0.5', 'max:10', 'numeric'],
            'projection' => ['required', 'numeric', new ValidateProjection($data)],
            'mechanism_id' => ['required', 'integer', 'exists:mechanisms,id'],
            'quantity' => ['required', 'min:1', 'integer'],
        ]);
        $oldMechanismId = $toldo->mechanism_id;
        $newMechanismId = $validatedData['mechanism_id'];
        $toldo->fill($validatedData);
        $this->resetAccessories($toldo, $oldMechanismId, $newMechanismId);
        return redirect()->route('toldo.cover', $order_id);
    }

    /**
     * Function to reset accessory values if there's a mechanism change
     *
     * @param Toldo $toldo
     * @param $oldMechanismId
     * @param int $newMechanismId
     */

    private function resetAccessories(Toldo $toldo, $oldMechanismId, int $newMechanismId) {
        if($oldMechanismId != $newMechanismId) {
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
            $toldo->handle_quantity = 0;
            $toldo->control_quantity = 0;
            $toldo->voice_quantity = 0;
            $toldo->sensor_quantity = 0;
        }
        Session::put('toldo', $toldo);
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

    public function addFeatures($order_id)
    {
        $toldo = Session::get('toldo');
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
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function addFeaturesPost(Request $request, $order_id)
    {
        $validatedData = $request->validate([
            'handle_id' => ['required', 'exists:handles,id', 'integer'],
            'canopy' => ['required', 'integer', 'min:0', 'max:1'],
            'control_id' => ['required', 'exists:controls,id', 'integer'],
            'voice_id' => ['required', 'exists:voice_controls,id', 'integer'],
            'control_quantity' => ['required', 'min:0', 'integer'],
            'handle_quantity' => ['required', 'min:0', 'integer'],
            'voice_quantity' => ['required', 'min:0', 'integer'],
            'bambalina' => ['required', 'integer', 'min:0', 'max:1'],
            'sensor_id' => ['required', 'exists:sensors,id', 'integer'],
            'sensor_quantity' => ['required', 'min:0', 'integer'],
        ]);
        $toldo = Session::get('toldo');
        if($toldo->model){
            $keys = ['model', 'cover', 'mechanism', 'handle', 'control', 'voice', 'sensor'];
            removeKeys($toldo, $keys, 'toldo');
        }
        $toldo->fill($validatedData);
        $toldo->price = $this->calculateToldoPrice($toldo);
        Session::put('toldo', $toldo);
        return redirect()->route('toldo.review', $order_id);
    }

    /**
     * Calculates the price of the awning
     *
     * @param Toldo $toldo
     * @return float
     */
    private function calculateToldoPrice(Toldo $toldo): float {
        $user = Auth::user();
        $bambalina = $toldo['bambalina'];
        $canopy = $toldo['canopy'];

        $width = $toldo['width'];
        $projection = $toldo['projection'];
        $quantity = $toldo['quantity'];

        $total_cover = $this->calculateCoverPrice($toldo['cover_id'], $toldo['model_id'], $width, $projection);

        $newWidth = ceilMeasure($width, 1);

        $sprice = SistemaToldo::where('modelo_toldo_id', $toldo['model_id'])->where('mechanism_id', $toldo['mechanism_id'])->where('projection', $projection)->where('width', $newWidth)->value('price');

        $total_canopy = $this->calculateCanopyPrice($canopy, $width);

        $total_bambalina = $this->calculateBambalinaPrice($bambalina, $width);

        $accessories = $this->calculateAccessoriesPrice($toldo) + $total_bambalina + $total_canopy;

        return ((((($sprice+$total_cover)*1.16) / (0.60)) * $quantity) * (1-($user->discount/100))) + $accessories;
    }

    /**
     * Function to calculate price of accessories depending on mechanism selected
     *
     * @param Toldo $toldo
     * @return float
     */
    private function calculateAccessoriesPrice(Toldo $toldo): float {
        $control = Control::find($toldo['control_id']);
        $mechanism_id = $toldo['mechanism_id'];
        $voice = VoiceControl::find($toldo['voice_id']);
        $handle = Handle::find($toldo['handle_id']);
        $sensor = Sensor::find($toldo['sensor_id']);

        $cquant = $toldo['control_quantity'];
        $vquant = $toldo['voice_quantity'];
        $squant = $toldo['sensor_quantity'];
        $hquant = $toldo['handle_quantity'];

        //Accessories plus IVA
        $control_total = $control->price * $cquant * 1.16;
        $voice_total = $voice->price * $vquant * 1.16;
        $sensor_total = $sensor->price * $squant * 1.16;
        $handle_total = $handle->price * $hquant * 1.16;

        switch($mechanism_id) {
            case 1:
                return $handle_total;
            case 2:
                return $control_total + $sensor_total + $voice_total;
            case 3:
                return $control_total + $handle_total + $sensor_total + $voice_total;
            case 4:
                return $handle_total + $voice_total + $control_total;
            default:
                return 0;
        }
    }

    /**
     * Function to calculate the price of the bambalina
     *
     * @param int $bambalina
     * @param float $width
     * @return float
     */
    private function calculateBambalinaPrice(int $bambalina, float $width): float {
        if($bambalina == 1) {
            return 4384.60 + ($width * 1.5 * 50 * 1.16) + (626.4 * $width);
        } else {
            return 0;
        }
    }

    /**
     * Calculate price of the canopy
     *
     * @param int $canopy
     * @param float $width
     * @return float
     */
    private function calculateCanopyPrice(int $canopy, float $width): float {
        if($canopy == 1) {
            if($width > 3.5) {
                return ((4268.18 / 5 * $width + 100) + 498.79 + (271.07 * $width) + (629.69 * 2))* 1.16 / 0.8;
            } else {
                return ((4268.18/5*$width+100) + 498.79 + (271.07*$width) + (629.69))* 1.16 / 0.8;
            }
        } else {
            return 0;
        }
    }

    /**
     * Function to calculate the price of the cover
     *
     *
     * @param int $cover_id
     * @param int $model_id
     * @param float $width
     * @param float $projection
     * @return float
     */
    private function calculateCoverPrice(int $cover_id, int $model_id, float $width, float $projection): float
    {
        $cover = Cover::find($cover_id);
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
        return ($cover_price + $work_price) / (1-0.30);
    }

    /**
     * This is the last step, and you will be able to review all the details of your product
     *
     * @param $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function review($order_id)
    {
        $toldo = Session::get('toldo');
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
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */

    public function reviewPost($id)
    {
        $toldo = Session::get('toldo');
        $this->authorize('checkUser', $toldo);
        saveSystem($toldo, $id);
        Session::forget('toldo');
        return redirect()->route('orders.show', $id);
    }

    /**
     * Function to delete saved product
     *
     * @param $id
     * @return mixed
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $toldo = Toldo::findOrFail($id);
        $this->authorize('checkUser', $toldo);
        deleteSystem($toldo);
        return redirect()->back()->withStatus('Sistema eliminado correctamente');
    }
}
