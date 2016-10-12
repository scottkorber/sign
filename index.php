
<?php

echo '
<!DOCTYPE html>
<html>
<head>
<style>

a {
    color: black;
}

body {
  background-color: #1a1a1a; 
  color: #fff;
  text-align: center;
}
div {
  display: inline-block;
  padding: 10px 25px;
  #margin: 0 auto;
  #font-size: 24px;
  #cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  color: #fff;
  background-color: #292524;
  border: none;
  border-radius: 50px;
  box-shadow: 0 5px #333333;  

}

#.button {
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  color: #fff;
  background-color: #000000;
  border-radius: 50px;
  display: inline-block;
}
table {
  display: inline-block;
  #display: block;
  padding: 10px 25px;
  #margin: 0 auto;
  #font-size: 24px;
  #cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  color: #fff;
  background-color: #524a49;
  border: none;
  border-radius: 50px;
  box-shadow: 0 5px #333333;
}
td {
  padding: 0px;
}

.uploadform {
  display: inline-block;
  #display: block;
  padding: 10px 25px;
  #margin: 0 auto;
  #font-size: 24px;
  #cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  color: #fff;
  background-color: #524a49;
  border: none;
  border-radius: 50px;
  box-shadow: 0 5px #333333;
}
</style>
</head>
<title>Sign Controller</title>
<body>
<h2>Liberty Church Sign Controller</h2>
<center>
<div>
<h3>Upload New Slideshow</h3>

';

$self = $_SERVER['PHP_SELF'];
echo '
<form class="uploadform" action="'.$self.'" method="post" enctype="multipart/form-data">
    Select slideshow to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">   
    <!--
    <input hidden type="file" name="fileToUpload" id="fileToUpload"\>
    <label class="button" for="fileToUpload">Choose a file</label>
    -->    
    <input class="button" type="submit" value="Upload Slideshow" name="submit">
</form>


<br><font size=1>Note: Slides shows MUST be created at a resolution of 300x90 to display properly on the sign...</font>


<br><br>

<h3>Select Slideshow to run</h3>
';



$server = $_SERVER['SERVER_NAME'];
$server = "http://".$server."/";
$justfilename = $_FILES['fileToUpload']['name'];
$uploaddir = './';
$archivedir = 'archive/'.$justfilename;
$uploadfile = $uploaddir . basename($_FILES['fileToUpload']['name']);

//echo $archivedir;
//echo $uploadfile;

if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadfile)) {
	$justfilename = $_FILES['fileToUpload']['name'];
}
copy($uploadfile, $archivedir);


foreach($_POST as $file_to_delete => $value){
	$file_to_delete = str_replace('_', '.', $file_to_delete); //Replaces the _ with . from the $POST
   
            //echo "The file ".$file_to_delete." would be deleted";
            $command = "/bin/rm $file_to_delete";
            $command_output = shell_exec($command);
            //echo $command_output;
        }

echo '<table border="0" cellpadding="0">';
echo '<form action="'.$self.'" method="post">';
//var_dump(glob("*"));
$files_to_exclude = '".htaccess\|index.php\|index1.php\|index.php~\|index1.php~\|update_sign.sh\|README.md"';
$list_of_files_command = 'find . -maxdepth 1 -type f |cut -c 3- |grep -v '.$files_to_exclude;
$list_of_files = shell_exec($list_of_files_command);
$final_list=explode("\n",$list_of_files);
array_pop($final_list);
//var_dump($final_list);        
echo '<tr><td colspan=2><hr></td></tr>';    


foreach ($final_list as $filename) {
	 //ob_flush();
	 //flush();
        echo '<tr><td align="left">';
        echo '<input type="radio" name="slideshow" value="'.$filename.'"><a href="'.$server.$filename.'"> '.$filename.'</a><br>';
        echo '</td><td>';      
        echo '<input class="button" type="submit" value="X" name="'.$filename.'">';
        echo "</td></tr>";
        echo '<tr><td colspan=2><hr></td></tr>';
}
ob_flush();
flush();
echo '<tr><td colspan=2><input class="button" type="submit" value="Start Slideshow" name="submit"></td></tr>';
echo '</form>';
echo '</table>';
echo '<br><br>';


if ($_POST['slideshow']){
    $slidshow = $_POST['slideshow'];
    //echo $slidshow;
    $command = "./update_sign.sh $slidshow";
    $command_output = shell_exec($command);
    //echo $command;
    echo $command_output;
    
}    


echo '
<br><br>

</div>
</center>
</body>
</html>

';

?>



