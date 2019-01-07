<?php require_once('../../Connections/conn_vietchuyen.php'); ?><?php
// Load the tNG classes
require_once('../../includes/tng/tNG.inc.php');

// Make unified connection variable
$conn_conn_vietchuyen = new KT_connection($conn_vietchuyen, $database_conn_vietchuyen);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_conn_vietchuyen, "../../");
//Grand Levels: Level
$restrict->addLevel("1");
$restrict->Execute();
//End Restrict Access To Page

$bReturnAbsolute=false;

$sBaseVirtual0="/Editor/assets";  //Assuming that the path is http://yourserver/Editor/assets/ ("Relative to Root" Path is required)

$sBase0="D:/xampp_5/htdocs/Editor/assets"; //The real path
//$sBase0="/home2/websiteh/public_html/Editor/assets"; //example for Unix server

$sName0="Assets";

$sBaseVirtual1="";
$sBase1="";
$sName1="";

$sBaseVirtual2="";
$sBase2="";
$sName2="";

$sBaseVirtual3="";
$sBase3="";
$sName3="";
?>
