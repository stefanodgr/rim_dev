<?php
ini_set("display_errors","1");
include_once('tbs_class.php');

//Connexion to the database
//  Use the example below.
$cnx_id = pg_connect('host=localhost port=5432 dbname=gestion_mtto_nac user=postgres password=postgres');

$sql_ok = (isset($cnx_id) && is_resource($cnx_id) ) ? 1 : 0;
if ($sql_ok==0) $cnx_id = 'clear'; // makes the block to be cleared instead of merged with an SQL query.

$TBS = new clsTinyButStrong;
$TBS->LoadTemplate('tbs_us_examples_datapostgresql.htm');

$TBS->MergeBlock('blk1',$cnx_id,'SELECT codente,descente FROM entesseguridad');

$TBS->Show();

?>