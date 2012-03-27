<?php

namespace WebChess\Model;

use WebChess\Model\Player;
use WebChess\Model\ChessBoard;
use WebChess\Model\ChessGameHistory;

/**
 * Description of ChessGame
 *
 * @author con
 * @copyright 23.03.2012 
 */
class ChessGame {

  const COLOR_WHITE    = 'white';
  const COLOR_BLACK    = 'black';
  
  const STATUS_CREATED = 10;
  const STATUS_STARTED = 20;
  const STATUS_ABORTED = 30;
  const STATUS_MATE    = 40;
  const STATUS_DRAW    = 50;
  
  /**
   * unique gameId
   * 
   * @var string
   */
  protected $id;
  
  /**
   * the currend round
   * 
   * @var int
   */
  protected $round;
  
  /**
   * the board this game is played on
   * 
   * @var ChessBoard
   */
  protected $board;
  
  /**
   * the current game status
   * 
   * @var string
   */
  protected $status;
  
  /**
   * array of players
   * 
   * @var array
   */
  protected $player = array();
  
  /**
   * the player who's turn is currently running
   * 
   * @var Player
   */
  protected $currentTurn;
  
  /**
   * the game's winner
   * 
   * @var Player
   */
  protected $winner;
  
  /**
   * list of history recordings -> every round
   * 
   * @var array
   */
  protected $historyRecordings = array();
  
  /**
   * the date of the creation of the game
   * 
   * @var DateTime
   */
  protected $createdAt;
  
  /**
   * the date of the last update of the game
   * 
   * @var DateTime
   */
  protected $updatedAt;
  
  /**
   * creates a game
   * 
   * @param array $player
   * @param ChessGameHistory $history (optional)
   */
  public function __construct(array $player, ChessGameHistory $history = null)
  {
    foreach($player as $player) {
      $this->addPlayer($player);
    }
    
  }
  
  /**
   * initialization logic for a new game 
   */
  protected function initNewGame()
  {
    
  }
  
  /**
   * add player to the game
   * 
   * @param Player $player 
   */
  public function addPlayer(Player $player)
  {
    $this->player[] = $player;
  } 
  
  /**
   * receive all players or one by passing a key
   * 
   * @param int $key (optional)
   * @return type
   * @throws \InvalidArgumentException 
   */
  public function getPlayer($key = null)
  {
    if($key == null) {
      return $this->player;
    }elseif(array_key_exists($key, $this->player)){
      return $this->player[$key];
    }else{
      throw new \InvalidArgumentException(sprintf('Unknown Player with key %s', $key));
    }
  }
  
  /**
   * receives an array with possible colors
   * 
   * @return array
   */
  public static function getColors()
  {
    return array(
      self::COLOR_WHITE,
      self::COLOR_BLACK
    );
  }
  
}

