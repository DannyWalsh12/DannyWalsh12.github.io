<?php

/**
 * This is used as a one-stop-shop for all things session handling.
 */
class session {
  public function startSession() {
    session_start();
  }
  public function setSessionUserId($userId) {
    $_SESSION["userId"] = $userId;
  }
  public function getSessionUserId() {
    return $_SESSION["userId"];
  }
  public function isSessionValid() {
    if ($_SESSION["userId"] >= 0) {
      return true;
    }
    return false;
  }
  public function destroySession() {
    $_SESSION["userId"] = null;
    session_unset();
    session_destroy();
  }
}