<?php

declare(strict_types=1);

namespace Drupal\be_verse\Entity;

use Drupal\be_verse\VerseInterface;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the verse entity class.
 *
 * @ContentEntityType(
 *   id = "verse",
 *   label = @Translation("Verse"),
 *   label_collection = @Translation("Verses"),
 *   label_singular = @Translation("verse"),
 *   label_plural = @Translation("verses"),
 *   label_count = @PluralTranslation(
 *     singular = "@count verses",
 *     plural = "@count verses",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\be_verse\VerseListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\be_verse\VerseAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\be_verse\Form\VerseForm",
 *       "edit" = "Drupal\be_verse\Form\VerseForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *       "delete-multiple-confirm" = "Drupal\Core\Entity\Form\DeleteMultipleForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\be_verse\Routing\VerseHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "verse",
 *   data_table = "verse_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer verse",
 *   entity_keys = {
 *     "id" = "id",
 *     "langcode" = "langcode",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *     "owner" = "uid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/verse",
 *     "add-form" = "/verse/add",
 *     "canonical" = "/verse/{verse}",
 *     "edit-form" = "/verse/{verse}",
 *     "delete-form" = "/verse/{verse}/delete",
 *     "delete-multiple-form" = "/admin/content/verse/delete-multiple",
 *   },
 *   field_ui_base_route = "entity.verse.settings",
 * )
 */
final class Verse extends ContentEntityBase implements VerseInterface {

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage): void {
    parent::preSave($storage);
    if (!$this->getOwnerId()) {
      // If no owner has been set explicitly, make the anonymous user the owner.
      $this->setOwnerId(0);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setTranslatable(TRUE)
      ->setLabel(t('Author'))
      ->setSetting('target_type', 'user')
      ->setDefaultValueCallback(self::class . '::getDefaultEntityOwner')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => 15,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'author',
        'weight' => 15,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setTranslatable(TRUE)
      ->setDescription(t('The time that the verse was created.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setTranslatable(TRUE)
      ->setDescription(t('The time that the verse was last edited.'));

    return $fields;
  }

}
