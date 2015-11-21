<?php
/**
 * @file
 * Contains \Drupal\views_templates\Plugin\ViewsDuplicateBuilder.
 */


namespace Drupal\views_templates\Plugin;


use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\views\Entity\View;
use Drupal\views_templates\Entity\ViewTemplate;
use Drupal\views_templates\ViewsTemplateLoaderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class ViewsDuplicateBuilderBase extends ViewsBuilderBase implements ViewsDuplicateBuilderPluginInterface, ContainerFactoryPluginInterface {

  /** @var \Drupal\views_templates\ViewsTemplateLoaderInterface $template_loader */
  protected $template_loader;

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
    $this->alterViewTemplateAfterCreation($view_template, $options);
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

  public function getAdminLabel() {
    return $this->loadViewsTemplateValue('label');
  }

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
    return $this->template_loader->load($this);
  }

  /**
   * After View Template has been created the Builder should alter it some how.
   *
   * @param \Drupal\views_templates\Entity\ViewTemplate $view_template
   */
  protected function alterViewTemplateAfterCreation(&$view_template, $options) {

  }


}
