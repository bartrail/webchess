<?php

namespace WebChess\Model;

use WebChess\Model\Player;
use WebChess\Model\Player\Human;
use WebChess\Model\Player\Ai;
use WebChess\Model\ChessBoard;
use WebChess\Model\ChessGameHistory;

use WebChess\Model\Piece\Pawn;
use WebChess\Model\Piece\Bishop;
use WebChess\Model\Piece\Knight;
use WebChess\Model\Piece\Rook;
use WebChess\Model\Piece\Queen;
use WebChess\Model\Piece\King;

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
   * keeps the captured pieces
   * 
   * @var array
   */
  protected $capturedPieces = array();
  
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
   * @param string $id
   * @param array $player
   * @param ChessGameHistory $history (optional)
   */
  public function __construct($id, array $player, ChessGameHistory $history = null)
  {
    $this->setId($id);
    
    $hasSavedGame = ChessGameHistory::getGame($this->getId());
    
    if($hasSavedGame) {
        foreach($hasSavedGame['player'] as $player) {
            $this->addSavedPlayer($player);
        }
        $this->board = new ChessBoard($this, $hasSavedGame);
        
    }else{
        foreach($player as $player) {
            $this->addPlayer($player);
        }
        $this->initNewGame();
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
      $wPawn[] = new Pawn($white, $this->getBoard()->getField($x, 2));
      }
      
      $wKnight = array(
          new Knight($white, $this->getBoard()->getField(2, 1)),
          new Knight($white, $this->getBoard()->getField(7, 1))
      );
      $wBishop = array(
          new Bishop($white, $this->getBoard()->getField(3, 1)), 
          new Bishop($white, $this->getBoard()->getField(6, 1))
      );
      $wRook = array(
          new Rook($white, $this->getBoard()->getField(1, 1)), 
          new Rook($white, $this->getBoard()->getField(8, 1))
      );
      $wQueen = new Queen($white, $this->getBoard()->getField(4, 1));
      $wKing = new King($white, $this->getBoard()->getField(5, 1));
      
//      $this->board = new King($white, $wKnight);
      
      
      $black = $this->getPlayer(1);
      
      $bPawn  = array();
      for($x=1; $x<=8; $x++)
      {
      $bPawn[] = new Pawn($black, $this->getBoard()->getField($x, 7));
      }
      
      $bKnight = array(
          new Knight($black, $this->getBoard()->getField(2, 8)), 
          new Knight($black, $this->getBoard()->getField(7, 8))
      );
      $bBishop = array(
          new Bishop($black, $this->getBoard()->getField(3, 8)), 
          new Bishop($black, $this->getBoard()->getField(6, 8))
      );
      $bRook = array(
          new Rook($black, $this->getBoard()->getField(1, 8)), 
          new Rook($black, $this->getBoard()->getField(8, 8))
      );
      $bQueen = new Queen($black, $this->getBoard()->getField(4, 8));
      $bKing = new King($black, $this->getBoard()->getField(5, 8));
      
  }
  
  public function setId($id)
  {
      $this->id = $id;
  }
  
  public function getId()
  {
      return $this->id;
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
   * @return Player
   * @throws \InvalidArgumentException 
   */
  public function getPlayer($key = null)
  {
    if($key === null) {
      return $this->player;
    }elseif(array_key_exists($key, $this->player)){
      return $this->player[$key];
    }else{
      throw new \InvalidArgumentException(sprintf('Unknown Player with key %s', $key));
    }
  }
  
  /**
   * add a captured piece to the list
   * 
   * @param Piece $piece 
   */
  public function addCaptured(Piece $piece)
  {
      $this->capturedPieces[$piece->getPlayer()->getName()][] = $piece;
  }
  
  /**
   *
   * @param string $name
   * @return Player
   */
  public function getPlayerByName($name)
  {
      foreach($this->getPlayer() as $player) {
          /* @var $player Player */
          if($player->getName() == $name) {
              return $player;
          }
      }
  }
  
  /**
   * returns the other player, playing this game
   * 
   * @param Player $player
   * @return Player
   */
  public function getOtherPlayer(Player $player)
  {
      foreach($this->getPlayer() as $p) {
          if($p != $player) {
              return $p;
          }
      }
  }
  
  /**
   * adds a player from a savegame
   * 
   * @param array $player 
   */
  public function addSavedPlayer($player)
  {
      $player = new Human($player['name'], $player['color']);
      $this->addPlayer($player);
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
  
  /**
   *
   * @return \DateTime
   */
  public function getCreatedAt()
  {
      return $this->createdAt;
  }
  
  public function setUpdatedAt(\DateTime $date)
  {
      $this->updatedAt = $date;
  }
  
  /**
   *
   * @return \DateTime
   */
  public function getUpdatedAt()
  {
      return $this->updatedAt;
  }
  
}

