<?php
require_once('header.php');

use WebChess\Model\ChessGame;
use WebChess\Model\ChessGameHistory;
use WebChess\Model\Player\Human;

//$p1   = new Human('Sebastian', ChessGame::COLOR_WHITE);
//$p2   = new Human('Conrad', ChessGame::COLOR_BLACK);

//ChessGameHistory::deleteAllGames();

//$game = new ChessGame('spiel1', array($p1, $p2));

//$game->initNewGame();

//ChessGameHistory::deleteAllGames();
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
            
            <button id="newGame">New Game</button>
            <button id="loadGame">Load Game</button>
            
        </div>
        
        <div id="gameWrapper">
            <div id="gameBorder">
                <div id="board">
                <?php
//                echo $game->getBoard()->render();
                ?>
                </div>
                <?php // echo $game->getBoard()->renderAllBorders() ?>
            </div>           
        </div>
            
            
        
    </div>
    
    <div id="loadGameDialog">
        <?php
            $games = ChessGameHistory::getGames();
            if(empty($games)):
        ?>
        <h2>No Games avaiable</h2>
        <?php else: ?>
        <form>
            <label for="selectGame">Select Game: </label>
            <select name="gameId" id="selectGame">
                <option></option>
            <?php foreach($games as $game): ?>
                <option value="<?php echo $game ?>"><?php echo $game ?></option>
            <?php endforeach ?>
            </select>
            <input type="hidden" name="action" value="load" />
        </form>
        <?php endif; ?>
    </div>
    <div id="newGameDialog">
        <p class="validateTips">All form fields are required.</p>

        <form>
        <fieldset>
            <p>
                <label for="player1">Player 1</label>
                <input type="text" name="player1" id="player1" class="" />
            </p>
            <p>
                <label for="player2">Player 2</label>
                <input type="text" name="player2" id="player2" class="" />
            </p>
            <p>
                <label for="gameId">Game Name</label>
                <input type="text" name="gameId" id="gameId" class="" />
            </p>
            <input type="hidden" name="action" value="create" />
            <?php /*
            <p>
            <?php for($i = 0; $i < 10; $i++): ?>
                <label for="radio<?php echo $i ?>">Radio <?php echo $i ?></label>
                <input type="radio" name="radiotest" id="radio<?php echo $i ?>" /><br />
            <?php endfor ?>
            </p>
             */ ?>
        </fieldset>
        </form>
    </div>
</body>
</html>

<?php 
//    print_r($_SESSION);
?>