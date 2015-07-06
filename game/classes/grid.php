<?php
/**
 * Created by PhpStorm.
 * User: ksukhov
 * Date: 03.07.15
 * Time: 13:14
 */

class Grid {
    /**
     * @var int ширина поля
     */
    public $gridWidth;
    /**
     * @var int высота поля
     */
    public $gridHeight;
    /**
     * @var array марркеры
     */
    private $markers = array('X','0','*','#','@');

    /**
     * @param $width ширина поля
     * @param $height высота поля
     */
    function __construct($width, $height){
        $this->gridWidth = $width;
        $this->gridHeight = $height;
    }

    /**
     * выводит в консоль игровое поле
     * с установленными камням.
     *
     * @param array $users
     */
    function drawGrid(array $users){
        system('clear');
        print " ";

        for($j=0;$j < $this->gridWidth; $j++) {
            print "|";
            print $j + 1;
        }
        print "|\n";
        for($i=0;$i < $this->gridHeight; $i++){
            print $i + 1;
            for($j=0;$j < $this->gridWidth; $j++) {
                print "|".$this->checkSite($j,$i, $users);
            }
            print "|\n";
        }
    }

    /**
     * Проверяет, есть-ли на поле камень, в зависимости от
     * результата проверки возвращает маркер ипи пробел.
     *
     * @param $x
     * @param $y
     * @param $stones
     * @return string
     */
    function checkSite($x,$y, $users) //TODO переделать
    {
        for($i = 0; $i < count($users); $i++) {
		//  var_dump($users[$i]->stones);
            if (in_array(array($x + 1, $y + 1), $users[$i]->stones)) {
                return $this->markers[$i];	
            }
        }
        return ' ';
    }
}
