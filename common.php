<?php

// These variables define the connection information for your MySQL database
require_once "connect.php";

// By passing the following $options array to the database connection code we
// are telling the MySQL server that we want to communicate with it using UTF-8
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

try
{
    $db = new PDO("mysql:host={$host};dbname={$database};charset=utf8", $user, $pw, $options);
}
catch(PDOException $ex)
{
    // If an error occurs while opening a connection to your database, it will
    // be trapped here.
    die("Failed to connect to the database: " . $ex->getMessage());
}

// This statement configures PDO to throw an exception when it encounters
// an error.  This allows us to use try/catch blocks to trap database errors.
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// This statement configures PDO to return database rows from your database using an associative array.
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

// This block of code is used to undo magic quotes.  Older installations
// of PHP may still have magic quotes enabled and this code is necessary to
// prevent them from causing problems.
if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
{
    function undo_magic_quotes_gpc(&$array)
    {
        foreach($array as &$value)
        {
            if(is_array($value))
            {
                undo_magic_quotes_gpc($value);
            }
            else
            {
                $value = stripslashes($value);
            }
        }
    }

    undo_magic_quotes_gpc($_POST);
    undo_magic_quotes_gpc($_GET);
    undo_magic_quotes_gpc($_COOKIE);
}

// This tells the web browser that your content is encoded using UTF-8
// and that it should submit content back to you using UTF-8
header('Content-Type: text/html; charset=utf-8');

// This initializes a session.
if(!isset($_SESSION)) {
    session_start();
}