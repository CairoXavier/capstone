<?php
    require './class/class_staff.php';
    $classStaff  = new Staff;
    session_start();

    if (isset($_POST['login'])) {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $result = $classStaff->login($username, $password);

            if ($result) {
                $_SESSION['user_authenticated'] = true;
                $_SESSION['user_role'] = $result;
                $_SESSION['username'] = $username;

                header("Location: index.php");
                exit();
            } else {
                echo "<script>alert('Invalid login details');window.location.href='login.php';</script>";
            }
        }
    }  elseif (isset($_POST['addExhibit'])){
        $exhibitName        = $_POST['exhibitName'];
        $exhibitInformation = $_POST['exhibitInformation'];
        $exhibitModel       = $_POST['exhibitModel'];
        

        $result = $classStaff->addExhibit($exhibitName, $exhibitInformation, $exhibitModel);

        if ($result){
            header("Location: exhibits.php");
            exit();
        } else {
            echo "error";
        }
    } elseif (isset($_POST['editExhibit'])){
        $exhibitCode        = $_POST['exhibitCode'];
        $exhibitName        = $_POST['exhibitName'];
        $exhibitInformation = $_POST['exhibitInformation'];
        $exhibitModel       = $_POST['exhibitModel'];
        $exhibitStatus      = $_POST['exhibitStatus'];

        $result = $classStaff->editExhibit($exhibitCode, $exhibitName, $exhibitInformation, $exhibitModel, $exhibitStatus);

        if ($result){
            header("Location: exhibits.php");
            exit();
        } else {
            echo "error";
        }
    } elseif (isset($_POST['addStaff'])){
        $staffFirstName     = $_POST['staffFirstName'];
        $staffLastName      = $_POST['staffLastName'];
        $staffContactNumber = $_POST['staffContactNo'];
        $staffUsername      = $_POST['staffUsername'];
        $staffPassword      = $_POST['staffPassword'];

        $result = $classStaff->addStaff($staffFirstName, $staffLastName, $staffContactNumber, $staffUsername, $staffPassword);

        if ($result){
            header("Location: staff-list.php");
            exit();
        } else {
            echo "error";
        }
    } elseif (isset($_POST['editStaff'])){
        $staffID            = $_POST['staffID'];
        $staffUsername      = $_POST['staffUsername'];
        $staffPassword      = $_POST['staffPassword'];
        $staffStatus        = $_POST['staffStatus'];

        $result = $classStaff->editStaff($staffID, $staffUsername, $staffPassword, $staffStatus);

        if ($result){
            header("Location: staff-list.php");
            exit();
        } else {
            echo "error";
        }
    } elseif (isset($_POST['editProfile'])){
        $ID            = $_POST['ID'];
        $firstName     = $_POST['firstName'];
        $lastName      = $_POST['lastName'];
        $contactNumber = $_POST['contactNumber'];
        $username      = $_POST['username'];
        $password      = $_POST['password'];

        $result = $classStaff->editProfile($ID, $firstName, $lastName, $contactNumber, $username, $password);

        if ($result){
            header("Location: profile.php");
            exit();
        } else {
            echo "error";
        }
    } elseif (isset($_GET['action']) && $_GET['action'] === 'deleteStaff' && isset($_GET['id']))  {
        $id     = $_GET['id'];

        $result = $classStaff->deleteStaff($id);

        if($result){
            header("Location: staff-list.php");
        } else {
            echo "error";
        }
    } elseif(isset($_POST['addEstablishment'])){
        $establishmentName  = $_POST['establishmentName'];
        $result             = $classStaff->addEstablishment($establishmentName);

        if ($result){
            header("Location: establishment.php");
        } else{
            echo "error";
        }
    } elseif (isset($_POST['editEstablishment'])){
        $establishmentCode        = $_POST['establishmentCode'];
        $establishmentName        = $_POST['establishmentName'];
        $establishmentStatus      = $_POST['establishmentStatus'];

        $result = $classStaff->editEstablishment($establishmentCode, $establishmentName, $establishmentStatus);

        if ($result){
            header("Location: establishment.php");
            exit();
        } else {
            echo "error";
        }
    } elseif (isset($_POST['addGallery'])){
        $establishmentCode= $_POST['establishmentCode'];
        $galleryName      = $_POST['galleryName'];
        $result           = $classStaff->addGallery($establishmentCode, $galleryName);

        if($result){
            header("Location: gallery.php");
        } else {
            echo "error";
        }
    } elseif (isset($_POST['editGallery'])){
        $galleryCode        = $_POST['galleryCode'];
        $establishmentCode  = $_POST['establishmentCode'];
        $galleryName        = $_POST['galleryName'];
        $galleryStatus      = $_POST['galleryStatus'];

        $result = $classStaff->editGallery($galleryCode, $establishmentCode, $galleryName, $galleryStatus);

        if ($result){
            header("Location: gallery.php");
            exit();
        } else {
            echo "error";
        }
    } elseif (isset($_POST['addRacking'])){
        $galleryCode    = $_POST['galleryCode'];
        $rackingName    = $_POST['rackingName'];
        $result         = $classStaff->addRacking($galleryCode, $rackingName);

        if($result){
            header("Location: racking.php");
        } else {
            echo "error";
        }
    } elseif (isset($_POST['editRacking'])){
        $rackingCode        = $_POST['rackingCode'];
        $galleryCode        = $_POST['galleryCode'];
        $rackingName        = $_POST['rackingName'];
        $rackingStatus      = $_POST['rackingStatus'];

        $result = $classStaff->editRacking($rackingCode, $galleryCode, $rackingName, $rackingStatus);

        if ($result){
            header("Location: racking.php");
            exit();
        } else {
            echo "error";
        }
    } elseif (isset($_POST['getEstablishments'])) {
        $options = '';
        
        $q = "SELECT establishmentCode, establishmentName FROM establishment";
        $r = mysqli_query($conn, $q);

        while ($row = mysqli_fetch_assoc($r)) {
            $options .= "<option value='{$row['establishmentCode']}'>{$row['establishmentName']}</option>";
        }
        echo $options;
        exit; 
    } elseif (isset($_POST['getGalleries']) && isset($_POST['establishmentCode'])) {
        $establishmentCode = $_POST['establishmentCode'];
        $options = '';

        $q = "SELECT galleryCode, galleryName FROM gallery WHERE establishmentCode = '$establishmentCode'";
        $r = mysqli_query($conn, $q);

        while ($row = mysqli_fetch_assoc($r)) {
            $options .= "<option value='{$row['galleryCode']}'>{$row['galleryName']}</option>";
        }
        echo $options;
        exit;
    } elseif (isset($_POST['getRackings']) && isset($_POST['galleryCode'])) {
        $galleryCode = $_POST['galleryCode'];
        $options = '';

        $q = "SELECT rackingCode, rackingName FROM racking WHERE galleryCode = '$galleryCode'";
        $r = mysqli_query($conn, $q);

        while ($row = mysqli_fetch_assoc($r)) {
            $options .= "<option value='{$row['rackingCode']}'>{$row['rackingName']}</option>";
        }
        echo $options;
        exit; 
    } elseif (isset($_POST['addAccession'])){
        $exhibitID          = $_POST['exhibitID'];
        $establishmentCode  = $_POST['establishmentCode'];
        $galleryCode        = $_POST['galleryCode'];
        $rackingCode        = $_POST['rackingCode'];
        $date               = $_POST['date'];
        $staffID            = $_POST['staffID'];

        $result             = $classStaff->addAccession($exhibitID, $establishmentCode, $galleryCode, $rackingCode, $date, $staffID);

        if($result){
            header("Location: accession.php");
        } else {
            echo "error";
        }
    } elseif (isset($_POST['confirmPostAccession'])){
        $accessionCode = $_POST['accessionCode'];

        $result        = $classStaff->confirmPost($accessionCode);

        if($result){
            header("Location: accession.php");
        } else {
            echo "error";
        }
    } elseif (isset($_POST['addTransfer'])){
        $exhibitID          = $_POST['exhibitID'];
        $establishmentCode  = $_POST['establishmentCode'];
        $galleryCode        = $_POST['galleryCode'];
        $rackingCode        = $_POST['rackingCode'];
        $date               = $_POST['date'];
        $staffID            = $_POST['staffID'];

        $result             = $classStaff->addTransfer($exhibitID, $establishmentCode, $galleryCode, $rackingCode, $date, $staffID);

        if($result){
            header("Location: transfer.php");
        } else {
            echo "error";
        }
    } 