<h1 align="center"> Socialite</h1>
<p align="center">
<a href="https://packagist.org/packages/gauss314/bsm"><img src="https://poser.pugx.org/gauss314/bsm/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/overtrue/socialite"><img src="https://poser.pugx.org/gauss314/bsm/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/overtrue/socialite"><img src="https://poser.pugx.org/overtrue/socialite/license" alt="License"></a>
</p>


<p align="center">A simple way to get options primes, greeks and implied volatility using Black&Scholes valuation model.</p>

# Requirement

```
PHP >= 5.6
```
# Installation

```shell
$ composer require "gauss314/bsm"
```

# Usage

For Laravel 5, symfony and all frameworks that use composer autoload


```php
<?php
$bsm = new \gauss314\bsm\Bsm();

$spot=100;
$strike=100;
$free_risk=0.018;
$tiempo=30/365;
$sigma=0.2;
$prima_mkt=2;
$q = 0;
$dividend_yield=0;

$call = $bsm->bsCall($spot, $strike, $free_risk, $tiempo, $sigma, $dividend_yield);
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


$vi = $bsm->viCall($spot, $strike, $free_risk, $tiempo, $prima_mkt);  // 16.84647

```


### Configuration

It doesnt need any configuration line :smile:


Enjoy it! :heart:  :arg:

# Reference

- [Black & Scholes & Merton forms](https://en.wikipedia.org/wiki/Black%E2%80%93Scholes_model)


# License

MIT
