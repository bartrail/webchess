<?php

namespace WebChess\Model\Piece;

use WebChess\Model\Piece;
use WebChess\Model\Player;
use WebChess\Model\Field;
use WebChess\Model\ChessGame;

use WebChess\Exception\ChessException\InvalidMoveException;
use WebChess\Exception\ChessException\InvalidPositionException;

/**
 * King Piece Class
 *
 * @author con
 * @copyright 23.03.2012 
 */
class King extends Piece {

  public function __construct(Player $player, Field $field)
  {
      parent::__construct($player, $field);
      if($player->getColor() == ChessGame::COLOR_WHITE) {
          $this->setImage('&#9812;');
      }else{
          $this->setImage('&#9818;');
      }
  }    
    
  protected function verifyMove(Field $field)
  {
      $target  = $field->getPosition();
      
      // test if target field is out of the dimensions of the board
      if($this->getBoard()->validPosition($target[0], $target[1]) == false) {
          throw new InvalidMoveException(sprintf('Cannot move out of the board to %s/%s', $target[0], $target[1]));
      }
      
      // get all possible moves next
      $allMoves   = $this->getPossibleMoves($this->getField());
//      print_r($allMoves);
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
  
  protected function getPossibleMoves(Field $field)
  {
      $x = $field->getPosX();
      $y = $field->getPosY();
      
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
  
}
