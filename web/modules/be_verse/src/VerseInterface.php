<?php

declare(strict_types=1);

namespace Drupal\be_verse;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a verse entity type.
 */
interface VerseInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
