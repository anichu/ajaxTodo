<?php
   include_once("./db.php");  

  
  if(isset($_GET['deleteId'])){
    $id = $_GET['deleteId'];
    $deleteQuery = "delete from contact where id = $id";
    $deleteRes = mysqli_query($con,$deleteQuery);
    if($deleteRes){
      echo 'success';
    }else{
      echo "error". mysqli_error($con);
    }
  }

  if(isset($_GET['editId'])){
    $id = $_GET['editId'];
    $query = "select * from contact where id=$id";
    $res = mysqli_query($con,$query);
    $row = mysqli_fetch_assoc($res);
    echo json_encode($row); 
  }

  if(isset($_GET['editedId'])){
    $id = $_GET['editedId'];
    echo $id;
    $name = $_POST['name'];
    $phonenumber = $_POST['phonenumber'];
    $email = $_POST['email'];
    $query = "update contact set name='$name',email='$email',phone='$phonenumber' where id= $id";
    $res = mysqli_query($con,$query);
    if($res){
      echo 'success';
    } else{
      echo "error" . mysqli_error($con);
    }
  }

  
  if(isset($_GET['show'])){
    $query = "select * from contact";
    $res = mysqli_query($con,$query);
    $row = mysqli_fetch_all($res,MYSQLI_ASSOC);
    echo json_encode($row);
  }

  if(isset($_GET['addTodo'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $query = "insert into contact (id,name,email,phone) values('','$name','$email','$phonenumber')";
    $res = mysqli_query($con,$query);
    if($res){
      echo 'succes';
    }
    else{
      echo "error". mysqli_errno($con);
    }
    
  }


?>
