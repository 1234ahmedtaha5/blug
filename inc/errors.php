<?php if(isset($_SESSION['error'])):
    foreach($_SESSION['error'] as $error):
    ?>
    <div class="alert alert-danger">
    <?php echo $error?>
    </div>
<?php  endforeach; endif; unset($_SESSION["error"])?>