<?php

namespace WebChess\Model;

use WebChess\Model\ChessGame;

use WebChess\Model\Piece;
use WebChess\Model\Piece\Pawn;
use WebChess\Model\Piece\Knight;
use WebChess\Model\Piece\Bishop;
use WebChess\Model\Piece\Rook;
use WebChess\Model\Piece\Queen;
use WebChess\Model\Piece\King;

use WebChess\Exception\ChessException\InvalidColorException;

/**
 * Abstract base PlayerClass
 *
 * @author con
 * @copyright 23.03.2012 
 */
abstract class Player {
  
  const TYPE = null;
  
  /**
   *
   * @var String $name
   */
  protected $name;
  
  /**
   * Human / AI
   * @var String $type
   */
  protected $type;
  
  /**
   *
   * @var String $color
   */
  protected $color;
  
  /**
   *
   * @var ChessGame
   */
  protected $game;
  
  /**
   * list of pieces this player has left
   * 
   * @var array
   */
  protected $pieces = array();

  /**
   * Creates a Player
   * 
   * @param String $name
   * @param String $color
   * @param ChessGame $game 
   */
  public function __construct($name, $color)
  {
    
    $this->type = self::TYPE;
    $this->setName($name);
    $this->setColor($color);
    
  }
  
  /**
   * set the color of the player
   * 
   * @param type $color 
   */
  public function setColor($color)
  {
    if(!in_array($color, ChessGame::getColors())) {
      throw new InvalidColorException(sprintf("Wrong color: %s", $color));
    }
    
    $this->color = $color;
  }
  
  /**
   * get the color of the player
   * 
   * @return String
   */
  public function getColor()
  {
    return $this->color;
  }
  
  /**
   * set the name of the player
   * 
   * @param String $name 
   */
  public function setName($name)
  {
    $this->name = $name;
  }
  
  /**
   * get the name of the player
   * 
   * @return String
   */
  public function getName()
  {
    return $this->name;
  }
  
  /**
   * set the game to the player
   * 
   * @param ChessGame $game 
   */
  public function setGame(ChessGame $game)
  {
    $this->game = $game;
  }
  
  /**
   * get the game of the player
   * 
   * @return ChessGame
   */
  public function getGame()
  {
    return $this->game;
  }
  
  /**
   * returns whether it's this player's turn or not 
   */
  public function hasTurn()
  {
    
  }
  
  /**
   * set the pieces of the player
   * 
   * @param array $pieces 
   */
  public function setPieces(array $pieces)
  { 
    $this->pieces = $pieces;
  }
  
  /**
   * get the pieces of the player
   * 
   * @return type 
   */
  public function getPieces()
  {
    return $this->pieces;
  }
  
  public function addPiece($piece)
  {
      $this->pieces[] = $piece;
  }
  
  public function __toString()
  {
      return $this->getName();
  }
}
