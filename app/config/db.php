<?php
namespace App\Config;
use Illuminate\Database\Capsule\Manager as Capsule;

return function() {
    $capsule = new Capsule;
    $capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'slim',
    'username' => 'user',
    'password' => '123456',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

};