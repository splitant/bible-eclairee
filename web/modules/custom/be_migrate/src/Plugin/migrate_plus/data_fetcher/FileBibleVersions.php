<?php

namespace Drupal\be_migrate\Plugin\migrate_plus\data_fetcher;

/**
 * Retrieve data from a url for migration bible versions.
 *
 * @DataFetcher(
 *   id = "be_migrate_file_bible_versions",
 *   title = @Translation("Be migrate : File bible versions")
 * )
 */
class FileBibleVersions extends FileBase {

  /**
   * {@inheritdoc}
   */
  protected function rebuildJson(array $data): string {
    $data_rebuild = [];

    foreach ($data as $version_code => $version_name) {
      $data_rebuild['bible_versions'][] = [
        'version_code' => $version_code,
        'version_name' => $version_name,
      ];
    }

    return json_encode($data_rebuild);
  }

}
