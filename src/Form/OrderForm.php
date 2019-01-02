<?php

namespace Drupal\sweets_shop\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


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
        ]

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
                ':select[name="order"]' => array(
                    'value' => 'icecream',
                ),
            ),
        ),
    ];

    $form['waffle_toppings'] = [
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
                ':select[name="order"]' => array(
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
    \Drupal::state()->set('order',  $form_state->getValue('order'));
    \Drupal::state()->set('icecream_flavor',  $form_state->getValue('icecream_flavor'));
    \Drupal::state()->set('waffle_toppings',  $form_state->getValue('waffle_toppings'));
    \Drupal::messenger()->addStatus('Your order has been saved. Please wait while we prepare your order.');
  }

}