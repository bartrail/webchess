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
  
  /**
   * retrieves a game from the session
   * 
   * @param string $gameId
   * @return null or array
   */
  public static function getGame($gameId)
  {
      if(array_key_exists($gameId, $_SESSION)) {
          return $_SESSION[$gameId];
      }else{
          return null;
      }
  }
  
  /**
   * saves a game in the session
   * 
   * @param ChessGame $game 
   */
  public static function save(ChessGame $game)
  {
      
      $gameData = $game->getBoard()->getGameData();
      $game->setUpdatedAt(new \DateTime());
//      $gameData['meta'] = array(
//        'createdAt' => $game->getCreatedAt()->getTimestamp(),
//        'updatedAt' => $game->getUpdatedAt()->getTimestamp()
//      );
      
      self::saveKey($game->getId(), $gameData);
      
  }
  
  /**
   * shortcut for saving in a session
   * 
   * @param mixed $key
   * @param mixed $value 
   */
  protected static function saveKey($key, $value)
  {
      $_SESSION[$key] = $value;
  }
  
  /*
   * deletes a game from the session
   */
  public static function deleteGame(ChessGame $game)
  {
      $gameId = $game->getId();
      if(array_key_exists($gameId, $_SESSION)) {
          unset($_SESSION[$gameId]);
      }
  }
  
  public static function deleteAllGames()
  {
      foreach($_SESSION as $key => $value) {
          unset($_SESSION[$key]);
      }
  }
  
  public static function getGames()
  {
      return array_keys($_SESSION);
  }
  
}
