<?php
namespace Controller;

class Js extends \Leno\Controller
{
    public function index()
    {
        return file_get_contents(
            ROOT . '/public/js/upload.js'
        );
    }
}
