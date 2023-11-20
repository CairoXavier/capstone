<?php
    $exhibitName = isset($_GET['exhibitName']) ? $_GET['exhibitName'] : '';

    if (empty($exhibitName)) {
        header('Location: index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <script src="https://aframe.io/releases/1.3.0/aframe.min.js"></script>
    <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>
    <body style="margin : 0px; overflow: hidden;">
        <a-scene embedded arjs>
            <a-marker preset="hiro">
                <a-box position="0. 0 0"
                        gltf-model="models/<?php echo $exhibitName; ?>.glb"
                        scale="1 1 1"
                ></a-box>
            </a-marker>
            <a-entity camera></a-entity>
        </a-scene>
    </body>
</html>
