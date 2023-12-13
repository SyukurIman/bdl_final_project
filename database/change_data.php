<?php 

include 'config_db.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$department_id = $_POST['department_id'];
$salary = $_POST['salary'];

if(isset($_POST['employee_id'])){
  $id = $_POST['employee_id'];
  $query = "UPDATE `employees` SET `first_name`='$first_name', `last_name`='$last_name', `department_id`='$department_id', `salary`='$salary' WHERE `employee_id` = ".$id;
  
  print_r($query);
  $run_sql = mysqli_query($koneksi, $query);

  if ($run_sql) {
    header('Location: index.php?msg=Update Sukses');
  } else {
    header('Location: index.php?msg=Update Failed');
  }
} else {
  $query = "INSERT INTO employees (`first_name`, `last_name`, `department_id`, `salary`) VALUES ('$first_name', '$last_name', '$department_id', '$salary')";
  
  $run_sql = mysqli_query($koneksi, $query);

  if ($run_sql) {
    header('Location: index.php?msg=Insert Sukses');
  } else {
    header('Location: index.php?msg=Insert Failed');
  }
  
}