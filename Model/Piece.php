<?php

namespace WebChess\Model;

use WebChess\Model\ChessBoard;
use WebChess\Model\Field;
use WebChess\Model\Player;

use WebChess\Exception\ChessException;
use WebChess\Exception\ChessException\InvalidPositionException;
use WebChess\Exception\ChessException\InvalidMoveException;

/**
 * Piece Base Class
 *
 * @author con
 * @copyright 23.03.2012 
 */
abstract class Piece {

  /**
   * The field this Piece is placed
   * 
   * @var Field
   */
  protected $field;
  
  /**
   * The chess board
   * 
   * @var ChessBoard
   */
  protected $board;
  
  /**
   * The Player this piece belongs to
   * 
   * @var Player
   */
  protected $player;
          
  /**
   * whether this piece is captured (and out of the game) or not
   * 
   * @var boolean
   */
  protected $captured;
  
  /**
   * 
   * @var String
   */
  protected $image;
  
  public function __construct(Player $player, Field $field)
  {
    $this->setPlayer($player);
    $this->setField($field);
    $this->setBoard($field->getBoard());
  }
  
  /**
   * set the player
   * 
   * @param Player $player 
   */
  public function setPlayer(Player $player)
  {
    $this->player = $player;
  }
  
  /**
   * get the player
   * 
   * @return Player
   */
  public function getPlayer()
  {
    return $this->player;
  }
  
  /**
   *
   * @param String $image 
   */
  public function setImage($image)
  {
    $this->image = $image;
  }
  
  /**
   *
   * @return String
   */
  public function getImage()
  {
    return $this->image;
  }
  
  /**
   * sets the piece to the field
   * and tells the field that is has this piece
   * 
   * @param Field $field 
   */
  public function setField(Field $field)
  {
    $this->field = $field;
    $field->setPiece($this);
  }
  
  /**
   * get the current field
   * 
   * @return Field
   */
  public function getField()
  {
    return $this->field;
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
  
  /**
   * Alias of Piece::move()
   * 
   * @param type $posX
   * @param type $posY 
   */
  public function setPosition($posX, $posY)
  {
    return $this->move($posX, $posY);
  }

  /**
   * move the piece to the desired location
   * 
   * @param int $posX
   * @param int $posY
   * @return boolean 
   */
  public function move($posX, $posY)
  {

    try {
      
      // get the field from the board
      $field = $this->getBoard()->getField($posX, $posY);
      
      // verify if the move is allowed
      if($this->verifyMove($field)) {
        if($field->hasPiece()) {
          
        }
        return $this->moveToField($field);
      }
      
    }catch(ChessException $e) {
      
      return false;
      
    }
    
  }
  
  /**
   * captures another piece
   * 
   * @param Piece $piece 
   */
  public function capture(Piece $piece)
  {
    // set self to the piece's position
//    $piece->getField()->setPiece($this);
    $piece->setIsCaptured(true);
  }
  
  /**
   *
   * @return type 
   */
  public function isCaptured()
  {
    return $this->captured;
  }
  
  /**
   * set if this piece is captured or not
   * 
   * @param type $captured
   * @throws \InvalidArgumentException 
   */
  public function setIsCaptured($captured)
  {
    if(!is_bool($captured)) {
      throw new \InvalidArgumentException(sprintf('Boolean required to set captured state, %s given', gettype($captured)));
    }
    $this->captured = $captured;
  }
  
  /**
   * actually moves the piece
   * 
   * @param Field $field
   * @return boolean 
   */
  protected function moveToField(Field $field)
  {
    $this->setField($field);
    return true;
  }
  
  /**
   * veryfies the move and throws an exception if invalid
   * 
   * @param Field $field 
   * @return boolean
   * @throws InvalidMoveException
   */
  protected abstract function verifyMove(Field $field);
  
}
