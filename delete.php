<?php
  include "sql/database_conn.php";

  if(isset($_GET['id'])){
    //$query = "DELETE FROM student_info where student_id = '".$_GET['id']."' ";
    $query = "UPDATE student_info SET is_delete = '1' WHERE student_id ='".$_GET['id'] ."'" ;
    execute_sql($query);
    echo "<script>alert('Student Deleted');</script>";
    header("location:index.php");
    //die();
  }
?>
