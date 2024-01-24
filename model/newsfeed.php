<?php
//AUTHOR: Gitendrajeet RAMLOCHUND
//DATE: 31.07.2023
//SCOPE: Creating a Class NewsFeed for connection(PDO) with Database and PHP
require_once('database.php');

class newsfeed
{

    //Create Employee on tbl_employee
    public function createNews($title, $content, $image, $video_link, $isActive)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('INSERT INTO tbl_newsfeed ( title , content , image,video_link,isActive) VALUES( :title , :content , :image,:video_link,:isActive)');

        //call bind method in database class
        $database->bind(':title', $title);
        $database->bind(':content', $content);
        $database->bind(':image', $image);
        $database->bind(':video_link', $video_link);
        $database->bind(':isActive', $isActive);

        //execute prepared statement
        $database->execute();
    }


    //Create Employee on tbl_employee
    public function getActiveNews($database)
    {
        $database = new DBHandler();
        $database->query('SELECT * FROM tbl_newsfeed where isActive=1');
        return $row = $database->resultset();
    }

    //Create Employee on tbl_employee
    public function getAllNews($database)
    {
        $database = new DBHandler();
        $database->query('SELECT * FROM tbl_newsfeed');
        return $row = $database->resultset();
    }

    //Function to update Employee Details in Database
    public function updateNewsStatus($news_id, $isActive)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('UPDATE tbl_newsfeed SET isActive=:isActive WHERE news_id=:news_id');

        //call bind method in database class
        $database->bind(':news_id', $news_id);
        $database->bind(':isActive', $isActive);
        //execute prepared statement
        $database->execute();
    }

    //Function to update News Details in Database
    public function updateNews($news_id, $title, $content)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('UPDATE tbl_newsfeed SET title=:title , content=:content WHERE news_id=:news_id');

        //call bind method in database class
        $database->bind(':news_id', $news_id);
        $database->bind(':title', $title);
        $database->bind(':content', $content);
        //execute prepared statement
        $database->execute();
    }

    public function countAllNews($database)
    {
        $database = new DBHandler();
        $database->query('SELECT count(*) AS total FROM tbl_newsfeed');
        return $row = $database->resultset();
    }

    public function countNewsActive($database)
    {
        $database = new DBHandler();
        $database->query('SELECT count(*) AS total FROM tbl_newsfeed where isActive=1');
        return $row = $database->resultset();
    }

    public function countNewsArchive($database)
    {
        $database = new DBHandler();
        $database->query('SELECT count(*) AS total FROM tbl_newsfeed where isActive=0');
        return $row = $database->resultset();
    }
}
