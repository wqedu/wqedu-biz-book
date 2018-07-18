<?php
/**
 * Created by PhpStorm.
 * User: qujiyong
 * Date: 2018/5/28
 * Time: 下午4:27
 */

namespace Biz\Book\Dao\Impl;

use Biz\Book\Dao\BookDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class BookDaoImpl extends GeneralDaoImpl implements BookDao
{
    protected $table = 'book';

    public function declares()
    {
        return array(
            'serializes' => array(
            ),
            'orderbys' => array(
                'createdTime',
                'updatedTime',
                'id',
            ),
            'timestamps' => array('createdTime', 'updatedTime'),
            'conditions' => array(
                'id = :id',
                'updatedTime >= :updatedTime_GE',
                'status = :status',
                'type = :type',
                'title LIKE :titleLike',
                'createdTime >= :startTime',
                'createdTime < :endTime',
                'category LIKE :categoryLike',
                'tag LIKE :tagLike',
                'smallPicture = :smallPicture',
                'id NOT IN ( :excludeIds )',
                'id IN ( :bookIds )',
            ),
            'wave_cahceable_fields' => array(),
        );
    }
}