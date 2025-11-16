<?php

// 1-connecting

$mysqli = new mysqli("localhost", "root", "****", "se_factory");

if ($mysqli->connect_error) {
    die("connection error" . $mysqli->connection_error);
}

echo "1- Connection Successfull<br><br>";


// 2- inserting rows
// -----------------------------NOTE for future improvement: use loops

$statement = $mysqli->prepare("INSERT INTO authors(name) VALUES(?)");

// $id_author = 3;
$name_author = "J.K. Rowling";
$statement->bind_param("s", $name_author);
$statement->execute();

// $id_author = 4;
$name_author = "Agatha Christie";
$statement->bind_param("s", $name_author);
$statement->execute();

// $id_author = 5;
$name_author = "Stephen King";
$statement->bind_param("s", $name_author);
$statement->execute();
echo "2.1- Inserting authors Successfull.<br><br>";

$statement = $mysqli->prepare("INSERT INTO books (title, author_id, year) VALUES (?, ?, ?)");

$title = "Harry Potter";
$author_id = 3;
$year = 1997;
$statement->bind_param("sii", $title, $author_id, $year);
$statement->execute();

$title = "The Casual Vacancy";
$author_id = 3;
$year = 2012;
$statement->bind_param("sii", $title, $author_id, $year);
$statement->execute();

$title = "The Christmas Pig";
$author_id = 3;
$year = 2021;
$statement->bind_param("sii", $title, $author_id, $year);
$statement->execute();

$title = "Death on the Nile";
$author_id = 4;
$year = 1937;
$statement->bind_param("sii", $title, $author_id, $year);
$statement->execute();

$title = "The Shining";
$author_id = 5;
$year = 1977;
$statement->bind_param("sii", $title, $author_id, $year);
$statement->execute();
echo "2.2- Inserting books Successfull.<br><br>";


// 3-fetching books with Join
echo "3- Fetching books from books_table joined on authors.name:<br><br>";
$result = $mysqli->query("
    SELECT books.title, authors.name AS author, books.year
    FROM books
    JOIN authors ON books.author_id = authors.id
");

$row = $result->fetch_assoc();
while ($row) {
    echo "Book: {$row['title']} | Author: {$row['author']} | Year: {$row['year']}<br>";
    $row = $result->fetch_assoc();
}
echo "<br>";

// 4-updating book title
$statement = $mysqli->prepare("UPDATE books SET title = ? WHERE id = ?");

$updated_title = "Dummy row to be deleted";
$book_id = 1;
$statement->bind_param("si", $updated_title, $book_id);
$statement->execute();

$updated_title = "Dummy row to be deleted";
$book_id = 2;
$statement->bind_param("si", $updated_title, $book_id);
$statement->execute();

// printing results after update:
echo "<br>4- Successfully updated titles of books to be deleted: <br><br>";
$result = $mysqli->query("
    SELECT books.title, authors.name AS author, books.year
    FROM books
    JOIN authors ON books.author_id = authors.id
");

$row = $result->fetch_assoc();
while ($row) {
    echo "Book: {$row['title']} | Author: {$row['author']} | Year: {$row['year']}<br>";
    $row = $result->fetch_assoc();
}
echo "<br>";


// 5-deleting books:

$statement = $mysqli->prepare("DELETE FROM books WHERE id=?");

$book_id = 1;
$statement->bind_param("i", $book_id);
$statement->execute();

$book_id = 2;
$statement->bind_param("i", $book_id);
$statement->execute();
echo "5- Deleting of dummy books successfull!<br><br>";


// 6-fetching authors | book count:

$result = $mysqli->query("
    SELECT authors.name AS author, COUNT(books.id) AS book_count
    FROM authors
    LEFT JOIN books ON authors.id = books.author_id
    GROUP BY author
");

echo "6- Fetching authors | book count:<br><br>";
$row = $result->fetch_assoc();
while ($row) {
    echo "Author: {$row['author']} | Books Written: {$row['book_count']}<br>";
    $row = $result->fetch_assoc();
}
echo "<br>";


// 7-fetching all books to specific author_id

$author_id = 3;
echo "7- Books by Author ID $author_id:<br><br>";

$statement = $mysqli->prepare("
    SELECT title FROM books
    WHERE author_id = ?
    ");
$statement->bind_param("i", $author_id);
$statement->execute();

$result = $statement->get_result();
$row = $result->fetch_assoc();
while ($row) {
    echo "-{$row['title']}<br>";
    $row = $result->fetch_assoc();
}

echo "<br>";

?>