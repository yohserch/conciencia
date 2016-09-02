var filaEditada, map;

$(document).ready(function() {
	init();

});

function init() {
	activeCreateForm();
	deleteEvent();
	editEvent();
	showMap();
}

function activeCreateForm() {
	$("#formNewEvent").on('submit', function(event) {
		event.preventDefault();
		fila = event.target.parentNode.parentNode;
		$.post('eventos/create', $("#formNewEvent").serializeArray()).done(function(data) {
			console.log(data);
			if(data.hasOwnProperty("event")) {
				createEventDOM(data.event, data.edited);
				location.hash = "#";
				showNotification(data.msj, 'success');
				clearInput();
			} else {
				showNotification(data.msj, 'error');
			}
		});
	});
}

function deleteEvent(anchor) {
	$('.danger').on('click', function(event) {
		event.preventDefault();
		anchor = event.target.parentNode;
		id = anchor.dataset.id;
		$.post('eventos/remove/'+id, function(data) {
			$(anchor.parentNode.parentNode).fadeOut("slow", function() {
				$(this).remove();
			});
			showNotification(data.msj, data.status);
		});
	});
}

function editEvent() {
	$('.edit').on('click', function(event) {
		event.preventDefault();
		anchor = event.target.parentNode;
		id = anchor.dataset.id;
		filaEditada = anchor.parentNode.parentNode;
		$.get('eventos/'+id, function(data) {
			inputs = $("#formNewEvent input");
			for(var i = 0; i < inputs.length; i++) {
				var name = inputs[i].name;
				if(name != "_token") {
					inputs[i].value = data.evento[name];
				}
				location.hash = "#newEvent";
			}
		});
	});
}

function createEventDOM(evento, edited) {
	var fila = "<tr>" +
				"<td>" + evento.fecha + "</td>" +
				"<td>" + evento.sede + "</td>" +
				"<td>" + evento.lugar + "</td>" +
				"<td>" + evento.hora_inicio + "</td>" +
				"<td>" + evento.hora_fin + "</td>" +
				"<td><a href='#eventMap' class='be-blue map' data-lng='"+ evento.longitud +"' data-lat='"+evento.latitud+"' data-sede='"+evento.sede+"'><i class='fa fa-globe fa-lg'></i></a></td>" +
				"<td>" +
					"<a href='#' class='edit' data-id='"+ evento.id +"'><i class='fa fa-pencil-square-o fa-lg'></i></a> " +
					"<a href='#' class='danger' data-id='"+ evento.id +"'><i class='fa fa-trash-o fa-lg'></i></a>" +
				"</td>" +
				"</tr>";
	if(edited) {
		$(filaEditada).replaceWith(fila);
	} else {
		$("#table-content").append(fila);
	}
	deleteEvent();
	showMap();
}

function showNotification(content, type) {
	if(type == 'success') {
		$(".notification").addClass('success-notification');
	} else {
		$(".notification").addClass('error-notification');
	}
	$("#notification-content").text(content);
	$(".notification").addClass("notification-show");
	setTimeout(function(){
		$(".notification").removeClass("notification-show");
	}, 4000);
}

function showMap() {
	$('.map').on('click', function(event) {
		var latitud = $(this).data('lat'),
			longitud = $(this).data('lng'),
			sede = $(this).data('sede');
		map = new GMaps({
			div: '#mapa',
			lat: latitud,
			lng: longitud,
			zoom: 17,
			zoomControl: true,
			zoomControlOpt: {
				style: 'SMALL',
				position: 'TOP_RIGHT'
			},
			panControl: true,
			streetViewControl: true,
			mapTypeControl: false
		});
		map.addMarker({
			lat: latitud,
			lng: longitud,
			title: sede,
			infoWindow: {
				content: '<strong>'+ sede +'</strong>'
			}
		});
	});
}

function clearInput() {
	$("#formNewEvent").trigger("reset");
	$("#id").val("");
}
