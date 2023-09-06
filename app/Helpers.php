<?php

function removeKeys($object, array $keys) {
    foreach ($keys as $key) {
        unset($object[$key]);
    }
}
