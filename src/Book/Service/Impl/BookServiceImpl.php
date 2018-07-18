<?php
/**
 * Created by PhpStorm.
 * User: qujiyong
 * Date: 3018/7/18
 * Time: 下午4:27
 */

namespace Biz\Book\Service\Impl;

use Codeages\Biz\Framework\Service\BaseService;
use Biz\Book\Service\BookService;
use Wqedu\Common\ArrayToolkit;

class BookServiceImpl extends BaseService implements BookService
{

    public function getBook($id)
    {
        try{
            $book  = $this->getBookDao()->get($id);

            if(empty($book))
                throw new \Exception('Book Resource Not Found', 30304);

            return array(
                'code'  =>  0,
                'data'  =>  KeypointsSerialize::unserialize($book)
            );
        } catch (\Exception $e) {
            return $this->_filterSystemException($e->getCode(), $e->getMessage());
        }
    }

    public function createBook($book)
    {
        try{
            if (!ArrayToolkit::requireds($book, array('title')))
                throw new \Exception('Missing Necessary Fields', 30301);

            $book                = $this->_filterBookFields($book);
            $book['status']      = 'published';
            $book['about']       = !empty($book['about']) ? $book['about'] : '';
            //$book['about']       = !empty($book['about']) ? $this->purifyHtml($book['about']) : '';//todo, add htmlhelper
            $book['createdTime'] = time();
            $book['updatedTime'] = time();
            $book                = $this->getBookDao()->create(KeypointsSerialize::serialize($book));

            //$this->getLogService()->info('book', 'create', "创建教材《{$book['title']}》(#{$book['id']})");

            return array(
                'code'  =>  0,
                'data'  =>  KeypointsSerialize::unserialize($book)
            );
        } catch (\Exception $e){
            return $this->_filterSystemException($e->getCode(), $e->getMessage());
        }
    }

    public function updateBook($id, $fields)
    {
        try{
            $book   = $this->getBookDao()->get($id);
            if(empty($book))
                throw new \Exception('Book Resource Not Found', 30304);

            $fields = $this->_filterBookFields($fields);
            $fields        = KeypointsSerialize::serialize($fields);
            $updatedBook = $this->getBookDao()->update($id, $fields);
            //$this->getLogService()->info('book', 'update', "更新教材《{$book['title']}》(#{$book['id']})的信息", $fields);

            return array(
                'code'  =>  0,
                'data'  =>  KeypointsSerialize::unserialize($updatedBook)
            );
        } catch (\Exception $e) {
            return $this->_filterSystemException($e->getCode(), $e->getMessage());
        }
    }

    public function deleteBook($id)
    {
        try {
            $book   = $this->getBookDao()->get($id);
            if(empty($book))
                throw new \Exception('Book Resource Not Found', 30304);

            $this->getLessonDao()->deleteLessonsByBookId($id);
            $this->getChapterDao()->deleteChaptersByBookId($id);
            $this->getBookDao()->delete($id);

            //$this->getLogService()->info('book', 'delete', "删除教材《{$book['title']}》(#{$book['id']})");
            return array(
                'code'  =>  0,
                'data'  =>  true
            );

        } catch (\Exception $e) {
            return $this->_filterSystemException($e->getCode(), $e->getMessage());
        }
    }

    public function searchBookCount($conditions)
    {
        try {
            $conditions = $this->_prepareBookConditions($conditions);

            $count = $this->getBookDao()->count($conditions);

            return array(
                'code'  =>  0,
                'data'  =>  array('totalCount' => $count)
            );

        } catch (\Exception $e) {
            return $this->_filterSystemException($e->getCode(), $e->getMessage());
        }

    }

    public function searchBooks($conditions, $sort, $start, $limit)
    {
        try{
            $conditions = $this->_prepareBookConditions($conditions);
            $orderBy = $this->_prepareBookOrderBy($sort);

            $list = $this->getBookDao()->search($conditions, $orderBy, $start, $limit);
            return array(
                'code'  =>  0,
                'data'  =>  array('list' => $list)
            );
        } catch (\Exception $e)
        {
            return $this->_filterSystemException($e->getCode(), $e->getMessage());
        }
    }

    /*
     * book
     */

    protected function _filterBookFields($fields)
    {
        $fields = ArrayToolkit::filter($fields, array(
            'title'             =>  '',
            'subtitle'          =>  '',
            'price'             =>  0.00,
            'category'          =>  '',
            'tags'              =>  '',
            'keypoints'         =>  array(),
            'smallPicture'      =>  '',
            'middlePicture'     =>  '',
            'largePicture'      =>  '',
            'about'             =>  '',
            'status'            =>  'published',
            'url'               =>  '',
            'createdTime'       =>  time(),
            'updatedTime'       =>  time(),

        ));

        return $fields;
    }

    protected function _prepareBookConditions($conditions)
    {
        $conditions = array_filter(
            $conditions,
            function ($value) {
                if (0 == $value) {
                    return true;
                }

                return !empty($value);
            }
        );

        return $conditions;
    }

    protected function _prepareBookOrderBy($sort)
    {
        if (is_array($sort)) {
            $orderBy = $sort;
        } elseif ('createdTimeByAsc' == $sort) {
            $orderBy = array('createdTime' => 'ASC');
        } else {
            $orderBy = array('createdTime' => 'DESC');
        }

        return $orderBy;
    }

    /**
     * @return BookDao
     */
    protected function getBookDao()
    {
        return $this->biz->dao('Book:BookDao');
    }
}