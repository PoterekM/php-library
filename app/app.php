<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Book.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    // use Symfony\Component\Debug\Debug;
    //     Debug::enable();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' =>__DIR__.'/../views'
    ));
    //  $app['debug'] = true;

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('authors' => Author::getAll(), 'books' => Book::getAll()));
    });

    $app->get("/authors", function() use ($app) {
        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });

    $app->post("/authors", function() use ($app) {
        $author_name = $_POST['author_name'];
        $new_author = new Author($author_name, $id = null);
        $new_author->save();
        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));

    });

    $app->get("/authors/{id}", function($id) use ($app) {
       $author = Author::find($id);
       return $app['twig']->render('author.html.twig', array('author' => $author, 'books' => $author->getBooks(), 'all_books' => Book::getAll()));
   });

   $app->post("/add_authors", function() use ($app) {
        $book = Book::find($_POST['book_id']);
        $author = Author::find($_POST['author_id']);
        $book->addAuthor($author);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'books' => Book::getAll(), 'authors' => $book->getAuthors(), 'all_authors' => Author::getAll()));
    });

    $app->post("/add_books", function() use ($app) {
       $author = Author::find($_POST['author_id']);
       $book = Book::find($_POST['book_id']);
       $author->addBook($book);
       return $app['twig']->render('author.html.twig', array('author' => $author, 'authors' => Author::getAll(), 'books' => $author->getBooks(), 'all_books' => Book::getAll()));
    });

    $app->get("/books", function() use ($app) {
       return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->get("/books/{id}", function($id) use ($app) {
       $book = Book::find($id);
       return $app['twig']->render('book.html.twig', array('book' => $book, 'authors' => $book->getAuthors(), "all_authors" => Author::getAll()));
    });

    $app->post("/books", function() use ($app) {
       $book = new Book($_POST['title']);
       $book->save();
       return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->get("/books/{id}/edit", function($id) use ($app) {
       $book = Book::find($id);
       return $app['twig']->render('book_edit.html.twig', array('book' => $book));
    });

    $app->patch("/books/{id}", function($id) use ($app) {
        $title = $_POST['title'];
        $book = Book::find($id);
        $book->update($title);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'authors' => $book->getAuthors()));
    });

    $app->delete("/books/{id}", function($id) use ($app) {
        $book = Book::find($id);
        $book->delete();
        return $app['twig']->render('index.html.twig', array('books' => Book::getAll()));
    });

    $app->post("/delete_books", function() use ($app) {
     Book::deleteAll();
     return $app['twig']->render('index.html.twig');
   });

    $app->post("/delete_authors", function() use ($app) {
      Author::deleteAll();
      return $app['twig']->render('index.html.twig');
    });

    $app->get("/search_author", function() use ($app) {
        $authors = Author::getAll();
        $author_search = array();

        if(empty($author_search) == true) {
            foreach ($authors as $author) {
                if ($author->getAuthorName() == $_GET['author_search']) {
                    array_push($author_search, $author);
                }
            }
        }
        return $app['twig']->render('search_author.html.twig', array('author' => $author_search));
    });

      return $app;
?>
