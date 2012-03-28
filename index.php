<?php
require_once('header.php');

use WebChess\Model\ChessGame;
use WebChess\Model\ChessGameHistory;
use WebChess\Model\Player\Human;

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
    <link rel="stylesheet" href="js/jquery/css/humanity/jquery-ui-1.8.18.custom.css" type="text/css">

    <script type="text/javascript" src="js/jquery/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="js/jquery/js/jquery-ui-1.8.18.custom.min.js"></script>
    <script type="text/javascript" src="js/chess.js"></script>
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