@extends("layout.base", array("title" => "Contacto"))

@section("title")
<h2>Contactanos</h2>
@stop
@section("content")
	<p class="paragraph-center">Si tienes una algún comentario o alguna idea que compartir, por fvor ingresa tus datos en la siguiente forma de contacto</p>
	<form action="{{URL::route('contacto')}}" method="POST" class="form-center">
		<input type="text" name="nombre" placeholder="Nombre" required autocomplete="off">
		@if($errors->has('nombre'))
			<div class="error">{{$errors->first('propuesta')}}</div>
		@endif
		<input type="text" name="email" placeholder="Email" required autocomplete="off">
		@if($errors->has('email'))
			<div class="error">{{$errors->first('email')}}</div>
		@endif
		<textarea name="mensaje" cols="30" rows="10" placeholder="Escribe tu mensaje" required></textarea>
		@if($errors->has('mensaje'))
			<div class="error">{{$errors->first('mensaje')}}</div>
		@endif
		<div>
			<button type="submit">ENVIAR</button>
		</div>
		{{Form::token()}}
	</form>
	</div>
@stop

@section("scripts")
	<script>
		$(document).ready(function() {
			setTimeout(function() {
				$('.error').hide("slow");
			}, 3000);
		});
	</script>
@stop