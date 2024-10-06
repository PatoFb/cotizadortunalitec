<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoverRequest;
use App\Http\Requests\ModelRequest;
use App\Http\Requests\ToldoDataRequest;
use App\Http\Requests\ToldoFeaturesRequest;
use App\Http\Requests\ToldoModelRequest;
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

    public function copy($id)
    {
        $toldo = Toldo::findOrFail($id);
        $order = Order::findOrFail($toldo->order_id);
        if(!auth()->user()->isAdmin()) {
            $this->authorize('checkUser', $order);
        }
        copySystem($toldo, $order);
        return redirect()->back()->withStatus('Copia generada correctamente');
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
        $this->echoToldo($toldo, $value);
    }

    public function fetchCover2(Request $request){
        $value = $request->get('cover_id');
        $id = $request->get('toldo_id');
        $toldo = Toldo::findOrFail($id);
        $this->echoToldo($toldo, $value);
    }

    private function echoToldo(Toldo $toldo, int $value) {
        $cover = Cover::findOrFail($value);
        if ($toldo->model_id == 2) {
            $measure = $toldo->projection * 2 + 0.85;
        } else {
            $measure = $toldo->projection + 0.85;
        }
        if($cover->unions == 'Vertical') {
            $num_lienzos = ceil($toldo->width / $cover->roll_width);
            $total_fabric = $measure * $num_lienzos;
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
            $complements = ceil($measure/$cover->roll_width);
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
                   <h7 style='color: grey;'>Lienzos completos: <strong>$complements</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Medida de lienzos: <strong>$measure mts</strong></h7>
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
     * @param ToldoModelRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function addModelPost(ToldoModelRequest $request, $order_id)
    {
        createSession($request['model_id'], $order_id, Toldo::class, 'toldo');
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
     * @param CoverRequest $request
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function addCoverPost(CoverRequest $request, $order_id)
    {
        $toldo = Session::get('toldo');
        $toldo->cover_id = $request['cover_id'];
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
        if($toldo->model_id == 7) {
            $mechs = Mechanism::whereIn('id', [1,2,3])->get();
        } else {
            $mechs = Mechanism::all();
        }
        $model = ModeloToldo::find($toldo->model_id);
        return view('toldos.data', compact('order_id', 'toldo', 'mechs', 'model'));
    }

    /**
     * Validation for the two numeric fields, store in session and then go to next step
     *
     * @param ToldoDataRequest $request
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function addDataPost(ToldoDataRequest $request, $order_id)
    {
        $toldo = Session::get('toldo');
        $oldMechanismId = $toldo->mechanism_id;
        $newMechanismId = $request['mechanism_id'];
        $newWidth = ceilMeasure($request['width'], 1);

        if ($newMechanismId == 4) {
            // Get the system based on the specified conditions
            $system = SistemaToldo::where('modelo_toldo_id', $toldo['model_id'])
                ->where('projection', $request['projection'])
                ->where('width', $newWidth)
                ->first();

            // Validate if tube_price is not null
            if (!$system || $system->tube_price == 0) {
                return back()->withErrors(['mechanism_id' => 'Las medidas seleccionadas no permiten el motor Tube']);
            }
        }

        $toldo->fill($request->all());
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
            $sensors = Sensor::where('type', 'L')->get();
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
     * @param ToldoFeaturesRequest $request
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function addFeaturesPost(ToldoFeaturesRequest $request, $order_id)
    {
        $toldo = Session::get('toldo');
        if($toldo->model){
            $keys = ['model', 'cover', 'mechanism', 'handle', 'control', 'voice', 'sensor'];
            removeKeys($toldo, $keys, 'toldo');
        }
        $toldo->fill($request->all());
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

        switch ($toldo['mechanism_id']) {
            case 1:
                $sprice = SistemaToldo::where('modelo_toldo_id', $toldo['model_id'])->where('projection', $projection)->where('width', $newWidth)->value('price');
                break;
            case 2:
                $somfy = SistemaToldo::where('modelo_toldo_id', $toldo['model_id'])->where('projection', $projection)->where('width', $newWidth)->first();
                $sprice = $somfy->price + $somfy->somfy_price;
                break;
            case 3:
                $cmo = SistemaToldo::where('modelo_toldo_id', $toldo['model_id'])->where('projection', $projection)->where('width', $newWidth)->first();
                $sprice = $cmo->price + $cmo->cmo_price;
                break;
            case 4:
                $tube = SistemaToldo::where('modelo_toldo_id', $toldo['model_id'])->where('projection', $projection)->where('width', $newWidth)->first();
                $sprice = $tube->price + $tube->tube_price;
                break;
            default:
                $sprice = 0;
                break;
        }
        $total_canopy = $this->calculateCanopyPrice($canopy, $width);

        $total_bambalina = (632.4 * $width) + $this->calculateBambalinaPrice($bambalina);

        $accessories = $this->calculateAccessoriesPrice($toldo) + $total_bambalina + $total_canopy;

        return (((($sprice+$total_cover+$accessories) / (0.60)) * $quantity) * (1-($user->discount/100)))*1.1;
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
        $control_total = $control->price * $cquant;
        $voice_total = $voice->price * $vquant;
        $sensor_total = $sensor->price * $squant;
        $handle_total = $handle->price * $hquant;

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
    private function calculateBambalinaPrice(int $bambalina): float {
        if($bambalina == 1) {
            return 6326.22 / 0.7;
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
                return ((3212.05 / 5 * $width + 100) + 392.37 + (496.40 * 2) + (181.77 * $width)) / 0.7;
            } else {
                return ((3212.05/5*$width+100) + 392.37 + (496.40) + (181.77 * $width)) / 0.7;
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
        if ($model_id == 2) {
            $measure = $projection * 2 + 0.85;
        } else {
            $measure = $projection + 0.85;
        }
        if($cover->unions == 'Vertical') {
            $num_lienzos = ceil($width / $cover->roll_width);
            $total_fabric = $measure * $num_lienzos;
            $cover_price = $cover->toldo_price * $total_fabric;
        } else {
            $complements = ceil($measure/$cover->roll_width);
            $cover_price = $cover->toldo_price * $complements * $width;
        }
        //Calculates total pricing of fabric plus handiwork plus IVA
        $work_price = (50 * $measure * $width);
        return ($cover_price + $work_price);
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
