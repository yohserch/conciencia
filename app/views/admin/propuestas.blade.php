@extends("layout.base-admin", array("title" => "Propuestas"))

@section("title")
<h2>Gestión de propuestas</h2>
@stop

@section("content")
	<table>
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Participante</th>
				<th>Escuela</th>
				<th>Área</th>
				<th>Email</th>
				<th>Aprobada</th>
				<th>Archivos</th>
			</tr>
		</thead>
		<tbody>
			@foreach($propuestas as $propuesta)
				<tr>
					<td>{{$propuesta->nombre_propuesta}}</td>
					<td>{{$propuesta->nombre}}</td>
					<td>{{$propuesta->escuela}}</td>
					<td>{{$propuesta->area}}</td>
					<td>{{$propuesta->email}}</td>
					<td>{{$propuesta->status}}</td>
					<td>#</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<div class="flatCheckBox">
		<input type="checkbox" name="#" name="status" id="flatOneCheckbox">
		<label for="flatOneCheckbox"></label>
	</div>
@stop