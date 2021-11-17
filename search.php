<?php 
 require  'dbConnection.php';
 require  'helpers.php';

 if($_SERVER['REQUEST_METHOD'] == "POST"){
    // SEARCH Code ..... 

    $key = Clean($_POST['key']);

    $Errors = [];
    # Validate Input .... 
    if(!validate($key,1)){
      $Errors['SearchKy'] = "Field Required";
    }


    if(count($Errors) > 0){
        foreach($Errors as $key => $val){
            echo "* ".$key.' : '.$val;
        }
    }else{

        $sql = "select * from data where title like '%$key%' ";

        $op = mysqli_query($con,$sql);

        if(mysqli_num_rows($op) > 0){
            // fetch Data .... 
          while($data = mysqli_fetch_assoc($op)){
              echo $data['title'].'<br>';
          }


        }else{
            echo 'No Matched Data !!!!!';
        }
    }





 }


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Search posts</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data">



            <div class="form-group">
             
                <input type="text" name="key" class="form-control" id="exampleInputName" aria-describedby=""
                    placeholder="Search Here">
            </div>


            <button type="submit" class="btn btn-primary">GO!!</button>
        </form>
    </div>

</body>

</html>