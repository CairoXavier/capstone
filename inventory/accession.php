<?php
    $pageTitle = "Inventory";
    include '../header.php';
    include 'navbar.php';
    include '../db_connect.php';
    include 'i_nav.php';
    
    $_SESSION['last_active_page'] = basename(__FILE__);

    if (isset($_SESSION['username'])) {
        $username    = $_SESSION['username'];
        $staffQuery  = "SELECT * FROM staff WHERE username = '$username'";
        $staffResult = mysqli_query($conn, $staffQuery);

        while($staffRow = mysqli_fetch_assoc($staffResult)){
            $staffID    = $staffRow['staffID'];

            $_SESSION['staffID'] = $staffID;
        }
    } else {
        header('Location: index.php');
        exit();
    }
?>
<div class="container w-50">
    <div class="container d-flex justify-content-between align-items-center text-muted fst-italic">
        <p class="text-muted fst-italic">Management of Exhibit Accession</p>
        
        <button class="btn btn-dark mb-2" data-bs-toggle="modal" data-bs-target="#addAccessionModal" role="button">
            <i class="fa-solid fa-plus"></i>
            <span class="ms-2">Add Accession</span>
        </button>
        
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Exhibit</th>
                    <th scope="col">Location<small class="d-block text-muted fst-italic">establishment - gallery - racking</small></th>
                    <th scope="col">Date</th>
                    <th scope="col">Staff</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $q = "SELECT accession.*, establishment.establishmentName, gallery.galleryName, racking.rackingName, exhibits.exhibitName
                    FROM accession 
                    LEFT JOIN establishment ON accession.establishmentCode = establishment.establishmentCode
                    LEFT JOIN gallery ON accession.galleryCode = gallery.galleryCode
                    LEFT JOIN racking ON accession.rackingCode = racking.rackingCode              
                    LEFT JOIN exhibits ON accession.exhibitID = exhibits.exhibitID";
                    $r = mysqli_query($conn, $q);

                    while ($row = mysqli_fetch_assoc($r)) {
                        $accessionCode        = $row['accessionCode'];
                        $establishmentName    = $row['establishmentName'];
                        $galleryName          = $row['galleryName'];
                        $rackingName          = $row['rackingName'];
                        $exhibitName          = $row['exhibitName'];
                        $staffID              = $row['staffID'];
                        $accessionDate        = $row['accessionDate'];
                        $posted               = $row['posted'];
                        

                        $postStatus = ($posted == 1) ? "Posted" : "Not Posted";
                        ?>
                    <tr>
                        <td class="text-center"><?php echo $accessionCode; ?></td>
                        <td class="text-center"><?php echo $exhibitName; ?></td>
                        <td class="text-center"><?php echo $establishmentName . ' - ' . $galleryName . ' - ' . $rackingName; ?></td>
                        <td class="text-center"><?php echo $accessionDate; ?></td>
                        <td class="text-center"><?php echo $staffID; ?></td>
                        <td class="text-center"><?php echo $postStatus; ?></td>
                        <td>
                            <div class="text-center">
                                <?php if ($postStatus == "Not Posted") { ?>
                                    <button type="button" class="btn btn-dark mb-2" data-bs-toggle="modal" data-bs-target="#postConfirmationModal<?php echo $accessionCode; ?>">
                                        <i class="fa-solid fa-arrow-up"></i>
                                        <span class="ms-2">Post</span>
                                    </button>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-dark mb-2" disabled>
                                        <i class="fa-solid fa-check"></i>
                                        <span class="ms-2">Posted</span>
                                    </button>
                                <?php } ?>
                            </div>

                            <!-- Post Confirmation Modal -->
                            <div class="modal fade" id="postConfirmationModal<?php echo $accessionCode; ?>" tabindex="-1" aria-labelledby="postConfirmationModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="postConfirmationModalLabel">Post Accession</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="functions.php" method="post">
                                            <input type="hidden" name="accessionCode" value="<?php echo $accessionCode; ?>">
                                            <div class="modal-body">
                                                <p>Are you sure you want to post this Accession?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success" name="confirmPostAccession">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Accession Modal -->
<div class="modal fade" id="addAccessionModal" tabindex="-1" aria-labelledby="addAccessionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAccessionModalLabel">Exhibit Accession</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post">
                    <div class="mb-3">
                        <label for="exhibitID" class="form-label">Exhibit</label>
                        <select class="form-select" id="exhibitID" name="exhibitID" required>
                            <?php
                                $exhibitsQuery = "SELECT exhibitID, exhibitName FROM exhibits WHERE isActive = 1";
                                $exhibitsResult = mysqli_query($conn, $exhibitsQuery);

                                while ($exhibitsRow = mysqli_fetch_assoc($exhibitsResult)) {
                                    $exhibitID   = $exhibitsRow['exhibitID'];
                                    $exhibitName = $exhibitsRow['exhibitName'];

                                    echo "<option value=\"$exhibitID\">$exhibitName</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="establishment">Establishment</label>
                        <select class="form-control" id="establishment" name="establishment" required>
                            <option value=""></option>
                        </select>
                    </div>
                    <input type="hidden" id="establishmentCode" name="establishmentCode">

                    <div class="mb-3">
                        <label for="gallery">Gallery</label>
                        <select class="form-control" id="gallery" name="gallery" required disabled>
                            <option value=""></option>
                        </select>
                    </div>
                    <input type="hidden" id="galleryCode" name="galleryCode">

                    <div class="mb-3">
                        <label for="racking">Racking</label>
                        <select class="form-control" id="racking" name="racking" required disabled>
                            <option value=""></option>
                        </select>
                    </div>
                    <input type="hidden" id="rackingCode" name="rackingCode">

                    <div class="mb-3">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>

                    <input type="hidden" name="staffID" value="<?php echo $_SESSION['staffID']; ?>">
                    <div class="text-end">
                        <button type="submit" name="addAccession" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#establishment").html('<option value="">Select Establishment</option>');
        $("#gallery").html('<option value="">Select Gallery</option>');
        $("#racking").html('<option value="">Select Racking</option>');

        $.ajax({
            url: "functions.php",
            method: "POST",
            data: { getEstablishments: true },
            success: function(data) {
                $("#establishment").append(data);
            }
        });

        $("#establishment").on("change", function() {
            var establishmentCode = $(this).val();
            $("#establishmentCode").val(establishmentCode);

            if (establishmentCode){
                $("#gallery").html('<option value="">Select Gallery</option>');
                $("#racking").html('<option value="">Select Racking</option>');

                $("#gallery").prop("disabled", false);

                $.ajax({
                    url: "functions.php",
                    method: "POST",
                    data: { getGalleries: true, establishmentCode: establishmentCode },
                    success: function(data) {
                        $("#gallery").append(data);
                    }
                });
            }
        });

        $("#gallery").on("change", function() {
            var galleryCode = $(this).val();
            $("#galleryCode").val(galleryCode);

            if (galleryCode){
                $("#racking").html('<option value="">Select Racking</option>');
                $("#racking").prop("disabled", false);

                $.ajax({
                    url: "functions.php",
                    method: "POST",
                    data: { getRackings: true, galleryCode: galleryCode },
                    success: function(data) {
                        $("#racking").append(data);
                    }
                });
            }
        });

        $("#racking").on("change", function() {
            var rackingCode = $(this).val();
            $("#rackingCode").val(rackingCode);
        });
    });
</script>