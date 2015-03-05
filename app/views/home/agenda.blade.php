<?php 

use Carbon\Carbon;
 ?>

@extends("layout.base", array("title" => "Agenda"))

@section("title")
<h2>Próximos eventos</h2>
@stop

@section("content")
	<iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d7530.751762875661!2d-99.0473763!3d19.309489!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2smx!4v1425446370628" width="400" height="250" frameborder="0" style="border:0" id="map"></iframe>
	<h3>Lugar: {{$eventos->get(2)->lugar}}</h3>
	<h3>Fecha: {{Carbon::createFromFormat("Y-m-d H:i:s", $eventos->get(2)->fecha, 'America/Mexico_City')->format("d/m/Y")}}</h3>
	<h3>Hora de inicio: {{Carbon::createFromFormat("H:i:s", $eventos->get(2)->hora_inicio, 'America/Mexico_City')->format("H:i")}}</h3>
@stop

@section("scripts")
{{HTML::script("js/sortable.js")}}
@stop