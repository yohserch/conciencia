@extends("layout.base", array("title" => "Propuestas"))
@section("title")
<h2>Registro de propuestas</h2>
@stop

@section("content")
	<p class="paragraph-center">Si tienes alguna propuesta de experimento, ponencia, etc. Registrala :D</p>
	<form action="{{URL::route("propuestas")}}" method="POST" enctype="multipart/form-data" class="form-center">

		<input type="text" name="propuesta" placeholder="Nombre de la propuesta">
		@if($errors->has('propuesta'))
			<div class="error">{{$errors->first('propuesta')}}</div>
		@endif

		<input type="text" name="area" placeholder="Area de la propuesta">
		@if($errors->has('area'))
			<div class="error">{{$errors->first('area')}}</div>
		@endif

		<input type="text" name="nombre" placeholder="Nombre" required>
		@if($errors->has('nombre'))
			<div class="error">{{$errors->first('nombre')}}</div>
		@endif
		
		<input type="text" name="escuela" placeholder="Escuela">
		@if($errors->has('empresa'))
			<div class="error">{{$errors->first('empresa')}}</div>
		@endif
		
		<input type="text" name="email" placeholder="alguien@alguien.com" required>
		@if($errors->has('email'))
			<div class="error">{{$errors->first('email')}}</div>
		@endif
		<label for="archivos" id="lbl-archivos">Elige archivos para enviar</label>
		<input type="file" name="archivos[]" multiple accept=".doc, .docx, image/*, .pdf, .xlsx, .xls" id="archivos">
		<div>
			<button type="submit">Enviar propuesta</button>
		</div>
	</form>
	<div>
		@if(Session::has('message'))
			<h3>{{Session::get('message')}}</h3>
		@endif
	</div>
@stop

@section("scripts")
	<script>
		$(document).ready(function() {
			setTimeout(function() {
				console.log($('.error'));
				$('.error').hide("slow");
				console.log("Hola");
			}, 3000);
		});
	</script>
@stop