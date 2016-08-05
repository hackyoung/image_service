<?php
/**
 * 通过leno init自动生成, 如果需要在路由之前执行逻辑，则重写Router的beforeRoute方法
 */
class Router extends \Leno\Routing\Router
{
    protected $rules = [
        '^[0-9a-f]{8}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{12}$' => '/index/${1}',
    ];
}
