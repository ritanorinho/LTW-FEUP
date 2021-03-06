PRAGMA foreign_keys = ON;
.mode columns
.headers on
.nullvalue NULL


DROP TABLE IF EXISTS User;

CREATE TABLE User (
    ID        INTEGER PRIMARY KEY AUTOINCREMENT,
    FirstName STRING NOT NULL,
    LastName  STRING NOT NULL,
    Username  STRING UNIQUE NOT NULL,
    Gender    STRING NOT NULL,
    Birthday  DATE NOT NULL,
    Country   STRING NOT NULL,
    Email     STRING UNIQUE NOT NULL,
    Password  CHAR (256) NOT NULL,  
    Photo     STRING DEFAULT "default.jpg",
    Points    INTEGER
    
);

DROP TABLE IF EXISTS Genre;

CREATE TABLE Genre (
    ID          INTEGER PRIMARY KEY AUTOINCREMENT,
    Name        STRING NOT NULL 
);

DROP TABLE IF EXISTS Director;

CREATE TABLE Director (
     ID          INTEGER  PRIMARY KEY AUTOINCREMENT,
     Name        STRING NOT NULL
);

DROP TABLE IF EXISTS Movie;

CREATE TABLE Movie (
    ID          INTEGER PRIMARY KEY AUTOINCREMENT,
    Name        STRING NOT NULL,
    ReleaseYear STRING NOT NULL,
    CoverPhoto  STRING DEFAULT "default.jpg",
    Description STRING NOT NULL
);

DROP TABLE IF EXISTS MovieGenre;

CREATE TABLE MovieGenre (
    GenreID    INTEGER REFERENCES Genre(ID) ON DELETE CASCADE,
    MovieID    INTEGER REFERENCES Movie(ID) ON DELETE CASCADE,
    PRIMARY KEY (GenreID, MovieID)

);

DROP TABLE IF EXISTS MovieDirector;

CREATE TABLE MovieDirector (
    DirectorID    INTEGER REFERENCES Director(ID) ON DELETE CASCADE,
    MovieID    INTEGER REFERENCES Movie(ID) ON DELETE CASCADE,
    PRIMARY KEY (DirectorID, MovieID)
);


DROP TABLE IF EXISTS Review;

CREATE TABLE Review (
    ID          INTEGER PRIMARY KEY AUTOINCREMENT,
    Title       STRING  NOT NULL,
    UserID      INTEGER REFERENCES User(ID) ON DELETE CASCADE,
    MovieID     INTEGER REFERENCES Movie(ID) ON DELETE CASCADE,
    ReviewDate  DATE NOT NULL,
    Description STRING NOT NULL
    
);

DROP TABLE IF EXISTS Comment;

CREATE TABLE Comment (
    ID          INTEGER PRIMARY KEY AUTOINCREMENT,
    UserID      INTEGER REFERENCES User(ID) ON DELETE CASCADE,
    CommentDate DATE NOT NULL,
    ReviewID    INTEGER REFERENCES Review(ID) ON DELETE CASCADE,
    Description STRING NOT NULL
    
);

DROP TABLE IF EXISTS LikeReview;
CREATE TABLE LikeReview(
    UserID INTEGER REFERENCES User(ID) ON DELETE CASCADE,
    ReviewID INTEGER REFERENCES Review(ID) ON DELETE CASCADE,
    PRIMARY KEY (UserID, ReviewID)

);
DROP TABLE IF EXISTS DisLikeReview;
CREATE TABLE DisLikeReview(
    UserID INTEGER REFERENCES User(ID) ON DELETE CASCADE,
    ReviewID INTEGER REFERENCES Review(ID) ON DELETE CASCADE,
    PRIMARY KEY (UserID, ReviewID)

);

DROP TABLE IF EXISTS LikeComment;
CREATE TABLE LikeComment(
    UserID INTEGER REFERENCES User(ID) ON DELETE CASCADE,
    CommentID INTEGER REFERENCES Comment(ID) ON DELETE CASCADE,
    PRIMARY KEY (UserID, CommentID)

);

DROP TABLE IF EXISTS DisLikeComment;
CREATE TABLE DisLikeComment(
    UserID INTEGER REFERENCES User(ID) ON DELETE CASCADE,
    CommentID INTEGER REFERENCES Comment(ID) ON DELETE CASCADE,
    PRIMARY KEY (UserID, CommentID)

);





.read data.sql
-- COMMIT TRANSACTION;



