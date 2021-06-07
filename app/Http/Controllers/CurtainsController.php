<?php

namespace App\Http\Controllers;

use App\Models\Curtain;
use App\Models\CurtainCanopy;
use App\Models\CurtainControl;
use App\Models\CurtainCover;
use App\Models\CurtainHandle;
use App\Models\CurtainMechanism;
use App\Models\CurtainModel;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Table;

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
        $models = CurtainModel::all();
        $covers = CurtainCover::all();
        $handles = CurtainHandle::all();
        $canopies = CurtainCanopy::all();
        $controls = CurtainControl::all();
        $mechanisms = CurtainMechanism::all();
        return view('curtains.create', compact('order_id', 'models', 'covers', 'handles', 'canopies', 'controls', 'order', 'mechanisms'));
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
                'quantity' => 'required',
                'installation_type' => 'required',
                'mechanism_side' => 'required',
                'view_type' => 'required',
                'mechanism_id'=>'required'
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
                'quantity' => 'required',
                'mechanism_id'=>'required'
            ]);
        }
        $curtain = new Curtain();
        $curtain['order_id'] = $order_id;
        $curtain->fill($validatedData);
        $handle = CurtainHandle::where('id', $curtain['handle_id'])->first();
        $canopy = CurtainCanopy::where('id', $curtain['canopy_id'])->first();
        $control = CurtainControl::where('id', $curtain['control_id'])->first();
        $model = CurtainModel::where('id', $curtain['model_id'])->first();
        $cover = CurtainCover::where('id', $curtain['cover_id'])->first();
        $mechanism = CurtainMechanism::where('id', $curtain['mechanism_id'])->first();

        $width = $curtain['width'];
        $height = $curtain['height'];
        $quantity = $curtain['quantity'];

        //Calculates number of fabric needed for pricing
        $num_lienzos = ceil($width/$cover->roll_width);
        $measure = $height + 0.45;
        $total_fabric = $measure * $num_lienzos;

        //Calculates total pricing of fabric plus handiwork plus IVA
        $cover_price = $cover->price * $total_fabric;
        $work_price = (53 * $total_fabric)/(1 - 0.40);
        $total_cover = ($cover_price + $work_price) * 1.16;

        //If user chooses canopy, it will calculate the price by width plus IVA
        if($curtain['canopy_id'] == 1) {
            $canopy_price = 2165.94 / 5 * $width + 100;
            //If width is greater than 3.6, price will be summed (322.66 * 2)
            if ($width > 3.5) {
                $total_canopy = ($canopy_price + 255.04 + (322.66 * 2) + (118.15 * $width)) * 1.16;
            } else { //If not, price will be summed 322.66
                $total_canopy = ($canopy_price + 255.04 + (322.66) + (118.15 * $width)) * 1.16;
            }
        } else { //Canopy price is 0 if selection is No
            $total_canopy = 0;
        }

        //Calculates the tube price for the model, multiplying it by width + cut and adding utility
        $tube_price = ($model->tube->price * $width + 100) / (1 - 0.37);
        //Calculates the panel price for the model, multiplying it by width + cut and adding utility
        $panel_price = ($model->panel->price * $width + 150) / (1 - 0.37);
        //Sums all data for model + the cordon plus IVA
        $price_model = ($model->base_price + $tube_price + $panel_price + (6.18 * ($width * 2) / (1 - 0.37))) * 1.16;

        //Handle plus IVA
        $handle_total = $handle->price * 1.16;

        //Control plus IVA
        $control_total = $control->price * 1.16;

        //Pricing of user selected option
        $curtain['price'] = ($handle_total + $total_canopy + $control_total + $price_model + $total_cover + ($mechanism->price * 1.16)) * $quantity;
        $curtain->save();
        $order->price = $order->price + $curtain['price'];
        $order->total = $order->total + ($curtain['price'] * (1 - ($order->discount/100)));
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

        $model_id = $input['model_id'];
        $model = CurtainModel::find($model_id);

        $cover_id = $input['cover_id'];
        $cover = CurtainCover::find($cover_id);

        $handle_id = $input['handle_id'];
        $handle = CurtainHandle::find($handle_id);

        $control_id = $input['control_id'];
        $control = CurtainControl::find($control_id);

        $mechanism_id = $input['mechanism_id'];
        $mechanism = CurtainMechanism::find($mechanism_id);

        //Gets all mechanisms for the comparisob
        $manual = CurtainMechanism::find(1);
        $somfy = CurtainMechanism::find(2);
        $elec = CurtainMechanism::find(3);
        $tube = CurtainMechanism::find(4);

        $width = $input['width'];
        $height = $input['height'];
        $quantity = $input['quantity'];

        //Calculates number of fabric needed for pricing
        $num_lienzos = ceil($width/$cover->roll_width);
        $measure = $height + 0.45;
        $total_fabric = $measure * $num_lienzos;

        //Calculates total pricing of fabric plus handiwork plus IVA
        $cover_price = $cover->price * $total_fabric;
        $work_price = (53 * $total_fabric)/(1 - 0.40);
        $total_cover = ($cover_price + $work_price) * 1.16;

        //If user chooses canopy, it will calculate the price by width plus IVA
        if($input['canopy_id'] == 1) {
            $canopy_price = 2165.94 / 5 * $width + 100;
            //If width is greater than 3.6, price will be summed (322.66 * 2)
            if ($width > 3.5) {
                $total_canopy = ($canopy_price + 255.04 + (322.66 * 2) + (118.15 * $width)) * 1.16;
            } else { //If not, price will be summed 322.66
                $total_canopy = ($canopy_price + 255.04 + (322.66) + (118.15 * $width)) * 1.16;
            }
        } else { //Canopy price is 0 if selection is No
            $total_canopy = 0;
        }

        //Calculates the tube price for the model, multiplying it by width + cut and adding utility
        $tube_price = ($model->tube->price * $width + 100) / (1 - 0.37);
        //Calculates the panel price for the model, multiplying it by width + cut and adding utility
        $panel_price = ($model->panel->price * $width + 150) / (1 - 0.37);
        //Sums all data for model + the cordon plus IVA
        $price_model = ($model->base_price + $tube_price + $panel_price + (6.18 * ($width * 2) / (1 - 0.37))) * 1.16;

        //Handle plus IVA
        $handle_total = $handle->price * 1.16;

        //Control plus IVA
        $control_total = $control->price * 1.16;

        //Pricing of user selected option
        $price = ($handle_total + $total_canopy + $control_total + $price_model + $total_cover + ($mechanism->price * 1.16)) * $quantity;
        $price = number_format($price, 2);

        //Pricing of manual mechanism
        $price_manual = ($handle_total + $total_canopy + $control_total + $price_model + $total_cover + ($manual->price * 1.16)) * $quantity;
        $price_manual = number_format($price_manual, 2);

        //Pricing of somfy mechanism
        $price_somfy = ($handle_total + $total_canopy + $control_total + $price_model + $total_cover+ ($somfy->price * 1.16)) * $quantity;
        $price_somfy = number_format($price_somfy, 2);

        //Pricing of manual-electric mechanism
        $price_elec = ($handle_total + $total_canopy + $control_total + $price_model + $total_cover + ($elec->price * 1.16)) * $quantity;
        $price_elec = number_format($price_elec, 2);

        //Pricing of tube mechanism
        $price_tube = ($handle_total + $total_canopy + $control_total + $price_model + $total_cover + ($tube->price *  1.16)) * $quantity;
        $price_tube = number_format($price_tube,2);
        echo "<div class='text-right'><h3><strong>Precio estimado: $$price</strong></h3></div>
            <div class='row text-right'>
            <div class='col-md-3 col-sm-6'>
            <strong>Manual-Eléctrico <br>$$price_elec</strong>
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
            <h4>Detalles de sistema</h4>
            <div class='row'>
                <div class='col-md-4 col-sm-12'>
                   <img src=".asset('storage')."/images/".$model->photo." style='width: 100%;' alt='Image not found'>
              </div>
              <div class='col-md-8 col-sm-12'>
                   <h7 style='color: grey;'><strong>$model->description</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Máxima resistencia al viento de <strong>$model->max_resistance km/h</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Tiempo de producción: <strong>$model->production_time días hábiles</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Ancho máximo: <strong>$model->max_width</strong></h7>
                   <br>
                   <h7 style='color: grey;'>Caída máxima: <strong>$model->max_height</strong></h7>
              </div>
              </div>
              <hr>
              </div>
              <div>
              <div class='col-12'>
                <h4>Detalles de cubierta</h4>
               </div>
                <div class='row'>
                <div class='col-md-4 col-sm-12'>
                   <img src=".asset('storage')."/images/".$cover->photo." style='width: 100%;'>
              </div>
              <div class='col-md-8 col-sm-12'>
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
              </div>";
    }

    /**
     * This function works exactly as the model one but retrieves the cover
     *
     * @param Request $request
     */
    public function fetchCover(Request $request){
        //$select = $request->get('select');
        $value = $request->get('value');
        //$dependant = $request->get('dependant');
        $cover = CurtainCover::findOrFail($value);

        echo "<div class='col-12'>
                <h4>Detalles de cubierta</h4>
               </div>
                <div class='row'>
                <div class='col-md-6 col-sm-12'>
                   <img src=".asset('storage')."/images/".$cover->photo." style='width: 100%;'>
              </div>
              <div class='col-md-6 col-sm-12'>
                   <h7 style='color: grey;'>$cover->name</h7>
                   <br>
                   <h7 style='color: grey;'>Ancho de rollo: $cover->roll_width mts</h7>
                   <br>
                   <h7 style='color: grey;'>Uniones: $cover->unions</h7>
                   <br>
                   <h7 style='color: grey;'>Número de lienzos:<h7 class='number'> </h7></h7>
                   <br>
                   <h7 style='color: grey;'>Medida de lienzos:<h7 class='measure'> </h7></h7>
                   <br>
                   <h7 style='color: grey;'>Total de textil:<h7 class='numbertotal'> </h7></h7>
              </div>
                </div>
              ";
    }

    /**
     * Function that retrieves the data in the height and width fields (In progress)
     *
     * @param Request $request
     */

    public function fetchNumbers(Request $request){
        $values = $request->get('values');
        echo "<p>Hola</p>";
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
    /*public function addModel(Request $request, $id)
    {
        $order_id = $id;
        $models = CurtainModel::all();
        $curtain = $request->session()->get('curtain');
        return view('curtains.model', compact('order_id', 'models', 'curtain'));
    }*/

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

    /*public function addModelPost(Request $request, $id)
    {
        $order_id = $id;
        $validatedData = $request->validate([
            'model_id' => 'required',
        ]);
        if(empty($request->session()->get('curtain'))){
            $curtain = new Curtain();
            $curtain['order_id'] = $order_id;
            $curtain->fill($validatedData);
            $request->session()->put('curtain', $curtain);
        }else{
            $curtain = $request->session()->get('curtain');
            $curtain->fill($validatedData);
            $request->session()->put('curtain', $curtain);
        }
        return redirect()->route('curtain.cover', $order_id);
    }*/

    /**
     * Works exactly the same as the model function, but with covers
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    /*public function addCover(Request $request, $id)
    {
        $order_id = $id;
        $covers = CurtainCover::all();
        $curtain = $request->session()->get('curtain');
        return view('curtains.cover', compact('order_id', 'covers', 'curtain'));
    }*/

    /**
     * It works exactly the same as the model post function, but without the if statement since
     * thanks to the validation, the session wont be empty once you reach this point
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    /*public function addCoverPost(Request $request, $id)
    {
        $order_id = $id;
        $validatedData = $request->validate([
            'cover_id' => 'required',
        ]);
        $curtain = $request->session()->get('curtain');
        $curtain->fill($validatedData);
        $request->session()->put('curtain', $curtain);
        return redirect()->route('curtain.data', $order_id);
    }*/

    /**
     * Works the same as the model and cover functions, but since we don't need any data for a radio list,
     * we won't send any objects but the curtain stored in session
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    /*public function addData(Request $request, $id)
    {
        $order_id = $id;
        $curtain = $request->session()->get('curtain');
        return view('curtains.data', compact('order_id', 'curtain'));
    }*/

    /**
     * Validation for the two numeric fields, store in session and then go to next step
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    /*public function addDataPost(Request $request, $id)
    {
        $order_id = $id;
        $validatedData = $request->validate([
            'width' => 'required',
            'height' => 'required',
        ]);
        $curtain = $request->session()->get('curtain');
        $curtain->fill($validatedData);
        $request->session()->put('curtain', $curtain);
        return redirect()->route('curtain.features', $order_id);
    }*/

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

    /*public function addFeatures(Request $request, $id)
    {
        $order_id = $id;
        $handles = CurtainHandle::all();
        $canopies = CurtainCanopy::all();
        $controls = CurtainControl::all();
        $curtain = $request->session()->get('curtain');
        return view('curtains.features', compact('order_id', 'curtain', 'handles', 'canopies', 'controls'));
    }*/

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

    /*public function addFeaturesPost(Request $request, $id)
    {
        $order_id = $id;
        $validatedData = $request->validate([
            'handle_id' => 'required',
            'canopy_id' => 'required',
            'control_id' => 'required',
            'quantity' => 'required'
        ]);
        $curtain = $request->session()->get('curtain');
        $curtain->fill($validatedData);
        $request->session()->put('curtain', $curtain);
        $handle = CurtainHandle::where('id', $curtain['handle_id'])->first();
        $canopy = CurtainCanopy::where('id', $curtain['canopy_id'])->first();
        $control = CurtainControl::where('id', $curtain['control_id'])->first();
        $model = CurtainModel::where('id', $curtain['model_id'])->first();
        $cover = CurtainCover::where('id', $curtain['cover_id'])->first();
        $curtain['price'] = ($handle->price + $canopy->price + $control->price + $model->base_price + $cover->price) * $curtain['quantity'];
        return redirect()->route('curtain.review', $order_id);
    }*/

    /**
     * This is the last step and you will be able to review all the details of your product
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    /*public function review(Request $request, $id)
    {
        $order_id = $id;
        $curtain = $request->session()->get('curtain');
        return view('curtains.review', compact('order_id', 'curtain'));
    }*/

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

    /*public function reviewPost(Request $request, $id)
    {
        $order_id = $id;
        $curtain = $request->session()->get('curtain');
        $curtain->save();
        $order = Order::findOrFail($id);
        $order->price = $order->price + $curtain['price'];
        $order->total = $order->total + ($curtain['price']*(1 - ($order->discount/100)));
        $order->save();
        $request->session()->forget('curtain');
        return redirect()->route('orders.show', $order_id);
    }*/

    /**
     * Delete a curtain from an order and subtract the total price
     *
     * @param $id
     * @return mixed
     */
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
