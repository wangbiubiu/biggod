<?php
@session_start();
header('Content-Type: text/html;charset=utf-8');
require  './Framework/Framework.class.php';
Framework::run();