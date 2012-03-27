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
  public function initNewGame()
  {
      $this->setCreatedAt(new \DateTime());
      $this->board = new ChessBoard($this);
//    $this->nextRound();
  
      
      $white = $this->getPlayer(0);
      
      $wPawn  = array();
      for($x=1; $x<=8; $x++)
      {
      $wPawn[] = $this->getBoard()->getField($x, 2);
      }
      
      $wKnight = array($this->getBoard()->getField(2, 1),$this->getBoard()->getField(7, 1));
      $wBishop = array($this->getBoard()->getField(3, 1), $this->getBoard()->getField(6, 1));
      $wRook = array($this->getBoard()->getField(1, 1), $this->getBoard()->getField(8, 1));
      $wQueen = array($this->getBoard()->getField(4, 1));
      $wKing = array($this->getBoard()->getField(5, 1));
      
      
      
      $black = $this->getPlayer(1);
      
      
      $bPawn  = array();
      for($x=1; $x<=8; $x++)
      {
      $bPawn[] = $this->getBoard()->getField($x, 7);
      }
      
      $bKnight = array($this->getBoard()->getField(2, 8),$this->getBoard()->getField(7, 8));
      $bBishop = array($this->getBoard()->getField(3, 8), $this->getBoard()->getField(6, 8));
      $bRook = array($this->getBoard()->getField(1, 8), $this->getBoard()->getField(8, 8));
      $bQueen = array($this->getBoard()->getField(4, 8));
      $bKing = array($this->getBoard()->getField(5, 8));
      
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
  
  public function setGameId($id)
  {
      $this->id = $id;
  }
  
  public function getGameId()
  {
      return $this->id;
  }
  
  protected function setRound($round)
  {
      $this->round = $round;
  }
  
  public function getRound()
  {
      return $this->round;
  }
  
  public function nextRound()
  {
      $this->round++;
  }
  
  /**
   *
   * @param ChessBoard $board 
   */
  public function setBoard(ChessBoard $board)
  {
      $this->board = $board;
  }
  
  /**
   *
   * @return ChessBoard
   */
  public function getBoard()
  {
      return $this->board;
  }
  
  public function setStatus($status)
  {
      $this->status = $status;
  }
  
  public function getStatus()
  {
      return $this->status;
  }
  
  public function setWinner(Player $player)
  {
      $this->winner = $player;
  }
  
  public function getWinner()
  {
      return $this->winner;
  }
  
  public function setCreatedAt(\DateTime $date)
  {
      $this->createdAt = $date;
  }
  
  public function getCreatedAt()
  {
      return $this->createdAt;
  }
  
  public function setUpdatedAt(\DateTime $date)
  {
      $this->updatedAt = $date;
  }
  
  public function getUpdatedAt()
  {
      return $this->updatedAt;
  }
  
}

