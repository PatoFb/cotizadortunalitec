<?php

namespace App\Http\Controllers;

use App\Http\Requests\addDataOrderRequest;
use App\Http\Requests\addDataRequest;
use App\Http\Requests\CoverOrderRequest;
use App\Http\Requests\CoverRequest;
use App\Http\Requests\CurtainDataRequest;
use App\Http\Requests\CurtainFeaturesOrderRequest;
use App\Http\Requests\CurtainFeaturesRequest;
use App\Http\Requests\CurtainModelRequest;
use App\Http\Requests\OrdersEditRequest;
use App\Models\Complement;
use App\Models\Cover;
use App\Models\Curtain;
use App\Models\Control;
use App\Models\Handle;
use App\Models\Mechanism;
use App\Models\CurtainModel;
use App\Models\ModeloToldo;
use App\Models\Order;
use App\Models\RollWidth;
use App\Models\SystemCurtain;
use App\Models\SystemScreenyCurtain;
use App\Models\VoiceControl;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CurtainsController extends Controller
{
    public function show($id)
    {
        $curtain = Curtain::findOrFail($id);
        return view('curtains.show', compact('curtain'));
    }

    /**
     * This function validates the data from the modal when you want to edit the product and saves it (the product id is sent in a hidden input form)
     *
     * @param Request $request
     * @return mixed
     */

    public function addData(addDataRequest $request)
    {
        $curtain = Curtain::findOrFail($request->get('curtain_id'));
        $order = Order::findOrFail($curtain->order_id);
        $order->price = $order->price - $curtain->price;
        $order->total = $order->total - $curtain->price;
        $curtain->fill($request->all());
        $curtain->systems_total = $this->calculateCurtainPrice($curtain, $order->discount);
        $curtain->accessories_total = $this->calculateAccessoriesPrice($curtain);
        $curtain->price = $curtain->systems_total + $curtain->accessories_total;
        $order->price = $order->price + $curtain->price;
        $order->total = $order->total + $curtain->price;
        $curtain->save();
        if($order->delivery == 1) {
            addPackages($order);
        }
        $order->save();
        return redirect()->route('orders.show', $order->id)->withStatus('Datos guardados correctamente');
    }

    public function copy($id)
    {
        $curtain = Curtain::findOrFail($id);
        $order = Order::findOrFail($curtain->order_id);
        if(!auth()->user()->isAdmin()) {
            $this->authorize('checkUser', $order);
        }
        copySystem($curtain, $order);
        return redirect()->back()->withStatus('Copia generada correctamente');
    }

    /**
     * Function to return values of the cover through a JavaScript function using Ajax, data changes a bit with each union
     *
     * @param Request $request
     */
    public function fetchCover(Request $request){
        $value = $request->get('cover_id');
        $curtain = Session::get('curtain');
        $this->echoCurtain($curtain, $value);
    }

    public function fetchCover2(Request $request){
        $value = $request->get('cover_id');
        $id = $request->get('curtain_id');
        $curtain = Curtain::findOrFail($id);
        $this->echoCurtain($curtain, $value);
    }

    private function echoCurtain(Curtain $curtain, int $value) {
        $cover = Cover::findOrFail($value);
        $width = $curtain['width'];
        $height = $curtain['height'];
        $measure = $height + 0.35;

        if($cover->unions == 'Vertical') {
            //Calculates number of fabric needed for pricing
            $num_lienzos = ceil($width / $cover->roll_width);
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
            $range = RollWidth::where('width', $cover->roll_width)->where('meters', $height)->value('range');
            $num_lienzos = Complement::where('range', $range)->value('complete');
            $complement = Complement::where('range', $range)->value('complements');
            $total_fabric = $num_lienzos * $width;
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
                   <h7 style='color: grey;'>Complementos: <strong>$complement</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Total de textil: <strong>$total_fabric mts</strong></h7>
              </div>
                </div>
              ";
        }
    }

    /**
     * Redirects to model selection page
     *
     * @param $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addModel($order_id)
    {
        $models = CurtainModel::all();
        $curtain = Session::get('curtain');
        return view('curtains.model', compact('order_id', 'models', 'curtain'));
    }

    /**
     * Post route
     *
     * @param CurtainModelRequest $request
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function addModelPost(CurtainModelRequest $request, $order_id)
    {
        createSession($request['model_id'], $order_id, Curtain::class, 'curtain');
        return redirect()->route('curtain.data', $order_id);
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
        $order = Order::findOrFail($order_id);
        $curtain = Session::get('curtain');
        return view('curtains.cover', compact('order_id', 'cov', 'curtain', 'order'));
    }

    /**
     *  Saving cover selection in session, redirecting to next step
     *
     * @param Request $request
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCoverPost(Request $request, $order_id)
    {
        $curtain = Session::get('curtain');
        $order = Order::findOrFail($order_id);
        if ($order->activity == "Pedido") {
            $rp = new CoverOrderRequest();
            $validatedData = $request->validate($rp->rules(), $rp->messages());
        } else {
            $ro = new CoverRequest();
            $validatedData = $request->validate($ro->rules(), $ro->messages());
        }
        $curtain->fill($validatedData);
        Session::put('curtain', $curtain);
        return redirect()->route('curtain.features', $order_id);
    }

    /**
     * Sending the session and mechanisms to the data view
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function addDat($order_id)
    {
        $curtain = Session::get('curtain');
        if($curtain->model_id == 5 || $curtain->model_id == 6) {
            $mechs = Mechanism::all()->except(3);
        } else {
            $mechs = Mechanism::all();
        }
        $model = CurtainModel::find($curtain->model_id);
        return view('curtains.data', compact('order_id', 'curtain', 'mechs', 'model'));
    }

    /**
     * Saving data in session
     *
     * @param CurtainDataRequest $request
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function addDataPost(CurtainDataRequest $request, $order_id)
    {
        $curtain = Session::get('curtain');
        $oldMechanismId = $curtain->mechanism_id;
        $newMechanismId = $request['mechanism_id'];
        $curtain->fill($request->except('squared'));
        //reset accessory values
        $this->resetAccessories($curtain, $oldMechanismId, $newMechanismId);
        return redirect()->route('curtain.cover', $order_id);
    }

    /**
     * The accessories page, we get the valid ones according to the mechanism selected, if the mechanism isn't compatible,
     * it returns the "No valido" option, with id 9999
     *
     * @param $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function addFeatures($order_id)
    {
        $curtain = Session::get('curtain');
        if($curtain->mechanism_id == 1){
            $controls = Control::where('id', 9999)->get();
            $voices = VoiceControl::where('id', 9999)->get();
            $handles = Handle::where('mechanism_id', 1)->get();
        } elseif ($curtain->mechanism_id == 4) {
            $controls = Control::where('mechanism_id', 4)->get();
            $voices = VoiceControl::where('mechanism_id', 4)->get();
            $handles = Handle::where('id', 9999)->get();
        } else {
            if($curtain->mechanism_id == 3){
                $handles = Handle::where('mechanism_id', 1)->get();
            } else {
                $handles = Handle::where('id', 9999)->get();
            }
            $controls = Control::where('mechanism_id', 2)->get();
            $voices = VoiceControl::where('mechanism_id', 2)->get();
        }
        $order = Order::findOrFail($order_id);
        return view('curtains.features', compact('order_id', 'curtain', 'handles', 'controls', 'voices', 'order'));
    }

    /**
     * Validation for the fields
     *
     * Storing the price in the session before sending you to the review page
     *
     * @param CurtainFeaturesRequest $request
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function addFeaturesPost(Request $request, $order_id)
    {
        $curtain = Session::get('curtain');
        $order = Order::findOrFail($order_id);
        if ($order->activity == "Pedido") {
            $rp = new CurtainFeaturesOrderRequest();
            $validatedData = $request->validate($rp->rules(), $rp->messages());
        } else {
            $ro = new CurtainFeaturesRequest();
            $validatedData = $request->validate($ro->rules(), $ro->messages());
        }
        if($curtain->model) {
            $keys = ['model', 'cover', 'mechanism', 'handle', 'control', 'voice'];
            removeKeys($curtain, $keys, 'curtain');
        }
        $curtain->fill($validatedData);
        $curtain->systems_total = $this->calculateCurtainPrice($curtain, $order->discount);
        $curtain->accessories_total = $this->calculateAccessoriesPrice($curtain);
        $curtain->price = $curtain->systems_total + $curtain->accessories_total;
        Session::put('curtain', $curtain);
        return redirect()->route('curtain.review', $order_id);
    }

    /**
     * This is the last step, and you will be able to review all the details of your product
     *
     * @param $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function review($order_id)
    {
        $curtain = Session::get('curtain');
        $order = Order::findOrFail($order_id);
        return view('curtains.review', compact('order_id', 'curtain', 'order'));
    }

    /**
     * Function to reset accessory values if there's a mechanism change
     *
     * @param Curtain $curtain
     * @param $oldMechanismId
     * @param int $newMechanismId
     */

    private function resetAccessories(Curtain $curtain, $oldMechanismId, int $newMechanismId) {
        if($oldMechanismId != $newMechanismId) {
            if ($curtain['mechanism_id'] == 1) {
                $curtain->control_id = 9999;
                $curtain->voice_id = 9999;
                $curtain->handle_id = 999;
            } elseif ($curtain['mechanism_id'] == 3) {
                $curtain->handle_id = 999;
                $curtain->control_id = 999;
                $curtain->voice_id = 999;
            } else {
                $curtain->handle_id = 9999;
                $curtain->control_id = 999;
                $curtain->voice_id = 999;
            }
            $curtain->handle_quantity = 0;
            $curtain->control_quantity = 0;
            $curtain->voice_quantity = 0;
        }
        Session::put('curtain', $curtain);
    }

    /**
     * Function to calculate and return the full price of the curtain
     *
     * @param Curtain $curtain
     * @return float
     */

    public function calculateCurtainPrice(Curtain $curtain, float $discount): float {
        $model_id = $curtain['model_id'];
        $canopy = $curtain['canopy'];

        $width = $curtain['width'];
        $height = $curtain['height'];
        $quantity = $curtain['quantity'];

        //Calculate cover plus handwork price
        $total_cover = $this->calculateCoverPrice($curtain['cover_id'], $width, $height);

        //Ceil the width to x.5 if width < x.5 or to x.0 if width > x.5
        $newWidth = ceilMeasure($width, 1);

        //Get the system price depending on model selected, height and width
        $system_price = $this->getSystemPrice($model_id, $height, $newWidth);

        $system = $this->calculateSystemPrice($curtain['mechanism_id'], $system_price);

        //Calculate the price of the canopy
        $total_canopy = $this->calculateCanopyPrice($canopy, $width, $newWidth);

        return (($total_cover+$system) * 1.16 / 0.60 * (1-($discount/100)) * $quantity) + $total_canopy;
    }

    /**
     * Function to calculate the price of all the accessories
     *
     * @param Curtain $curtain
     * @param float $system_price
     * @return float
     */

    public function calculateAccessoriesPrice(Curtain $curtain): float {
        $control = Control::find($curtain['control_id']);
        $mechanism_id = $curtain['mechanism_id'];
        $voice = VoiceControl::find($curtain['voice_id']);
        $handle = Handle::find($curtain['handle_id']);

        $cquant = $curtain['control_quantity'];
        $vquant = $curtain['voice_quantity'];
        $hquant = $curtain['handle_quantity'];

        //Accessories plus IVA
        $control_total = $control->price * $cquant;
        $voice_total = $voice->price * $vquant;
        $handle_total = $handle->price * $hquant;

        switch($mechanism_id) {
            case 1:
                //manual mechanism accessories
                return $handle_total * 1.16;
            case 2:
                //somfy mechanism accessories
                return ($control_total + $voice_total) * 1.16;
            case 3:
                //cmo mechanism accessories
                return ($control_total + $handle_total + $voice_total) * 1.16;
            case 4:
                //tube mechanism accessories
                return ($voice_total + $control_total) * 1.16;
            default:
                return 0;
        }
    }

    private function calculateSystemPrice(int $mechanism_id, float $system_price): float {
        switch($mechanism_id) {
            case 1:
                //manual mechanism accessories
                return ($system_price) ;
            case 2:
                //somfy mechanism accessories
                return ($system_price + (6927.693627*1.1));
            case 3:
                //cmo mechanism accessories
                return ($system_price + (7971.151961*1.1));
            case 4:
                //tube mechanism accessories
                return ($system_price + (1959.235294*1.1));
            default:
                return 0;
        }
    }

    /**
     * Calculate the price of the canopy, or return 0 if none was selected
     *
     * @param int $canopy
     * @param float $width
     * @param float $newWidth
     * @return float
     */

    private function calculateCanopyPrice(int $canopy, float $width, float $newWidth): float {
        if($canopy == 1) {
            return (((1023*1.1) * $width) + ((145*1.1) * $width) + ((142*1.1) * ($newWidth/2)) + (377*1.1)) * 1.16;
        } else {
            return 0;
        }
    }

    /**
     * Function to calculate the price of the cover depending on the unions of the textile
     *
     * @param Cover $cover
     * @param float $width
     * @param float $height
     * @return float
     */

    private function calculateCoverPrice(int $cover_id, float $width, float $height): float {
        $cover = Cover::find($cover_id);
        $measure = $height + 0.35;
        $squared_meters = $measure * $width;

        if($cover->unions == 'Vertical') {
            //Calculates number of fabric needed for pricing
            $num_lienzos = ceil($width / $cover->roll_width);
            $total_fabric = $measure * $num_lienzos;
            $cover_price = $cover->price * $total_fabric;
        } else {
            $height *= 10;
            $roundedHeight = ceil($height);
            $roundedHeight /= 10;
            $range = RollWidth::where('width', $cover->roll_width)->where('meters', $roundedHeight)->value('range');
            $num_lienzos = Complement::where('range', $range)->value('complete');
            $complement = Complement::where('range', $range)->value('complements');
            $total_fabric = $num_lienzos * $width;

            $full_price = $cover->price * $total_fabric;
            $complement_price = $cover->price / $cover->roll_width * 2.5 * $complement;
            $cover_price = $full_price + $complement_price;
        }

        $work_price = ($squared_meters * (70/(1 - 0.3))*1.1);
        return ($cover_price + $work_price);
    }

    /**
     * Function to get the price of the system from the database
     *
     * @param int $model_id
     * @param float $height
     * @param float $newWidth
     * @return float
     */

    private function getSystemPrice(int $model_id, float $height, float $newWidth): float {
        if($model_id > 3 && $model_id < 7){
            $newHeight = ceilMeasure($height, 1);
            $system = SystemScreenyCurtain::where('model_id', $model_id)->where('width', $newWidth)->where('height', $newHeight)->value('price');
        } else {
            $system = SystemCurtain::where('model_id', $model_id)->where('width', $newWidth)->value('price');
        }
        return $system;
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
     * @throws AuthorizationException
     */

    public function reviewPost(Request $request, $id) {
        $curtain = Session::get('curtain');
        $this->authorize('checkUser', $curtain);
        saveSystem($curtain, $id);
        Session::forget('curtain');
        return redirect()->route('orders.show', $id);
    }

    /**
     * Delete the curtain
     *
     * @param $id
     * @return mixed
     */

    public function destroy($id) {
        $curtain = Curtain::findOrFail($id);
        $this->authorize('checkUser', $curtain);
        deleteSystem($curtain);
        return redirect()->back()->withStatus('Sistema eliminado correctamente');
    }

    public function edit($id){
        $curtain = Curtain::findOrFail($id);
        $user = Auth::user();
        $role = $user->role_id;
        $handles = Handle::where('price', '>', 0)->get();
        $controls = Control::where('price', '>', 0)->get();
        $voices = VoiceControl::where('price', '>', 0)->get();
        return view('curtains.edit', compact('curtain', 'role', 'handles', 'controls', 'voices'));
    }
}
