@extends('layout.base-admin', array("title" => "Galerias", "controller" => "GalleryController"))

@section("angular")
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-resource.min.js"></script>
	<script src="{{URL::to('js/adminController.js')}}"></script>
@stop

@section("title")
	<h2>Galerias</h2>
@stop

@section("content")
	<div id="btn-insert">
		<a href="#newGallery" class="btn-action"><i class="fa fa-plus-circle fa-lg"></i> Agregar galeria</a>
	</div>

	<table>
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Imagenes</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="galeria in galerias">
				<td><% galeria.nombre %></td>
				<td><% galeria.imagenes.length || 0 %></td>
				<td>
					<a href="gallery/<%galeria.id%>" class="be-blue"><i class="fa fa-eye fa-lg"></i></a>
					{{-- <a href="#newGallery" class="edit" ng-click="edit(galeria.id)"><i class="fa fa-pencil-square-o fa-lg" ></i></a> --}}
					<a href="#" class="danger" ng-click="delete(galeria.id)"><i class="fa fa-trash-o fa-lg"></i></a>
				</td>
			</tr>
		</tbody>
	</table>
@stop

@section("modals")
	<div class="modalMask" id="newGallery">
		<div class="modalbox rotate">
			<div class="header">
				<h2>Agregar galeria</h2>
				<a href="#" title="Close" id="#"><i class="fa fa-times fa-lg"></i></a>
			</div>
			<div class="modal-content">
				<form id="formNewGaleria" ng-submit="save()">
					<input type="hidden" name="id" value="" id="id" ng-model="galeria.id">
					<input type="text" name="nombre_galeria" placeholder="Nombre" ng-model="galeria.nombre_galeria">
					{{Form::token()}}
					<div><button><i class="fa fa-floppy-o fa-lg"></i> Guardar galeria</button></div>
				</form>
			</div>
		</div>
	</div>

	<div id="notification" class="notification">
		<p id="notification-content">
		</p>
	</div>
@stop