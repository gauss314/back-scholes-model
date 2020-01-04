<h1 align="center"> Black and Scholes and Merton forms</h1>
<p align="center">
          [![Latest Stable Version](http://img.shields.io/badge/Latest%20Stable-1.0-blue.svg)](https://packagist.org/packages/gauss314/bsm)

<a href="https://packagist.org/packages/gauss314/bsm"><img src="https://poser.pugx.org/gauss314/bsm/v/stable.svg" alt=" Version"></a>
<a href="https://packagist.org/packages/gauss314/bsm"><img src="https://poser.pugx.org/gauss314/bsm/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/gauss314/bsm"><img src="https://poser.pugx.org/gauss314/bsm/license" alt="License"></a>
</p>


<p align="center">A simple way to get options primes, greeks and implied volatility using Black&Scholes valuation model.</p>

# Installation

```shell
$ composer require "gauss314/bsm"
```
<br>

# Usage

For Laravel 5, Symfony and any PHP project and framework with a composer.json file


```php
<?php

// Instance Object
$bsm = new \gauss314\bsm\Bsm();

// Parameters
$spot=100;
$strike=100;
$free_risk=0.018;     //free risk rate 1=100%
$time=30/365;         //time year fraction 1=1yr
$sigma=0.2;           //Annualized volatility 1=100%
$mkt_value=2;         //Option market value, its only necessary for implied volatility calc
$dividend_yield=0;    //not required, default value = 0

/*
**********************************************
          GET Call prime, and greeks
**********************************************
*/
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



/*
**********************************************
          GET Put prime, and greeks
**********************************************
*/
$put = $bsm->bsPut($spot, $strike, $free_risk, $time, $sigma, $dividend_yield);
/*
    Array
    (
      [put] => 2.2123103559286
      [delta] => -0.47827976451867
      [gamma] => 0.069473882914289
      [vega] => 0.11420364314678
      [theta] => -0.035600140877582
      [rho] => -0.041129002855723
    )
*/

/*
**********************************************
            GET Implied volatility
**********************************************
*/

$iv = $bsm->ivCall($spot, $strike, $free_risk, $tiempo, $mkt_value);  // 16.84647

//Use ivPut() method to get implied volatility from put contract.

```

<br>

# Configuration

It doesnt need any configuration line


Enjoy it! :heart:  

<br>

# Reference

- [Black & Scholes & Merton forms](https://en.wikipedia.org/wiki/Black%E2%80%93Scholes_model)

<br>

# License

MIT
