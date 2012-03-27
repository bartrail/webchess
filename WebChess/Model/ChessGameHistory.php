<?php

namespace WebChess\Model;

/**
 * ChessGameHistory saves a snapshot of every round of every game
 *
 * @author con
 * @copyright 23.03.2012 
 */
class ChessGameHistory {
  
  protected $game;
  
  protected $round;
  
  protected $boardSnapshot;
  
  protected $createdAt;
  
  protected $session;

  public function __construct()
  {
      
  }
  
  public function save(ChessGame $game)
  {
      print_r($game);
  }
  
  
}
