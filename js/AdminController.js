var admin = angular.module("adminApplication", ['ngResource'], function($interpolateProvider) {
		$interpolateProvider.startSymbol("<%");
		$interpolateProvider.endSymbol("%>");
});

admin.factory('Event', function($resource){
		return $resource('event/:id', null, {
			update: {
				method: 'PUT'
			}
		});
});

admin.factory('Galeria', function($resource) {
	return $resource('gallery/:id', null, {
		update: {
			method: 'PUT'
		}
	});
});

admin.service('NotificationService', function() {
	var notification = document.getElementById('notification'),
		notificationContent = document.getElementById('notification-content');

	this.show = function(message, error) {
		if(error)
			notification.classList.add("error-notification");
		else
			notification.classList.add("success-notification");
		notification.textContent = message;
		notification.classList.add("notification-show");
		setTimeout(this.hide, 4000);
	};

	this.hide = function() {
		notification.classList.remove("notification-show");
	};
});

admin.controller('EventController', function($scope, Event, NotificationService) {
	$scope.eventos = [];
	$scope.evento = new Event();
	$scope.message = "";
	var eventos = Event.query(function(){
		$scope.eventos = eventos;
	});

	$scope.edit = function(id) {
		var evento = Event.get({id:id}, function() {
			$scope.evento = evento;
			console.log(evento);
		});
	};

	$scope.save = function() {
		var datos;
		if ($scope.evento.id !== undefined) {
			datos =  Event.update({id:$scope.evento.id}, $scope.evento, function() {
				NotificationService.show(datos.msj, datos.error);
				if(datos.object) {
					for (var i = 0; i < $scope.eventos.length; i++) {
						if($scope.eventos[i].id == datos.object.id) {
							$scope.eventos[i] = datos.object;
						}
					}
				}
			});
		} else {
			console.log("Guardando");
			datos = Event.save($scope.evento, function() {
				NotificationService.show(datos.msj, datos.error);
				if(!datos.error)
					$scope.eventos.push(datos.object);
			});
		}
		console.log(datos);
		if(!datos.error) {
			$scope.evento = new Event();
			location.hash = "#";
		}
	};

	$scope.showMap = function(obj) {
		var data = obj.target.parentElement.dataset;
		map = new GMaps({
			div: '#mapa',
			lat: data.lat,
			lng: data.lng,
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
			lat: data.lat,
			lng: data.lng,
			title: data.sede,
			infoWindow: {
				content: '<strong>'+ data.sede +'</strong>'
			}
		});
	};

	$scope.delete = function(id) {
		var datos = Event.delete({id:id}, function() {
			NotificationService.show(datos.msj, false);
			for (var i = 0; i < $scope.eventos.length; i++) {
				if($scope.eventos[i].id == datos.id) {
					$scope.eventos.splice(i,1);
				}
			}
		});
	};
});

admin.controller('GalleryController', function($scope, Galeria, NotificationService) {
	$scope.galerias = [];
	$scope.galerias = Galeria.query();
	$scope.galeria = new Galeria();

	$scope.save = function() {
		var datos;
		if ($scope.galeria.id !== undefined) {
			datos = Galeria.update({id: $scope.galeria.id}, $scope.galeria, function() {
				NotificationService.show(datos.msj, datos.error);
				if(datos.object) {
					for (var i = 0; i < $scope.galerias.length; i++) {
						if($scope.galerias[i].id == datos.object.id) {
							$scope.galerias[i] = datos.object;
						}
					}
				}
			});
		} else {
			console.log("Guardando");
			console.log($scope.galeria);
			datos = Galeria.save($scope.galeria, function() {
				NotificationService.show(datos.msj, datos.error);
				if (!datos.error)
					$scope.galerias.push(datos.object)
			});
		}

		if(!datos.error) {
			$scope.galeria = new Galeria();
			location.hash = "#";
		}
	};

	$scope.edit = function(id) {
		$scope.galeria = Galeria.get({id: id});
	};

	$scope.delete = function(id) {
		var datos = Galeria.delete({id:id}, function() {
			NotificationService.show(datos.msj, false);
			for (var i = 0; i < $scope.galerias.length; i++) {
				if($scope.galerias[i].id == datos.id) {
					$scope.galerias.splice(i,1);
				}
			}
		});
	}
});