<?php

namespace Drupal\be_migrate\Plugin\migrate_plus\data_fetcher;

use Drupal\migrate_plus\Plugin\migrate_plus\data_fetcher\File as CoreFile;

/**
 * Base class to manage fetching data for migration in Be context.
 */
abstract class FileBase extends CoreFile {

  /**
   * {@inheritdoc}
   */
  public function getResponseContent(string $url): string {
    $json = parent::getResponseContent($url);
    // Convert objects to associative arrays.
    $source_data = json_decode($json, TRUE, 512, JSON_THROW_ON_ERROR);

    // If json_decode() has returned NULL, it might be that the data isn't
    // valid utf8 - see http://php.net/manual/en/function.json-decode.php#86997.
    if (is_null($source_data)) {
      $utf8response = mb_convert_encoding($json, 'UTF-8');
      $source_data = json_decode($utf8response, TRUE, 512, JSON_THROW_ON_ERROR);
    }

    return $this->rebuildJson($source_data);
  }

  /**
   * Rebuild JSON method depending of the strategy.
   *
   * @param array $data
   *   Array data.
   *
   * @return string
   *   JSON string rebuilt.
   */
  abstract protected function rebuildJson(array $data): string;

}
