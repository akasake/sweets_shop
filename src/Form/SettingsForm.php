<?php

namespace Drupal\sweets_shop\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Settings' Form.
 *
 * @Block(
 *   id = "sweets_shop_settings_form",
 *   admin_label = @Translation("Sweets Shop SettingsForm"),
 *   category = @Translation("Settings Form"),
 * )
 */
class SettingsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return '';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['icecream_nr'] = [
      '#default_value' => \Drupal::state()->get('icecream_nr'),
      '#type' => 'textfield',
      '#title' => 'Minimum value of icecream for notification',
    ];

    $form['waffles_nr'] = [
      '#default_value' => \Drupal::state()->get('waffles_nr'),
      '#type' => 'textfield',
      '#title' => 'Minimum value of waffles for notification',
    ];
        
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::state()->set('icecream_nr',  $form_state->getValue('icecream_nr'));
    \Drupal::state()->set('waffles_nr',  $form_state->getValue('waffles_nr'));
    \Drupal::messenger()->addStatus('Your settings have been saved');
  }

}