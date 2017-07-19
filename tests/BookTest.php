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
        protected function tearDown()
               {
                 Author::deleteAll();
                 Book::deleteAll();
               }

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

       function testGetAll()
       {
         //Arrange
         $book_title = "Raven";
         $test_book = new Book($book_title);
         $test_book->save();

         $book_title_2 = "Well";
         $test_book_2 = new Book($book_title_2);
         $test_book_2->save();
         //Act
         $result = Book::getAll();
         //Assert
         $this->assertEquals([$test_book, $test_book_2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
           $book_title = "Raven";
           $test_title = new Book($book_title);
           $test_title->save();

           $book_title_2 = "Well";
           $test_title_2 = new Book($book_title_2);
           $test_title_2->save();

           //Act
           Book::deleteAll();
           $result = Book::getAll();
           //Assert
           $this->assertEquals([], $result);
        }

        function testFind()
        {
          //Arrange
          $book_title = "Raven";
          $test_title = new Book($book_title);
          $test_title->save();

          $book_title_2 = "Pooh";
          $test_title_2 = new Book($book_title_2);
          $test_title_2->save();
          //Act
          $result = Book::find($test_title->getId());
          //Assert
          $this->assertEquals($test_title, $result);
         }

        function testUpdate()
        {
          //Arrange
          $book_title = "Raven";
          $test_title = new Book($book_title);
          $test_title->save();
          $new_book_title = "Pooh";
          //Act
          $test_title->update($new_book_title);
          //Assert
          $this->assertEquals("Pooh", $test_title->getBookTitle());
        }

        function testDelete()
        {
        //Arrange
        $book_title = "Raven";
        $test_title = new Book($book_title);
        $test_title->save();

        $book_title_2 = "Pooh";
        $test_title_2 = new Book($book_title_2);

        $test_title_2->save();
        //Act

        $test_title->delete();
        //Assert

        $this->assertEquals([$test_title_2], Book::getAll());
        }

        function testGetAuthors()
        {
            //Arrange
            $book_title = "Raven";
            $id = null;
            $test_book = new Book($book_title, $id);
            $test_book->save();

            $author_name = "Poe";
            $id = null;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $author_name_2 = "Wells";
            $id_2 = null;
            $test_author_2 = new Author($author_name_2, $id_2);
            $test_author_2->save();

            //Act
            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author_2);
            //Assert

            $this->assertEquals($test_book->getAuthors(), [$test_author, $test_author_2]);
        }

        function testAddAuthor()
        {
            //Arrange
            $book_title = "Pooh";
            $id = null;
            $test_book = new Book($book_title, $id);
            $test_book->save();

            $author_name = "Poe";
            $id = null;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            //Act
            $test_book->addAuthor($test_author);
            //Assert
            $this->assertEquals($test_book->getAuthors(), [$test_author]);
        }

    }
?>
