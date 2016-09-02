@extends("layout.base", array("title" => "Galeria"))
@section('styles')
@stop

@section("title")
	<h2>Galeria</h2>
@stop
@section("content")
	@foreach($galerias as $galeria)
		<h3 class="title-gallery">{{$galeria->nombre}}</h3>
		@if($galeria->imagenes()->count() > 0)
			<div class="galleria">
				@foreach($galeria->imagenes as $imagen)
					<img src="{{Cloudy::show($imagen->public_id)}}" alt="" height="200px" data-info="Esta es la info">
				@endforeach
			</div>
		@endif
	@endforeach
@stop

@section('scripts')
	<script src="{{URL::to('js/galleria.js')}}"></script>
	<script>
		Galleria.loadTheme('{{URL::to("js/themes/classic/galleria.classicmod.js")}}');
		Galleria.run('.galleria', {
			transition: 'pulse',
			touchTransition: 'slide',
			responsive: true,
			fullscreenDoubleTap: true,
			trueFullScreen: true,
			showInfo: true
		});
	</script>
@stop