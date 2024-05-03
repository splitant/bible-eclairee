<?php

namespace Drupal\be_migrate\Plugin\migrate_plus\data_fetcher;

/**
 * Retrieve data from a url for migration bible books.
 *
 * @DataFetcher(
 *   id = "be_migrate_file_bible_books",
 *   title = @Translation("Be migrate : File bible books")
 * )
 */
class FileBibleBooks extends FileBase {

  /**
   * {@inheritdoc}
   */
  protected function rebuildJson(array $data): string {
    $data_rebuild = [];

    foreach ($data as $book) {
      $data_rebuild['bible_books'][] = [
        'book_name' => $book['label_book'],
        'book_order' => $book['id_book_topbible'],
      ];
    }

    return json_encode($data_rebuild);
  }

}
