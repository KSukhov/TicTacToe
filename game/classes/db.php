<?php
/**
 * Created by PhpStorm.
 * User: geol
 * Date: 6/14/15
 * Time: 4:02 AM
 */


class DB {
    private $db;
    function __construct(){
        $dsn = "sqlite:tic.db";
        $option = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $this->db =new PDO($dsn,'','', $option);

        $sql = "CREATE TABLE IF NOT EXISTS games
                    (
                            id INTEGER PRIMARY KEY,
                           game TEXT
                            )";
        $this->db->query($sql);
    }
    function saveGame($game, $id){
        if(!empty($id)){
            $sql = "UPDATE games SET game = '".$game."' WHERE id = ".$id;
        } else {
            $sql = "INSERT INTO games (game) VALUES('" . $game . "')";
        }
        try {
            $this->db->query($sql);
            $number = (!empty($id))?$id:$this->db->lastInsertId();
            print "Игра сохранена под номером ".$number."\n";
        } catch (PDOException $e) {
            print "Не удалось сохранить игру: " . $e->getMessage()."\n";
        }
    }
    function openGame($id){
        $sql = "SELECT game FROM games WHERE id = ".$id;
        $game = $this->db->query($sql)->fetchAll();
	// var_dump($game);
        if(isset($game[0]['game']))
            return $game[0]['game'];
        return null;

    }
}

