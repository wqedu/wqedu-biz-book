<?php
/**
 * Created by PhpStorm.
 * User: qujiyong
 * Date: 2018/7/18
 * Time: 下午4:24
 */
namespace Biz\Book\Service;

use Codeages\Biz\Framework\Service\Exception\AccessDeniedException;

interface BookService
{
    public function getBook($id);

    public function createBook($book);

    public function updateBook($id, $fields);

    public function deleteBook($id);

    public function searchBookCount($conditions);

    public function searchBooks($conditions, $sort, $start, $limit);
}
