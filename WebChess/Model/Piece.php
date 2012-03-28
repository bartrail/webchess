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

  public $type;
    
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
  
  /**
   * create a piece
   * 
   * @param Player $player
   * @param Field $field 
   */
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
    $player->addPiece($this);
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
    // remove from old field
    if($this->getField()) {
        $this->getField()->removePiece();
    }
    $this->field = $field;
    $field->setPiece($this);
    return true;
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
            
          $this->capture($field->getPiece());
          
        }
        return $this->setField($field);
      }
      
    }catch(ChessException $e) {
      
//      echo $e->getMessage();
//      echo "\n";
//      echo $e->getTraceAsString();
      throw new ChessException('Invalid Move');
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
    $this->getBoard()->getGame()->addCaptured($piece);
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
  public function moveToField(Field $field)
  {
      return $this->move($field->getPosX(), $field->getPosY());
  }
  
  /**
   * veryfies the move and throws an exception if invalid
   * 
   * @param Field $field 
   * @return boolean
   * @throws InvalidMoveException
   */
  protected function verifyMove(Field $field)
  {
      $target  = $field->getPosition();
      
      // get all possible moves next
      $allMoves   = $this->getPossibleMoves();
      
      // remove all fields that either are out of the board or placed 
      // width an own piece
      $allowedMoves = array();
      foreach($allMoves as $move) {
        $x = $move[0];
        $y = $move[1];
        try {
            $fieldOnBoard = $this->getBoard()->getField($x, $y);
        }catch(InvalidPositionException $e) {
            continue;
        }
        
        // is field placed with an own field?
        if($fieldOnBoard->hasPieceFromPlayer($this->getPlayer()) == false) {
            $allowedMoves[] = $fieldOnBoard;
        }
      }
      
      foreach($allowedMoves as $allowedMove) {
          if($field == $allowedMove) {
              return true;
          }
      }
      
      throw new InvalidMoveException(sprintf("Move to %s/%s is not allowed", $target[0], $target[1]));
  }
  
  /**
   * calculates the possible moves, only coordinates
   * 
   * @param Field $field 
   * @return array
   */
  protected function getPossibleMoves()
  {
      $x = $this->getField()->getPosX();
      $y = $this->getField()->getPosY();
      
      $moves = array(
        array($x-1, $y-1),  // bottom left
        array($x  , $y-1),  // bottom center
        array($x+1, $y-1),  // bottom right
        array($x-1, $y+1),  // top left
        array($x  , $y+1),  // top center
        array($x+1, $y+1),  // top right
        array($x-1, $y  ),  // center left
        array($x+1, $y  )   // center right
      );
      
      return $moves;
  }
    
//  protected abstract function getPossibleMoves();
  
  public function __toString()
  {
      return sprintf('<div class="piece" data-gameid="%s" data-x="%s" data-y="%s" data-player="%s" data-type="%s">%s</div>', 
               $this->getBoard()->getGame()->getGameId(),
               $this->getField()->getPosX(),
               $this->getField()->getPosY(),
               $this->getPlayer()->getName(),
               $this->type,
               $this->getImage()
             );
  }
  
  public function getType()
  {
      return get_class($this);
  }
  
}
