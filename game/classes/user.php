<?php
/**
 * Created by PhpStorm.
 * User: ksukhov
 * Date: 03.07.15
 * Time: 17:22
 */

class User {
    public $stones = array();
    public $name;

    /**
     * @param $name имя игрока
     */
    function __construct($name){
        $this->name = $name;
    }

    /**
     * прорверяем, не достигнута ли этим ходом "победная" линия
     * @param array $stone
     * @param int $lenght
     * @return bool
     */
    function isLine($stone, $lenght)
    {
        $line = 1;
       for($i = 1; in_array(array($stone[0], $stone[1]+$i), $this->stones); $i++){
           $line ++ ;
       }
        for($i = 1; in_array(array($stone[0], $stone[1]-$i), $this->stones); $i++){
            $line ++ ;
        }
        if($line == $lenght) //по пвертикали
            return true;

        $line = 1;
        for($i = 1; in_array(array($stone[0]+$i, $stone[1]), $this->stones); $i++){
            $line ++ ;
        }
        for($i = 1; in_array(array($stone[0]-$i, $stone[1]), $this->stones); $i++){
            $line ++ ;
        }
        if($line == $lenght) //по горизонтали
            return true;

        $line = 1;
        for($i = 1; in_array(array($stone[0]+$i, $stone[1]+$i), $this->stones); $i++){
            $line ++ ; ;
        }
        for($i = 1; in_array(array($stone[0]-$i, $stone[1]-$i), $this->stones); $i++){
            $line ++ ;
        }
        if($line == $lenght)
            return true; // \

        $line = 1;
        for($i = 1; in_array(array($stone[0]+$i, $stone[1]-$i), $this->stones); $i++){
            $line ++ ;
        }
        for($i = 1; in_array(array($stone[0]-$i, $stone[1]+$i), $this->stones); $i++){
            $line ++ ;
        }
        if($line == $lenght) // /
            return true;

        return false;
    }
}
