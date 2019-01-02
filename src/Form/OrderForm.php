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
            'mokka' => $this->t('mokka'),
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
        '#empty_option' => 'vanilla',

    ];

    $form['waffles_toppings'] = [
        '#type' => 'checkboxes',
        '#title' => 'Choose your waffle toppings',
        '#options' =>[
            'whippedcream' => $this->t('whippedcream'),
            'sprinkles' => $this->t('sprinkles'),
            'fudge' => $this->t('fudge'),
            'syrup' => $this->t('syrup'),
        ],
        '#states' => array(
            //only show when waffle is chosen
            'visible' => array(
                ':input[name="order"]' => array(
                    'option' => 'waffles',
                ),
            ),
        ),
    ];

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
    ];
    
    return $form;
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
      // saving the data
      if($form_state->getValue('order')==='icecream'){
          // if order is icecream
        $result = \Drupal::database()->insert('sweets_shop_icecream_data')->fields([
            'flavor' => $form_state->getValue('icecream_flavor'),
            'made' => 0,
        ])->execute();
        \Drupal::messenger()->addStatus('Your icecream order has been saved.');
      }elseif($form_state->getValue('order')==='waffles'){
          // if order is waffles
        $toppingValues = $form_state->getValue('waffles_topping');
        $listOfToppings = array_filter($toppingValues);
        $whippedcream = 0;
        $sprinkles = 0;
        $fudge = 0;
        $syrup = 0;
        if(in_array('whippedcream', $listOfToppings)){
            $whippedcream = 1;
        }
        if(in_array('sprinkles', $listOfToppings)){
            $sprinkles = 1;
        }
        if(in_array('fudge', $listOfToppings)){
            $fudge = 1;
        }
        if(in_array('syrup', $listOfToppings)){
            $syrup = 1;
        }
        $result = \Drupal::database()->insert('sweets_shop_waffles_data')->fields([
            'whippedcream' => $whippedcream,
            'sprinkles' => $sprinkles,
            'fudge' => $fudge,
            'syrup' => $syrup,
            'made' => 0,
        ])->execute();
        \Drupal::messenger()->addStatus('Your waffles order has been saved.');
      }
    
  }

}