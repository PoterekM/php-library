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
           $test_author = new Author($author_name);
           $test_author->save();

           $author_name_2 = "Wells";
           $test_author_2 = new Author($author_name_2);
           $test_author_2->save();

           //Act
           Author::deleteAll();
           $result = Author::getAll();
           //Assert
           $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $author_name = "Poe";
            $test_author = new Author($author_name);
            $test_author->save();

            $author_name_2 = "Wells";
            $test_author_2 = new Author($author_name_2);
            $test_author_2->save();
            //Act
            $result = Author::find($test_author->getId());
            //Assert
            $this->assertEquals($test_author, $result);
         }

        function testUpdate()
        {
            //Arrange
            $author_name = "Poe";
            $test_author = new Author($author_name);
            $test_author->save();
            $new_author_name = "Wells";
            //Act
            $test_author->update($new_author_name);
            //Assert
            $this->assertEquals("Wells", $test_author->getAuthorName());
            }

        function testDelete()
        {
            //Arrange
            $author_name = "Poe";
            $test_author = new Author($author_name);
            $test_author->save();

            $author_name_2 = "Wells";
            $test_author_2 = new Author($author_name_2);

            $test_author_2->save();
            //Act

            $test_author->delete();
            //Assert

            $this->assertEquals([$test_author_2], Author::getAll());
        }

        function testGetBooks()
        {
            //Arrange
            $author_name = "Poe";
            $id = null;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $book_title = "Raven";
            $id = null;
            $test_book = new Book($book_title, $id);
            $test_book->save();
            $book_title_2 = "Pooh";
            $id_2 = null;
            $test_book_2 = new Book($book_title_2, $id_2);
            $test_book_2->save();

            //Act
            $test_author->addBook($test_book);
            $test_author->addBook($test_book_2);
            //Assert

            $this->assertEquals($test_author->getBooks(), [$test_book, $test_book_2]);
        }

        function testAddBooks()
        {
            //Arrange
            $author_name = "Poe";
            $id = null;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $book_title = "Nathan";
            $id = null;
            $test_book = new Book($book_title, $id);
            $test_book->save();

            //Act

            $test_author->addBook($test_book);
            //Assert
            $this->assertEquals($test_author->getBooks(), [$test_book]);
        }



    }


?>
