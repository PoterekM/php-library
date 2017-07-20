<?php

    class Copies
    {
        private $copy;
        private $id;

        function __construct($copy, $id = null)
        {
            $this->copy = $copy;
            $this->id = $id;
        }

        function getCopy()
        {
            return $this->copy;
        }

        function setCopy($new_copy)
        {
            $this->copy = $new_copy;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO copies (copy) VALUES ('{$this->getCopy()}');");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }

        }

        static function getAll()
        {
           $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies;");
           $copies = array();
           foreach($returned_copies as $copy) {
               $copy_name = $copy['copy'];
               $id = $copy['id'];
               $new_copy = new Copies($copy_name, $id);
               array_push($copies, $new_copy);
           }
           return $copies;
        }

        static function deleteAll()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM copies;");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        static function find($search_id)
        {
            $returned_copies = $GLOBALS['DB']->prepare("SELECT * FROM copies WHERE id = :id");
            $returned_copies->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_copies->execute();
            foreach ($returned_copies as $copy) {
              $copy_name = $copy['copy'];
              $id = $copy['id'];
              if ($id == $search_id) {
                  $found_copy = new Copies($copy_name, $id);
              }
            }
            return $found_copy;
        }

        function update($new_copy)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE copies SET copy = '{$new_copy}' WHERE id = {$this->getId()};");
            if ($executed) {
             $this->setCopy($new_copy);
             return true;
            } else {
             return false;
            }
        }

        function delete()
        {
          $executed = $GLOBALS['DB']->exec("DELETE FROM copies WHERE id = {$this->getId()};");
          if (!$executed) {
              return false;
          }
          $executed = $GLOBALS['DB']->exec("DELETE FROM books_copies WHERE copy_id = {$this->getId()};");
          if (!$executed) {
              return false;
          } else {
              return true;
          }
        }

        function getBooks()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT books.* FROM copies
            JOIN books_copies ON (books_copies.copy_id = copies.id)
            JOIN books ON (books.id = books_copies.book_id)
            WHERE copies.id = {$this->getId()};");
            $books = array();
            foreach ($returned_books as $book) {
                $book_title = $book['book_title'];
                $id = $book['id'];
                $new_book = new Book($book_title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        function addBook($book)
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO books_copies (copy_id, book_id) VALUES ({$this->getId()}, {$book->getId()});");
            if ($executed) {
            return true;
            } else {
            return false;
            }
        }


    }
 ?>
