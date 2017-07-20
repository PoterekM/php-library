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
   }
?>
