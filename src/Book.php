<?php

    class Book
    {
        private $book_title;
        private $id;

        function __construct($book_title, $id = null)
        {
            $this->book_title = $book_title;
            $this->id = $id;
        }

        function getBookTitle()
        {
            return $this->book_title;
        }

        function setBookTitle($new_book_title)
        {
            $this->book_title = (string) $new_book_title;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO books (book_title) VALUES ('{$this->getBookTitle()}');");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }
    }
 ?>
