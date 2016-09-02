<nav>
	<ul>
		<li><a href="{{URL::route('adminHome')}}"><i class="fa fa-home fa-lg"></i>Inicio</a><span class="flecha"><img src="{{URL::to('img/arrow-r.png')}}"></span></li>
		<li><a href="{{URL::route('adminEventos')}}"><i class="fa fa-calendar fa-lg"></i>Eventos</a><span class="flecha"><img src="{{URL::to('img/arrow-r.png')}}"></span></li>
		<li><a href="{{URL::route('AdminGaleria')}}"><i class="fa fa-picture-o fa-lg"></i>Galerias</a><span class="flecha"><img src="{{URL::to('img/arrow-r.png')}}"></span></li>
		<li><a href="{{URL::route('AdminPropuestas')}}"><i class="fa fa-plus fa-lg"></i>Propuestas</a><span class="flecha"><img src="{{URL::to('img/arrow-r.png')}}"></span></li>
		<li><a href="{{URL::route('signout')}}"><i class="fa fa-sign-out fa-lg"></i>Cerrar sesión</a><span class="flecha"><img src="{{URL::to('img/arrow-r.png')}}"></span></li>
	</ul>
</nav>