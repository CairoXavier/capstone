<?php
    require './db_connect.php';
    if (!class_exists('Staff')){
        class Staff {
            public function login($username, $password){
                $db = mysqli_connect('localhost', 'root', '', 'webar');
                $q  = "SELECT * FROM staff WHERE username = '$username' AND password = '$password'";
                $r  = mysqli_query($db, $q);

                if (mysqli_num_rows($r) > 0) {
                    $row = mysqli_fetch_assoc($r);
                    $role = $row['role'];
                    return $role;
                } else {
                    echo $db->error;
                }
            }

            public function addStaff($staffFirstName, $staffLastName, $staffContactNumber, $staffUsername, $staffPassword){
                $db = mysqli_connect('localhost', 'root', '', 'webar');
                $q  = "SELECT * FROM staff WHERE username = '$staffUsername'";
                $r  = mysqli_query($db, $q);
                
                if (mysqli_num_rows($r) > 0) {
                    echo "<script>alert('Username is already taken');window.location.href='../staff-list.php';</script>";
                } else {
                    $db = mysqli_connect('localhost', 'root', '', 'webar');
                    $q  = "INSERT INTO staff(firstName, lastName, contactNumber, username, password, role)
                           VALUES('$staffFirstName', '$staffLastName', '$staffContactNumber', '$staffUsername', '$staffPassword', 'staff')";
                    $r  = mysqli_query($db, $q);

                    if ($r){
                        return $db;
                    } else{
                        echo $db->error;
                    }
                }
            }
            
            public function editStaff($id, $staffFirstName, $staffLastName, $staffContactNumber, $staffUsername, $staffPassword){
                $db = mysqli_connect('localhost', 'root', '', 'webar');
                $q  = "UPDATE staff SET firstName = '$staffFirstName', lastName = '$staffLastName', contactNumber = '$staffContactNumber', username = '$staffUsername', password = '$staffPassword' WHERE id = $id";
                $r  = mysqli_query($db, $q);

                if ($r){
                    return $db;
                } else {
                    echo $db->error;
                }
            }

            public function deleteStaff($id){
                $db = mysqli_connect('localhost', 'root', '', 'webar');
                $q  = "DELETE FROM staff WHERE id = '$id'";
                $r  = mysqli_query($db, $q);

                if ($r){
                    return $db;
                } else $db->error;
            }
            
            public function addExhibit($exhibitName, $exhibitInformation, $exhibitModel){
                $db = mysqli_connect('localhost', 'root', '', 'webar');
                $q  = "INSERT INTO exhibits(name, information, model)
                       VALUES('$exhibitName', '$exhibitInformation', '$exhibitModel')";
                $r  = mysqli_query($db, $q);

                if ($r){
                    return $db;
                } else {
                    echo $db->error;
                }
            }

            public function editExhibit($id, $exhibitName, $exhibitInformation, $exhibitModel){
                $db = mysqli_connect('localhost', 'root', '', 'webar');
                $q  = "UPDATE exhibits SET name = '$exhibitName', information = '$exhibitInformation', model = '$exhibitModel' WHERE id = $id";
                $r  = mysqli_query($db, $q);

                if ($r){
                    return $db;
                } else {
                    echo $db->error;
                }
            }

            public function deleteExhibit($id){
                $db = mysqli_connect('localhost', 'root', '', 'webar');
                $q  = "DELETE FROM exhibits WHERE id = '$id'";
                $r  = mysqli_query($db, $q);

                if ($r){
                    return $db;
                } else $db->error;
            }
        }
    }