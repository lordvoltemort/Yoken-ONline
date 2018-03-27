<?php
require 'core.inc.php';

if(!loggedin())
{
	if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['password_confirm']))
	{
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$password_again = trim($_POST['password_confirm']);


		if(!empty($username)&&!empty($password)&&!empty($password_again))
		{
			if(strlen($username)>30)
			{
				echo 'Please adhere to maxlength of fields.';
			}
			else
			{
				if($password!=$password_again)
				{
					echo 'Passwords do not match.';
				}
				else
				{
					$password_hash = md5($password);

					$query = "SELECT UserName FROM admin WHERE username='".mysqli_real_escape_string($mysql_connect, $username)."'";
					$query_run = mysqli_query($mysql_connect, $query);
					$query_num_rows = mysqli_num_rows($query_run);
					if($query_num_rows>=1)
					{
						echo 'The username '.$username.' already exists.';
					}
					else
					{
						echo $query = "INSERT INTO admin ( UserName , Password ) VALUES ('".mysqli_real_escape_string($mysql_connect, $username)."','".mysqli_real_escape_string($mysql_connect, $password_hash)."')";

						if($query_run = mysqli_query($mysql_connect, $query))
						{
							header('Location: register_success.php');
						}
						else
						{
							echo 'Sorry, we couldn\'t register you at this time. Try again later.';
						}
					}
				}
			}
		}
		else
		{
			echo 'All fields are required.';
		}
	}
?>

<form action="register.php" method="POST">
	Username: <br/><input type="text" name="username" maxlength="30" value="<?php if(isset($username)) { echo $username; } ?>"><br/><br/>
	Password: <br/><input type="password" name="password" maxlength="30"><br/><br/>
	Confirm Password: <br/><input type="password" name="password_confirm" maxlength="30"><br/><br/>
	<input type="submit" value="Register">
</form>

<?php
}
else if(loggedin())
{
	echo 'You\'re already registered and logged in.';
}
?>
