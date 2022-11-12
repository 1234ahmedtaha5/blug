<?php

require_once "../inc/connection.php";

if(isset($_GET['id'])){
   $id=$_GET['id'];

    $title=trim(htmlspecialchars($_POST["title"]));
    $body=trim(htmlspecialchars($_POST['body']));
    
    $error=[];
    if(empty($title)||empty($body)){
        $error[]="title or body is empty";
    }
    elseif(is_numeric($title)||is_numeric($body)){
        $error[]="title and body must be string";
    }
     
    $query="select image from posts where id=$id";
    $result=mysqli_query($conn,$query);
    if(mysqli_num_rows($result)==1){
        $posts=mysqli_fetch_assoc($result);
        $oldimage=$posts['image'];
    }
    if($_FILES && $_FILES['image']['name']){

        $image=$_FILES['image'];
        $image_name=$image["name"];
        $image_tmpname=$image['tmp_name'];
        $sizemb=$image['size']/(1024*1024);
        $ext=strtolower(pathinfo($image_name,PATHINFO_EXTENSION));
        $newname=uniqid().time().".".$ext;
        
        if($sizemb>1){
            $error[]="large image";
        }elseif(! in_array($ext,["png",'jpg'])){
            $error[]="unvalid image";
        }

    }else{
        $newname=$oldimage;
    }

    if(empty($errors)){
        $query="update posts set `title`='$title',`body`='$body',`image`='$newname' where id=$id";
        $result=mysqli_query($conn,$query);
        if($result){
            //check (new image *> mmove,unlink)
            //show post
            if($_FILES['image']['name']){
                unlink("../uploads/$oldimage");
                move_uploaded_file($image_tmpname,"../uploads/$nawname");
            }
            $_SESSION["success"]="post updated successfull";
            header("location:../show-post.php?id=$id");
        }else{
            $_SESSION["error"]="error while updated";
            header("locaion:../edit-post.php?id=$id");
        }
    }else{
        $_SESSION['title']=$title;
        $_SESSION['body']=$body;
        $_SESSION["error"]=$error;
        header("locaion:../edit-post.php?id=$id");
    }


}else{
    $_SESSION["error"]="errors while updated";
    header("location:../index.php");
}