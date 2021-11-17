<?php 
 require 'dbConnection.php';
 require 'helpers.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

   $title     = Clean($_POST['title']); 
   $content    = Clean($_POST['content']);
   $file_tmp  = $_FILES['image']['tmp_name'];
   $fileName= basename($_FILES["image"]["name"]);

    # Validate Inputs ..... 
    $errors = [];

    if(!validate($title,1)){
       $errors['title'] = "Field Required";
    }elseif(!validate($title,2)){
        $error['title']="title must not contain numbers";
    }

    if(!validate($content,1)){
        $errors['content'] = "Field Required";
    }
    elseif(!validate($content,3)){
        $errors['content'] = "must be greater than 100 char";
    }

    // if(!empty($_FILES['image']['name'])){
    //    $fileName= basename($_FILES["file"]["name"]);
    //    $targetFpath = "./image/".$fileName;
    //    $fileType = pathinfo($targetFpath,PATHINFO_EXTENSION);

    //    $allowType= array(`jpg`,`png`,`jpeg`);
    //    if(in_array($fileType,$allowType)){
    //        if(move_uploaded_file($_FILES["file"]["tmp_name"],$targetFpath)){

    //        }
    //    }
    // }

  

     if(!empty($_FILES['image']['name'])){
        $file_extention =  explode('.' , $file_name); 
        $final_ext = strtolower(end($file_extention)); 

        $extentions = ['png' , 'jpg' , 'jpeg'];
        if(in_array($final_ext , $extentions)){
            $finalName = time().rand(). "." . $final_ext;
            $_SESSION['path'] =  $finalPath = './image/'.$finalName;
            
        }else{
            $errors['image'] = "*this extention is not allowed";
        }
      }else{    
        $errors['image'] = ' required';
      }
    
    if (count($errors) > 0  ) {
        foreach ($errors as $key => $value) {
            echo $key . ' => ' . $value ;
        }
    }else{
        // DB code
        $sql = "INSERT into data (title , content , image) VALUES ('$title' , '$content' , '$finalName')";

        $process = mysqli_query($con ,$sql);
        
        if(move_uploaded_file($file_tmp , $finalPath)){
            $errors[] = "uploaded";
        }else{
            $errors[] = 'error try again';
        }

        if ($process) {
            echo 'blog added';

            header('location: index.php');
        }else{
            echo 'try again';
        }
    }


    mysqli_close($con);

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>blog</h2>
  
  
  <form   action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  method="post">


  <div class="form-group">
    <label for="exampleInputName">title</label>
    <input type="text" class="form-control" name="title" id="exampleInputName" aria-describedby="" placeholder="title">
  </div>


  <div class="form-group">
    <label for="exampleInputEmail">content</label>
    <input type="text"   class="form-control"  name="content" placeholder="content">
  </div>

  <!-- <div class="form-group">
    <label for="exampleInputPassword">image</label>
    <input type="text"   class="form-control" name="image" id="exampleInputPassword1" placeholder="image here">
  </div>
  -->
  <div class="input-group mb-3">
  <label class="input-group-text" for="inputGroupFile01">Upload</label>
  <input type="file" class="form-control" id="inputGroupFile01" name="image">
</div>
  
  <button type="submit" class="btn btn-primary">Save</button>
</form>
</div>

</body>
</html>