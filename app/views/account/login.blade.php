<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width , maximum-scale=1" />
	{{HTML::style("css/style-login.css")}}
	{{HTML::style('font/awesome/font-awesome.min.css')}}
	{{HTML::style("font/Opensans/stylesheet.css")}}
	{{HTML::style("font/Existence/stylesheet.css")}}
	<title>Login</title>
</head>
<body>
	<h2>Inicia sesión</h2>
	<form action="{{URL::route("accountSignIn")}}" method="POST">
		@if(Session::has('message'))
			<div class="error-message">
				{{Session::get('message')}}
			</div>
		@endif
		<div id="data-user">
			<input type="text" name="username" placeholder="Username" autocomplete="off" {{Input::old('username') ? 'value="'.Input::old('username').'"' : ""}}>
			@if($errors->has('username'))
				<div class="error">{{$errors->first('username')}}</div>
			@endif
			<input type="password" name="password" placeholder="Password" autocomplete="off">
			@if($errors->has('password'))
				<div class="error">{{$errors->first('password')}}</div>
			@endif
		</div>
		{{Form::token()}}
		<button><i class="fa fa-arrow-right fa-lg"></i>Entrar</button>
	</form>
</body>
</html>
