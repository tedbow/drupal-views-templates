<?php

/**
 * @file
 * Contains \Drupal\views_templates\ViewTemplateListBuilder.
 */

namespace Drupal\views_templates;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a class to build a listing of view template entities.
 *
 * @see \Drupal\views_templates\Entity\ViewTemplate
 */
class ViewTemplateListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = t('Name');
    $header['description'] = array(
      'data' => t('Description'),
      'class' => array(RESPONSIVE_PRIORITY_MEDIUM),
    );
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['label'] = $entity->label();
    $row['description']['data'] = ['#markup' => $entity->getDescription()];
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultOperations(EntityInterface $entity) {
    $operations = parent::getDefaultOperations($entity);

    $operations['create_from_template'] = array(
      'title' => $this->t('add'),
      'weight' => 20,
      'url' => $entity->urlInfo('create-from-template'),
    );

    return $operations;
  }

}
