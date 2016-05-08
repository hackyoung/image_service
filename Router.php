<?php

class Router extends \Leno\Routing\Router
{
    protected $rules = [
        'image/${1}' => 'index/${1}',
        'image' => 'index',
    ];
}
