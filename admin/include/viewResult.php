<?php 
    $election_id = $_GET['viewResult'];
    function convertToOrdinal($number) {
        if ($number % 100 >= 11 && $number % 100 <= 13) {
            return $number . 'th';
        } else {
            switch ($number % 10) {
                case 1:
                    return $number . 'st';
                case 2:
                    return $number . 'nd';
                case 3:
                    return $number . 'rd';
                default:
                    return $number . 'th';
            }
        }
    }

?>


<div class="container">
        <div class="heading">
        <h2>Election Result</h2>
    
        </div>
</div>

        <div class="addElection">
        <?php
        $fetchingActiveElections = mysqli_query($conn, "SELECT * FROM elections WHERE id = '$election_id'") or die(mysqli_error($conn));
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
                <th>Rank</th>
                <th>Photo</th>
                <th>Candidate Details</th>
                <th>No. of Votes</th>
                </tr>

                </thead>
                <tbody>
                <tbody>
                <?php
                    $fetchingCandidates = mysqli_query($conn, "SELECT * FROM candidates WHERE electionid = '". $election_id ."'") or die(mysqli_error($conn));

                    $candidates = array(); // Array to store candidates and votes

                    while($candidateData = mysqli_fetch_assoc($fetchingCandidates)) {
                        $candidate_id = $candidateData['id'];
                        $candidate_photo = $candidateData['candidatephoto'];

                        // Fetching Candidate Votes
                        $fetchingVotes = mysqli_query($conn, "SELECT * FROM votes WHERE candidateid = '". $candidate_id . "'") or die(mysqli_error($conn));
                        $totalVotes = mysqli_num_rows($fetchingVotes);

                        $candidates[] = array(
                            'name' => $candidateData['candidatename'],
                            'details' => $candidateData['candidatedetails'],
                            'votes' => $totalVotes
                        );
                    }

                    // Sort candidates based on votes in descending order
                    usort($candidates, function($a, $b) {
                        return $b['votes'] - $a['votes'];
                    });

                    $rank = 1;

                    foreach ($candidates as $candidate) {
                        $candidate_name = $candidate['name'];
                        $candidate_details = $candidate['details'];
                        $candidate_votes = $candidate['votes'];

                        ?>
                        <tr>
                            <td class="rank"><?php echo convertToOrdinal($rank); ?></td>
                            <td><img src="<?php echo $candidate_photo; ?>" class="candidate_photo"></td>
                            <td><?php echo "<b>" . $candidate_name . "</b><br />" . $candidate_details; ?></td>
                            <td><?php echo $candidate_votes; ?></td>
                        </tr>
                        <?php

                        $rank++;
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


    
      

