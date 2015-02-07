<?php error_reporting(E_ERROR);

require_once('class/minCssAndJs.php') ; 

$minify = new minify() ; 


$minify->minifyJsAndCss() ; 