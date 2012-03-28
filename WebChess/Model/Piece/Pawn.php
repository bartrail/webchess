<?php

namespace WebChess\Model\Piece;

use WebChess\Model\Piece;
use WebChess\Model\Player;
use WebChess\Model\Field;
use WebChess\Model\ChessGame;

use WebChess\Exception\ChessException\InvalidPositionException;

/**
 * Pawn Piece Class
 *
 * @author con
 * @copyright 23.03.2012 
 */
class Pawn extends Piece {
    
  public $type = 'Pawn';
    
  public function __construct(Player $player, Field $field)
  {
      parent::__construct($player, $field);
      if($player->getColor() == ChessGame::COLOR_WHITE) {
          $this->setImage('&#9817;');
      }else{
          $this->setImage('&#9823;');
      }
  }   
  
  protected function getPossibleMoves()
  {
      $x = $this->getField()->getPosX();
      $y = $this->getField()->getPosY();

      // moves depend on the player
      $player       = $this->getPlayer();
      $otherPlayer  = $this->getBoard()->getGame()->getOtherPlayer($this->getPlayer());
      
      if($player->getColor() == ChessGame::COLOR_WHITE) {

          $moves = array();
          // default move +1 vertical if not placed with a piece
          if($this->getBoard()->getField($x, $y+1)->hasPieceFromPlayer($otherPlayer) == false) {
            $moves[] = array($x, $y+1);
          }
          
          // init move +2 vertical
          if($y == 2) {
              $moves[] = array($x, $y+2);
          }
          // try if top left or top right have a piece, it can be captured
          try {
            
            $fieldTopLeft   = $this->getBoard()->getField($x-1, $y+1);
            $fieldTopRight  = $this->getBoard()->getField($x+1, $y+1);
            if($fieldTopLeft->hasPieceFromPlayer($otherPlayer)) {
              $moves[] = array($x-1, $y+1);
            }
            if($fieldTopRight->hasPieceFromPlayer($otherPlayer)) {
              $moves[] = array($x+1, $y+1);
            }
          }catch(InvalidPositionException $e) {
              
          }
          
          
      }else{
          
          $moves = array();
          // default move -1 vertical if not placed with a piece
          if($this->getBoard()->getField($x, $y-1)->hasPieceFromPlayer($otherPlayer) == false) {
            $moves[] = array($x, $y-1);
          }        
        
          // init move -2 vertical
          if($y == 7) {
              $moves[] = array($x, $y-2);
          }
          
          // try if bottom left or bottom right have a piece, it can be captured
          try {
            
            $fieldTopLeft  = $this->getBoard()->getField($x-1, $y-1);
            $fieldTopRight = $this->getBoard()->getField($x+1, $y-1);
            $otherPlayer   = $this->getBoard()->getGame()->getOtherPlayer($this->getPlayer());
            if($fieldTopLeft->hasPieceFromPlayer($otherPlayer)) {
              $moves[] = array($x-1, $y-1);
            }
            if($fieldTopRight->hasPieceFromPlayer($otherPlayer)) {
              $moves[] = array($x+1, $y-1);
            }
          }catch(InvalidPositionException $e) {
              
          }          
          
      }
      
      return $moves;
  }
  
  
}
