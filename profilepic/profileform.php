<?php
error_reporting(0);
//include("../connection.php");
$msg = "";

// If upload button is clicked ...
if (isset($_POST['upload'])) {

	$filename = $_FILES["uploadfile"]["name"];
	$tempname = $_FILES["uploadfile"]["tmp_name"];
	$folder = "dp/" . $filename;

	$db = mysqli_connect("localhost", "root", "", "institute");

	// Get all the submitted data from the form
	$sql = "INSERT INTO profilepic (filename) VALUES ('$filename')";
    

	// Execute query
	mysqli_query($db, $sql);

	// Now let's move the uploaded image into the folder: image
	if (move_uploaded_file($tempname, $folder)) {
		echo "<h3> Image uploaded successfully!</h3>";
	} else {
		echo "<h3> Failed to upload image!</h3>";
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Image Upload</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
	<div id="content">
		<form method="POST" action="" enctype="multipart/form-data">
			<div class="form-group">
				<input class="form-control" type="file" name="uploadfile" value="" />
			</div>
			<div class="form-group">
				<button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
			</div>
		</form>
	</div>
	<div id="display-image">
		<?php
		$query = " select * from profilepic ";
		$result = mysqli_query($db, $query);
       

		while ($data = mysqli_fetch_assoc($result)) {
		?>
			<img src="dp/<?php echo $data['filename']; ?>">
            <?php echo $data['profile_id'] ; "<\br>" ?>
            <a href="delete.php?profile_id= <?php echo $data['profile_id'];?>">
                                    <button type='submit' class='delete'><i class='fas fa-trash-alt'></i></button>
                                
		<?php
		}
		?>
	</div>
</body>

</html>
