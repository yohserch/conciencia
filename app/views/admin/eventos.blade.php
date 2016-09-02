<?php 
use Carbon\Carbon;
 ?>

@extends("layout.base-admin", array("title" => "Eventos", "controller" => "EventController"))
@section("angular")
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-resource.min.js"></script>
	<script src="{{URL::to('js/adminController.js')}}"></script>
@stop


@section("title")
<h2>Gestión de eventos</h2>
@stop

@section("content")
	<div id="btn-insert">
		<a href="#newEvent" class="btn-action"><i class="fa fa-plus-circle fa-lg"></i> Registrar evento</a>
	</div>
	<table>
		<thead>
			<tr>
				<th>Fecha</th>
				<th>Sede</th>
				<th>Dirección</th>
				<th>Hora de inicio</th>
				<th>Hora de fin</th>
				<th>Mapa</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody id="table-content" ng-hide="eventos.length === 0">
			<tr ng-repeat="evento in eventos">
				<td><%evento.fecha%></td>
				<td><%evento.sede%></td>
				<td><%evento.lugar%></td>
				<td><%evento.hora_inicio%></td>
				<td><%evento.hora_fin%></td>
				<td>
					<a href="#eventMap" class="be-blue map" data-lng="<%evento.longitud%>" data-lat="<%evento.latitud%>" data-sede="<%evento.sede%>" ng-click="showMap($event)"><i class="fa fa-globe fa-lg"></i></a>
				</td>
				<td>
					<a href="#newEvent" class="edit" ng-click="edit(evento.id)"><i class="fa fa-pencil-square-o fa-lg" ></i></a>
					<a href="#" class="danger" ng-click="delete(evento.id)"><i class="fa fa-trash-o fa-lg"></i></a>
				</td>
			</tr>
		</tbody>
	</table>
@stop

@section("modals")
	<div class="modalMask" id="newEvent">
		<div class="modalbox rotate">
			<div class="header">
				<h2>Agregar nuevo evento</h2>
				<a href="#" title="Close" id="#"><i class="fa fa-times fa-lg"></i></a>
			</div>
			<div class="modal-content">
				<form id="formNewEvent" ng-submit="save()">
					<input type="hidden" name="id" value="" id="id" ng-model="evento.id">
					<input type="text" placeholder="Sede" name="sede" ng-model="evento.sede">
					<input type="text" placeholder="Dirección" name="lugar" ng-model="evento.lugar">
					<input type="text" placeholder="Fecha (dd-mm-yyy)" id="datepicker" name="fecha" ng-model="evento.fecha">
					<input type="text" placeholder="Hora de inicio (HH:mm)" class="timepicker" name="hora_inicio" ng-model="evento.hora_inicio">
					<input type="text" placeholder="Hora de fin (HH:mm)" class="timepicker" name="hora_fin" ng-model="evento.hora_fin">
					<input type="text" placeholder="Latitud" name="latitud" ng-model="evento.latitud">
					<input type="text" placeholder="Longitud" name="longitud" ng-model="evento.longitud">
					{{Form::token()}}
					<div><button><i class="fa fa-floppy-o fa-lg"></i> Guardar evento</button></div>
				</form>
			</div>
		</div>
	</div>
	<div id="notification" class="notification">
		<p id="notification-content">
		</p>
	</div>

	<div class="modalMask" id="eventMap">
		<div class="modalbox rotate">
			<div class="header">
				<h2>Mapa del evento</h2>
				<a href="#" title="Close" id="#"><i class="fa fa-times fa-lg"></i></a>
			</div>
			<div class="modal-content">
				<div id="mapa"></div>
			</div>
		</div>
	</div>
@stop

@section("scripts")
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyB2fAdcdjb_KEcorQVAa5UP0rIi-oypmM4"></script>
	<script src="{{URL::to('js/gmaps.js')}}"></script>
@stop
