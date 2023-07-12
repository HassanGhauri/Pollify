<?php
    $ETopic = "";
    $NOC    = "";
    $DOS    = "";
    $DOE    = "";

    require_once("database.php");

    if (isset($_GET['editelection'])){
        $id = mysqli_real_escape_string($conn,$_GET['editelection']);
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

            $sql = "UPDATE elections SET electiontopic = '$ETopic', noofcandidates = '$NOC', startdate = '$DOS', enddate = '$DOE', status = '$status', insertedby = '$InsertedBy' WHERE id = '$id'";
            mysqli_query($conn,$sql);
            $success = "Election edited successfully.";
            $ETopic = "";
            $NOC    = "";
            $DOS    = "";
            $DOE    = "";   
    
        }
        
    }
?>
        
<div class="container">
    <div class="heading">
        <h2>Editing the elections</h2>
    </div>
    </div>
        

      <div class="addElection">  
          <h2>Add New Election</h2>
      <div class="center">
      
        <h2><?php echo 'Edit The Election: '.$id?></h2>


            <form method="post">
                <div class="txt_field">
                <input type="text" name="ETopic" value="<?php echo $ETopic;?>" required />
                <span class="in"></span>
                <label>Election Topic</label>
                </div>
                <div class="txt_field">
                <input type="number" name="NOC" value="<?php echo $NOC;?>" required/>
                <span class="in"></span>
                <label>No of Candidates</label>
                </div>
                <div class="txt_field">
                <input type="text" onfocus="this.type='date'" name="DOS" value="<?php echo $DOS;?>" required/>
                <span class="in"></span>
                <label>Start Date</label>
                </div>
                <div class="txt_field">
                <input type="text" onfocus="this.type='date'" name="DOE" value="<?php echo $DOE;?>" required/>
                <span class="in"></span>
                <label>End Date</label>
                </div>
                <input type="submit" value="Edit Election" name="addElection" required/>
            </form>
        </div>
        </div>
        <div class="errors">
            <div class="error"><?php if(isset($error)) echo $error;?></div>
            <div class="success"><?php if(isset($success)){ echo $success; }?></div>
            
            </div>
