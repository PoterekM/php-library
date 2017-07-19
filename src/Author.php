<?php

    class Author
    {
        private $author_name;
        private $id;

        function __construct($author_name, $id = null)
        {
            $this->author_name = $author_name;
            $this->id = $id;
        }

        function getAuthorName()
        {
            return $this->author_name;
        }

        function setAuthorName($new_author_name)
        {
            $this->author_name = (string) $new_author_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO authors (author_name) VALUES ('{$this->getAuthorName()}');");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        static function getAll()
        {
           $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
           $authors = array();
           foreach($returned_authors as $author) {
               $author_name = $author['author_name'];
               $id = $author['id'];
               $new_author = new Author($author_name, $id);
               array_push($authors, $new_author);
           }
           return $authors;
        }

        static function deleteAll()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM authors;");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        static function find($search_id)
        {
            $returned_authors = $GLOBALS['DB']->prepare("SELECT * FROM authors WHERE id = :id");
            $returned_authors->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_authors->execute();
            foreach ($returned_authors as $author) {
              $author_name = $author['author_name'];
              $id = $author['id'];
              if ($id == $search_id) {
                  $found_author = new Author($author_name, $id);
              }
            }
            return $found_author;
        }

        function update($new_author_name)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE authors SET author_name = '{$new_author_name}' WHERE id = {$this->getId()};");
            if ($executed) {
             $this->setAuthorName($new_author_name);
             return true;
            } else {
             return false;
            }
        }

    }
 ?>
