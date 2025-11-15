<?php 
ini_set('session.cookie_samesite', 'None');
ini_set('session.cookie_secure', '1');
session_start();

$url ="https://bengalurutechsummit.com/web/bts-interlinx/"; 

echo '<iframe src="'.$url.'"  referrerpolicy="no-referrer" width="100%" height="100%" frameborder="0" scrolling="yes"></iframe>';
    