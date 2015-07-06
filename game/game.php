<?php
/**
 * Created by PhpStorm.
 * User: geol
 * Date: 6/14/15
 * Time: 4:11 AM
 */
error_reporting(E_ALL);
ini_set('display_errors', true);
set_include_path('classes/');
spl_autoload_register();

$users = array('firstGamer', 'secondGamer');
$db = new DB();
$id = !empty($argv[1])?(int)$argv[1]:null;

$game = new TicTacToe($db, $users, $id);
while(1){
    print '>>';
    $input = str_replace("\n", "", fgets(STDIN));
    if($input) {
        if($input == 'stop') {
            exit();
        } elseif ($input == 'save') {
            $game->saveGame();;
        } else {
            $stones = explode(" ", $input);
            $game->addStone((int)$stones[0], (int)$stones[1]);
        }

    }
}
