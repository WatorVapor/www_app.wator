<?php

namespace Wator\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function verify($accessToken,$access,$signature,$keyId) {
      $ecdsaURI = 'http://127.0.0.1:17263/' . $accessToken . '/' . $access . '/' . $signature . '/' . $keyId;
      //var_dump($ecdsaURI);
      $ecdsaVerifyStr = file_get_contents($ecdsaURI);
      //var_dump($ecdsaVerifyStr);
      $ecdsaVerify = json_decode($ecdsaVerifyStr);
      return $ecdsaVerify;
    }
}
