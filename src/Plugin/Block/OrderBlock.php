<?php

namespace Drupal\sweets_shop\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Provides a 'Order' Block.
 *
 * @Block(
 *   id = "order_block",
 *   admin_label = @Translation("Order Block"),
 *   category = @Translation("Orders"),
 * )
 */
class OrderBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('\Drupal\sweets_shop\Form\OrderForm');
    /*
    $icecreamOrders = $this->getAllUnmadeOrders('icecream');
    $wafflesOrders = $this->getAllUnmadeOrders('waffles');
    return [
      '#theme'=>'sweets_shop',
      '#form' => $form,
      '#waffles_orders' => $wafflesOrders,
      '#icecream_orders' => $icecreamOrders,
      '#attached' => array(
        'library' => array(
          'sweets_shop/sweets_shop',
        )
      )
    ];*/
    return $form;
  }
/*
  public function getAllUnmadeOrders($type){
    if($type.'_counter' === $type.'_nr'){
      \Drupal::state()->set($type.'_count', 0);
      $select = \Drupal::database()->select('sweets_shop_'.$type.'_data');
      $select->condition('made', 0);
      $result = $select->execute()->fetchAll();
      return $result;
    }
  }*/
}