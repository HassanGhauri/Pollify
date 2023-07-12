<?php 
    require_once("../../admin/include/database.php");
    echo "<script>console.log('Hello')</script>";

    if(isset($_POST['e_id']) AND isset($_POST['c_id']) AND isset($_POST['v_id']))
    {
    
        echo "<script>console.log('Hello')</script>";
        mysqli_query($conn, "INSERT INTO votes (electionid, voterid, candidateid) VALUES('". $_POST['e_id'] ."', '". $_POST['v_id'] ."','". $_POST['c_id'] ."')") or die(mysqli_error($conn));

        echo "Success";
    }

?>