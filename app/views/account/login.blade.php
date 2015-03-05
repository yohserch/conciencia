<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width , maximum-scale=1" />
	{{HTML::style("css/style-login.css")}}
	{{HTML::style("font/Opensans/stylesheet.css")}}
	{{HTML::style("font/Existence/stylesheet.css")}}
	<title>Login</title>
</head>
<body>
	<h2>Bienvenido</h2>
	<form action="{{URL::route("accountSignIn")}}" method="POST">
		<div id="data-user">
			<input type="text" name="username" placeholder="Username" autocomplete="off">
			<input type="password" name="password" placeholder="Password" autocomplete="off">
		</div>
		{{Form::token()}}
		<input type="submit" value="Login">
	</form>
</body>
</html>