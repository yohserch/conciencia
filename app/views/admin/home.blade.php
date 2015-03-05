<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin Home</title>
</head>
<body>
	<h1>Bienvenido {{Auth::user()->nombre}}</h1>
	@if(Session::has('message'))
		<div>{{Session::get('message')}}</div>
	@endif
</body>
</html>