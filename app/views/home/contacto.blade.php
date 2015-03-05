@extends("layout.base", array("title" => "Contacto"))

@section("title")
<h2>Contactanos</h2>
@stop
@section("content")
	<p class="paragraph-center">Si tienes una algún comentario o alguna idea que compartir, por fvor ingresa tus datos en la siguiente forma de contacto</p>
	<form action="{{URL::route('contacto')}}" method="POST" class="form-center">
		<input type="text" name="nombre" placeholder="Nombre" required autocomplete="off">
		<input type="text" name="email" placeholder="Email" required autocomplete="off">
		<textarea name="mensaje" cols="30" rows="10" placeholder="Escribe tu mensaje" required></textarea>
		<div>
			<button type="submit">ENVIAR</button>
		</div>
	</form>
	</div>
@stop

@section("scripts")
	<script>
		$('document').onload(function() {
			setTimeout(function() {
				$('.error').fadeIn();
			}, 3000);
		});
	</script>
@stop