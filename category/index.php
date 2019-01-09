<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	
	<form action="" method="POST">
	<label>Enter Order ID:</label><br />
	<input type="text" name="category_id" placeholder="Enter Order ID" required/>
	<br /><br />
	<button type="submit" name="submit">Submit</button>
	</form>    

	<?php
	if (isset($_POST['category_id']) && $_POST['category_id']!="") {
		$category_id = $_POST['category_id'];
		$url = "http://localhost/api/category/read_one.php?".$category_id;
		
		$client = curl_init($url);
		curl_setopt($client, CURLOPT_RETURNTRANSFER,true);
		$response = curl_exec($client);
		
		$result = json_decode($response);
		
		echo "<table>";
		echo "<tr><td>Category ID:</td><td>$result->category_id</td></tr>";
		echo "<tr><td>Category Name:</td><td>$result->category_name</td></tr>";
		echo "</table>";
	}
	    ?>

	<br />
	<strong>Sample Order IDs for Demo:</strong><br />
	15478952<br />
	15478955<br />
	15478958<br />
	15478959
</body>
</html>