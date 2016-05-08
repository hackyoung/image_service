<?php

define('ROOT', __DIR__);

require_once __DIR__ . '/vendor/autoload.php';

\Leno\AutoLoader::register('Model', '/model');
\Leno\AutoLoader::register('Controller', '/controller');

\Leno\View\Template::setCacheDir(ROOT . '/tmp/view');
\Leno\View::addViewDir(ROOT . '/view');

\Leno\Worker::setRouterClass('\\Router');
$worker = \Leno\Worker::instance();
$worker->errorToException();
$worker->execute();
