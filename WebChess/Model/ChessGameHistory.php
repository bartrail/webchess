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
  
  public function getGame($gameId)
  {
      if(array_key_exists($gameId, $_SESSION)) {
          return $_SESSION[$gameId];
      }else{
          return null;
      }
  }
  
  public function save(ChessGame $game)
  {
      
      $fields = $game->getBoard()->debugPieces();  
      $this->saveKey($game->getId(), $fields);
      
  }
  
  protected function saveKey($key, $value)
  {
      $_SESSION[$key] = $value;
  }
  
  public function deleteGame(ChessGame $game)
  {
      $gameId = $game->getId();
      if(array_key_exists($gameId, $_SESSION)) {
          unset($_SESSION[$gameId]);
      }
  }
  
}
