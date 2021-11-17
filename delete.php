<?php 
require 'dbConnection.php';
require 'helpers.php';

$id = $_GET['id'];

# Validate id ... 
if (validate($id ,3)) {
  

    #delete logic
    $sql = "SELECT image from data where id = $id";

    $op = mysqli_query($con , $sql);
    
    while($data = mysqli_fetch_assoc($op)){

        unlink('image'. $data['image'] );
    }

    $sql = " DELETE FROM data where id = $id  ";
    
    $op = mysqli_query($con , $sql);

        if ($op) {
            $message = ' removed';
        }else{
            $message = 'error';
        }
        
}else{
    $message = "invalid id";
}

$_SESSION['message'] = $message;

header('location: index.php')

?>
?>