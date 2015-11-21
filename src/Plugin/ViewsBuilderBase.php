<?php

/**
 * @file
 * Contains \Drupal\views_templates\Plugin\ViewsTemplateBuilder\ViewsBuilderBase.
 */

namespace Drupal\views_templates\Plugin;

use Drupal\Core\Plugin\PluginBase;
use Drupal\views\Entity\View;
use Drupal\views_templates\Plugin\ViewsBuilderPluginInterface;

/**
 * Base builder for View Templates
 *
 * This class get Views information for Plugin definition.
 * Extending classes can use derivatives to make many plugins.
 */
class ViewsBuilderBase extends PluginBase implements ViewsBuilderPluginInterface {
  /**
   * {@inheritdoc}
   */
  public function getBaseTable() {
    return $this->getDefinition('base_table');
  }

  /**
   * {@inheritdoc}
   */
  public function getAdminLabel() {
    return $this->getDefinition('admin_label');
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->getDefinition('description');
  }

  public function getDefinition($key) {
    $def = $this->getPluginDefinition();
    return $def[$key];
  }

  /**
   * {@inheritdoc}
   */
  public function createView($options = NULL) {

    $view_values = [
      'id' => $options['id'],
      'label' => $options['label'],
      'description' => $options['description'],
      'base_table' => $this->getBaseTable(),
    ];
    return View::create($view_values);
  }


}
