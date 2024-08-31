<?php

namespace Drupal\be_common\Controller;

use Drupal\config_pages\ConfigPagesLoaderServiceInterface;
use Drupal\config_pages\Entity\ConfigPages;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a controller for homepage.
 */
class HomepageController extends ControllerBase {

  protected ConfigPages $configPagesHomepage;

  /**
   * HomepageController constructor.
   *
   * @param \Drupal\config_pages\ConfigPagesLoaderServiceInterface $configPagesLoader
   *   The ConfigPages loader service.
   */
  public function __construct(
    protected ConfigPagesLoaderServiceInterface $configPagesLoader,
  ) {
    $this->configPagesHomepage = $configPagesLoader->load('homepage');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config_pages.loader'),
    );
  }

  /**
   * Provides a page to render homepage.
   *
   * @return array
   *   A render array.
   */
  public function __invoke(): array {
    if (!$this->configPagesHomepage) {
      return [];
    }

    return $this->entityTypeManager()->getViewBuilder('config_pages')
      ->view($this->configPagesHomepage);
  }

  /**
   * Provides a title callback for homepage.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   The title for the homepage.
   */
  public function title(): TranslatableMarkup {

    // @todo Add title from first hero paragraph fields
    return $this->t('Fix me %fix_me', []);
  }

}
