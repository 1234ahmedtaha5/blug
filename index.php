<?php require('inc/header.php'); ?>
<?php require('inc/navbar.php'); ?>
<?php require('inc/connection.php');
if (isset($_SESSION["user_id"])){

?>

<?php if(isset($_SESSION['error'])):?>
    <div class="alert alert-danger">
    <?php echo $_SESSION['error'] ?>
    </div>
<?php endif; unset($_SESSION["error"])?>

<?php require_once "inc/success.php"?>
<?php 
if (isset($_GET['page'])){
    $page=$_GET['page'];
}else{
    $page =1;
}
$limit=2;
$offset=($page-1)*$limit;

$totalquery="select count(`id`) as total from posts";
$totalResult=mysqli_query($conn,$totalquery);


$query="select id,title,created_at from posts 
limit $limit offset $offset";
$result=mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
    $posts=mysqli_fetch_all($result,MYSQLI_ASSOC);
}else{
    echo "data not found";
}
?>


<div class="container-fluid pt-4">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="d-flex justify-content-between border-bottom mb-5">
                <div>
                    <h3>All posts</h3>
                </div>
                <div>
                    <a href="create-post.php" class="btn btn-sm btn-success">Add new post</a>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Published At</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
            <?php 
            foreach($posts as $post):?>
                    <tr>
                        <td><?php echo $post['title'];?></td>
                        <td><?php echo $post['created_at']; ?></td>
                        <td>
                            <a href="show-post.php?id=<?php echo $post['id'] ?>" class="btn btn-sm btn-primary">Show</a>
                            <a href="edit-post.php?id=<?php echo $post['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                            <a href="handle/delete-post.php?id=<?php echo $post['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('do you really want to delete post?')">Delete</a>
                        </td>
                    </tr>
                  
            <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require('inc/footer.php');} else{
    header("location:login.php");
} ?>