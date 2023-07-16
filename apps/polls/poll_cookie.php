<?php
///////////////////////////////////////////////////
//  Advanced Poll 1.61 (PHP/MySQL)               //
//  Copyright (c)2001 Chi Kien Uong              //
//  URL: http://www.proxy2.de                    //
///////////////////////////////////////////////////
// this code is optional
// Important! You have to include it before your html code

$cookie_expire = 24; // hours

if (!isset($action)) {
  $action='';
}
if ($action=="vote" && isset($vote_for)) {
  $cookie_name = "AdvancedPoll".$poll_id;
  if(!isset($$cookie_name)) {
    setcookie($cookie_name, "1", time()+(3600*$cookie_expire));
  }
}
?>