
function getInputSelection(el) {
    var start = 0, end = 0, normalizedValue, range,
        textInputRange, len, endRange;

    if (typeof el.selectionStart == "number" && typeof el.selectionEnd == "number") {
        start = el.selectionStart;
        end = el.selectionEnd;
    } else {
        range = document.selection.createRange();

        if (range && range.parentElement() == el) {
            len = el.value.length;
            normalizedValue = el.value.replace(/\r\n/g, "\n");

            // Create a working TextRange that lives only in the input
            textInputRange = el.createTextRange();
            textInputRange.moveToBookmark(range.getBookmark());

            // Check if the start and end of the selection are at the very end
            // of the input, since moveStart/moveEnd doesn't return what we want
            // in those cases
            endRange = el.createTextRange();
            endRange.collapse(false);

            if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1) {
                start = end = len;
            } else {
                start = -textInputRange.moveStart("character", -len);
                start += normalizedValue.slice(0, start).split("\n").length - 1;

                if (textInputRange.compareEndPoints("EndToEnd", endRange) > -1) {
                    end = len;
                } else {
                    end = -textInputRange.moveEnd("character", -len);
                    end += normalizedValue.slice(0, end).split("\n").length - 1;
                }
            }
        }
    }

    return {
        start: start,
        end: end
    };
}


function getNewValue(actual_value, tag , url, info,start){

    var newValue='';

    if(tag=="youtube"){
        if(actual_value == ""){
            newValue =newValue.concat("["+tag+"]");
            newValue =newValue.concat(url);
            newValue =newValue.concat("[/"+tag+"]\n");
        }
        else if(actual_value.length == start){
            newValue =newValue.concat(actual_value);
            newValue =newValue.concat("[youtube]");
            newValue =newValue.concat(url);
            newValue =newValue.concat("[/youtube]\n");
        }
        else
            for (var i = 0; i< actual_value.length; i++) {
                    if(i==start){
                        newValue = newValue.concat("\n[");
                        newValue = newValue.concat(tag);
                        newValue = newValue.concat("]");

                        newValue = newValue.concat(url);
                        newValue = newValue.concat("[/");
                        newValue = newValue.concat(tag);
                        newValue = newValue.concat("]\n");
                    }else
                        newValue = newValue.concat(actual_value[i]);
            }
    }


    if(tag=="img"){
        if(actual_value == ""){
            newValue =newValue.concat("["+tag+"]");
            newValue =newValue.concat(url);
            newValue =newValue.concat("[/"+tag+"]\n");
            newValue =newValue.concat("[info]");
            newValue =newValue.concat(info);
            newValue =newValue.concat("[/info]\n");
        }
        else if(actual_value.length == start){
            newValue =newValue.concat(actual_value);
            newValue =newValue.concat("["+tag+"]");
            newValue =newValue.concat(url);
            newValue =newValue.concat("[/"+tag+"]\n");
            newValue =newValue.concat("[info]");
            newValue =newValue.concat(info);
            newValue =newValue.concat("[/info]\n");

        }
        else
            for (var i = 0; i< actual_value.length; i++) {
                    if(i==start){
                        newValue = newValue.concat("\n[");
                        newValue = newValue.concat(tag);
                        newValue = newValue.concat("]");
                        newValue = newValue.concat(url);
                        newValue = newValue.concat("[/");
                        newValue = newValue.concat(tag);
                        newValue = newValue.concat("]\n");

                        newValue =newValue.concat("[info]");
                        newValue =newValue.concat(info);
                        newValue =newValue.concat("[/info]\n");


                    }else
                        newValue = newValue.concat(actual_value[i]);
            }
    }

    return newValue;
}

function getYoutubeURL(url){

    var newURL='';
    var y = "https://www.youtube.com/watch?v=";
    var y2 = "https://youtu.be/";


    if(url.indexOf(y) > -1){
        newURL = url.substring(y.length,url.length);
    }else if(url.indexOf(y2) > -1){
        newURL = url.substring(y2.length,url.length);
    }else{
        newURL = "-1";
    }


    return newURL;

}

document.getElementById("btnYoutube").addEventListener("click",function(){
    var input = document.getElementById("postarea");
    var inputContent = input.value.length;
    input.focus();


    //cursor position in textarea
    var result = getInputSelection(input);
    //Ocultar el dropdown al terminar
    var drop = document.getElementById("YOU");
     drop.classList.remove("open");


    var value = input.value;
    var url = document.getElementById("youtubeURL").value;
    url = getYoutubeURL(url);
    if(url=="-1"){
        alert("Por favor inserte url de videos con esta forma:\n\nhttps://www.youtube.com/watch?v=kOc-W1K8EoM\n\n O también:\n\nhttps://youtu.be/kOc-W1K8EoM");
    }else{
        var newValue = getNewValue(value,"youtube",url,"",result.start);
        input.value = newValue;
    }

    document.getElementById("youtubeURL").value ='';






},false);






function imgName(){
    var fullPath = document.getElementById('file-input').value;
    var filename ;
    if (fullPath) {
        var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
        filename = fullPath.substring(startIndex);
        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
            filename = filename.substring(1);
        }

    }
    return filename;

}

$(document).ready(init());

function init(){
    fileInput = document.getElementById('file-input');
    uploadProgress = document.getElementById('upload-progress');
    message = document.getElementById('message');
    img = document.getElementById('IMG');
    information = document.getElementById('information');
    enviar = document.getElementById('enviar');
    var filename;

    enviar.disabled = true;
    enviar.style.cursor= 'not-allowed';

    fileInput.addEventListener('change',function(){
        enviar.disabled = false;
        enviar.style.cursor= 'pointer';

        filename = imgName();
        message.innerHTML= filename;
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
            fileInput.disabled = false;
        };

        xhr.upload.onloadend = function(e){
            uploadProgress.classList.remove('visible');
            message.innerHTML = 'complete...';
            fileInput.disabled = false;

        };
        xhr.onload = function(){
                message.innerHTML = xhr.responseText;
                var imgName = document.getElementById('newName').value;

                image(imgName);

                var n = document.getElementById('body');
                n.classList.remove("modal-open");
                n.style ="";

                var modal = document.getElementById('myModal');
                modal.classList.remove('in');
                modal.style.display = "none";

                var m = document.getElementsByClassName("modal-backdrop");
                m[0].remove();

                $("#file-input").val('');
                message.innerHTML ='';
                uploadProgress.value=0;
                information.value ='';
        };
        xhr.open('POST', 'catch-file.php', true);
        xhr.send(fd);

    });
}

function image(imgName){
    var input = document.getElementById("postarea");
    var inputContent = input.value.length;
    input.focus();
    //alert(imgName);


    //cursor position in textarea
    var result = getInputSelection(input);

    console.log(result);

    var value = input.value;
    var information = document.getElementById("information").value;

    var newValue = getNewValue(value,"img",imgName,information,result.start);
    input.value = newValue;

}
