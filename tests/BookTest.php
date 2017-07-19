<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Book.php";
    require_once "src/Author.php";
    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {
        // protected function tearDown()
        //        {
        //          Author:deleteAll();
        //          Student::deleteAll();
        //        }

        function testGetBookTitle()
       {
           //Arrange
           $book_title = "Raven";
           $test_book = new Book($book_title);
           //Act
           $result = $test_book->getBookTitle();
           //Assert
           $this->assertEquals($book_title, $result);
       }

        function testGetId()
       {
           //Arrange
           $book_title = "Raven";
           $test_book = new Book($book_title);
           $test_book->save();
           //Act
           $result = $test_book->getId();
           //Assert
           $this->assertEquals(true, is_numeric($result));
       }


       function testSave()
       {
           //Arrange
           $book_title = "Raven";
           $test_book = new Book($book_title);
           //Act
           $executed = $test_book->save();
           //Assert
           $this->assertTrue($executed, "Theres no book in database!!!!");
       }
    }


?>
