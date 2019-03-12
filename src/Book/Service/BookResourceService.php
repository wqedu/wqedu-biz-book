<?php
/**
 * Created by PhpStorm.
 * User: wangqianjin
 * Date: 2019/3/12
 * Time: 11:17 AM
 */
namespace Biz\Book\Service;

use Codeages\Biz\Framework\Service\Exception\AccessDeniedException;

interface BookResourceService
{
    public function getResource($bookId);

    public function createResource($resource);

    public function updateResource($id, $fields);

    public function deleteResource($id);

    public function searchResourceCount($conditions);

    public function searchResources($conditions, $sort, $start, $limit);
}