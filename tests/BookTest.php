<?php

require_once('../Book.php');

class BookTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Book
     */
    protected $book = null;

    protected function setUp() {
        $params = array(
            'author' => 'Author',
            'title' => 'Title',
            'totalPages' => 123,
        );

        $book = new Book($params);

        $this->book = $book;
    }

    public function testRequiredAttributesShouldBeSetInConstructor() {
        $paramsWithoutAuthor = array();
        $paramsWithoutTitle = array(
            'author' => 'Author',
        );
        $paramsWithoutTotalPages = array(
            'author' => 'Author',
            'title' => 'Title',
        );
        $paramsCorrect = array(
            'author' => 'Author',
            'title' => 'Title',
            'totalPages' => 123,
        );

        try {
            $book = new Book($paramsWithoutAuthor);
            $this->fail('Expected exception on empty Author param');
        } catch (BookException $e) {
            $this->assertEquals('Author must be set', $e->getMessage());
        }

        try {
            $book = new Book($paramsWithoutTitle);
            $this->fail('Expected exception on empty Title param');
        } catch (BookException $e) {
            $this->assertEquals('Title must be set', $e->getMessage());
        }

        try {
            $book = new Book($paramsWithoutTotalPages);
            $this->fail('Expected exception on empty TotalPages param');
        } catch (BookException $e) {
            $this->assertEquals('Total pages must be set', $e->getMessage());
        }

        try {
            $book = new Book($paramsCorrect);
        } catch (BookException $e) {
            $this->fail('BookException not expected');
        }
    }

    public function testAdditionalAttributesCanBeSetFromConstructor() {
        $history = array(10, 13, 27, null);

        $params = array(
            'author' => 'Author',
            'title' => 'Title',
            'totalPages' => 123,
            'history' => $history,
        );

        $book = new Book($params);

        $this->assertEquals($history, $book->getHistory());
        $this->assertEquals(true, $book->isOpened());
    }

    public function testBookCanBeOpened() {
        $book = $this->book;

        $this->assertEquals(false, $book->isOpened());
        $book->open();
        $this->assertEquals(true, $book->isOpened());
    }

    public function testBookCantBeOpenedTwice() {
        $this->setExpectedException('BookException', 'Book is opened already');

        $book = $this->book;

        $book->open();
        $book->open();
    }

    public function testClosedBookCantBeClosedAgain() {
        $this->setExpectedException('BookException', 'Book is closed already');

        $currentPage = 10;

        $book = $this->book;

        $book->close($currentPage);
    }

    public function testBookParametersCanBeGet() {
        $author = 'Book Author';
        $title = 'Some title';
        $totalPages = 500;

        $params = array(
            'author' => $author,
            'title' => $title,
            'totalPages' => $totalPages,
        );

        $book = new Book($params);

        $this->assertEquals($author, $book->getAuthor());
        $this->assertEquals($title, $book->getTitle());
        $this->assertEquals($totalPages, $book->getTotalPages());
    }


    public function testBookShouldLogOpenCloseHistory() {
        $book = $this->book;

        $book->open();
        $book->close(15);
        $book->open();
        $book->close(23);
        $book->open();
        $expectedHistory = array(15, 23, null);

        $this->assertEquals($expectedHistory, $book->getHistory());
    }
}
