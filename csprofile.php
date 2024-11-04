<?php
include('config.php');

if(isset($_POST['btn-upload']))
	{ 
	 $id = $_POST['id'];

	 $file = rand(1000,100000)."-".$_FILES['file']['name'];
	 $file_loc = $_FILES['file']['tmp_name'];
	 $folder="upload/";
	 
	 // new file size in KB
	 //$new_size = $file_size/1024;  
	 // new file size in KB
	 
	 // make file name in lower case
	 $new_file_name = strtolower($file);
	 // make file name in lower case
	 
	 $final_file=str_replace(' ','-',$new_file_name);
	 
	 if(move_uploaded_file($file_loc,$folder.$final_file))
	 {
	  $query = "UPDATE user SET photo='$final_file' WHERE id = '$id'";
	  $result = $conn->query($query);
	  ?>
	  <script>
	  alert('successfully uploaded');
	        window.location.href='csdashboard.php';
	        </script>
	  <?php
	 }
	 else
	 {
	  ?>
	  <script>
	  alert('error while uploading file');
	        window.location.href='csdahsboard.php';
	        </script>
	  <?php
	 }
	}