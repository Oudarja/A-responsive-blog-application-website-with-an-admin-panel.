<?php

require 'config/constant.php';
//destroy all data registered to a session
session_destroy();
//head to ROOT URL bit not get into any other directory 
header('location:' . ROOT_URL);
die();