use se_factory;

CREATE TABLE authors (
	id INT auto_increment PRIMARY KEY,
	name VARCHAR(255)
	);
 
-- DROP TABLE books;    
CREATE TABLE books (
	id INT auto_increment PRIMARY KEY,
    title VARCHAR(255),
    author_id INT,
    foreign key (author_id) REFERENCES authors(id),
    year YEAR
    );
    
INSERT INTO authors (name) VALUES
('dummy author1'),
('dummy author2')
;

INSERT INTO books (title, author_id, year) VALUES
('dummy book1', 1, 2000),
('dummy book2', 2, 2001)
;

-- SELECT * FROM books