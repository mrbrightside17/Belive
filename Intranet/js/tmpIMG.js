
$(document).ready(init());


function init(){
    fileInput = document.getElementById('file-input');
    uploadProgress = document.getElementById('upload-progress');
    message = document.getElementById('message');
    img = document.getElementById('IMG');
    information = document.getElementById('information');
    enviar = document.getElementById('enviar');
    enviar.disabled = true;
    enviar.style.cursor= 'not-allowed';

    fileInput.addEventListener('change',function(){
        //enviar.disabled = false;
        enviar.style.cursor= 'pointer';
        var fullPath = document.getElementById('file-input').value;
        if (fullPath) {
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
            message.innerHTML= filename;
        }


    });

    enviar.addEventListener('click',function(){

        let xhr = new XMLHttpRequest(),
            fd = new FormData();

        fd.append('file',fileInput.files[0]);
        fd.append('info',information.value);

        xhr.upload.onloadstart = function(e){
            uploadProgress.classList.add('visible');
            uploadProgress.value=0;
            uploadProgress.max= e.total;
            message.innerHTML = 'uploading...';
        };

        xhr.upload.onprogress = function(e){
            uploadProgress.value= e.loaded;
            uploadProgress.max= e.total;
            fileInput.disabled = true;
        };

        xhr.upload.onloadend = function(e){
            uploadProgress.classList.remove('visible');
            message.innerHTML = 'complete...';
            fileInput.disabled = false;
        };
        xhr.onload = function(){
                message.innerHTML = xhr.responseText;
        };
        xhr.open('POST', 'catch-file.php', true);
        xhr.send(fd);

    });
}


function clicked(){
    alert("hola mundo")

}
