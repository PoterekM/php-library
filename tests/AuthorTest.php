<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Author.php";
    require_once "src/Book.php";
    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        // protected function tearDown()
        //        {
        //          Author:deleteAll();
        //          Student::deleteAll();
        //        }

        function testGetAuthorName()
       {
           //Arrange
           $author_name = "Poe";
           $test_author = new Author($author_name);
           //Act
           $result = $test_author->getAuthorName();
           //Assert
           $this->assertEquals($author_name, $result);
       }

        function testGetId()
       {
           //Arrange
           $author_name = "Poe";
           $test_author = new Author($author_name);
           $test_author->save();
           //Act
           $result = $test_author->getId();
           //Assert
           $this->assertEquals(true, is_numeric($result));
       }


       function testSave()
       {
           //Arrange
           $author_name = "Poe";
           $test_author = new Author($author_name);
           //Act
           $executed = $test_author->save();
           //Assert
           $this->assertTrue($executed, "Theres no author in database!!!!");
       }
    }


?>
