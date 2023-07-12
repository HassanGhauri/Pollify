<?php
$ETopic = "";
$NOC    = "";
$DOS    = "";
$DOE    = "";

?>

<?php

if (isset($_POST["addElection"])){

    $ETopic     = mysqli_real_escape_string($conn,$_POST["ETopic"]);
    $NOC        = mysqli_real_escape_string($conn,$_POST["NOC"]);
    $DOS        = mysqli_real_escape_string($conn,$_POST["DOS"]);
    $DOE        = mysqli_real_escape_string($conn,$_POST["DOE"]);
    $InsertedBy = $_SESSION["userName"];
    $InsertedOn = date("Y-m-d");


    $date1 = date_create($InsertedOn);
    $date2 = date_create($DOS);
    $diff  = date_diff($date1,$date2);

    if ($diff->format("%R%a") > 0){

        $status = "InActive";
    }else {
        $status = "Active";
    }

    mysqli_query($conn,"INSERT INTO `elections` (`electiontopic`, `noofcandidates`, `startdate`, `enddate`, `status`, `insertedby`) VALUES ('$ETopic', '$NOC', '$DOS', '$DOE', '$status', '$InsertedBy'); ") or die(mysqli_error($conn));
    $success = "Election added successfully.";
    $ETopic = "";
    $NOC    = "";
    $DOS    = "";
    $DOE    = "";



}

if(isset($_POST['delete'])){

    $id_to_delete = mysqli_real_escape_string($conn,$_POST['id_to_delete']);
    $sql = "DELETE FROM elections where id = $id_to_delete";

    if (mysqli_query($conn,$sql)) {
        
        header('index.php?addelectionpage=1');

    } else{ 
        echo 'query error: ' . mysqli_error($conn);
    }
}
?>


<div class="container">
        <div class="heading">
            <h2>Admin Panel | Add Election</h2>
    
        </div>
    
      </div>

      <div class="addElection">  
          <h2>Add New Election</h2>
      <div class="center">
      <div class="errors">
            <div class="error"><?php if(isset($error)) echo $error; ?></div>
            <div class="success"><?php if(isset($success)){ echo $success; }?></div>
            
            </div>

      <form method="post">
                <div class="txt_field">
                <input type="text" name="ETopic" value="<?php echo $ETopic; ?>" required />
                <span class="in"></span>
                <label>Election Topic</label>
                </div>
                <div class="txt_field">
                <input type="number" name="NOC" value="<?php echo $NOC; ?>" required/>
                <span class="in"></span>
                <label>No of Candidates</label>
                </div>
                <div class="txt_field">
                <input type="text" onfocus="this.type='date'" name="DOS" value="<?php echo $DOS; ?>" required/>
                <span class="in"></span>
                <label>Start Date</label>
                </div>
                <div class="txt_field">
                <input type="text" onfocus="this.type='date'" name="DOE" value="<?php echo $DOE; ?>" required/>
                <span class="in"></span>
                <label>End Date</label>
                </div>
                <input type="submit" value="Add Election" name="addElection" required/>
            </form>
        </div>

        <?php
        
        $fetchingData = mysqli_query($conn, "SELECT * FROM elections") or die(mysqli_error($conn)); 
        $isAnyElectionAdded = mysqli_num_rows($fetchingData);

        if($isAnyElectionAdded > 0)
        {
            ?>

            <h2>Upcoming/Ongoing Elections</h2>

            <div class="table" style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>No of Candidates</th>
                        <th>Starting On</th>
                        <th>Ending On</th>
                        <th>Status</th>
                        <th>Delete</th>
                        <th>Edit</th>

                    </tr>

                </thead>
                <tbody>
            <?php
            $sno = 1;
            while($row = mysqli_fetch_assoc($fetchingData))
                    {
                        $election_id = $row['id'];
            ?>
                        <tr>
                            <td><?php echo $sno++; ?></td>
                            <td><?php echo $row['electiontopic']; ?></td>
                            <td><?php echo $row['noofcandidates']; ?></td>
                            <td><?php echo $row['startdate']; ?></td>
                            <td><?php echo $row['enddate']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                
                                <form method="POST">
                                    <input type="hidden" name="id_to_delete" value="<?php echo $election_id; ?>">
                                    <input type="submit" name="delete" value="Delete" style = "border-radius:15px; color: white; font-style: italic; background-color: white;font-size: 15px; text-align: center;height: 26px;width: 56px;">
                                </form>
                                
                            </td> 
                            <td>
                                <!-- <form method="POST">
                                    <input type="hidden" name="id_to_edit" value="<?php echo $election_id; ?>">
                                    <input type="submit" name="edit" value="Edit" style="font-style: italic; color: white; font-size: 15px; height:25px; width: 50px;">
                                </form>-->
                                <a href="index.php?editelection=<?php echo $row['id'];?>" class="edit">Edit</a>
                             <!--   <a href="#" class="delete"> <i class="ri-delete-bin-6-line"></i> </a>-->
                                <!-- <button class="btn btn-sm btn-danger" onclick="DeleteData(<?php echo $election_id; ?>)"> Delete </button> -->
                            </td>
                        </tr>
            <?php } ?>
        
        </tbody>
            </table>

        <?php
        }
        ?>      
            </div>
            </div>
        
