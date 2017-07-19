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
        protected function tearDown()
               {
                 Author::deleteAll();
                 Book::deleteAll();
               }

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

       function testGetAll()
       {
            //Arrange
            $author_name = "Poe";
            $test_author = new Author($author_name);
            $test_author->save();

            $author_name_2 = "Wells";
            $test_author_2 = new Author($author_name_2);
            $test_author_2->save();
            //Act
            $result = Author::getAll();
            //Assert
            $this->assertEquals([$test_author, $test_author_2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
           $author_name = "Poe";
           $test_course = new Author($author_name);
           $test_course->save();

           $author_name_2 = "Wells";
           $test_course_2 = new Author($author_name_2);
           $test_course_2->save();

           //Act
           Author::deleteAll();
           $result = Author::getAll();
           //Assert
           $this->assertEquals([], $result);
        }
    }


?>
