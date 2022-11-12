<?php require('../inc/header.php'); ?>
<?php require('../inc/navbar.php'); ?>
<?php require('../inc/connection.php'); ?>

<?php


if(isset($_POST["submit"])){
    $title=trim(htmlspecialchars($_POST["title"]));
    $body=trim(htmlspecialchars($_POST['body']));
    
    $error=[];
    if(empty($title)||empty($body)){
        $error[]="title or body is empty";
    }
    elseif(is_numeric($title)||is_numeric($body)){
        $error[]="title and body must be string";
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
        $newname="";
    }
    if(empty($error)){
        $query="insert into posts(`title`,`body`,`image`,`user_id`)
        values('$title','$body','$newname',1)";
        $result = mysqli_query($conn,$query);
        if($result){
            if($_FILES['image']['name']){
                move_uploaded_file($image_tmpname,"../uploads/$newname");
            }
            $_SESSION['success']="post inserted successful";
            header("location:../index.php");

        }else{
            $_SESSION['error']=["error while insert data"];
            header("location:../create-post.php");
        }
    }else{
        $_SESSION['title']=$title;
        $_SESSION['body']=$body;
        $_SESSION["error"]=$error;
        header("location:../create-post.php");
    }
}else{
    header("location:../create-post.php");
}
