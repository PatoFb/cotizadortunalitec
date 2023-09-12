<?php

use App\Models\Order;
use Illuminate\Support\Facades\Session;

function removeKeys($object, array $keys) {
    foreach ($keys as $key) {
        unset($object[$key]);
    }
}

function ceilMeasure(float $measure, float $min): float {
    if($measure >= $min) {
        $ceiledMeasure = ceil($measure);
        $diff = $ceiledMeasure - $measure;
        if ($diff < 0.5 && $diff != 0) {
            $newMeasure = $ceiledMeasure - 0.5;
        } else if ($diff > 0.5 && $diff != 0) {
            $newMeasure = $ceiledMeasure;
        } else {
            $newMeasure = $measure;
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
