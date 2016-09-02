<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>

<section style="font-size: 35px">
	<img src="{{URL::to('img/conciencia.png')}}" style="display: block; margin: 0 auto;">
	<div id="content" style="margin: 0 auto;">
		{{$mensaje}}
		<br>
		<br>
		<div id="from" style="text-align: center;'">
			Atte: <strong>{{$nombre}} </strong>
			<div><< <a href="mailto:{{$email}}">{{$email}}</a> >> </div>
		</div>
	</div>
</section>