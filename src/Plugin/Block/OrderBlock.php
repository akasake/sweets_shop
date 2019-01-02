<?php

namespace Drupal\sweets_shop\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Connection;

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
    return $form;
  }
}