<?php
/**
 * @file
 * Contains \Drupal\views_templates\Plugin\ViewsDuplicateBuilder.
 */


namespace Drupal\views_templates\Plugin;


use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\views\Entity\View;
use Drupal\views_templates\ViewsTemplateLoaderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class ViewsDuplicateBuilderBase extends ViewsBuilderBase implements ViewsDuplicateBuilderPluginInterface, ContainerFactoryPluginInterface {

  /** @var \Drupal\views_templates\ViewsTemplateLoaderInterface $template_loader */
  protected $template_loader;

  protected $loaded_template;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, ViewsTemplateLoaderInterface $loader) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->template_loader = $loader;

  }


  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('views_templates.loader')
    );
}

  /**
   * {@inheritdoc}
   */
  public function createView($options = NULL) {
    $view_template = $this->loadTemplate();
    $view_template['id'] = $options['id'];
    $view_template['label'] = $options['label'];
    $view_template['description'] = $options['description'];
    return View::create($view_template);
  }


  /**
   * {@inheritdoc}
   */
  public function getViewTemplateId() {
    return $this->getDefinitionValue('view_template_id');
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm($form, FormStateInterface $form_state) {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getAdminLabel() {
    return $this->loadViewsTemplateValue('label');
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->loadViewsTemplateValue('description');
  }

  /**
   * Return value from template.
   *
   * @param $key
   *
   * @return null|mixed
   */
  protected function loadViewsTemplateValue($key) {
    $view_template = $this->loadTemplate();
    if (isset($view_template[$key])) {
      return $view_template[$key];
    }
    return NULL;
  }

  /**
   * Load template from service.
   *
   * @return object
   */
  protected function loadTemplate() {
    if (empty($this->loaded_template)) {
      $template = $this->template_loader->load($this);
      $this->alterViewTemplateAfterCreation($template);
      $this->loaded_template = $template;
    }

    return $this->loaded_template;
  }

  /**
   * After View Template has been created the Builder should alter it some how.
   *
   * @param \Drupal\views_templates\Entity\ViewTemplate $view_template
   *
   * @param array $options
   *  Options for altering
   */
  protected function alterViewTemplateAfterCreation(array &$view_template, $options = NULL) {
    if ($replace_values = $this->getDefinitionValue('replace_values')) {
      $this->replaceTemplateKeyAndValues($view_template, $replace_values);
    }
  }

  /**
   * Recursively replace keys and values in template elements.
   *
   * For example of builder and yml template:
   *
   * @see Drupal\views_templates_builder_test\Plugin\ViewsTemplateBuilder
   *
   * @param array $template_elements
   *  Array of elements from a View Template array
   * @param array $replace_values
   *  The values in that should be replaced in the template.
   *  The keys in this array can be keys OR values template array.
   *  This allows replacing both keys and values in the template.
   */
  protected function replaceTemplateKeyAndValues(array &$template_elements, array $replace_values) {
    foreach ($template_elements as $key => &$value) {
      if (is_array($value)) {
        $this->replaceTemplateKeyAndValues($value, $replace_values);
      }
      foreach ($replace_values as $replace_key => $replace_value) {
        if (!is_array($value)) {
          if (is_string($value)) {
            if (stripos($value, $replace_key) !== FALSE) {
              $value = str_replace($replace_key, $replace_value, $value);
            }
          }
          elseif ($replace_key === $value) {
            $value = $replace_value;
          }
        }
        if ($key === $replace_key) {
          // NULL is used in replace value to remove keys from template.
          if ($replace_value !== NULL) {
            $template_elements[$replace_value] = $value;
          }
          unset($template_elements[$key]);
        }
      }
    }
  }


}
