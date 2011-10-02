<?php

require_once('BookException.php');

/**
 * Book class
 *
 * @author Denis Pugachev <xstudpidkidzx@gmail.com>
 * @throws BookException
 */
class Book {

    /**
     * @var bool
     */
    protected $opened = false;

    /**
     * @var string
     */
    protected $author;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $totalPages;

    /**
     * @var array
     */
    protected $history = array();

    /**
     * @throws BookException
     * @param array $params
     */
    public function __construct($params = array()) {

        if (!isset($params['author'])) {
            throw new BookException('Author must be set');
        } else {
            $this->author = $params['author'];
        }

        if (!isset($params['title'])) {
            throw new BookException('Title must be set');
        } else {
            $this->title = $params['title'];
        }

        if (!isset($params['totalPages'])) {
            throw new BookException('Total pages must be set');
        } else {
            $this->totalPages = $params['totalPages'];
        }

        if (isset($params['history'])) {
            $history = $params['history'];
            $this->history = $history;
            if (count($history) != 0 && array_pop($history) === null) {
                $this->opened = true;
            }
        }
    }

    /**
     * @throws BookException
     * @return Book
     */
    public function open() {
        if ($this->isOpened()) {
            throw new BookException('Book is opened already');
        }
        $this->opened = true;
        $this->history[] = null;
        return $this;
    }

    /**
     * @throws BookException
     * @param int $currentPage
     * @return Book
     */
    public function close($currentPage) {
        if (!$this->isOpened()) {
            throw new BookException('Book is closed already');
        }
        $this->opened = false;
        $this->history[count($this->history) - 1] = (int)$currentPage;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOpened() {
        return $this->opened;
    }

    /**
     * @return string
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getTotalPages() {
        return $this->totalPages;
    }

    /**
     * @return array
     */
    public function getHistory() {
        return $this->history;
    }

}
