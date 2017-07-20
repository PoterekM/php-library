<?php

    class Patron
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = (string)$new_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO patrons (name) VALUES ('{$this->getName()}');");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        static function getAll()
        {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons;");
            $patrons = array();
            foreach ($returned_patrons as $patron) {
                $patron_name = $patron['name'];
                $id = $patron['id'];
                $new_patron = new Patron($patron_name, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        static function deleteAll()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM patrons;");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        static function find($search_id)
        {
            $returned_patrons = $GLOBALS['DB']->prepare("SELECT * FROM patrons WHERE id = :id");
            $returned_patrons->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_patrons->execute();
            foreach ($returned_patrons as $patron) {
              $patron_name = $patron['name'];
              $id = $patron['id'];
              if ($id == $search_id) {
                 $found_patron = new Patron($patron_name, $id);
              }
            }
            return $found_patron;
        }

        function update($new_patron)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE patrons SET name = '{$new_patron}' WHERE id = {$this->getId()};");
            if ($executed) {
             $this->setName($new_patron);
             return true;
            } else {
             return false;
            }
        }

        function delete()
        {
          $executed = $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
          if (!$executed) {
              return false;
          }
          $executed = $GLOBALS['DB']->exec("DELETE FROM books_patrons WHERE patron_id = {$this->getId()};");
          if (!$executed) {
              return false;
          } else {
              return true;
          }
        }

        function getBooks()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT books.* FROM patrons
            JOIN books_patrons ON (books_patrons.patron_id = patrons.id)
            JOIN books ON (books.id = books_patrons.book_id)
            WHERE patrons.id = {$this->getId()};");
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
            $executed = $GLOBALS['DB']->exec("INSERT INTO books_patrons (patron_id, book_id) VALUES ({$this->getId()}, {$book->getId()});");
            if ($executed) {
            return true;
            } else {
            return false;
            }
        }





    }
 ?>
