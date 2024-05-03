<?php

namespace Drupal\be_migrate\Plugin\migrate_plus\data_fetcher;

/**
 * Retrieve data from a url for migration bible verses.
 *
 * @DataFetcher(
 *   id = "be_migrate_file_bible_verses",
 *   title = @Translation("Be migrate : File bible verses")
 * )
 */
class FileBibleVerses extends FileBase {

  /**
   * {@inheritdoc}
   */
  protected function rebuildJson(array $data): string {
    $data_rebuild = [];

    foreach ($data['chapters'] as $chapter_id => $verses) {
      foreach ($verses as $verse_id => $verse_content) {
        $data_rebuild['bible_verses'][] = [
          'book_version' => $data['version_book'],
          'book_version_code' => $data['code_version_book'],
          'book_name' => $data['name'],
          'chapter_id' => $chapter_id,
          'verse_id' => $verse_id,
          'verse_content' => $verse_content,
        ];
      }
    }

    return json_encode($data_rebuild);
  }

}
