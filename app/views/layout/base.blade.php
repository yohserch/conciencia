<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width , maximum-scale=1" />
	{{HTML::style("font/Opensans/stylesheet.css")}}
	{{HTML::style("font/CaviarDreams/stylesheet.css")}}
	{{HTML::style("font/Existence/stylesheet.css")}}
	{{HTML::style("font/Clemente/stylesheet.css")}}
	{{HTML::style("css/style.css")}}
	<title>{{ "Ipn con-ciencia | ", $title}}</title>
</head>
<body>
	<header>
		@include("layout.navigation")
	</header>
	<div id="lineaGuinda">
		<div id="logoIPN">
			<img src="{{URL::to("img/IpnBlanco.png")}}" alt="IPN">
		</div>
	</div>
	<section>
		@yield("title")
		<div id="content">
		@yield("content")
		</div>
	</section>
	{{HTML::script("js/jquery.js")}}
	@yield("scripts")
</body>
</html>