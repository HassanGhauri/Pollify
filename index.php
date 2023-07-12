<?php

require_once("admin/include/database.php");

    $fetchingElections = mysqli_query($conn, "SELECT * FROM elections") OR die(mysqli_error($conn));
    while($data = mysqli_fetch_assoc($fetchingElections))
    {
        $stating_date = $data['startdate'];
        $ending_date = $data['enddate'];
        $curr_date = date("Y-m-d");
        $election_id = $data['id'];
        $status = $data['status'];

        // Active = Expire = Ending Date
        // InActive = Active = Starting Date

        if($status == "Active")
        {
            $date1=date_create($curr_date);
            $date2=date_create($ending_date);
            $diff=date_diff($date1,$date2);
            
            if((int)$diff->format("%R%a") < 0)
            {
                // Update! 
                mysqli_query($conn, "UPDATE elections SET status = 'Expired' WHERE id = '". $election_id ."'") OR die(mysqli_error($conn));
            }
        }else if($status == "InActive")
        {
            $date1=date_create($curr_date);
            $date2=date_create($stating_date);
            $diff=date_diff($date1,$date2);
            

            if((int)$diff->format("%R%a") <= 0)
            {
                // Update! 
                mysqli_query($conn, "UPDATE elections SET status = 'Active' WHERE id = '". $election_id ."'") OR die(mysqli_error($conn));
            }
        }
        

    }
?>



<?php
if (!isset($_POST["signup"])){

    $fullname = "";
    $username = "";
    $email = "";
    $password = "";
    $retypepassword = "";
    
}elseif (!isset($_POST["login"])){
    $email = "";
}
?>
<?php

require_once("admin/include/database.php");

if (isset($_POST["signup"])){

    $fullname = mysqli_real_escape_string($conn,$_POST["fullname"]);
    $username = mysqli_real_escape_string($conn,$_POST["username"]);
    $email = mysqli_real_escape_string($conn,$_POST["email"]);
    $password = mysqli_real_escape_string($conn,$_POST["password"]);
    $retypepassword = mysqli_real_escape_string($conn,$_POST["retypepassword"]);


    $flag = true;

    if (empty($fullname)){
        $fullnameerror = "field is required !";
        $flag = false;
    }

    if (empty($username)){
        $usernameerror = "field is required !";
        $flag = false;
    }

    if (empty($email)){
        $emailerror = "field is required !";
        $flag = false;
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailerror = "invalid email !";
        $flag = false;
    }else {
        $query = "SELECT COUNT(*) as count FROM users WHERE email = '$email';";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] > 0) {
            $emailerror = "email already taken !";
            $flag = false;
        } 

    }

    if (empty($password)){
        $passworderror = "field is required !";
    }elseif (strlen($password)<8) {
        $passworderror = "password must be of 8 or more characters !";
    }

    if (empty($retypepassword)){
        $retypepassworderror = "field is required !";
    }

    if ($password !== $retypepassword){
        $retypepassworderror = "password's doesn't match !";
    }

    if ($flag == true){
        $hashedpassword = sha1($password);
        $query = "INSERT INTO `users`(`fullname`, `username`, `email`, `userrole`, `password`) VALUES ('$fullname','$username','$email','Voter','$hashedpassword')";
        if (mysqli_query($conn, $query)) {
            $fullname = "";
            $username = "";
            $email = "";
            $password = "";
            $retypepassword = "";
            $success =  "Sign Up Successful...";
        } else {
            $error = "Sign Up Unsuccessful...";
        }
    
    
    }   

}elseif (isset($_POST["login"])) {

    $email = mysqli_real_escape_string($conn,$_POST["lemail"]);
    $password = mysqli_real_escape_string($conn,sha1($_POST["lpassword"]));

    $sql = "SELECT * FROM users WHERE email = '$email';";
    $query = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    
    if(mysqli_num_rows($query) > 0) {
        
        $data = mysqli_fetch_assoc($query);
        if ($data["email"]==$email AND $data["password"]==$password){

            session_start();
            $_SESSION["userRole"] = $data["userrole"];
            $_SESSION["userName"] = $data["username"];
            $_SESSION["userID"]   = $data["id"];

            if ($data["userrole"] == "Admin"){
                $_SESSION["Key"] = "AdminKey";
                ?>
                <script>location.assign("admin/index.php?homepage=1");</script>
                <?php
            }else {
                $_SESSION["Key"] = "VoterKey";
                ?>
                <script>location.assign("voter/index.php");</script>
                <?php
            }


        }else {
            $error = "wrong email or password !";    
        }


    }else {
        $error = "email is not registered !";
    }



}








?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
  </head>
  <body>

    <?php
    if (isset($_GET["signup"])){
        ?>

        <div class="center">
            <h1>POLLIFY.</h1>
            <div class="errors">
            <div class="error"><?php if(isset($fullnameerror)) echo $fullnameerror; ?></div>
            <div class="error"><?php if(isset($usernameerror)){echo $usernameerror;} ?></div>
            <div class="error"><?php if(isset($emailerror)){echo $emailerror; }?></div>
            <div class="error"><?php if(isset($passworderror)){ echo $passworderror; }?></div>
            <div class="error"><?php if(isset($retypepassworderror)){ echo $retypepassworderror; }?></div>
            <div class="error"><?php if(isset($error)){ echo $error; }?></div>
            <div class="success"><?php if(isset($success)){ echo $success; }?></div>
            
            </div>
            <form method="post">
                <div class="txt_field">
                <input type="text" name="fullname" value="<?php echo $fullname; ?>" required />
                <span class="in"></span>
                <label>Fullname</label>
                </div>
                <div class="txt_field">
                <input type="text" name="username" value="<?php echo $username; ?>" required/>
                <span class="in"></span>
                <label>Username</label>
                </div>
                <div class="txt_field">
                <input type="text" name="email" value="<?php echo $email; ?>" required/>
                <span class="in"></span>
                <label>Email</label>
                </div>
                <div class="txt_field">
                <input type="password" name="password" required/>
                <span class="in"></span>
                <label>Password</label>
                </div>
                <div class="txt_field">
                <input type="password" name="retypepassword" required/>
                <span class="in"></span>
                <label>Retype Password</label>
                </div>
                <input type="submit" value="Sign Up" name="signup" required/>
                <div class="signup_link">Already a member? <a href="index.php">Login</a></div>
            </form>
            </div>

        <?php

    }else {
        ?>

        <div class="center">
            <h1>POLLIFY.</h1>
            <div class="errors">
            <div class="error"><?php if(isset($error)){ echo $error; }?></div>
            </div>
            <form method="post">
                <div class="txt_field">
                <input type="text" name="lemail" value="<?php echo $email; ?>" required/>
                <span class="in"></span>
                <label>Email</label>
                </div>
                <div class="txt_field">
                <input type="password" name="lpassword" required/>
                <span class="in"></span>
                <label>Password</label>
                </div>
                <div class="pass">Forgot Password?</div>
                <input type="submit" value="Login" name="login" />
                <div class="signup_link">Not a member? <a href="index.php?signup=1">Sign Up</a></div>
            </form>
            </div>

    <?php
    }
    
    ?>
    
  </body>
</html>



