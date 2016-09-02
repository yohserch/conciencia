@extends('layout.base-admin', array('title' => 'Home', 'controller' => ''))
@section("title")
	<h2>Bienvenido {{Auth::user()->nombre}}</h2>
@stop

@section("content")
@stop