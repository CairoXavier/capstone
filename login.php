<?php
    require 'db_connect.php';
    include 'header.php';
    include 'navbar.php';
?>

<h1 class="text-center py-4 my-1">Login</h1>
<div class="w-50 m-auto">
    <!-- change action -->
<form action="functions.php" method="post" autocomplete="off">
    <div class="form-group">
        <label for="">Username</label>
        <input class="form-control" type="text" name="username" id="username" placeholder="Enter Username" Required>
    </div>
    <div class="form-group">
        <label for="">Password</label>
        <input class="form-control" type="password" name="password" id="password" placeholder="Enter Password" Required>
    </div><br>
    <button class="btn btn-dark" name="login">Login</button><br><br>
</form>
</div>