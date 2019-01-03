<?php

namespace Drupal\sweets_shop\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AjaxController extends ControllerBase{
    public function make_order(Request $request){

        try{
            $sweet = $request->get('sweet');
            $result = \Drupal::database()->update('sweets_shop_'.$sweet.'_data')->fields([
                'made' => 1,
            ])->condition('made', 0)->execute();

            
        }catch(exception $e){
            return new Response('There was a problem making your order');
        }
        return new Response('Your order has been made');

        
    }
}