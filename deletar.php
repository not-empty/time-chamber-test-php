<?php

require_once __DIR__ . '/vendor/autoload.php';

use Carbon\Carbon;
use Predis\Client as Redis;
use Illuminate\Container\Container;
use Tests1Doc\SimpleTests;
use Tests1Doc\AdvancedTests;
use Tests1Doc\ContainerTest;

$simple = new SimpleTests();
echo $simple->soma(1, 2) . PHP_EOL;
echo $simple->multiplicacao(1, 2) . PHP_EOL;
echo $simple->divisao(2, 2) . PHP_EOL;
echo $simple->multiplicacao(0, 2) . PHP_EOL;
echo $simple->multiplicacao(2, 0) . PHP_EOL;

$carbon = new Carbon();
$advanced = new AdvancedTests($carbon);
echo $advanced->returnNow() . PHP_EOL;
echo $advanced->returnAge(1992, 11, 20) . PHP_EOL;
echo $advanced->biricutidoDay(2022, 4, 22) . PHP_EOL;
var_dump($advanced->getCredential('test', 'service')) . PHP_EOL;
var_dump($advanced->setCredential('test', 'service', '123')) . PHP_EOL;
var_dump($advanced->delCredential('test', 'service')) . PHP_EOL;

$containerClass = new Container();
$container = new ContainerTest($containerClass);
echo $container->usingAdvancedTests() . PHP_EOL;
