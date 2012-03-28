<?php
session_start();

use WebChess\Model\ChessGame;
use WebChess\Model\ChessGameHistory;
use WebChess\Model\Player\Human;

spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register();

$p1   = new Human('Sebastian', ChessGame::COLOR_WHITE);
$p2   = new Human('Conrad', ChessGame::COLOR_BLACK);

//ChessGameHistory::deleteAllGames();

$game = new ChessGame('spiel1', array($p1, $p2));

//$game->initNewGame();

//ChessGameHistory::deleteGame($game);
//ChessGameHistory::save($game);

//$gameFromSession = $history->getGame($game->getId());
//print_r($game->getBoard()->getGameData());

?>
<!DOCTYPE html>
<html>
<head>
    <title>WebChess</title>
    <link rel="stylesheet" href="styles/boardStyles.css" type="text/css">
    
</head>
<body>
    
    <div id="globalWrapper">
        
        <div id="header">
            <h1>WebChess</h1>
        </div>
        
        <div id="gameWrapper">
            <div id="gameBorder">
                <div id="board">
                <?php
                echo $game->getBoard()->render();
                ?>
                </div>
                <?php echo $game->getBoard()->renderAllBorders() ?>
            </div>           
        </div>
            
            
        
    </div>
    
</body>
</html>

<?php 
//    print_r($_SESSION);
?>