<?php
/**
 * Created by PhpStorm.
 * User: geol
 * Date: 6/14/15
 * Time: 4:02 AM
 */

class TicTacToe {
    /**
     * @var array массив имен играков
     */
    private $users;
    /**
     * @var int дпрлинна "победной" линии
     */
    private $line;
    /**
     * @var int|null- идентификатор игры
     */
    private $id = null;
    /**
     * @var Grid игровое поле
     */
    private $grid;

    /**
     * @var PDO
     */
    private $db;

    /**
     * @param DB $db
     * @param int|null $id
     * @param int $width
     * @param int $height
     * @param int $line
     */
    function __construct(DB $db, array $users, $id = null, $width = 3, $height=3, $line = 3)
    {
       $this->db = $db;
        if(!empty($id)){
            $game = unserialize($this->db->openGame($id));
            if(!empty($game)) {
                $this->id = $id;
                $this->users= $game['users'];

     		$this->line=$game['game']['line'];
        	$this->grid = new Grid($game['game']['width'], $game['game']['height']);
            } else {
                print "Такой игры не обнаружено";
                exit();
            }
        } else {
            foreach($users as $user){
               $this->users[] = new User($user);
            }
     	    $this->line=$line;
            $this->grid = new Grid($width, $height);
        }
   
        $this->grid->drawGrid($this->users);	
        $u = $this->getCurrentGamer();
        print "\nХод ".$this->getCurrentGamer()->name."\n";
    }

    /**
     * добавляем камень на поле
     *
     * @param $x
     * @param $y
     */
    public function addStone($x, $y){
        $stone = array($x, $y);
        if(!$this->checkStone($stone))
            return 0;
        $user = $this->getCurrentGamer();
        $this->getCurrentGamer()->stones[] = array((int)$x, (int)$y);
        $this->grid->drawGrid($this->users);
        if($user->isline($stone, $this->line)){
            print "\n".$user->name." WIN!\n";
            exit();
        }
	
        print "\nХод ".$this->getCurrentGamer()->name."\n";
        return 1; // для тестов

    }

    /**
     * определяем текущего игрока
     *
     * @return User
     */
    private function getCurrentGamer(){
	    $curretCount = count($this->users[0]->stones);
 	    for($i =1; $i < count($this->users); $i++){
            if(count($this->users[$i]->stones) < $curretCount){
		        return $this->users[$i];
            }
        }
        return $this->users[0];
    }

    /**
     * проверка корректности координат камня
     *
     * @param array $stone
     * @return bool
     */
    function checkStone(array $stone)
    {
        if(empty($stone[0]) || empty($stone[1]) ) {
            print "Не коррерктные входные параметры\n";	
            return false;
        }
        if($stone[0] > $this->grid->gridWidth ||
            $stone[1] > $this->grid->gridHeight ||
            $stone[0]<=0 || $stone[1]<=0) {
              print "Нарушены пределы поля\n";
              return false;
        }
        foreach($this->users as $user) {
            if(in_array($stone, $user->stones) ) { 
                print "Занято!\n";
                return false;
            }
	    }
        return true;
    }

    /**
     * сохраняем игру
     */
    function saveGame(){
	$item = array(
		'users' => $this->users,
		'game'   => array(
			'width'  => $this->grid->gridWidth,
			'height' => $this->grid->gridHeight,
			'line'   => $this->line,
		),
	);
        $this->db->saveGame(serialize($item), $this->id);
    }


}
