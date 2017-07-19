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
            $executed = $GLOBALS['DB']->exec("INSERT INTO author (author_name) VALUES ('{$this->getAuthorName()}');");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }
    }
 ?>
