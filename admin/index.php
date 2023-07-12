<?php
$Hactive  = "";
$AEactive = "";
$ACactive = "";
$EEactive = "";
$ECactive = "";






if(isset($_GET["homepage"])){
    
    $Hactive = "active";
    require_once("include/header.php");
    require_once("include/navigation.php");
    require_once("include/home.php");
    require_once("include/footer.php");

}elseif (isset($_GET["addelectionpage"])) {

    $AEactive = "active";
    require_once("include/header.php");
    require_once("include/navigation.php");
    require_once("include/addElection.php");
    require_once("include/footer.php");

}elseif (isset($_GET["addcandidatepage"])) {
    
    $ACactive = "active";
    require_once("include/header.php");
    require_once("include/navigation.php");
    require_once("include/addCandidate.php");
    require_once("include/footer.php");

}else if(isset($_GET['viewResult']))
{   
    $Hactive = "active";
    require_once("include/header.php");
    require_once("include/navigation.php");
    require_once("include/viewResult.php");
    require_once("include/footer.php");
    
}
else if(isset($_GET['editelection']))
{   
    $Eactive = "active";
    require_once("include/header.php");
    require_once("include/editelection.php");
    require_once("include/footer.php"); 
}
else if(isset($_GET['editcandidate']))
{   
    $ECactive = "active";
    require_once("include/header.php");
    require_once("include/editcandidate.php");
    require_once("include/footer.php"); 
}


?>