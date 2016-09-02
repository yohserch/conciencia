var uploader = {};

(function(o) {
	"use strict";
	var ajax, getFormData, setProgress, addFile, images = new FormData(), uploadFiles, count = 0, addImagesToDOM;
	uploadFiles = function() {
		o.options.buttonUpload.disabled = true;
		o.options.buttonContent.classList.add("notShow");
		o.options.buttonLoad.classList.remove("notShow");
		images.append('galleryId', o.options.galleryId);
		var xmlhttp = new XMLHttpRequest(), uploaded;
		xmlhttp.addEventListener('readystatechange', function() {
			if(this.readyState === 4) {
				if(this.status === 200) {
					uploaded = JSON.parse(this.response);
					addImagesToDOM(uploaded);
					o.options.buttonLoad.classList.add("notShow");
					o.options.buttonUpload.classList.add('be-green');
					o.options.buttonContentText.textContent = "Listo!!";
					o.options.buttonContent.classList.remove("notShow");
					setTimeout(function() {
						o.options.buttonUpload.classList.remove('be-green');
						o.options.buttonContentText.textContent = "Upload";
					}, 4000);
					count = 0;

				} else {
					o.options.buttonUpload.disabled = false;
				}
			}
		});

		xmlhttp.addEventListener('progress', function(event) {
			var percent;
			if (event.lengthComputable === true) {
				percent = Math.round((event.loaded) / (event.total)) * 100;
			}
		});

		xmlhttp.open('post', o.options.proccessor);
		xmlhttp.send(images);
	};

	addImagesToDOM = function(filesInfo) {
		var div, img, a;
		for (var i = 0; i < filesInfo.length; i++) {
			div = document.createElement('div');
			img = document.createElement('img');
			a = document.createElement('a');
			img.src = filesInfo[i].url;
			img.dataset.publicId = filesInfo[i].public_id;
			a.href = "#";
			o.options.uploads.appendChild(img);
		}
	};

	addFile = function(files) {
		for (var i = 0; i < files.length; i++) {
			images.append("file[]", files[i]);
			count++;
		}
		o.options.buttonUpload.disabled = false;
		o.options.buttonContentText.textContent = ' Upload (' + count + ' archivo(s) listo(s))';
	};

	o.uploader = function(options) {
		o.options = options;
		if(o.options.dropzone) {
			o.options.dropzone.ondrop = function(e) {
				e.preventDefault();
				o.options.dropzone.classList.remove('dragover');
				addFile(e.dataTransfer.files);
				return false;
			};

			o.options.dropzone.ondragover = function(){
				o.options.dropzone.classList.add('dragover');
				return false;
			};

			o.options.dropzone.ondragleave = function() {
				o.options.dropzone.classList.remove('dragover');
				return false;
			};

			o.options.buttonUpload.onclick = function() {
				console.log("Click D:");
				uploadFiles();
			};
		}
	};
}(uploader));