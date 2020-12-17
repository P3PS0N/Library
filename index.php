<?php
	$database = new mysqli("localhost", "lib_admin", "", "library");
	if($database->connect_error) {
		die("Connection failed: ".$conn->connect_error);
	}
	


	//		USER
	function printUsers($database) {
		$result = $database->query("SELECT * FROM users");

		if($result->num_rows > 0) {
			$table = "<table border=1><thead><tr>".
					"<th>id</th> <th>username</th> <th>email</th> <th>password</th> <th>last_login</th> <th>created_at</th>".
					"</tr></thead><tbody>";


			while($row = $result->fetch_assoc()) {
				$table .= "<tr><td>".$row["id"]."</td>".
						"<td>".$row["username"]."</td>".
						"<td>".$row["email"]."</td>".
						"<td>".$row["password"]."</td>".
						"<td>".$row["last_login"]."</td>".
						"<td>".$row["created_at"]."</td></tr>";
			}

			$table .= "</tbody></table>\n";
			return $table;
		} else {
			return "No users found";
		}
	}

	function addUser($database, $username, $email, $password) {
		$sql = "INSERT INTO users (username, email, password) VALUES ('".$username."', '".$email."', '".$password."')";

		if($database->query($sql) === TRUE) {
			return TRUE;
		} else {
			//return "Error: " . $sql . "<br>" . $database->error;
			return FALSE;
		}
	}

	if(isset($_POST['submit_user'])) {
		addUser($database, $_POST['username'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT));
	}



	//		BOOK
	function printBooks($database) {
		$result = $database->query("SELECT * FROM books");

		if($result->num_rows > 0) {
			$table = "<table border=1><thead><tr>".
					"<th>id</th> <th>isbn</th> <th>title</th> <th>created_at</th>".
					"</tr></thead><tbody>";


			while($row = $result->fetch_assoc()) {
				$table .= "<tr><td>".$row["id"]."</td>".
						"<td>".$row["isbn"]."</td>".
						"<td>".$row["title"]."</td>".
						"<td>".$row["created_at"]."</td></tr>";
			}

			$table .= "</tbody></table>\n";
			return $table;
		} else {
			return "No books found";
		}
	}

	function addBook($database, $isbn, $title) {
		$sql = "INSERT INTO books (isbn, title) VALUES ('".$isbn."', '".$title."')";

		if($database->query($sql) === TRUE) {
			return TRUE;
		} else {
			//return "Error: " . $sql . "<br>" . $database->error;
			return FALSE;
		}
	}

	if(isset($_POST['submit_user'])) {
		addUser($database, $_POST['username'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT));
	}


	if(isset($_POST['submit_book'])) {
		addBook($database, $_POST['isbn'], $_POST['title']);
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Virtual Library</title>
</head>
<body>
	<h2>Users</h2>
	<span>Add new user</span>
	<form name="user" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<input type="text" name="username" placeholder="Username"><br>
		<input type="text" name="email" placeholder="Email"><br>
		<input type="password" name="password" placeholder="Password"><br>
		<input type="submit" name="submit_user">
	</form>
	<br>
	<span>Table</span>
	<?php echo printUsers($database); ?>
	<br><br><br>


	<h2>Books</h2>
	<span>Add new book</span>
	<form name="book" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<input type="text" name="isbn" placeholder="ISBN"><br>
		<input type="text" name="title" placeholder="Title"><br>
		<input type="submit" name="submit_book">
	</form>
	<br>
	<span>Table</span>
	<?php echo printBooks($database); ?>
	<br><br><br>
</body>
</html>