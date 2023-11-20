<?php
    $pageTitle = "Inventory";
    include 'header.php';
    include 'db_connect.php';
    include 'navbar.php';

    $q  = "SELECT * FROM exhibits";
    $r = mysqli_query($conn, $q);

    if($r){   
        $row    = mysqli_fetch_assoc($r);
        $id     = $row['id'];
        $name   = $row['name'];
        $info   = $row['information'];
        $model  = $row['model'];
        $marker = $row['marker'];
    }
?>

<div class="container w-50 my-3">
    <h1 class="text-start mt-4">Exhibits</h1> 
    <div class="container text-end">
        <button type="button" class="btn btn-dark mb-2" id="openAddExhibitModal" data-bs-toggle="modal" data-bs-target="#addExhibitModal">
            Add 
        </button>
        <a role="button" class="btn btn-secondary mb-2">
            Close
        </a> <!-- to be configured; if admin = admin-main.php; if staff = staff-main.php --> 
    </div>
    <div class="table-responsive">
        <table class="table table-hover text-center">
            <thead>
            <tr>
                <th scope="col">Exhibit ID</th>
                <th scope="col">Exhibit Name</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php         
                $q  = "SELECT * FROM exhibits";
                $r = mysqli_query($conn, $q);
                while($row = mysqli_fetch_assoc($r)){
                    $id     = $row['id'];
                    $name   = $row['name'];
                    ?>
                        <tr>
                        <td><?php echo $id; ?></td>
                        <td><?php echo $name; ?></td>
                        <td>
                            <button type="button" class="btn btn-dark mb-2" id="openViewExhibitModal" data-bs-toggle="modal" data-bs-target="#viewExhibitModal">
                                View 
                            </button>
                        </td>
                    </tr>
            <?php      
                    }
            ?> 
            </tbody>
        </table>
    </div>
</div>

<!-- VIEW -->
<div class="modal fade" id="viewExhibitModal" tabindex="-1" role="dialog" aria-labelledby="viewExhibitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewExhibitModalLabel">
                    Exhibit
                </h5>
            </div>
            <form action="functions.php" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exhibitName">
                            Exhibit ID
                        </label>
                        <input type="text" class="form-control" id="exhibitID" name="exhibitID" value="<?php echo $id ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="exhibitName">
                            Exhibit Name
                        </label>
                        <input type="text" class="form-control" id="exhibitName" name="exhibitName" value="<?php echo $name ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="exhibitInfo">
                            Information
                        </label>
                        <input class="form-control" id="exhibitInfo" name="exhibitInfo" value="<?php echo $info ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="exhibitModel">
                            3D Model
                        </label>
                        <input type="text" class="form-control" id="exhibitModel" name="exhibitModel" value="<?php echo $model ?>" placeholder="Enter 3D Model URL" readonly required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark mb-2" id="openEditExhibitModal" data-bs-toggle="modal" data-bs-target="#editExhibitModal">
                        Edit
                    </button>
                    <a class="btn btn-dark btn-sm" href="functions.php?action=deleteExhibit&id=<?php echo $id ?>" role="button">
                        Delete
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT -->
<div class="modal fade" id="editExhibitModal" tabindex="-1" role="dialog" aria-labelledby="editExhibitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editExhibitModalLabel">
                    Edit Exhibit
                </h5>
            </div>
            <form action="functions.php" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                        <label for="exhibitName">
                            Exhibit Name
                        </label>
                        <input type="text" class="form-control" id="exhibitName" name="exhibitName" value="<?php echo $name ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exhibitInfo">
                            Information
                        </label>
                        <input class="form-control" id="exhibitInfo" name="exhibitInfo" value="<?php echo $info ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exhibitModel">
                            3D Model
                        </label>
                        <input type="text" class="form-control" id="exhibitModel" name="exhibitModel" value="<?php echo $model ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark" type="submit" name="editExhibit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ADD -->
<div class="modal fade" id="addExhibitModal" tabindex="-1" role="dialog" aria-labelledby="addExhibitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExhibitModalLabel">Add Exhibit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="functions.php" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exhibitName">Exhibit Name</label>
                        <input type="text" class="form-control" id="exhibitName" name="exhibitName" placeholder="Enter Exhibit Name"  required>
                    </div>
                    <div class="form-group">
                        <label for="exhibitInfo">Information</label>
                        <input class="form-control" id="exhibitInfo" name="exhibitInfo" placeholder="Enter Exhibit Information" required>
                    </div>
                    <div class="form-group">
                        <label for="exhibitModel">3D Model</label>
                        <input type="text" class="form-control" id="exhibitModel" name="exhibitModel" placeholder="Enter 3D Model URL" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="addExhibit" class="btn btn-dark">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        function openModal(modalId) {
            const openModalButton = document.querySelector(`[data-bs-target='${modalId}']`);
            const modal = new bootstrap.Modal(document.querySelector(modalId));

            openModalButton.addEventListener("click", function () {
                modal.show();
            });
        }

        openModal("#addExhibitModal");
        openModal("#viewExhibitModal");
        openModal("#editExhibitModal");
    });
</script>
