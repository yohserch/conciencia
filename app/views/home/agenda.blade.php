<?php 

	use Carbon\Carbon;
?>

@extends("layout.base", array("title" => "Agenda"))

@section("title")
<h2>Próximos eventos</h2>
@stop

@section("content")
	@if(!$eventos->isEmpty())
		<iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d7530.751762875661!2d-99.0473763!3d19.309489!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2smx!4v1425446370628" width="400" height="250" frameborder="0" style="border:0" id="map"></iframe>
		<p class="agenda_p"><strong>Sede:</strong> {{$eventos->get(0)->sede}}</p>
		<p class="agenda_p">
			<span><strong>Dirección:</strong></span>
			{{$eventos->get(0)->lugar}}
		</p>
		<p class="agenda_p"><strong>Fecha:</strong> {{$eventos->get(0)->fecha}}</p>
		<p class="agenda_p"><strong>Hora de inicio:</strong> {{$eventos->get(0)->hora_inicio}}</p>
		@foreach($eventos->slice(1, $eventos->count()) as $evento)
		{{$evento}}
		@endforeach
	@endif
@stop

@section("scripts")
{{HTML::script("js/sortable.js")}}
@stop