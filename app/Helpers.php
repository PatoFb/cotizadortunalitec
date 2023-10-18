<?php

use App\Models\Curtain;
use App\Models\Order;
use Illuminate\Support\Facades\Session;

function removeKeys($object, array $keys, string $system) {
    foreach ($keys as $key) {
        unset($object[$key]);
    }
    Session::forget($system);
}

function ceilMeasure(float $measure, float $min): float {
    if($measure > $min) {
        $ceiledMeasure = ceil($measure);
        $diff = $ceiledMeasure - $measure;
        if ($diff > 0.5) {
            $newMeasure = $ceiledMeasure - 0.5;
        } else {
            $newMeasure = $ceiledMeasure;
        }
    } else {
        $newMeasure = $min;
    }
    return $newMeasure;
}

function createSession(int $model_id, int $order_id, string $object, string $system) {
    if(empty(Session::get($system))){
        $object = new $object();
        $object['order_id'] = $order_id;
    }else{
        $object = Session::get($system);
    }
    $object->model_id = $model_id;
    Session::put($system, $object);
}

function deleteSystem($system) {
    $order = Order::where('id', $system->order_id)->first();
    $order->price = $order->price - $system->price;
    $order->total = $order->total - $system->price;
    $order->save();
    $system->delete();
}

function saveSystem($system, $id) {
    $system->save();
    $order = Order::findOrFail($id);
    $order->price = $order->price + $system['price'];
    $order->total = $order->total + $system['price'];
    $order->save();
}

function addPackages(Order $order, int $mechanism_id, int $quantity) {
    $somfy_quantity = 0;
    $qty = 0;
    if($mechanism_id == 2) {
        $somfy_quantity = $quantity;
    } else {
        $qty = $quantity;
    }
    $somfy_packages = ['small' => 0, 'large' => 0];
    $other_packages = ['small' => 0, 'large' => 0];
    foreach($order->curtains as $c){
        if($c->mechanism_id == 2) {
            $somfy_quantity = $c->quantity + $somfy_quantity;
            $somfy_packages = addPackagesPerSystem(1, $somfy_quantity);
            \Illuminate\Support\Facades\Log::info($somfy_packages);
        } else {
            $qty = $c->quantity + $qty;
            $other_packages = addPackagesPerSystem(2, $qty);
            \Illuminate\Support\Facades\Log::info($other_packages);
        }
    }
    $small_packages = $somfy_packages['small'] + $other_packages['small'];
    $large_packages = $somfy_packages['large'] + $other_packages['large'];
    $order->total_packages = ($small_packages * 250) + ($large_packages * 330);
    $order->insurance = $order->total/1.16*0.012;
    $order->price = $order->price + $order->total_packages + $order->insurance;
    $order->total = $order->total + $order->total_packages + $order->insurance;
    $order->save();
}

function addPackagesPerSystem(int $value, int $quantity): array {
    $qty = (ceil($quantity/5));
    $small_packages = $qty * $value;
    $large_packages = $quantity;
    return ['small'=>$small_packages, 'large'=>$large_packages];
}
