<?php
/**
 * @file
 * Contains
 * \Drupal\views_templates_builder_test\Plugin\ViewsTemplateBuilder\ViewDuplicatorTest.
 */


namespace Drupal\views_templates_builder_test\Plugin\ViewsTemplateBuilder;


use Drupal\Core\Form\FormStateInterface;
use Drupal\views_templates\Plugin\ViewsDuplicateBuilderBase;

/**
 * @Plugin(
 *  id = "view_duplicator_test",
 *  default_title = "Nodes List",
 *  view_template_id = "simpliest"
 * )
 */
class ViewDuplicatorTest extends ViewsDuplicateBuilderBase{

  /**
   * {@inheritdoc}
   */
  public function alterViewTemplateAfterCreation(&$view_template, $options) {
    // Make a simple change. This one goes to 11!
    $view_template->display['default']['display_options']['pager']['options']['items_per_page'] = $options['pager_count'];
  }

  public function buildConfigurationForm($form, FormStateInterface $form_state) {
    $config_form['pager_count'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Pager Count'),
      '#default_value' => '10',
    ];
    return $config_form;
  }


}