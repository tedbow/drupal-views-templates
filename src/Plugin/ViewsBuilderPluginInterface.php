<?php
/**
 * @file
 * Contains \Drupal\views_templates\Plugin\ViewsBuilderPluginInterface.
 */


namespace Drupal\views_templates\Plugin;


use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Creates a common interface for Views Builder classes.
 */
interface ViewsBuilderPluginInterface extends  PluginInspectionInterface {

  /**
   * Returns base table id.
   *
   * @return string
   */
  public function getBaseTable();

  /**
   * Get template description.
   *
   * @return string
   */
  public function getDescription();

  /**
   * Get template admin label.
   *
   * @return string
   */
  public function getAdminLabel();

  /**
   * Get a value from the plugin definition.
   * @param $key
   *
   * @return mixed
   */
  public function getDefinition($key);

  /**
   * Create a View. Don't save it.
   * @param null $options
   *
   * @return \Drupal\views\ViewEntityInterface
   */
  public function createView($options = NULL);

}
