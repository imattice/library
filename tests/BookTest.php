<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase {

        protected function tearDown() {
            Book::deleteAll();
        }

        function test_save() {
            //Arrange
            $author = "Dr. Seuss";
            $title = "The Cat in the Hat";
            $test_book = new Book($author, $title);

            //Act
            $test_book->save();

            //Assert
            $result = Book::getAll();
            $this->assertEquals($test_book, $result[0]);
        }

        function test_getAll() {
            //Arrange
            $author = "Dr. Seuss";
            $title = "The Cat in the Hat";
            $test_book = new Book($author, $title);
            $test_book->save();
            $author2 = "Stephen King";
            $due_date2 = "Misery";
            $test_book2 = new Book($author2, $due_date2);
            $test_book2->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function test_deleteAll() {
            //Arrange
            $author = "Dr. Seuss";
            $title = "The Cat in the Hat";
            $test_book = new Book($author, $title);
            $test_book->save();
            $author2 = "Stephen King";
            $due_date2 = "Misery";
            $test_book2 = new Book($author2, $due_date2);
            $test_book2->save();

            //Act
            Book::deleteAll();

            //Assert
            $result = Book::getAll();
            $this->assertEquals([], $result);
        }

        function test_getId() {
            //Arrange
            $author = "Dr. Seuss";
            $title = "The Cat in the Hat";
            $test_book = new Book($author, $title);
            $test_book->save();

            //Act
            $result = $test_book->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_find() {
            //Arrange
            $author = "Dr. Seuss";
            $title = "The Cat in the Hat";
            $test_book = new Book($author, $title);
            $test_book->save();
            $author2 = "Stephen King";
            $due_date2 = "Misery";
            $test_book2 = new Book($author2, $due_date2);
            $test_book2->save();

            //Act
            $id = $test_book->getId();
            $result = Book::find($id);

            //Assert
            $this->assertEquals($test_book, $result);
        }

        function testUpdateAuthor() {
            //Arrange
            $author = "Dr. Seuss";
            $title = "The Cat in the Hat";
            $test_book = new Book($author, $title);
            $test_book->save();
            $new_author = "Theodore Geissel";

            //Act
            $test_book->updateAuthor($new_author);

            //Assert
            $this->assertEquals("Theodore Geissel", $test_book->getAuthor());
        }

        function testUpdateTitle() {
            //Arrange
            $author = "Dr. Seuss";
            $title = "The Cat in the Hat";
            $test_book = new Book($author, $title);
            $test_book->save();
            $new_title = "Green Eggs and Ham";

            //Act
            $test_book->updateTitle($new_title);

            //Assert
            $this->assertEquals("Green Eggs and Ham", $test_book->getTitle());
        }

        function testDeleteOne() {
            //Arrange
            $author = "Dr. Seuss";
            $title = "The Cat in the Hat";
            $test_book = new Book($author, $title);
            $test_book->save();
            $author2 = "Stephen King";
            $due_date2 = "Misery";
            $test_book2 = new Book($author2, $due_date2);
            $test_book2->save();

            //Act
            $test_book->deleteOne();
            $result = Book::getAll();

            //Assert
            $this->assertEquals($test_book2, $result[0]);
        }
    }
?>
