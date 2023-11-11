<?php
    $pageTitle = "Inventory";
    include '../header.php';
    include 'navbar.php';
    include '../db_connect.php';
    include 'l_nav.php';
?>
<div class="container w-50 my-3">
    <div class="container text-start text-muted fst-italic">
        Management of Gallery
    </div>
    <div class="container text-end">
        <button class="btn btn-dark mb-2" href="#" data-bs-toggle="modal" data-bs-target="#addGalleryModal" role="button">
            Add Gallery
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">From</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $q= "SELECT * FROM gallery";
                    $r = mysqli_query($conn, $q);

                    while ($row = mysqli_fetch_assoc($r)) {
                        $galleryCode        = $row['galleryCode'];
                        $galleryName        = $row['galleryName'];
                        $establishmentCode  = $row['establishmentCode'];
                        $galleryStatus      = $row['isActive'];

                        $statusText = ($galleryStatus == 1) ? "Active" : "Inactive";
                        ?>
                    <tr>
                        <td class="text-center"><?php echo $galleryCode; ?></td>
                        <td class="text-center"><?php echo $galleryName; ?></td>
                        <td class="text-center"><?php echo $establishmentCode ; ?></td>
                        <td class="text-center"><?php echo $statusText; ?></td>
                        <td>
                            <div class="text-center">
                                <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target="#editGalleryModal<?php echo $galleryCode; ?>">
                                    Edit
                                </button>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editGalleryModal<?php echo $galleryCode; ?>" tabindex="-1" aria-labelledby="editGalleryModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editGalleryModalLabel">Edit Gallery</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="functions.php" method="post">
                                                <input type="hidden" name="galleryCode" value="<?php echo $galleryCode; ?>">
                                                <div class="mb-3">
                                                    <label for="establishmentCode" class="form-label">Select Establishment</label>
                                                    <select class="form-select" id="establishmentCode" name="establishmentCode" required>
                                                        <?php
                                                            $establishmentQuery = "SELECT establishmentCode, establishmentName FROM establishment";
                                                            $establishmentResult = mysqli_query($conn, $establishmentQuery);

                                                            while ($establishmentRow = mysqli_fetch_assoc($establishmentResult)) {
                                                                $currentEstablishmentCode = $establishmentRow['establishmentCode'];
                                                                $currentEstablishmentName = $establishmentRow['establishmentName'];

                                                                $selected = ($currentEstablishmentCode == $establishmentCode) ? "selected" : "";

                                                                echo "<option value=\"$currentEstablishmentCode\" $selected>$currentEstablishmentName</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="galleryName" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="galleryName" name="galleryName" value="<?php echo $galleryName; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="galleryStatus" class="form-label">Status</label>
                                                    <select class="form-select" id="galleryStatus" name="galleryStatus">
                                                        <option value="1" <?php echo ($galleryStatus == 1) ? "selected" : ""; ?>>Active</option>
                                                        <option value="0" <?php echo ($galleryStatus == 0) ? "selected" : ""; ?>>Inactive</option>
                                                    </select>
                                                </div>
                                                <button type="submit" name="editGallery" class="btn btn-primary">Save changes</button>
                                            </form>
                                        </div>
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

<!-- Add Gallery Modal -->
<div class="modal fade" id="addGalleryModal" tabindex="-1" aria-labelledby="addGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addGalleryModalLabel">Add gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post">
                    <div class="mb-3">
                        <label for="establishmentCode" class="form-label">Select Establishment</label>
                        <select class="form-select" id="establishmentCode" name="establishmentCode" required>
                            <?php
                                $establishmentQuery = "SELECT establishmentCode, establishmentName FROM establishment";
                                $establishmentResult = mysqli_query($conn, $establishmentQuery);

                                while ($establishmentRow = mysqli_fetch_assoc($establishmentResult)) {
                                    $establishmentCode = $establishmentRow['establishmentCode'];
                                    $establishmentName = $establishmentRow['establishmentName'];

                                    echo "<option value=\"$establishmentCode\">$establishmentName</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="galleryName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="galleryName" name="galleryName" placeholder="Enter gallery name" required>
                    </div>
                    <button type="submit" name="addGallery" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>