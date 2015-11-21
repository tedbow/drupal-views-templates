<?php

/**
 * @file
 * Contains \Drupal\views_templates\ViewsTemplateLoader.
 */

namespace Drupal\views_templates;

use Drupal\Component\Serialization\Yaml;
use Drupal\views_templates\Plugin\ViewsDuplicateBuilderPluginInterface;


/**
 * Service class to load templates from the file system.
 *
 *
 */
class ViewsTemplateLoader implements ViewsTemplateLoaderInterface {

  /**
   * {@inheritdoc}
   */
  public function load(ViewsDuplicateBuilderPluginInterface $builder) {
    // @todo through errors template file is not available.
    $templates = &drupal_static(__FUNCTION__, array());

    $template_id = $builder->getViewTemplateId();
    if (!isset($templates[$template_id])) {
      $dir = drupal_get_path('module', $builder->getDefinitionValue('module')) . '/views_templates';
      if (is_dir($dir)) {

        $file_path = $dir . '/' . $builder->getViewTemplateId() . '.yml';
        if (is_file($file_path)) {
          $templates[$template_id] = Yaml::decode(file_get_contents($file_path));
        }
      }
    }
    return $templates[$template_id];
  }

}
