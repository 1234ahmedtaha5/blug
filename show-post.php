<?php require('inc/header.php'); ?>
<?php require('inc/navbar.php'); ?>
<?php require('inc/connection.php'); ?>


<?php 

if(isset($_GET['id'])){
    $id=$_GET['id'];

    $query="select * from posts where id=$id";
    $result=mysqli_query($conn,$query);
    if(mysqli_num_rows($result)==1){
        $posts=mysqli_fetch_assoc($result);
    }else{
        $_SESSION["error"]="no data found";
        header("location:index.php");
    }

}else{
    header("location:index.php");
}

?>
<div class="container-fluid pt-4">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="d-flex justify-content-between border-bottom mb-5">
                <div>
                    <h3><?php echo $posts["title"]?></h3>
                </div>
                <div>
                    <a href="index.php" class="text-decoration-none">Back</a>
                </div>body
            </div>
            <div>
            <?php echo $posts["body"]?>
            </div>
            <div>
               <img src="uploads/<?php echo $posts['image'] ?>" alt="" srcset="" width="300px">
            </div>
        </div>
    </div>
</div>

<?php require('inc/footer.php'); ?>