<?php 
require 'dbConnection.php';
require 'checklogin.php';
require 'helpers.php';

$id = $_GET['id'];

# Validate id ... 
if (validate($id , 5)) {
  

    #delete logic
    $sql = "SELECT image from data where id = $id";

    $op = mysqli_query($con , $sql);
    
    while($data = mysqli_fetch_assoc($op)){

        unlink('image'. $data['image'] );
    }

    $sql = " DELETE FROM data where id = $id  ";
    
    $op = mysqli_query($con , $sql);

        if ($op) {
            $message = 'Row removed';
        }else{
            $message = 'Error tr again';
        }
        
}else{
    $message = "invalid id";
}

$_SESSION['message'] = $message;

header('location: index.php')

?>
?>