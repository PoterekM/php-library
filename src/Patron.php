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



    }
 ?>
