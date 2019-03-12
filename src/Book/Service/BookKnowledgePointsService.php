<?php
/**
 * Created by PhpStorm.
 * User: wangqianjin
 * Date: 2019/3/12
 * Time: 11:09 AM
 */
namespace Biz\Book\Service;

use Codeages\Biz\Framework\Service\Exception\AccessDeniedException;

interface BookKnowledgePointsService
{
    public function getKnowledgePoint($id);

    public function getKnowledgePointByBookId($bookId);

    public function getKnowledgePointByChapterId($bookId,$chapterId);

    public function createKnowledgePoint($point);

    public function updateKnowledgePoint($id, $fields);

    public function deleteKnowledgePoint($id);

    public function searchKnowledgePointCount($conditions);

    public function searchKnowledgePoints($conditions, $sort, $start, $limit);
}