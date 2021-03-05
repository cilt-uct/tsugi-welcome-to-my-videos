<?php
require_once('../config.php');
include 'tool-config.php';

use \Tsugi\Core\LTIX;
use \Tsugi\Core\Settings;

$launch = LTIX::requireData();

$menu = false; // We are not using a menu
header( 'Location: '.addSession('instructor-home.php') ) ;
