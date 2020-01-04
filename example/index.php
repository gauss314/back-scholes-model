<?php

require_once __DIR__ . "/../vendor/autoload.php";

$bsm = new \gauss314\bsm\Bsm();

$spot=100;
$strike=100;
$free_risk=0.018;
$time=30/365;
$sigma=0.2;
$prima_mkt=2;
$q = 0;
$dividend_yield=0;

$call = $bsm->bsCall($spot, $strike, $free_risk, $time, $sigma, $dividend_yield);
/*
Array
(
    [call] => 2.3601461764389
    [delta] => 0.52172023548133
    [gamma] => 0.069473882914289
    [vega] => 0.11420364314678
    [theta] => -0.040524357193283
    [rho] => 0.040941269072625
)
*/

$put = $bsm->bsPut($spot, $strike, $free_risk, $time, $sigma, $dividend_yield);
echo "<pre>";
print_r($put);

$vi = $bsm->viCall($spot, $strike, $free_risk, $time, $prima_mkt);  // 16.84647

?>
