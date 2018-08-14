$(document).ready(init)

function init(){
    //code here
    loadTablaBanners();
    loadtablaPestañas();
    $("#myfile").change(showImage);
    $("#enviar").click(enviar);

}

function enviar(){

    var nombre = $("#nombre");
    var link   = $("#enlace");

    if( $("#myfile")[0].files[0] && nombre.val()!=""){
        sendFile();
    }else{
        $("#resultado").html("<p class='text-danger'>Por favor elija un banner y asigne un nombre</p>");
    }
}


function eliminarBanner(){
    var id = this.id;
    parametros = {'id':id};
    $.ajax({
    	data:  parametros,
    	url:   'eliminarBanner.php',
    	type:  'post',
    	beforeSend: function () {
    	$("#"+id).html('Remover <i class="fa fa-spin fa-spinner" aria-hidden="true"></i>');
    	},
    	success:  function (response) {
            if(response=="ok")
                loadTablaBanners();
            else {
                $("#"+id).html(response);
            }

    	},
    	error: function (request, status, error) {
    	console.log(request.responseText);
    	}
    	});
}


function showImage(){//mostar imagen al seleccionarla con el input
    if(this.files && this.files[0]){
        document.getElementById("blah").style.display ="none";
        var reader = new FileReader();
        reader.onload = function(e){
            //$('#blah').attr('src', e.target.result);
            var image = new Image();
            image.src = e.target.result;

            var alto = image.naturalHeight;
            var ancho = image.naturalWidth;

            delete image;
            $('#blah').fadeIn("slow").attr('src', e.target.result);



            /*
            if(alto < (ancho*0.25 + 10) && (alto>0) &&(ancho>0) ){
                $('#blah').fadeIn("slow").attr('src', e.target.result);
                $("#resultado").html("");
            }else{
                mensaje = "<p class='text-danger'>Su imagen debe tener de ancho cuatro veces la altura. <br> Con un valor mínimo de 1000x250px</p>";
                $("#resultado").html(mensaje);
            }*/
        }
         reader.readAsDataURL(this.files[0]);



    }

}

function sendFile(){
    let xhr = new XMLHttpRequest(),
        fd = new FormData();

        uploadProgress = document.getElementById('upload-progress');
        message = document.getElementById('resultado');
    fd.append('file',$("#myfile")[0].files[0]);

    fd.append('nombre',$("#nombre").val());
    if($("#enlace").val()!="")
        fd.append('enlace',$("#enlace").val());
    else
        fd.append('enlace',"#");


    xhr.upload.onloadstart = function(e){

        $("#upload-progress").fadeIn("fast");
        uploadProgress.value=0;
        uploadProgress.max= e.total;
        message.innerHTML = 'uploading...';
    };

    xhr.upload.onprogress = function(e){
        uploadProgress.value= e.loaded;
        uploadProgress.max= e.total;
        //fileInput.disabled = true;
    };

    xhr.upload.onloadend = function(e){

        message.innerHTML = 'complete...';
        //fileInput.disabled = false;
    };
    xhr.onload = function(){
        response = xhr.responseText;
        if(response=="Guardado"){
            $("#resultado").html("");
            $("#nombre").val("");
            $("#enlace").val("");
            $("#blah").fadeOut("fast");
            $("#upload-progress").fadeOut("fast");
            var control = jQuery('#myfile');
            control.replaceWith( control = control.val('').clone( true ) );
            loadTablaBanners();
        }else {
            $("#resultado").html(response);
        }
    };
    xhr.open('POST', 'catch-banner.php', true);
    xhr.send(fd);
}

function loadtablaPestañas(){
    parametros={};
    $.ajax({
    	data:  parametros,
    	url:   'gettablaPestañas.php',
    	type:  'post',
    	beforeSend: function () {
    	$('#tablaBanners').html('Procesando, espere por favor...');
    	},
    	success:  function (response) {
    	$('#tablaPestañas').html(response);
        $(".btn-success").click(function(){
            var id = this.id;
            loadmyModal(id);
        });
    	},
    	error: function (request, status, error) {
    	alert(request.responseText);
    	}
    	});
}

function loadTablaBanners(){
    parametros={};
    $.ajax({
    	data:  parametros,
    	url:   'getBanners.php',
    	type:  'post',
    	beforeSend: function () {
    	$('#tablaBanners').html('Procesando, espere por favor...');
    	},
    	success:  function (response) {
    	$('#tablaBanners').html(response);
        $(".btn-danger").click(eliminarBanner);
        $(".btn-warning").click(function(){
            var id = this.id;
            loadBannerModal(id);
        });
    	},
    	error: function (request, status, error) {
    	alert(request.responseText);
    	}
    	});

}

function loadBannerModal(id){
    parametros={
        "id":id
    }
    $.ajax({
    	data:  parametros,
    	url:   'getbannerModal.php',
    	type:  'post',
    	beforeSend: function () {
    	$('#editModal').html('Procesando, espere por favor...');
    	},
    	success:  function (response) {
    	$('#editModal').html(response);
        $("#guardarBanner").click(guardarBanner)

    	},
    	error: function (request, status, error) {
    	alert(request.responseText);
    	}
    	});
}

function guardarBanner(){
    parametros ={
        "id":$("#idBanner").val(),
        "link":$("#linkBanner").val()
    };

    $.ajax({
    	data:  parametros,
    	url:   'guardarBanner.php',
    	type:  'post',
    	beforeSend: function () {
    	$('#resultadoBanner').html('Procesando, espere por favor...');
    	},
    	success:  function (response) {
    	$('#resultadoBanner').html(response);
        if(response=="<p class='text-success'>Se ha actualizado el link</p>")
            loadTablaBanners();
    	},
    	error: function (request, status, error) {
    	alert(request.responseText);
    	}
    	});
}


function loadmyModal(id){
    parametros={
        "id":id
    }
    $.ajax({
    	data:  parametros,
    	url:   'getmyModal.php',
    	type:  'post',
    	beforeSend: function () {
    	$('#myModal').html('Procesando, espere por favor...');
    	},
    	success:  function (response) {
    	$('#myModal').html(response);
        $("#selection").change(changeBanner);
        $("#latselection").change(changeLatBanner);
    	},
    	error: function (request, status, error) {
    	alert(request.responseText);
    	}
    	});
}


function changeBanner(){
    var value = $("#selection").val();
    parametros ={
        'id':value,
        'set':$("#set").val(),
        'pestana':$("#setPestana").val()
    };

    $.ajax({
    	data:  parametros,
    	url:   'changeBanner.php',
    	type:  'post',
    	beforeSend: function () {
    	$('#imgResult').html('Procesando, espere por favor...');
    	},
    	success:  function (response) {
            if(response!="error"){
                $('#imgResult').html(response);
            }

    	},
    	error: function (request, status, error) {
    	alert(request.responseText);
    	}
    	});

}


function changeLatBanner(){
    var value = $("#latselection").val();
    parametros ={
        'id':value,
        'set':$("#latset").val(),
        'pestana':$("#latsetPestana").val()
    };


    $.ajax({
    	data:  parametros,
    	url:   'changeLatBanner.php',
    	type:  'post',
    	beforeSend: function () {
    	$('#imglatResult').html('Procesando, espere por favor...');
    	},
    	success:  function (response) {
            if(response!="error"){
                $('#imglatResult').html(response);
            }

    	},
    	error: function (request, status, error) {
    	alert(request.responseText);
    	}
    	});

}
