<?php 
include 'config_db.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $query_text_ds = "SELECT first_name, last_name, department_id, salary FROM employees WHERE employee_id = ".$id;
  $query = mysqli_query($koneksi, $query_text_ds);
  $data_lama = mysqli_fetch_array($query);
}

if (isset($_GET['msg'])){
  echo "<script type='text/javascript'>alert('".$_GET['msg']."');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Kelola</title>
</head>
<body>
  <h2>Data Input Pegawai: </h2>
  <form action="change_data.php" method="post">
    <label for="first_name">Nama Depan</label>
    <input value="<?php if(isset($data_lama)) echo $data_lama[0] ?>" type="text" name="first_name" id="first_name">

    <label for="last_name">Nama Belakang</label>
    <input value="<?php if(isset($data_lama)) echo $data_lama[1] ?>" type="text" name="last_name" id="last_name">

    <label for="department_id">List Department</label>
    <select name="department_id" id="department_id">
      <?php 

      $query_text_dp = "SELECT department_id, department_name FROM `departments`";
      $query_depart = mysqli_query($koneksi, $query_text_dp);
      $data_depart = mysqli_fetch_all($query_depart);

      for($i = 0; $i < count($data_depart); $i++) {
      ?>
      <option value="<?php echo $data_depart[$i][0] ?>" <?php if(isset($data_lama) && $data_lama[2] == $data_depart[$i][0]) echo 'selected'  ?>>  
        <?php echo $data_depart[$i][1] ?>
      </option>

      

      <?php } ?>
    </select>

    <?php if(isset($data_lama)) {?>
      <input type="text" hidden name="employee_id" id="employee_id" value="<?php if(isset($data_lama)) echo $id ?>">
    <?php }?>

    <label for="salary">Gaji (Dolar)</label>
    <input value="<?php if(isset($data_lama)) echo $data_lama[3] ?>" type="number" name="salary" id="salary">

    <input type="submit" value="Submit">
  </form>

  <h2>Tabel Data Pegawai: </h2>
  <table>
    <thead>
      <tr>
        <td>Firt Name</td>
        <td>Last Name</td>
        <td>Departmen Name</td>
        <td>Gaji</td>
        <td>Action</td>
      </tr>
    </thead>
    <?php 
      $query_text_pe = "SELECT employees.first_name, employees.last_name, employees.salary, departments.department_name, employees.employee_id FROM employees INNER JOIN departments ON employees.department_id = departments.department_id";
      $query_pegawai = mysqli_query($koneksi, $query_text_pe);
      $data_pegawai = mysqli_fetch_all($query_pegawai);
      
      for ($i = 0; $i < count($data_pegawai); $i++){
    ?>
      <tbody>
        <tr>
          <td><?php echo $data_pegawai[$i][0] ?></td>
          <td><?php echo $data_pegawai[$i][1] ?></td>
          
          <td><?php echo $data_pegawai[$i][3] ?></td>
          <td><?php echo "Rp. ".number_format((float)$data_pegawai[$i][2] * 16000, 2) ?></td>
          <td><a href="index.php?id=<?php echo $data_pegawai[$i][4] ?>">Edit</a> 
              <a href="delete.php?id=<?php echo $data_pegawai[$i][4] ?>">Delete</a>
          </td>
        </tr>
      
      </tbody> 

    <?php }?>
    
  </table>
</body>
</html>