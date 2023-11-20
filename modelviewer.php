<?php
    $pageTitle = "Web-AR";
    include 'header.php';
    include 'navbar.php';
    session_start();
    
    $exhibitName = isset($_GET['exhibitName']) ? $_GET['exhibitName'] : '';
  
    if (empty($exhibitName)) {
     
        header('Location: index.php');
        exit;
    }
?>

<style>
    model-viewer {
        width: 100%;
        height: 100%;
        margin: 0px;
    }
</style>

<model-viewer 
    id="model-3d-viewer"
    src="models/<?php echo $exhibitName; ?>.glb"
    ar 
    camera-controls 
    touch-action="pan-y"
></model-viewer>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- JavaScript to handle model content -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modelViewer = document.getElementById('model-3d-viewer');
        var modelPath = 'models/' + '<?php echo $exhibitName; ?>' + '.glb';
        console.log('Model Path:', modelPath);

        modelViewer.setAttribute('src', modelPath);
    });
</script>

<?php include 'footer.php'; ?>
