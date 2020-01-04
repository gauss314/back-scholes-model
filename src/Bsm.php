<?php
namespace gauss314\bsm;

class BSM {
  public function  fi($x){
    $Pi = 3.141592653589793238;
    $a1 = 0.319381530;
    $a2 = -0.356563782;
    $a3 = 1.781477937;
    $a4 = -1.821255978;
    $a5 = 1.330274429;
    $L = abs($x);
    $k = 1 / ( 1 + 0.2316419 * $L);
    $p = 1 - 1 / pow(2 * $Pi, 0.5) * exp( -pow($L, 2) / 2 ) * ($a1 * $k + $a2 * pow($k, 2)
    + $a3 * pow($k, 3) + $a4 * pow($k, 4) + $a5 * pow($k, 5) );
    if ($x >= 0) {
      return $p;
    }else{
      return 1-$p;
    }
  }

  public function normalInv($x){
    return ((1/sqrt(2*pi())) * exp(-$x*$x*0.5));
  }


  #Funciones de Calculo de primas y griegas
  public function bsCall($S0, $K, $r, $T, $sigma, $q=0){
      if ($S0 > 0 && $K > 0 && $r >= 0 && $T > 0 && $sigma > 0){
        $d1 = ( log($S0/$K) + ($r -$q +$sigma*$sigma*0.5)*$T ) / ($sigma * sqrt($T));
        $d2 = $d1 - $sigma*sqrt($T);
        $ret['call'] = exp(-$q*$T) * $S0 * $this->fi($d1)- $K*exp(-$r*$T)*$this->fi($d2);
        $ret['delta'] = exp(-$q*$T) * $this->fi($d1);
        $ret['gamma'] = ($this->normalInv($d1) * exp(-$q*$T)) / ($S0 * $sigma * sqrt($T));
        $ret['vega'] = 0.01 * $S0 * exp(-$q*$T) * $this->normalInv($d1) * sqrt($T);
        $ret['theta'] = (1/365) * ( -(($S0*$sigma*exp(-$q*$T))/(2*sqrt($T))) * $this->normalInv($d1) - $r*$K*(exp(-$r*$T))*$this->fi($d2) + $q*$S0*(exp(-$q*$T)) * $this->fi($d1) );
        $ret['rho'] = 0.01 * $K * $T * exp(-$r*$T) * $this->fi($d2) ;
      }else {
        $ret['errores']= "Se Ingresaron valores incorrectos";
      }
      return $ret;
  }


  public function bsPut($S0, $K, $r, $T, $sigma, $q=0){
    if ($S0 > 0 && $K > 0 && $r >= 0 && $T > 0 && $sigma > 0){
      $d1 = ( log($S0/$K) + ($r -$q +$sigma*$sigma*0.5)*$T ) / ($sigma * sqrt($T));
      $d2 = $d1 - $sigma*sqrt($T);
      $ret['put'] = $K*exp(-$r*$T)*$this->fi(-$d2) - exp(-$q*$T) * $S0 * $this->fi(-$d1);
      $ret['delta'] = - exp(-$q*$T) * $this->fi(-$d1);
      $ret['gamma'] = exp(-$q*$T) * $this->normalInv($d1) / ($S0 * $sigma * sqrt($T));
      $ret['vega'] = 0.01* $S0 * exp(-$q*$T) * $this->normalInv($d1) * sqrt($T);
      $ret['theta'] =  (1/365) * ( -(($S0*$sigma*exp(-$q*$T))/(2*sqrt($T))) * $this->normalInv($d1) + $r*$K*(exp(-$r*$T))*$this->fi(-$d2) - $q*$S0*(exp(-$q*$T)) * $this->fi(-$d1) );
      $ret['rho'] = -0.01 * $K * $T * exp(-$r*$T) * $this->fi(-$d2);
    }else {
      $ret['errores']= "Se Ingresaron valores incorrectos";
    }
      return $ret;
  }


  public function ivCall($S0, $K, $r, $T, $prima, $q=0){
    if ($S0 > 0 && $K > 0 && $r >= 0 && $T > 0){
      $maximasIteraciones = 300;
      $pr_techo = $prima;
      $pr_piso = $prima;
      $vi_piso = $maximasIteraciones;
      $vi = $maximasIteraciones;
      for ($number=1; $number <= $maximasIteraciones; $number++) {
        $sigma = ($number)/100;
        $primaCalc = $this->bsCall($S0, $K, $r, $T, $sigma, $q)['call'];
        if ($primaCalc>$prima) {
          $vi_piso = $number -1;
          $pr_techo = $primaCalc;
          break(1);
        }else{
          $pr_piso = $primaCalc;
        }
      }
      $rango = ($prima - $pr_piso) / ($pr_techo - $pr_piso);
      $vi = $vi_piso + $rango;
    }else{
      $vi = "No se puede calcular VI porque los valores ingresados son incorrectos" ;
    }
    return($vi);
  }



  public function ivPut($S0, $K, $r, $T, $prima, $q=0){
    if ($S0 > 0 && $K > 0 && $r >= 0 && $T > 0){
      $maximasIteraciones = 300;
      $pr_techo = $prima;
      $pr_piso = $prima;
      $vi_piso = $maximasIteraciones;
      $vi = $maximasIteraciones;
      for ($number=1; $number <= $maximasIteraciones; $number++) {
        $sigma = ($number)/100;
        $primaCalc = $this->bsPut($S0, $K, $r, $T, $sigma, $q)['put'];
        if ($primaCalc>$prima) {
          $vi_piso = $number -1;
          $pr_techo = $primaCalc;
          break(1);
        }else{
          $pr_piso = $primaCalc;
        }
      }
      $rango = ($prima - $pr_piso) / ($pr_techo - $pr_piso);
      $vi = $vi_piso + $rango;
    }else{
      $vi = "No se puede calcular VI porque los valores ingresados son incorrectos" ;
    }
    return($vi);
  }


}
 ?>
