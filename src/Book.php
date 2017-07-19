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

        static function getAll()
        {
           $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
           $books = array();
           foreach($returned_books as $book) {
               $book_name = $book['book_title'];
               $id = $book['id'];
               $new_book = new Book($book_name, $id);
               array_push($books, $new_book);
           }
           return $books;
        }

        static function deleteAll()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM books;");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        static function find($search_id)
        {
            $returned_books = $GLOBALS['DB']->prepare("SELECT * FROM books WHERE id = :id");
            $returned_books->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_books->execute();
            foreach ($returned_books as $book) {
              $book_title = $book['book_title'];
              $id = $book['id'];
              if ($id == $search_id) {
                  $found_book = new Book($book_title, $id);
              }
            }
            return $found_book;
        }

        function update($new_book_title)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE books SET book_title = '{$new_book_title}' WHERE id = {$this->getId()};");
            if ($executed) {
             $this->setBookTitle($new_book_title);
             return true;
            } else {
             return false;
            }
        }

        function delete()
      {
          $executed = $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
          if (!$executed) {
              return false;
          }
          $executed = $GLOBALS['DB']->exec("DELETE FROM authors_books WHERE book_id = {$this->getId()};");
          if (!$executed) {
              return false;
          } else {
              return true;
          }
      }


    }
 ?>
