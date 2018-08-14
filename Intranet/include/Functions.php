<?php
require_once("DB.php");
require_once("Sessions.php");

function Redirect_to($New_Location,$get=""){
    header("Location:$New_Location"."$get");
    exit;
}



function Login_Attempt($Username,$Password,$Connection){
    $Query="SELECT * FROM registration
    WHERE username='$Username' AND password='$Password'";
    $Execute=$Connection->query($Query);
    if($admin=mysqli_fetch_assoc($Execute)){
	return $admin;
    }else{
	return null;
    }
}


function Login(){
    if(isset($_SESSION["User_Id"])){
	return true;
    }
}


 function Confirm_Login(){
    if(!Login()){
	    $_SESSION["ErrorMessage"]="Login Required ! ";
	    Redirect_to("index.php");
    }else{
        return true;
    }
  
     
}

function get4articles($Connection,$Name){
    $Query="SELECT category, title, image, id FROM admin_panel WHERE name='$Name' ORDER BY RAND() LIMIT 4";
    $res=$Connection->query($Query);
    $i = 0;
    while($fila=$res->fetch_assoc()){
        $var[$i] = $fila['category'];
        $var[$i+4] = $fila['title'];
        $var[$i+8] = $fila['image'];
		$var[$i+12] = $fila['id'];
        $i = $i+1;
    }
    return $var;
}

function Analyze($FPost)
{
    $Aux = '';
    $flag = false;
    $Post = str_split($FPost);
    for($i=0; $i<count($Post);$i++){
        $FirstChar = $Post[$i];
        //unset($Post[$i]);
        switch($FirstChar){
            case "[":
                //Opening label code:
                if(array_key_exists($i+1,$Post) &&
                   array_key_exists($i+2,$Post) &&
                   array_key_exists($i+3,$Post) &&
                   array_key_exists($i+4,$Post) &&
                   array_key_exists($i+5,$Post) &&
                   array_key_exists($i+6,$Post) &&
                   array_key_exists($i+7,$Post) &&
                   array_key_exists($i+8,$Post)){
                    if($Post[$i+1] == "y" &&
                       $Post[$i+2] == "o" &&
                       $Post[$i+3] == "u" &&
                       $Post[$i+4] == "t" &&
                       $Post[$i+5] == "u" &&
                       $Post[$i+6] == "b" &&
                       $Post[$i+7] == "e" &&
                       $Post[$i+8] == "]"){
                        
                        $Aux = $Aux. '<br><div class ="vidio"><iframe style="border-style:none; width:80%; height:400px;" class="embed-responsive-item" src="https://www.youtube.com/embed//';
                        $flag=true;
                    }
                }
                
                if(array_key_exists($i+1,$Post) &&
                   array_key_exists($i+2,$Post) &&
                   array_key_exists($i+3,$Post) &&
                   array_key_exists($i+4,$Post)){
                    if($Post[$i+1] == "i" &&
                       $Post[$i+2] == "m" &&
                       $Post[$i+3] == "g" &&
                       $Post[$i+4] == "]"){
                        
                        $Aux = $Aux. '<br><div class =""><img style="border-style:none; width:80%; height:400px;" class="" src="Upload/';
                    }
                }
                
                //Closing label code:
                if(array_key_exists($i+1,$Post) &&
                   array_key_exists($i+2,$Post) &&
                   array_key_exists($i+3,$Post) &&
                   array_key_exists($i+4,$Post) &&
                   array_key_exists($i+5,$Post) &&
                   array_key_exists($i+6,$Post) &&
                   array_key_exists($i+7,$Post) &&
                   array_key_exists($i+8,$Post) &&
                   array_key_exists($i+9,$Post)){
                    if($Post[$i+1] == "/" &&
                       $Post[$i+2] == "y" &&
                       $Post[$i+3] == "o" &&
                       $Post[$i+4] == "u" &&
                       $Post[$i+5] == "t" &&
                       $Post[$i+6] == "u" &&
                       $Post[$i+7] == "b" &&
                       $Post[$i+8] == "e" &&
                       $Post[$i+9] == "]"){
                        $Aux = $Aux. '"></iframe></div><br>';
                        }
                    }
                
                if(array_key_exists($i+1,$Post) &&
                   array_key_exists($i+2,$Post) &&
                   array_key_exists($i+3,$Post) &&
                   array_key_exists($i+4,$Post) &&
                   array_key_exists($i+5,$Post)){
                    if($Post[$i+1] == "/" &&
                       $Post[$i+2] == "i" &&
                       $Post[$i+3] == "m" &&
                       $Post[$i+4] == "g" &&
                       $Post[$i+5] == "]"){
                        $Aux = $Aux. '"></div><br>';
                        }
                    }
                
                break;
                    
                default:
                //if($flag==true){
                if($FirstChar =="\n"){
                    $Aux = $Aux. "</p><p>";
                }else{
                $Aux = $Aux.$FirstChar;
                $Aux = str_replace('/youtube]', '', $Aux);    
                $Aux = str_replace('youtube]', '', $Aux);
                $Aux = str_replace('/img]', '', $Aux);
                $Aux = str_replace('img]', '', $Aux);
                //}
                }
            }
        }
    return $Aux;
}
?>
