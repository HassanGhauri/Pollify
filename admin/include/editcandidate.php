<?php
    $electionid = "";
    $candidatename ="";
    $candidatedetails ="";

    require_once("database.php");
    if (isset($_GET['editcandidate'])){
        $id = mysqli_real_escape_string($conn,$_GET['editcandidate']);
        if (isset($_POST["addCandidate"])){

            $electionid       = mysqli_real_escape_string($conn, $_POST['electionid']);
            $candidatename    = mysqli_real_escape_string($conn, $_POST['candidatename']);
            $candidatedetails = mysqli_real_escape_string($conn, $_POST['candidatedetails']);
            $insertedby       = $_SESSION['userName'];
    
            // Photograph Logic Starts
            $targetted_folder = "../assets/images/candidates/";
            $candidate_photo = $targetted_folder . rand(111111111, 99999999999) . "_" . rand(111111111, 99999999999) . $_FILES['candidatephoto']['name'];
            $candidate_photo_tmp_name = $_FILES['candidatephoto']['tmp_name'];
            $candidate_photo_type = strtolower(pathinfo($candidate_photo, PATHINFO_EXTENSION));
            $allowed_types = array("jpg", "png", "jpeg");        
            $image_size = $_FILES['candidatephoto']['size'];
    
            if($image_size < 2000000) // 2 MB
            {
                if(in_array($candidate_photo_type, $allowed_types))
                {
                    if(move_uploaded_file($candidate_photo_tmp_name, $candidate_photo))
                    {
                        // inserting into db
                        mysqli_query($conn, "UPDATE candidates SET electionid = '$electionid', candidatename = '$candidatename', candidatedetails = '$candidatedetails', candidatephoto = '$candidate_photo', insertedby = '$insertedby' WHERE id = '$id'") or die(mysqli_error($conn));
    
                        $success = "Candidate added successfully.";
                        $electionid = "";
                        $candidatename ="";
                        $candidatedetails ="";
    
    
                    }else {
                        $error = "Image uploading failed, please try again.";                    
                    }
                }else {
                    $error = "Invalid image type (Only .jpg, .png files are allowed) .";
                }
            }else {
                $error = "Candidate image is too large, please upload small file (you can upload any image upto 2mbs.).";
            }
    
    
    }
}

?>

<div class="container">
        <div class="heading">
        <h2>Editing the Candidates</h2>
    
        </div>
    
      </div>

      <div class="addElection">  
        <h2><?php echo 'Edit The Candidate: '.$id?></h2>
      <div class="center">
      <div class="errors">
            <div class="error"><?php if(isset($error)) echo $error; ?></div>
            <div class="success"><?php if(isset($success)){ echo $success; }?></div>
            
            </div>

      <form method="post" enctype="multipart/form-data">
                <div class="select" >              
                <select class="form-control" name="electionid" value="<?php echo $electionid; ?>" required> 
                    <option value=""> Select Election </option>
                    <?php 
                        $fetchingElections = mysqli_query($conn, "SELECT * FROM elections") OR die(mysqli_error($conn));
                        $isAnyElectionAdded = mysqli_num_rows($fetchingElections);
                        if($isAnyElectionAdded > 0)
                        {
                            while($row = mysqli_fetch_assoc($fetchingElections))
                            {
                                $election_id = $row['id'];
                                $election_name = $row['electiontopic'];
                                $allowed_candidates = $row['noofcandidates'];
                                
                                // Now checking how many candidates are added in this election 
                                $fetchingCandidate = mysqli_query($conn, "SELECT * FROM candidates WHERE electionid = '". $election_id ."'") or die(mysqli_error($conn));
                                $added_candidates = mysqli_num_rows($fetchingCandidate);
                                
                                

                                if($added_candidates < $allowed_candidates)
                                {
                        ?>
                                <option value="<?php echo $election_id; ?>"><?php echo $election_name; ?></option>
                        <?php
                                }
                            }
                        }else {
                    ?>
                            <option value=""> No elections available </option>
                    <?php
                        }
                    ?>
                </select>
                </div>
                <div class="txt_field">
                <input type="text" name="candidatename" value="<?php echo $candidatename; ?>" required/>
                <span class="in"></span>
                <label>Candidate Name</label>
                </div>
                
                <label>Candidate Photo</label>
                <input type="file" name="candidatephoto" class="form-control" required />

                <div class="txt_field">
                <input type="text" name="candidatedetails" value="<?php echo $candidatedetails; ?>" required/>
                <span class="in"></span>
                <label>Candidate Details</label>
                </div>
                <input type="submit" value="Add Candidate" name="addCandidate" required/>
            </form>
        </div>















