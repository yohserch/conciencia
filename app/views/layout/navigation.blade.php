<nav>
	<ul>
		<li><a href="{{URL::route("home")}}">Inicio</a></li>
		<li><a href="{{URL::route("galeria")}}">Galeria</a></li>
		<li><a href="{{URL::route("agenda")}}">Agenda</a></li>
		<li><a href="{{URL::route("contacto")}}">Contacto</a></li>
		<li id="logo"><a href="{{URL::route("home")}}"><img src="{{URL::to('img/ipnconciencia.png')}}" alt=""></a></li>
		<li><a href="{{URL::route("propuestas")}}">Registro de propuestas</a></li>
		<li><a href="#">Patrocinadores</a></li>
		{{-- <li><a href="{{URL::route("accountSignIn")}}">Sign In</a></li> --}}
	</ul>
</nav>