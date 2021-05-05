<?php
  include "sql/database_conn.php";
?>

<!DOCTYPE HTML>
<html>
<head>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

  <title>13 Design Street Project</title>
</head>
<body>

        <div>
          <button class="btn btn-outline-primary" onclick="window.location.href='index.php'">Register Student</button>
          <button class="btn btn-outline-info" onclick="window.location.href='search.php'">Search Student</button>
        </div>

          <form method="get">
              <h5><label for="search_input">Search</label></h5>
              <label>Search By Name</label><input onclick="select_search_type(1)" type="radio" name="search_type" checked value="1" ><br />
              <label>Search By Code</label><input onclick="select_search_type(2)" type="radio" name="search_type" value="2" ><br />
              <label>Search By Date</label><input onclick="select_search_type(3)" type="radio" name="search_type" value="3" ><br />
              <input class="form-control" type="text" id="search_inp" name="search_inp"/><br />
              <div id="dates" style="display:none">
                <label>Start Date</label><input type="date" value="<?= date('Y-m-d')?>" name="sdate" id="sdate"/><br />
                <label>End Date</label><input type="date" value="<?= date('Y-m-d')?>" name="edate" id="edate"/><br />
              </div><br/>
              <input class="btn btn-outline-primary" type="submit" value="Search">
            </form>

          <?php
            if(isset($_GET['search_type'])){

              $start = date('Y-m-d', strtotime($_GET['sdate']));
              $end   = date('Y-m-d', strtotime($_GET['edate']));

              if($start > $end){
                  echo "<script>alert('Start Date should be less than End Date');</script>";
                  die();
              }

              $results = array();
              $search_type = $_GET['search_type'];

              switch ($search_type) {
                case 1:{
                  $query = "SELECT * FROM student_info where lower(firstname) like '%".strtolower($_GET['search_inp'])."%'";
                  $results = execute_sql($query);
                  break;
                }
                case 2:{
                  $query = "SELECT * FROM student_info where lower(code) like '%".strtolower($_GET['search_inp'])."%' ";
                    $results = execute_sql($query);
                  break;
                }
                case 3:{
                  $query = "SELECT * FROM student_info where date(registration_date) >= '".$_GET['sdate']."' and date(registration_date) <= '".$_GET['edate']."' ";
                    $results = execute_sql($query);
                  break;
                }

                default:
                  echo "<script>alert('An Error Occured');</script>";
                  break;
              }

              ?>
              <div style="margin-top:50px">
                <h3>Search Results</h3>

                <table class="table table-striped">
    <thead class="thead-dark">
      <tr>
        <th>
                        S.No
                      </th>
                      <th>
                          Student Name
                      </th>
                      <th>
                        Student Code
                      </th>
                      <th>
                        Date of Birth
                      </th>
                      <th>
                        Image
                      </th>
                      <th>
                        Country
                      </th>
                      <th>
                        State
                      </th>
                      <th>
                        Registration Date
                      </th>
                      <th>
                        Created On
                      </th>
                      <th>
                        Last Modified On
                      </th>
                      <th>
                        Action
                      <th>
      </tr>
    </thead>
    <tbody><?php
                      if($results){
                        $i = 1;
                        foreach($results as $row){
                          //echo "-------  ".$row['is_delete']."  -------";
                          if($row['is_delete']==0){
                          echo "<tr>".
                                  "<td>".$i."</td>".
                                  "<td>".$row['firstname']." ".$row['lastname']."</td>".
                                  "<td>".$row['code']."</td>".
                                  "<td>".$row['dob']."</td>".

                                  "<td>"."<img src=".$row['img']." border=3 height=130 width=150 alt='student Image' />"."</td>".
                                  "<td>".$row['countryname']."</td>".
                                  "<td>".$row['statename']."</td>".
                                  "<td>".$row['registration_date']."</td>".
                                  "<td>".$row['created_date']."</td>".
                                  "<td>".$row['modified_date']."</td>".
                                  "<td><button class='btn btn-outline-info' onclick='window.location.href=\"edit.php?id=".$row['student_id']."\"'>Edit</button><button class='btn btn-outline-danger' onclick='window.location.href=\"delete.php?id=".$row['student_id']."\"'>Delete</button></td>".
                               "</tr>";
                               }
                          $i = $i + 1;
                        }
                      }
                      else{
                        echo "<tr><td colspan='11'><strong>No Data Found</strong></td></tr>";
                      }
                    ?>
    </tbody>
  </table>
                
              </div>
              <?php
            }
           ?>
        </div>
      </div>
    </div>
  </body>

  <script>
  function select_search_type(id){
    if(id == 1 || id == 2){
      document.getElementById("search_inp").style.display = "block";
      document.getElementById("dates").style.display = "none";
    }
    else{
      document.getElementById("search_inp").style.display = "none";
      document.getElementById("dates").style.display = "block";
    }
  }
</script>

</html>
