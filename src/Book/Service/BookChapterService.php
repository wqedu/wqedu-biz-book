<?php
/**
 * Created by PhpStorm.
 * User: wangqianjin
 * Date: 2019/3/12
 * Time: 10:59 AM
 */
namespace Biz\Book\Service;

use Codeages\Biz\Framework\Service\Exception\AccessDeniedException;

interface BookChapterService
{
    public function getChapter($bookId,$parentId=0);

    public function createChapter($bookId,$chapter);

    public function updateChapter($id, $fields);

    public function deleteChapter($id);

    public function searchChapterCount($conditions);

    public function searchChapters($conditions, $sort, $start, $limit);
}
