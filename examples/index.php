<?php

require(__DIR__ . '/../vendor/autoload.php');

$app = new \Illuminate\Container\Container();

$fsm = $app->make('Examples\FSM');

$fsm->handle('flickSwitch');
$fsm->handle('flickSwitch');
$fsm->handle('flickSwitch');
$fsm->handle('flickSwitch');
$fsm->handle('status');
$fsm->handle('flickSwitch');
$fsm->handle('flickSwitch');
$fsm->handle('flickSwitch');
$fsm->handle('flickSwitch');
$fsm->handle('flickSwitch');
$fsm->handle('status');