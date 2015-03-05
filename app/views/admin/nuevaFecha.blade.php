<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nueva Fecha</title>
</head>
<body>
	<h1>Nueva Fecha</h1>
	@if(Session::has('message'))
		<div>{{Session::get('message')}}</div>
	@endif
	<form action="" method="POST">
		@if($errors->has('fecha'))
			<div>{{$errors->first('fecha')}}</div>
		@endif
		<label for="fecha">Día del evento: </label>
		<input type="date" name="fecha" placeholder="Día del evento" required value="{{(Input::has('fecha')) ? Input::get('fecha') : ""}}">
		@if($errors->has('lugar'))
			<div>{{$errors->first('lugar')}}</div>
		@endif
		<label for="lugar">Lugar del evento:</label>
		<input type="text" name="lugar" placeholder="Lugar del evento" required value="{{(Input::has('lugar')) ? Input::get('lugar') : ""}}">
		@if($errors->has('hora_inicio'))
			<div>{{$errors->first('hora_inicio')}}</div>
		@endif
		<label for="hora_inicio">Hora de Inicio: </label>
		<input type="time" name="hora_inicio" placeholder="Hora de Inicio" required value="{{(Input::has('hora_inicio')) ? Input::get('hora_inicio') : ""}}">
		@if($errors->has('hora_fin'))
			<div>{{$errors->first('hora_fin')}}</div>
		@endif
		<label for="hora_fin">Hora de Fin: </label>
		<input type="time" name="hora_fin" placeholder="Hora de Fin" required value="{{(Input::has('hora_fin')) ? Input::get('hora_fin') : ""}}">
		<input type="submit" value="Guardar evento">
		{{Form::token()}}
	</form>
</body>
</html>