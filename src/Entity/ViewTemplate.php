<?php

/**
 * @file
 * Contains \Drupal\views_templates\Entity\FilterFormat.
 */

namespace Drupal\views_templates\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines a View template configuration entity class.
 *
 * @ConfigEntityType(
 *   id = "view_template",
 *   label = @Translation("View Template"),
 *   handlers = {
 *     "access" = "Drupal\views\ViewAccessControlHandler",
 *     "list_builder" = "Drupal\views_templates\ViewTemplateListBuilder",
 *     "form" = {
 *       "create_from_template" = "Drupal\views_templates\ViewTemplateForm"
 *     }
 *   },
 *   admin_permission = "administer views",
 *   config_prefix = "view_template",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   links = {
 *     "create-from-template" = "/admin/structure/views/template/{view_template}/add"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "module",
 *     "description",
 *     "tag",
 *     "base_table",
 *     "base_field",
 *     "core",
 *     "display",
 *   }
 * )
 */
class ViewTemplate extends ConfigEntityBase {

  /**
   * {@inheritdoc}
   */
  public function label() {
    if (!$label = $this->get('label')) {
      $label = $this->id();
    }
    return $label;
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->get('description');
  }
}
