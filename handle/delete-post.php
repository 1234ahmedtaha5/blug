<?php
require_once("../inc/connection.php");
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $query="select image,id from posts where id=$id";
    $result=mysqli_query($conn,$query);
    if(mysqli_num_rows($result)==1){

        $post=mysqli_fetch_assoc($result);
        $image=$post['image'];
        unlink("../uploads/$image");
        $query="delete from posts where id=$id";
        $result=mysqli_query($conn,$query);
        if($result==true){
            $_SESSION['succes']="posts deleted successful";
            header("location:../index.php");
        }else{
            $_SESSION['error']="error while deleting";
        }
    }
}else{
    $_SESSION['error']="no data for delete";
    header("location:../index.php");
}
