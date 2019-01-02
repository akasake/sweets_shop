<?php

namespace Drupal\sweets_shop\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class OrderForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return ' ';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['order'] = [
        '#type' => 'select',
        '#title' => 'What would you like to order?',
        '#options' => [
            'icecream' => $this->t('icecream'),
            'waffles' => $this->t('waffles'),
        ],
        '#empty_value' => 'icecream',
        '#empty_option' => 'icecream',

    ];

    $form['icecream_flavor'] = [
        '#type' => 'select',
        '#title' => 'Select the flavor of the icecream',
        '#options' =>[
            'vanilla' => $this->t('vanilla'),
            'strawberry' => $this->t('strawberry'),
            'chocolate' => $this->t('chocolate'),
            'mokka' => $this->t('mokka')
        ],
        '#states' => array(
            //only show when icecream is chosen
            'visible' => array(
                ':input[name="order"]' => array(
                    'value' => 'icecream',
                ),
            ),
        ),
        '#empty_value' => 'vanilla',
        '#empty_option' => 'vanilla'

    ];

    $form['waffles_toppings'] = [
        '#type' => 'checkboxes',
        '#title' => 'Choose your waffle toppings',
        '#options' =>[
            'whippedcream' => $this->t('whippedcream'),
            'sprinkles' => $this->t('sprinkles'),
            'fudge' => $this->t('fudge'),
            'syrup' => $this->t('syrup')
        ],
        '#states' => array(
            //only show when waffles is chosen
            'visible' => array(
                ':input[name="order"]' => array(
                    'value' => 'waffles',
                ),
            ),
        )
    ];

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
    ];
    
    return $form;
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
      
      if($form_state->getValue('order')==='icecream'){
          // if order is icecream
          // saving the data
        $result = \Drupal::database()->insert('sweets_shop_icecream_data')->fields([
            'flavor' => $form_state->getValue('icecream_flavor'),
            'made' => 0,
        ])->execute();
        

          // saving the counter 
          $icecream_count= \Drupal::state()->get('icecream_count');
          $icecream_nr= \Drupal::state()->get('icecream_nr');
          if($icecream_count<$icecream_nr){
              // icecream counter did not reach min yet
            \Drupal::state()->set('icecream_count', $icecream_count+1);
            ksm(\Drupal::state()->get('icecream_count'));
            \Drupal::messenger()->addStatus('Your icecream order has been saved. You need to order more icecream');
          }elseif($icecream_count>=$icecream_nr){
              // icecream counter reached min
            \Drupal::state()->set('icecream_count', 0);
            ksm(\Drupal::state()->get('icecream_count'));
            \Drupal::messenger()->addStatus('Your icecream order has been saved. The minimum icecream number has been reached');
          }
          

        
      }elseif($form_state->getValue('order')==='waffles'){
          // if order is waffles
        $listOfToppings = $form_state->getValue('waffles_toppings');
        $whippedcream = 0;
        $sprinkles = 0;
        $fudge = 0;
        $syrup = 0;
        //ksm($listOfToppings);
        foreach ($listOfToppings as $key => $topping){
            if($topping === 'whippedcream'){
                $whippedcream = 1;
            }elseif($topping === 'sprinkles'){
                $sprinkles = 1;
            }elseif($topping === 'fudge'){
                $fudge = 1;
            }elseif($topping === 'syrup'){
                $syrup = 1;
            }
        }
        $result = \Drupal::database()->insert('sweets_shop_waffles_data')->fields([
            'whippedcream' => $whippedcream,
            'sprinkles' => $sprinkles,
            'fudge' => $fudge,
            'syrup' => $syrup,
            'made' => 0,
        ])->execute();
        \Drupal::messenger()->addStatus('Your waffles order has been saved.');

        // saving the counter 
        $waffles_count= \Drupal::state()->get('waffles_count');
        $waffles_nr= \Drupal::state()->get('waffles_nr');
        if($waffles_count<$waffles_nr){
            // waffles counter did not reach min yet
          \Drupal::state()->set('waffles_count', $waffles_count+1);
          ksm(\Drupal::state()->get('waffles_count'));
          \Drupal::messenger()->addStatus('Your waffles order has been saved. You need to order more waffles');
        }elseif($waffles_count>=$waffles_nr){
            // waffles counter reached min
          \Drupal::state()->set('waffles_count', 0);
          ksm(\Drupal::state()->get('waffles_count'));
          \Drupal::messenger()->addStatus('Your waffles order has been saved. The minimum waffles number has been reached');
        }
      }
    
  }

}