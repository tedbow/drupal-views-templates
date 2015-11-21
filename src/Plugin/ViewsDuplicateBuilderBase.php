<?php
/**
 * @file
 * Contains \Drupal\views_templates\Plugin\ViewsDuplicateBuilder.
 */


namespace Drupal\views_templates\Plugin;


use Drupal\Core\Form\FormStateInterface;
use Drupal\views_templates\Entity\ViewTemplate;

abstract class ViewsDuplicateBuilderBase extends ViewsBuilderBase implements ViewsDuplicateBuilderPluginInterface{

  /**
   * {@inheritdoc}
   */
  public function createView($options = NULL) {
    $view_template = $this->duplicateViewTemplate();
    $view_template->set('entityTypeId', 'view');
    $view_template->set('id', $options['id']);
    $view_template->set('label', $options['label']);
    $view_template->set('description', $options['description']);
    $this->alterViewTemplateAfterCreation($view_template, $options);
    return $view_template;
  }

  /**
   * Load View Template and then manually change it to a View.
   *
   * @todo Is this actually safe to do?
   *
   * @return \Drupal\Views\Entity\View
   */
  protected function duplicateViewTemplate() {

    /** @var \Drupal\views_templates\Entity\ViewTemplate $view_template */
    $view_template = ViewTemplate::load($this->getViewTemplateId())->createDuplicate();

    return $view_template;
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

  protected function loadViewsTemplateValue($key) {
    $view_template = $this->duplicateViewTemplate();
    if (isset($view_template->$key)) {
      return $view_template->$key;
    }
    return NULL;
  }

  /**
   * After View Template has been created the Builder should alter it some how.
   *
   * @param \Drupal\views_templates\Entity\ViewTemplate $view_template
   */
  protected function alterViewTemplateAfterCreation(&$view_template, $options) {

  }


}
