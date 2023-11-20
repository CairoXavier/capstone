<?php
    $pageTitle = "Staff List";
    include 'header.php';
    include 'db_connect.php';
    include 'navbar.php';

    $q  = "SELECT * FROM staff WHERE role = 'staff' ";
    $r = mysqli_query($conn, $q);

    if($r){
        $row    = mysqli_fetch_assoc($r);
        $id         = $row['id'];
        $firstName  = $row['firstName'];
        $lastName   = $row['lastName'];
        $contactnum = $row['contactNumber'];
        $username   = $row['username'];
        $password   = $row['password'];
    }
?>

<div class="container w-50 my-3">
    <h1 class="text-start mt-4">Staff List</h1> 
    <div class="container text-end">
        <button type="button" class="btn btn-dark mb-2" id="openAddStafftModal" data-bs-toggle="modal" data-bs-target="#addStaffModal">
            Add Staff
        </button>
        <a role="button" class="btn btn-secondary mb-2">Close</a>
    </div>

    
    <table class="table table-hover text-center">
        <thead>
        <tr>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Action</th>
        </tr>
        </thead>

        <tbody>
        <?php
            $q  = "SELECT * FROM staff WHERE role = 'staff' ";
            $r = mysqli_query($conn, $q);
            
            while($row = mysqli_fetch_assoc($r)){
                $id         = $row['id'];
                $firstName  = $row['firstName'];
                $lastName   = $row['lastName'];
                ?>

                <tr>
                    <td><?php echo $firstName; ?></td>
                    <td><?php echo $lastName; ?></td>
                    <td>
                        <button type="button" class="btn btn-dark mb-2" id="openViewStaffModal" data-bs-toggle="modal" data-bs-target="#viewStaffModal">
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

<!-- VIEW -->
<div class="modal fade" id="viewStaffModal" tabindex="-1" role="dialog" aria-labelledby="viewStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewStaffModalLabel">Staff</h5>
            </div>
            <form action="functions.php" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="staffID">
                            Staff ID
                        </label>
                        <input type="text" class="form-control" id="staffID" name="staffID" value="<?php echo $id ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                        <label for="staffFirstName">
                            First Name
                        </label>
                        <input type="text" class="form-control" id="staffFirstName" name="staffFirstName" value="<?php echo $firstName ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="staffLastName">
                            Last Name
                        </label>
                        <input type="text" class="form-control" id="staffLastName" name="staffLastName" value="<?php echo $lastName ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="staffContactNumber">
                            Contact Number
                        </label>
                        <input type="number" class="form-control" id="staffContactNumber" name="staffContactNumber" value="<?php echo $contactnum ?>"  readonlyrequired>
                    </div>
                    <div class="form-group">
                        <label for="staffUsername">
                            Username
                        </label>
                        <input type="text" class="form-control" id="staffUsername" name="staffUsername" value="<?php echo $username ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="staffPassword">
                            Password
                        </label>
                        <input type="text" class="form-control" id="staffPassword" name="staffPassword" value="<?php echo $password ?>" readonly required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark mb-2" id="openEditStaffModal" data-bs-toggle="modal" data-bs-target="#editStaffModal">
                        Edit
                    </button>
                    <a class="btn btn-dark btn-sm" href="functions.php?action=deleteStaff&id=<?php echo $id ?>" role="button">
                        Delete
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT -->
<div class="modal fade" id="editStaffModal" tabindex="-1" role="dialog" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStaffModalLabel">Edit Staff</h5>
            </div>
            <form action="functions.php" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                        <label for="staffFirstName">First Name</label>
                        <input type="text" class="form-control" id="staffFirstName" name="staffFirstName" value="<?php echo $firstName ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="staffLastName">Last Name</label>
                        <input type="text" class="form-control" id="staffLastName" name="staffLastName" value="<?php echo $lastName ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="staffContactNumber">Contact Number</label>
                        <input type="number" class="form-control" id="staffContactNumber" name="staffContactNumber" value="<?php echo $contactnum ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="staffUsername">Username</label>
                        <input type="text" class="form-control" id="staffUsername" name="staffUsername" value="<?php echo $username ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="staffPassword">Password</label>
                        <input type="text" class="form-control" id="staffPassword" name="staffPassword" value="<?php echo $password ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="editStaff" class="btn btn-dark">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ADD -->
<div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStaffModalLabel">Add Staff</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="functions.php" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="staffFirstName">First Name</label>
                        <input type="text" class="form-control" id="staffFirstName" name="staffFirstName" required>
                    </div>
                    <div class="form-group">
                        <label for="staffLastName">Last Name</label>
                        <input type="text" class="form-control" id="staffLastName" name="staffLastName" required>
                    </div>
                    <div class="form-group">
                        <label for="staffContactNumber">Contact Number</label>
                        <input type="number" class="form-control" id="staffContactNumber" name="staffContactNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="staffUsername">Username</label>
                        <input type="text" class="form-control" id="staffUsername" name="staffUsername" required>
                    </div>
                    <div class="form-group">
                        <label for="staffPassword">Password</label>
                        <input type="text" class="form-control" id="staffPassword" name="staffPassword" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="addStaff" class="btn btn-dark">Add</button>
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

        openModal("#addStaffModal");
        openModal("#viewStaffModal");
        openModal("#editStaffModal");
    });
</script>