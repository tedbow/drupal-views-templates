<?php

/**
 * @file
 * Contains \Drupal\views_templates\ViewsTemplateLoaderInterface.
 */

namespace Drupal\views_templates;
use Drupal\views_templates\Plugin\ViewsDuplicateBuilderPluginInterface;

/**
 * Interface ViewsTemplateLoaderInterface.
 *
 * @package Drupal\views_templates
 */
interface ViewsTemplateLoaderInterface {

  public function load(ViewsDuplicateBuilderPluginInterface $builder);

}
