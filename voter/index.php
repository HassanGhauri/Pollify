<?php 
    require_once("include/header.php");
    require_once("include/navigation.php");
?>

<div class="container">
            <div class="heading">
                <h2>Voter Panel</h2>
            </div>
</div>

<div class="addElection">
        <?php
        $fetchingActiveElections = mysqli_query($conn, "SELECT * FROM elections WHERE status = 'Active'") or die(mysqli_error($conn));
        $totalActiveElections = mysqli_num_rows($fetchingActiveElections);

        if($totalActiveElections > 0)
        {
            while($data = mysqli_fetch_assoc($fetchingActiveElections))
                    {
                        $election_id = $data['id'];
                        $election_topic = $data['electiontopic'];    
                ?>
            

            <h2> Election Topic: <?php echo $election_topic; ?></h2>

            <div class="table" style="overflow-x:auto;">
            <table>
                <thead>
                    
                <tr>
                <th>Photo</th>
                <th>Candidate Details</th>
                <th>No. of Votes</th>
                <th>Action</th>
                </tr>

                </thead>
                <tbody>
                <tbody>
                            <?php 
                                $fetchingCandidates = mysqli_query($conn, "SELECT * FROM candidates WHERE electionid = '". $election_id ."'") or die(mysqli_error($conn));

                                while($candidateData = mysqli_fetch_assoc($fetchingCandidates))
                                {
                                    $candidate_id = $candidateData['id'];
                                    $candidate_photo = $candidateData['candidatephoto'];

                                    // Fetching Candidate Votes 
                                    $fetchingVotes = mysqli_query($conn, "SELECT * FROM votes WHERE candidateid = '". $candidate_id . "'") or die(mysqli_error($conn));
                                    $totalVotes = mysqli_num_rows($fetchingVotes);

                            ?>
                                    <tr>
                                        <td> <img src="<?php echo $candidate_photo; ?>" class="candidate_photo"> </td>
                                        <td><?php echo "<b>" . $candidateData['candidatename'] . "</b><br />" . $candidateData['candidatedetails']; ?></td>
                                        <td><?php echo $totalVotes; ?></td>
                                        <td>
                                    <?php
                                            $checkIfVoteCasted = mysqli_query($conn, "SELECT * FROM votes WHERE voterid = '". $_SESSION['userID'] ."' AND electionid = '". $election_id ."'") or die(mysqli_error($conn));    
                                            $isVoteCasted = mysqli_num_rows($checkIfVoteCasted);

                                            if($isVoteCasted > 0)
                                            {
                                                $voteCastedData = mysqli_fetch_assoc($checkIfVoteCasted);
                                                $voteCastedToCandidate = $voteCastedData['candidateid'];

                                                if($voteCastedToCandidate == $candidate_id)
                                                {
                                    ?>

                                                        <h4 class="voted"><i class="ri-check-line"></i> </h4>
                                    <?php
                                                }
                                            }else {
                                    ?>
                                                <button class="votebtn" onclick="CastVote(<?php echo $election_id; ?>, <?php echo $candidate_id; ?>, <?php echo $_SESSION['userID']; ?>)"> Vote </button>
                                    <?php
                                            }

                                            
                                    ?>


                                    </td>
                                    </tr>
                            <?php
                                }
                            ?>
                            </tbody>

                        </table>
                        </div>
                <?php
                    
                    }
                }
        ?>
        <?php
        
        ?>


    
      

</div>


<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<!-- ajax function for voting-->
<script>
    const CastVote = (election_id, customer_id, voters_id) => 
    {
        $.ajax({
            type: "POST", 
            url: "include/ajaxCalls.php",
            data: "e_id=" + election_id + "&c_id=" + customer_id + "&v_id=" + voters_id, 
            success: function(response) {
                console.log(response);
                if(response == "Success")
                {
                    location.assign("index.php?voteCasted=1");
                }else {
                    location.assign("index.php?voteNotCasted=1");
                }
            }
        });
    }

</script>



<?php
    require_once("include/footer.php");
?>
