<?php
namespace Model\Entity;

class App extends \Model\Entity
{
    public static $attributes = [
        'app_id' => ['type' => 'uuid'],
        'url' => ['type' => 'url'],
        'created' => ['type' => 'datetime'],
        'updated' => ['type' => 'datetime', 'required' => false],
        'deleted' => ['type' => 'datetime', 'required' => false],
    ];

    public static $primary = 'app_id';

    public static $table = 'application';
}
