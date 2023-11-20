<?php
    $pageTitle = "Web-AR";
    include 'header.php';
    include 'navbar.php';
    session_start();
    
    require_once('vendor/autoload.php');
    
    $clientID = "47852619874-gd8grjpupi6v2824afhlvm45mtbu8kvp.apps.googleusercontent.com";
    $secret = "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";
    
    // Google API Client
    $gclient = new Google_Client();
    
    $gclient->setClientId($clientID);
    $gclient->setClientSecret($secret);
    $gclient->setRedirectUri('http://localhost/capstone/index.php');
    
    $gclient->addScope('email');
    $gclient->addScope('profile');
    
    if(isset($_GET['code'])){
        $token = $gclient->fetchAccessTokenWithAuthCode($_GET['code']);
    
        if(!isset($token['error'])){
            $gclient->setAccessToken($token['access_token']);
    
            $_SESSION['access_token'] = $token['access_token'];
    
            $gservice = new Google_Service_Oauth2($gclient);
    
            $udata = $gservice->userinfo->get();
            foreach($udata as $k => $v){
                $_SESSION['login_'.$k] = $v;
            }
            $_SESSION['ucode'] = $_GET['code'];
            $_SESSION['user_email'] = $udata->email;
            header('location: feedback.php');
            exit;
        }
    }
?>
<style>
    model-viewer {
        width: 100%;
        height: 100%;
        margin: 0px;
    }
    .exhibit-box {
        cursor: pointer;
        width: 100%;
        max-width: 300px;
    }
    
    #exhibitModal .modal-body img {
        max-width: 100%; 
        max-height: 300px; 
        width: auto; 
        height: auto; 
    }
</style>

<!-- buttons -->
<div class="container mt-1 text-center">
    <a href="feedback.php" type="button" class="btn btn-dark">
        Send Feedback 
    </a>
    <a href="<?= $gclient->createAuthUrl() ?>" class="btn btn btn-secondary">Login with Google</a>
</div>

<!-- exhibit boxes -->
<div class="container w-50 mt-5">
    <div class="row">
        <?php
        $conn = new mysqli("localhost", "root", "", "webar");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM exhibits";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Define local .glb file URL for each exhibit
                $modelURL = 'models/' . $row['exhibitName'] . '.glb';

                echo '<div class="col-md-4 mb-4 exhibit-box" data-toggle="modal" data-target="#exhibitModal" data-exhibitName="' . $row["exhibitName"] . '" data-exhibitInformation="' . $row["exhibitInformation"] . '" data-exhibitModel="' . $row["exhibitModel"] . '" data-exhibitCode="' . $row["exhibitCode"] . '">';
                echo '<div class="card">';
                echo '<div class="card-body text-center">';
                echo '<h5 class="card-title">' . $row["exhibitName"] . '</h5>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "0 results found";
        }
        $conn->close();
        ?>
    </div>
</div>

<!-- Exhibit Modal -->
<div class="modal fade" id="exhibitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Exhibit Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                    <model-viewer 
                    id="modal-3d-viewer"
                    ar 
                    camera-controls 
                    touch-action="pan-y"
                    ></model-viewer>
                    </div>
                    <div class="col-md-8 text-right">
                        <h2 id="modal-exhibit-name"></h2>
                        <p id="modal-exhibit-information"></p>
                        <button id="view-3d-model-btn" class="btn btn-primary">View 3D Model</button>
                        <button id="scan-3d-model-btn" class="btn btn-secondary ml-2">Scan</button>
                        <div class="form-group">
                            <label for="rating">Rate this exhibit:</label>
                            <select class="form-control" ID="rating" exhibitName="rating">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- JavaScript to handle modal content -->
<script>
    $('.exhibit-box').click(function() {
        var exhibitName = $(this).data('exhibitname');
        var exhibitInformation = $(this).data('exhibitinformation');
        var exhibitCode = $(this).data('exhibitcode');
        var exhibitModel = $(this).data('exhibitmodel');
        var modal = $('#exhibitModal');
        modal.find('#modal-exhibit-name').text(exhibitName);
        modal.find('#modal-exhibit-information').text(exhibitInformation);
        modal.find('#modal-3d-viewer').attr('src', 'models/' + exhibitName + '.glb');
        modal.find('#modal-3d-viewer').attr('ios-src', 'models/' + exhibitName + '.usdz');


        // Dynamically set the model URL for the viewer
        var viewer = document.getElementById('modal-3d-viewer');
        viewer.setAttribute('src', 'models/' + exhibitName + '.glb');
    });
</script>

<script>
    // Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get the "Scan 3D Model" button by its id
    var scan3DModelButton = document.getElementById('scan-3d-model-btn');

    // Add a click event listener to the button
    scan3DModelButton.addEventListener('click', function() {
        // Get the exhibitName from the currently selected exhibit
        var exhibitName = $('#exhibitModal').find('#modal-exhibit-name').text();

        // Log the exhibitName to the console for debugging
        console.log('Exhibit Name:', exhibitName);

        // Redirect to scan.php with the exhibitName as a query parameter
        window.location.href = 'scan.php?exhibitName=' + encodeURIComponent(exhibitName);
    });
});

</script>

<script>
    // Wait for the DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Get the "View 3D Model" button by its id
        var view3DModelButton = document.getElementById('view-3d-model-btn');

        // Add a click event listener to the button
        view3DModelButton.addEventListener('click', function() {
            // Get the selected exhibitName from the modal
            var exhibitName = $('#exhibitModal').find('#modal-exhibit-name').text();

            // Redirect to modelviewer.php with the exhibitName parameter
            window.location.href = 'modelviewer.php?exhibitName=' + encodeURIComponent(exhibitName);
        });
    });
</script>

<script>
    $('.exhibit-box').click(function() {
        var exhibitName = $(this).data('exhibitname');
        var exhibitInformation = $(this).data('exhibitinformation');
        var exhibitCode = $(this).data('exhibitcode');
        var modal = $('#exhibitModal');

        modal.find('#modal-exhibit-name').text(exhibitName);
        modal.find('#modal-exhibit-information').text(exhibitInformation);

        // Star rating interaction
        $('.star').click(function() {
            var rating = $(this).data('rating');

            $('.star').removeClass('selected');
            $(this).addClass('selected');

            $.ajax({
                type: 'POST',
                url: 'submit_rating.php', // PHP script to handle rating submission
                data: { exhibitCode: exhibitCode, rating: rating },
                success: function(response) {
                    console.log('Rating submitted successfully!');
                },
                error: function(xhr, status, error) {
                    console.error('Error submitting rating: ' + error);
                }
            });
        });
    });
</script>
