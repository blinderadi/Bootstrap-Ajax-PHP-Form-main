<?php
include "sql/database_conn.php";
$id = $_POST['id'];
$sql = "select id,name from state where country_id = '$id'";
$html='';
$resulta = execute_sql($sql);
                                if($resulta){
                                    foreach ($resulta as $row) {
                                        $html.='<option value='.$row['id'].'>'.$row['name'].'</option>';
                                    }
                                    echo $html;}
?>