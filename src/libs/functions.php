<?php

namespace vendor\libs;

function debug($arr)
{
    echo '<pre>' . print_r($arr, true) . '</pre>';
}