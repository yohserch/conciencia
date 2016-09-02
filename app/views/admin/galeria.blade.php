@extends('layout.base-admin', array("title" => "Galerias", "controller" => "GalleryController"))

@section('title')
	<h2>Galeria "{{$galeria->nombre}}"</h2>
@stop

@section("content")
	<div id="uploader">
		<i class="fa fa-plus fa-5x"></i>
		<h3>Arrastra una imagen para agregarla</h3>
	</div>
	<button id="upload" disabled>
		<span id="buttonContent"><i class="fa fa-upload"></i> <span id="buttonContentText">Upload</span></span>
		<span id="buttonLoad" class="notShow"><i class="fa fa-spinner fa-pulse"></i> Cargando...</span>
	</button>
	<div id="images">
		@foreach($galeria->imagenes as $imagen)
			<div>
				<img src="{{Cloudy::show($imagen->public_id, array('width' => 150, 'height' => 150, 'crop' => 'fit'))}}">
				<a href="#" class="danger"><i class="fa fa-close"></i></a>
			</div>
		@endforeach
	</div>
@stop

@section("scripts")
	<script src="{{URL::to('js/Uploader.js')}}"></script>
	<script>
		uploader.uploader({
			dropzone: document.getElementById('uploader'),
			uploads: document.getElementById('images'),
			buttonUpload: document.getElementById("upload"),
			buttonContent: document.getElementById('buttonContent'),
			buttonContentText: document.getElementById('buttonContentText'),
			buttonLoad: document.getElementById('buttonLoad'),
			galleryId: {{$galeria->id}},
			proccessor: "{{URL::route('gallery.addImages')}}"
		});
	</script>
@stop