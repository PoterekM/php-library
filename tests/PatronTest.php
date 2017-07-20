<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Book.php";
    require_once "src/Author.php";
    require_once "src/Patron.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
             Patron::deleteAll();
             Author::deleteAll();
             Book::deleteAll();
        }

        function testGetName()
        {
            $name = "Johnny";
            $test_name = new Patron($name);

            $result = $test_name->getName();

            $this->assertEquals($name, $result);
        }

        function testGetId()
       {
           //Arrange
           $name = "Betty";
           $test_name = new Patron($name);
           $test_name->save();
           //Act
           $result = $test_name->getId();
           //Assert
           $this->assertEquals(true, is_numeric($result));
       }

       function testSave()
       {
           //Arrange
           $name = "Goiji";
           $test_name = new Patron($name);
           //Act
           $executed = $test_name->save();
           //Assert
           $this->assertTrue($executed, "Theres no PATRON in database!!!!");
       }

       function testGetAll()
       {
            //Arrange
            $patron_name = "Poe";
            $test_name = new Patron($patron_name);
            $test_name->save();

            $patron_name_2 = "Wells";
            $test_name_2 = new Patron($patron_name_2);
            $test_name_2->save();
            //Act
            $result = Patron::getAll();
            //Assert
            $this->assertEquals([$test_name, $test_name_2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
           $patron_name = "Poe";
           $test_name = new Patron($patron_name);
           $test_name->save();

           $patron_name_2 = "Wells";
           $test_name_2 = new Patron($patron_name_2);
           $test_name_2->save();

           //Act
           Patron::deleteAll();
           $result = Patron::getAll();
           //Assert
           $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $patron_name = "Joe";
            $test_name = new Patron($patron_name);
            $test_name->save();

            $patron_name_2 = "Wlls";
            $test_name_2 = new Patron($patron_name_2);
            $test_name_2->save();
            //Act
            $result = Patron::find($test_name->getId());
            //Assert
            $this->assertEquals($test_name, $result);
        }

        function testUpdate()
        {
          //Arrange
          $patron_name = "Raven";
          $test_name = new Patron($patron_name);
          $test_name->save();
          $new_patron_name = "Pooh";
          //Act
          $test_name->update($new_patron_name);
          //Assert
          $this->assertEquals("Pooh", $test_name->getName());
        }

        function testDelete()
        {
        //Arrange
        $patron_name = "Raven";
        $test_name = new Patron($patron_name);
        $test_name->save();

        $patron_name_2 = "Pooh";
        $test_name_2 = new Patron($patron_name_2);

        $test_name_2->save();
        //Act

        $test_name->delete();
        //Assert

        $this->assertEquals([$test_name_2], Patron::getAll());
        }

        function testGetBooks()
        {
            //Arrange
            $patron_name = "Raven";
            $id = null;
            $test_name = new Patron($patron_name, $id);
            $test_name->save();

            $book_title = "Poe";
            $id = null;
            $test_book = new Book($book_title, $id);
            $test_book->save();

            $book_title_2 = "Wells";
            $id_2 = null;
            $test_book_2 = new Book($book_title_2, $id_2);
            $test_book_2->save();

            //Act
            $test_name->addBook($test_book);
            $test_name->addBook($test_book_2);
            //Assert

            $this->assertEquals($test_name->getBooks(), [$test_book, $test_book_2]);
        }

        function testAddBook()
        {
            //Arrange
            $patron_name = "Pooh";
            $id = null;
            $test_name = new Patron($patron_name, $id);
            $test_name->save();

            $book_title = "Poe";
            $id = null;
            $test_book = new Book($book_title, $id);
            $test_book->save();

            //Act
            $test_name->addBook($test_book);
            //Assert
            $this->assertEquals($test_name->getBooks(), [$test_book]);
        }


   }
?>
