<div class="container">
        <div class="heading">
            <h2>Admin Panel | Home</h2>
    
        </div>
</div>
<div class="addElection">
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
                        <th>Action</th>
                        

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
                            <a href="index.php?viewResult=<?php echo $election_id; ?>" class="btn btn-sm btn-success"> View Result </a>
                            </td>
                        </tr>
            <?php
                    }

        
        ?>
        
        </tbody>
            </table>
        
        
        <?php
        }
        ?>


    
      </div>


