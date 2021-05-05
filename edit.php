<?php
include "sql/database_conn.php";

$id = $_GET['id'];
if (isset($_POST['dob'])) {

    $dob   = $_POST['dob'];
    $today = date("Y-m-d");
    //$date      = strtotime($dob);
    $datetime1 = strtotime($dob);
    $datetime2 = strtotime($today);
    //$age       = $today - date('Y-m-d', $date);
    //echo date('Y-m-d', $date);
    $age = ($datetime2 - $datetime1) / 3.154e+7;

    if ($age >= 5 && $age <= 20) {
if (isset($_POST['update_btn'])) {
    $firstName   = $_POST['firstName'];
    $lastName    = $_POST['lastName'];
    $fathername  = $_POST['fathername'];
    $phno        = $_POST['phno'];
    $dob         = $_POST['dob'];
    $regd        = $_POST['regd'];
    $address     = $_POST['address'];
    $gender      = $_POST['gender'];
    $cquery = "SELECT name FROM country WHERE id ='".$_POST['CountryCode']."'";
    $resultl = execute_sql($cquery);
    //echo $resultl[0][0];
    $CountryName = $resultl[0][0];
    $StateCode   = $_POST['StateCode'];
    $squery = "SELECT name FROM state WHERE id ='".$_POST['StateCode']."'";
    $results = execute_sql($squery);
    //echo $resultl[0][0];
    $StateName = $results[0][0];
    $CountryCode = $_POST['CountryCode'];
    

    $target_dir  = "uploads/";
    $target_file = $target_dir ."13DesignStreet".uniqid(). "==786==" . str_replace(' ', '',basename($_FILES["std_img"]["name"]));
    $allowed  = array('jpeg', 'png', 'jpg');
            $ext      = pathinfo($target_file, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                echo "<script>alert('Please Select a jpeg, png or jpg')</script>";
                
            }else{
    

    //$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $append = '';
    $check = getimagesize($_FILES["std_img"]["tmp_name"]);
    if ($check !== false) {
        move_uploaded_file($_FILES["std_img"]["tmp_name"], $target_file);
        $append = "', img = '" . $target_file ."";
    }

    $query = "UPDATE `student_info` " .
    "SET firstname = '" . $firstName . "', lastname = '" . $lastName . "', fathername = '" . $fathername . "', " .
    "dob = '" . $dob . $append . "', address = '" . $address . "', countrycode = '" . $CountryCode . "', " .
    "statecode = '" . $StateCode . "', phnno = '" . $phno . "', gender = '" . $gender . "', registration_date = '" . $regd . "', modified_date = '" . date('Y-m-d h:i:s') . "' ," ."countryname ='".$CountryName."',"."statename = '".$StateName."'".
        " where student_id = '" . $id . "'";

    execute_sql($query);

    echo "<script>alert('Student Updated');</script>";
}
}}}

if (isset($_GET['id'])) {
    $fetch_data   = "SELECT * FROM student_info where student_id='" . $_GET['id'] . "'";
    $student_data = execute_sql($fetch_data)[0];
    if (!$student_data) {
        header("location:index.php");
        die();
    }
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
      <title>Student Project</title>
        <!-- link of bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <!-- link of bootstrap -->
    </head>
    <body>

          <div>
            <button class="btn btn-outline-primary" onclick="window.location.href='index.php'">Register Student</button>
            <button class="btn btn-outline-info" onclick="window.location.href='search.php'">Search Student</button>
          </div>

            <div class="section-title">
                        <h3 class="display-4">EDIT DETAILS</h3>
                    </div>
                    <form action="" id="registration_form" method="post" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-6"><label for="firstName"></label>
                                <input class="form-control" type="text" required name="firstName" id="firstName" placeholder="First name" value="<?=$student_data['firstname']?>">
                                </div>
                                <div class="form-group col-md-6"><label for="lastName"></label>
                                        <input class="form-control" type="text" required name="lastName" id="lastName" placeholder="Last name" value="<?=$student_data['lastname']?>">
                                </div>

                                </div>
                                <div class="form-group">
                                        <label for="fathername"></label>
                                        <input class="form-control" type="text" required name="fathername" id="fathername" placeholder="Father's Name"  value="<?=$student_data['fathername']?>"></div>

                                 <div class="form-group">

                    <h5><label for="std_img">Student's Image</label></h5>
                    <img src="<?=$student_data['img']?>" alt="Student Image" border=3 height=130 width=150 />
                    <input class="form-control" type="file" name="std_img" id="std_img" />


                                 </div>

                                <div class="form-group">
                                            <h5><label for="phno">Phone Number</label></h5>
                                        <input class="form-control" type="number" required name="phno" id="phno" placeholder="Enter Contact Number"  value="<?=$student_data['phnno']?>">
                                </div>

                    <div class="form-group">
                        <h5><label for="dob">Date Of Birth</label></h5>
                    <input class="form-control" type="date" required name="dob" id="dob" value="<?=$student_data['dob']?>">
                    </div>

                    <div class="form-group">
                        <h5><label for="regd">Registration Date</label></h5>
                    <input class="form-control" type="date" required name="regd" id="regd" value="<?=date('Y-m-d', strtotime($student_data['registration_date']))?>">
                    </div>


                    <h5><label for="CountryCode">Select Country</label></h5>
                    <select required name="CountryCode" id="CountryCode" class="form-control" >
                    <option selected="selected" value="<?=$student_data['countrycode']?>"><?php echo $student_data['countryname'];?></option>
                    <option >Select Country</option>
                            <?php //c++

    $queryq = "SELECT * FROM country";
    $result = execute_sql($queryq);
    if ($result) {
        foreach ($result as $row) {
            //echo "<option data-countryCode=".$row['countries_iso_code']." value=".$row['countries_id'].">".$row['countries_name']."</option>";
            ?><option value = "<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                        <?php
}
    }

    ?>
                    </select>
                    <label for="CountryCode">Current Country: <?php echo $student_data['countryname']; ?></label>
                    <h5><label for="StateCode">Select State</label></h5>
                    <select required name="StateCode" id="StateCode" class="form-control">
                    <option selected="selected" value="<?=$student_data['statecode']?>"><?php echo $student_data['statename'];?></option>
                    
                    <option>Select Country First</option>

                    </select>

<label for="StateCode">Current State: <?php echo $student_data['statename']; ?></label>

                    <div style="display:none" id="statesdiv">
                      <h5><label for="StateCode">State Code</label></h5>
                      <select name="StateCode" id="StateCode"></select>

                      </div>

                    <div class="form-control">

                                            <h5><label for="address">Address</label></div></h5>
                                        <textarea class="form-control" name="address" required id="address"><?=$student_data['address']?></textarea>
                                        </div>

<div class="form-group">
                                            <h5><label for="gender">Gender</label></h5>
                                            <input type="radio" <?php if ($student_data['gender'] == '0') {echo "checked";}?> name="gender" id="male" checked value="0"><span>Male</span>
                                            <input type="radio" <?php if ($student_data['gender'] == '1') {echo "checked";}?> name="gender" id="female" value="1"><span>Female</span>
                                            <input type="radio" <?php if ($student_data['gender'] == '2') {echo "checked";}?> name="gender" id="other" value="2"><span>Other</span><br><br>

                                            <p><input class="btn btn-outline-success" type="submit" value="Update" name="update_btn" id="update_btn" ></p>
</div>
            </form>
    </body>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>

    $(document).ready(function(){
        jQuery('#CountryCode').change(function(){
            var id = jQuery(this).val();
            //alert(id);
            jQuery.ajax({
                type:'post',
                url:'get-data.php',
                data: 'id='+id,
                success:function(result){
                    //alert(result);
                    jQuery('#StateCode').html(result);
                }
            });
        });

    });

</script>


    </html>

    <?php
} else {
    header("location:index.php");
    die();
}
?>
