<?php if(isset($_SESSION['success'])):?>
    <div class="alert alert-succes">
    <?php echo $_SESSION['success'] ?>

    </div>
<?php endif; unset($_SESSION["success"])?>