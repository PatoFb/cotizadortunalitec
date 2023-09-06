<?php

namespace App\Http\Controllers;

use App\Models\Complement;
use App\Models\Cover;
use App\Models\Curtain;
use App\Models\Control;
use App\Models\Handle;
use App\Models\Mechanism;
use App\Models\CurtainModel;
use App\Models\ModeloToldo;
use App\Models\RollWidth;
use App\Models\SystemCurtain;
use App\Models\SystemScreenyCurtain;
use App\Models\VoiceControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CurtainsController extends Controller
{
    public function show($id)
    {
        $curtain = Curtain::findOrFail($id);
        return view('palillerias.show', compact('curtain'));
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
     * Dynamic function to return values of the cover through a JavaScript function using Ajax, data changes a bit with each union
     *
     * @param Request $request
     */
    public function fetchCover(Request $request){
        $value = $request->get('cover_id');
        $curtain = $request->session()->get('curtain');
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
        return redirect()->route('curtain.features', $order_id);
    }

    /**
     * Sendind the session and mechanisms to the data view
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function addDat(Request $request, $id)
    {
        $order_id = $id;
        $curtain = $request->session()->get('curtain');
        $mechs = Mechanism::all();
        $model = ModeloToldo::find($curtain->model_id);
        return view('curtains.data', compact('order_id', 'curtain', 'mechs', 'model'));
    }

    /**
     * Saving data in session, we store 9999 for incompatible accessories, and 1 for compatible ones
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
        $keys = ['handle_quantity', 'control_quantity', 'voice_quantity'];
        removeKeys($curtain, $keys);
        Session::put('curtain', $curtain);
        return redirect()->route('curtain.cover', $order_id);
    }

    /**
     * The accessories page, we get the valid ones according to the mechanism selected, if the mechanism isn't compatible,
     * it returns the "No valido" option, with id 9999
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
        return view('curtains.features', compact('order_id', 'curtain', 'handles', 'controls', 'voices'));
    }

    /**
     * Validation for the four fields asked on this step, store in session
     *
     * We get the prices of the other objects from other tables using all the ids stored in the session
     *
     * Price of the system is calculated in this step, so you can review the totals in the review page
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
            'canopy' => 'required',
            'control_id' => 'required',
            'voice_id' => 'required',
            'control_quantity' => 'required',
            'handle_quantity' => 'required',
            'voice_quantity' => 'required'
        ]);
        $curtain = Session::get('curtain');
        if($curtain->model){
            $keys = ['model', 'cover', 'mechanism', 'handle', 'control', 'voice'];
            removeKeys($curtain, $keys);
            Session::forget('curtain');
        }
        $curtain->fill($validatedData);

        $cover = Cover::find($curtain['cover_id']);

        $model_id = $curtain['model_id'];

        $control = Control::find($curtain['control_id']);

        $mechanism_id = $curtain['mechanism_id'];

        $voice = VoiceControl::find($curtain['voice_id']);

        $handle = Handle::find($curtain['handle_id']);

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

        $measure = $height + 0.35;
        $squared_meters = $measure * $width;

        if($cover->unions == 'Vertical') {
            //Calculates number of fabric needed for pricing
            $num_lienzos = ceil($width / $cover->roll_width);
            $total_fabric = $measure * $num_lienzos;
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

        $work_price = $squared_meters * (70/(1 - 0.3));
        $total_cover = ($cover_price + $work_price);

        $newWidth = ceilMeasure($width, 1);

        if($model_id > 3 && $model_id < 7){
            $newHeight = ceilMeasure($height, 1.5);
            $system = SystemScreenyCurtain::where('model_id', $model_id)->where('width', $newWidth)->where('height', $newHeight)->first();
        } else {
            $system = SystemCurtain::where('model_id', $model_id)->where('width', $newWidth)->first();
        }

        $manual = $system->price;
        $tube = 1959.235294 + $manual;
        $somfy = 6927.693627 + $manual;
        $cmo = 7971.151961 + $manual;

        //If user chooses canopy, it will calculate the price by width plus IVA
        if($canopy == 1) {
            $total_canopy = ((1023 * $width) + (145 * $width) + (142 * ($newWidth/2)) + 377) * 1.16;
        } else {
            $total_canopy = 0;
        }

        $utility = 0.40;

        switch($mechanism_id) {
            case 1:
                $accessories = $handle_total + $total_canopy;
                $curtain->price = ((((($manual+$total_cover)*1.16) / (1-$utility)) * (1-($user->discount/100))) * $quantity) + $accessories;
                break;
            case 2:
                $accessories = $control_total + $voice_total + $total_canopy;
                $curtain->price = ((((($somfy+$total_cover)*1.16) / (1-$utility)) * (1-($user->discount/100))) * $quantity) + $accessories;
                break;
            case 3:
                $accessories = $control_total + $handle_total + $voice_total + $total_canopy;
                $curtain->price = ((((($cmo+$total_cover)*1.16) / (1-$utility)) * (1-($user->discount/100))) * $quantity) + $accessories;
                break;
            case 4:
                $accessories = $voice_total + $total_canopy + $control_total;
                $curtain->price = ((((($tube+$total_cover)*1.16) / (1-$utility)) * (1-($user->discount/100))) * $quantity) + $accessories;
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

    public function reviewPost(Request $request, $id) {
        $curtain = Session::get('curtain');
        saveSystem($curtain, $id);
        Session::forget('curtain');
        return redirect()->route('orders.show', $id);
    }


    public function destroy($id) {
        $curtain = Curtain::findOrFail($id);
        deleteSystem($curtain);
    }
}
