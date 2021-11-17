<?php 
 require 'dbConnection.php';
 require 'checklogin.php';
 require 'helpers.php';

 $id = $_GET['id'];

 $sql = "select * from data where id = $id";

 $op = mysqli_query($con,$sql);

  if(mysqli_num_rows($op) == 1){
      // code 

     $data = mysqli_fetch_assoc($op);

  }else{
      header("Location: index.php");
  }





if($_SERVER['REQUEST_METHOD'] == "POST"){

   $title     = Clean($_POST['title']); 
   $content    = Clean($_POST['content']);
   $file_tmp  = $_FILES['image']['tmp_name'];
    $file_name = $_FILES['image']['name'];

    # Validate Inputs ..... 
    $errors = [];

    if(!validate($title,1)){
       $errors['name'] = "Field Required";
    }

    if(!validate($content,1)){
        $errors['content'] = "Field Required";
    }
   //  elseif(!validate($content,2)){
   //      $errors['content'] = "Invalid Email Format";
   //  }

   if(!empty($_FILES['image']['name'])){
    $file_extention =  explode('.' , $file_name); 
    $final_ext = strtolower(end($file_extention)); 

    $extentions = ['png' , 'jpg' , 'jpeg'];
    if(in_array($final_ext , $extentions)){
        $finalName = time().rand(). "." . $final_ext;
        $_SESSION['path'] =  $finalPath = './image/'.$finalName;
        
    }else{
        $errors['image'] = " extention is not allowed";
    }
  }else{    
    $errors['image'] = ' required';
  }

     if(count($errors) > 0){
         foreach($errors as $key => $val){
             echo $key."=>".$val;
         }
     }else{
      // DB code
      $sql = "UPDATE data SET title='$title' , content = '$content' , image='$finalName' WHERE id='$id' ";

      $process = mysqli_query($con ,$sql);
      
      
      if(move_uploaded_file($file_tmp , $finalPath)){
          $errors[] = "image updated";
      }else{
          $errors[] = 'error try again';
      }

      if ($process) {
          $message = 'data Updated' ;
      }else{
          $message =  ' try again';
      }

      unlink( './image/' . $data['image']);

      $_SESSION['message'] = $message;

      header('location: index.php');
  }
  mysqli_close($con);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Edit</h2>
  
  
  <form   action="edit.php?id=<?php echo $data['id'];?>"  method="post">


  <div class="form-group">
    <label for="exampleInputName">Name</label>
    <input type="text" class="form-control" name="name" value="<?php echo $data['name'];?>" id="exampleInputName" aria-describedby="" placeholder="Enter Name">
  </div>


  <div class="form-group">
    <label for="exampleInputEmail">Email address</label>
    <input type="email"   class="form-control"  name="email" value="<?php echo $data['email'];?>" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>

  <!-- <div class="form-group">
    <label for="exampleInputPassword">New Password</label>
    <input type="password"   class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
  </div> -->
 

  
  <div class="form-group">
    <label for="exampleInputPassword">LinkedIn Url</label>
    <input type="url"   class="form-control" name="linkedIn"  value="<?php echo $data['linkedIn'];?>" id="exampleInputPassword1" placeholder="LinkedIn Url">
  </div>
  
  <button type="submit" class="btn btn-primary">Update</button>
</form>
</div>

</body>
</html>