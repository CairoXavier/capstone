<?php
    require './class/class_staff.php';
    $classStaff  = new Staff;

    require './class/class_user.php';
    $classUser   = new User;

    if (isset($_POST['login'])){
        if (isset($_POST['username']) && isset($_POST['password'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $result = $classStaff->login($username, $password);

            if ($result){
                if ($result == 'admin'){
                    header("Location: admin-main.php");
                    exit();
                } elseif ($result == 'staff'){
                    header("Location: staff-main.php");
                    exit();
                }
            }else {
                echo "<script>alert('Invalid login details');window.location.href='login.php';</script>";
            }
        }
    }  elseif (isset($_POST['addExhibit'])){
        $exhibitName        = $_POST['exhibitName'];
        $exhibitInformation = $_POST['exhibitInfo'];
        $exhibitModel       = $_POST['exhibitModel'];

        $result = $classStaff->addExhibit($exhibitName, $exhibitInformation, $exhibitModel);

        if ($result){
            header("Location: inventory.php");
            exit();
        } else {
            echo "error";
        }
    } elseif (isset($_POST['editExhibit'])){
        $id                 = $_POST['id'];
        $exhibitName        = $_POST['exhibitName'];
        $exhibitInformation = $_POST['exhibitInfo'];
        $exhibitModel       = $_POST['exhibitModel'];

        $result = $classStaff->editExhibit($id, $exhibitName, $exhibitInformation, $exhibitModel);

        if ($result){
            header("Location: inventory.php");
            exit();
        } else {
            echo "error";
        }
    } elseif (isset($_GET['action']) && $_GET['action'] === 'deleteExhibit' && isset($_GET['id'])) {
        $id     = $_GET['id'];

        $result = $classStaff->deleteExhibit($id);

        if ($result){
            header("Location: inventory.php");
        } else {
            echo "error";
        }
    }  elseif (isset($_POST['addStaff'])){
        $staffFirstName     = $_POST['staffFirstName'];
        $staffLastName      = $_POST['staffLastName'];
        $staffContactNumber = $_POST['staffContactNumber'];
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
        $id                 = $_POST['id'];
        $staffFirstName     = $_POST['staffFirstName'];
        $staffLastName      = $_POST['staffLastName'];
        $staffContactNumber = $_POST['staffContactNumber'];
        $staffUsername      = $_POST['staffUsername'];
        $staffPassword      = $_POST['staffPassword'];

        $result = $classStaff->editStaff($id, $staffFirstName, $staffLastName, $staffContactNumber, $staffUsername, $staffPassword);

        if ($result){
            header("Location: staff-list.php");
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
    } elseif (isset($_POST['sendFeedback'])){
        $userFeedback = $_POST['userFeedback'];
        $userEmail    = $_POST['userEmail'];
        $result       = $classUser->sendFeedback($userFeedback, $userEmail);
    
        if($result){
            header("Location: feedback.php"); 
            exit();
        } else {
            echo "error";
        }
    }