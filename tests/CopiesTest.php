<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Book.php";
    require_once "src/Author.php";
    require_once "src/Patron.php";
    require_once "src/Copies.php";


    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CopiesTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
               {
                 Copies::deleteAll();
                 Author::deleteAll();
                 Book::deleteAll();
               }

        function testGetBookTitle()
       {
           //Arrange
           $copy = "1";
           $test_copy = new Copies($copy);
           //Act
           $result = $test_copy->getCopy();
           //Assert
           $this->assertEquals($copy, $result);
       }

        function testGetId()
       {
           //Arrange
           $copy = "Rad";
           $test_copy = new Copies($copy);
           $test_copy->save();
           //Act
           $result = $test_copy->getId();
           //Assert
           $this->assertEquals(true, is_numeric($result));
       }


       function testSave()
       {
           //Arrange
           $copy = "Rad";
           $test_copy = new Copies($copy);
           //Act
           $executed = $test_copy->save();
           //Assert
           $this->assertTrue($executed, "Theres no copy in database!!!!");
       }

       function testGetAll()
       {
         //Arrange
         $copy = "1";
         $test_copy = new Copies($copy);
         $test_copy->save();

         $copy_2 = "2";
         $test_copy_2 = new Copies($copy_2);
         $test_copy_2->save();
         //Act
         $result = Copies::getAll();
         //Assert
         $this->assertEquals([$test_copy, $test_copy_2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
           $copy = "1";
           $test_copy = new Copies($copy);
           $test_copy->save();

           $copy_2 = "2";
           $test_copy_2 = new Copies($copy_2);
           $test_copy_2->save();

           //Act
           Copies::deleteAll();
           $result = Copies::getAll();
           //Assert
           $this->assertEquals([], $result);
        }

        function testFind()
        {
          //Arrange
          $copy = "1";
          $test_copy = new Copies($copy);
          $test_copy->save();

          $copy_2 = "2";
          $test_copy_2 = new Copies($copy_2);
          $test_copy_2->save();
          //Act
          $result = Copies::find($test_copy->getId());
          //Assert
          $this->assertEquals($test_copy, $result);
         }

        function testUpdate()
        {
          //Arrange
          $copy = "1";
          $test_copy = new Copies($copy);
          $test_copy->save();
          $new_copy = "2";
          //Act
          $test_copy->update($new_copy);
          //Assert
          $this->assertEquals("2", $test_copy->getCopy());
        }

        function testDelete()
        {
        //Arrange
        $copy = "1";
        $test_copy = new Copies($copy);
        $test_copy->save();

        $copy_2 = "2";
        $test_copy_2 = new Copies($copy_2);

        $test_copy_2->save();
        //Act

        $test_copy->delete();
        //Assert

        $this->assertEquals([$test_copy_2], Copies::getAll());
        }

        function testGetBooks()
        {
            //Arrange
            $copy = "1";
            $id = null;
            $test_copy = new Copies($copy, $id);
            $test_copy->save();

            $book_title = "Raven";
            $id = null;
            $test_book = new Book($book_title, $id);
            $test_book->save();

            $book_title_2 = "Pooh";
            $id_2 = null;
            $test_book_2 = new Book($book_title_2, $id_2);
            $test_book_2->save();

            //Act
            $test_copy->addBook($test_book);
            $test_copy->addBook($test_book_2);
            //Assert

            $this->assertEquals($test_copy->getBooks(), [$test_book, $test_book_2]);
        }

        function testAddBook()
        {
            //Arrange
            $copy = "1";
            $id = null;
            $test_copy = new Copies($copy, $id);
            $test_copy->save();

            $book_title = "Raven";
            $id = null;
            $test_book = new Book($book_title, $id);
            $test_book->save();

            //Act
            $test_copy->addBook($test_book);
            //Assert
            $this->assertEquals($test_copy->getBooks(), [$test_book]);
        }

    }
?>
