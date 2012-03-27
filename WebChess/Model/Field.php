<?php

namespace WebChess\Model;

use WebChess\Model\Piece;
use WebChess\Model\ChessBoard;
use WebChess\Model\ChessGame;

use WebChess\Exception\ChessException\ColorException;
use WebChess\Exception\ChessException\InvalidPositionException;

/**
 * Represents a Field on a ChessBoard
 *
 * @author con
 * @copyright 23.03.2012 
 */
class Field {

  /**
   * x-position of the field
   * 
   * @var int
   */
  protected $posX;
  
  /**
   * y-position of the field
   * 
   * @var int
   */
  protected $posY;
  
  /**
   * the color of the field
   * 
   * @var String
   */
  protected $color;
  
  /**
   *
   * @var boolean
   */
  protected $free = true;
  
  /**
   * a chess-piece if one is on it
   * 
   * @var Piece
   */
  protected $piece;
  
  /**
   * the chessboard
   * 
   * @var ChessBoard
   */
  protected $board;
  
  /**
   * creates a Field
   * 
   * @param ChessBoard $board
   * @param type $posX
   * @param type $posY 
   */
  public function __construct(ChessBoard $board, $posX, $posY)
  {
    $this->setBoard($board);
    $this->setPosX($posX);
    $this->setPosY($posY);
    $this->setColor();
  }
  
  /**
   * set the ChessBoard
   * 
   * @param ChessBoard $board 
   */
  public function setBoard(ChessBoard $board)
  {
    $this->board = $board;
  }
  
  /**
   * get the ChessBoard
   * 
   * @return ChessBoard
   */
  public function getBoard()
  {
    return $this->board;
  }
  
  public function setColor($color = null)
  {
    if($color != null ) {
      if(!in_array($color, ChessGame::getColors())) {
        throw new InvalidColorException(sprintf("Wrong color: %s", $color));
      }      
      $this->color = $color;
    }else{
      
      // 
      if($this->posX % 2 == 0 && $this->posY % 2 != 0 || $this->posX % 2 != 0 && $this->posY % 2 == 0) {
        
        $this->setColor(ChessGame::COLOR_WHITE);
        
      }elseif($this->posX % 2 == 0 && $this->posY % 2 == 0 || $this->posX % 2 != 0 && $this->posY % 2 != 0) {
        
        $this->setColor(ChessGame::COLOR_BLACK);
        
      }
      
    }
       
  }
  
  public function getColor()
  {
      return $this->color;
  }
  
  /**
   *
   * @param boolean $isFree
   * @throws \InvalidArgumentException 
   */
  public function setIsFree($isFree)
  {
    if(!is_bool($isFree)) {
      throw new \InvalidArgumentException(sprintf('Only booleans are allowed for setting a field to free'));
    }
    $this->free = $isFree;
  }
  
  /**
   * return whether this field is free or not
   * 
   * @return boolean
   */
  public function isFree()
  {
    return $this->free;
  }
  
  /**
   * set the x-position of the field
   * 
   * @param int $posX
   * @throws InvalidPositionException 
   */
  public function setPosX($posX)
  {
    if($this->getBoard()->validPositionX($posX)) {
      $this->posX = $posX;
    }else{
      throw new InvalidPositionException(sprintf('Invalid Position on X-Achses %s, must be between 1 and %s', $posX, $this->getBoard()->getMaxDimension(0)));
    }
  }
  
  /**
   * get the x-position of a field
   * 
   * @return int
   */
  public function getPosX()
  {
    return $this->posX;
  }
  
  /**
   * set the y-position of a field
   * 
   * @param int $posY
   * @throws InvalidPositionException 
   */
  public function setPosY($posY)
  {
    if($this->getBoard()->validPositionY($posY)) {
      $this->posY = $posY;
    }else{
      throw new InvalidPositionException(sprintf('Invalid Position on Y-Achses %s, must be between 1 and %s', $posY, $this->getBoard()->getMaxDimension(1)));
    }
  }
  
  /**
   * get the y-position of a field
   * 
   * @return int
   */
  public function getPosY()
  {
    return $this->posY;
  }
  
  /**
   * get the positon of this field
   * 
   * @return array
   */
  public function getPosition()
  {
    return array(
      $this->getPosX(),
      $this->getPosY()
    );
  }
  
  /**
   * set the piece
   * 
   * @param Piece $piece 
   */
  public function setPiece(Piece $piece)
  {
    $this->piece = $piece;
    $this->setIsFree(false);
  }

  /**
   * clears the field and returns the piece
   * 
   * @return Piece
   */
  public function removePiece()
  {
    $piece       = $this->piece;
    $this->piece = null;
    $this->setIsFree(true);
    return $piece;
  }
  
  /**
   * receive the piece
   * 
   * @return Piece
   */
  public function getPiece()
  {
    return $this->piece;
  }
  
  public function getNameX()
  {
      return $this->getPosX();
  }
  
  public function getNameY()
  {
      $names = 'abcdefghijklmnopqrstuvwxyz';
      return $names[$this->getPosY()-1];
  }
  
  public function getName()
  {
      return $this->getNameY().$this->getNameX();
  }
  
  /**
   * find out whethere this field has a piece or not
   * 
   * @return boolean
   */
  public function hasPiece()
  {
    return $this->piece instanceof Piece ? true : false;
  }
  
  /**
   * returns whether there is a player placed on the field or not
   * 
   * @param Player $player
   * @return boolean
   */
  public function hasPieceFromPlayer(Player $player)
  {
      if($this->hasPiece()) {
          return $this->getPiece()->getPlayer() == $player;
      }else{
          return false;
      }
  }
  
   public function render()
   {
     
     $element = sprintf('<div id="field-%s-%s" data-x="%s" data-y="%s" data-name="%s" class="field %s">%s</div>', 
             $this->getPosX(),
             $this->getPosY(),
             $this->getPosX(),
             $this->getPosY(),
             $this->getName(),
             $this->getColor(),
             $this->getPiece()
     );
     return $element;
        
   }
   
}
