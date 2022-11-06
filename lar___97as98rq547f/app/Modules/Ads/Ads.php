<?php
namespace App\Modules\Ads;


class Ads
{

    public function Fetch($page, $device, $area){

       $ad = \DB::table('ads')->where([
           'page' => $page,
           'device' => $device,
           'area'  => $area,
           'status' => 1
       ]);

       return $ad ? $ad->code : false;

    }

    




}