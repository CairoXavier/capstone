<?php
    include 'header.php';
    include 'navbar.php';
    include 'db_connect.php';

    $id = $_GET['id'];
    $q  = "SELECT * FROM exhibits WHERE id = '$id'";
    $r  = mysqli_query($conn, $q);

    if($r){   
        $row    = mysqli_fetch_assoc($r);
        $id     = $row['id'];
        $name   = $row['name'];
        $info   = $row['information'];
        $model  = $row['model'];
        $marker = $row['marker'];
    }
?>

<div class="container w-50 m-auto">
    <h1 class="text-start mt-4">Edit Exhibit</h1> 

    <form action="functions.php" method="post" autocomplete="off">
        <div class="form-group">
            <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
            <label for="exhibitName">Name</label>
            <input class="form-control" type="text" name="exhibitName" id="name" value="<?php echo $name ?>" required>
        </div>
        <div class="form-group">
            <label for="exhibitInfo">Information</label>
            <input class="form-control" type="text" name="exhibitInfo" id="exhibitInfo" value="<?php echo $info ?>" required>
        </div>
        <div class="form-group">
            <label for="exhibitModel">Model</label>
            <input class="form-control" type="text" name="exhibitModel" id="exhibitModel" value="<?php echo $info ?>" required>
        </div><br>
        <button class="btn btn-dark" type="submit" name="editExhibit">Update</button>
    </form>
</div>
