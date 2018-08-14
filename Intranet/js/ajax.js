$(".fix").click(function(){
    var id = $(this).attr('id');
    var Post_id = $(this).val();

    var checkB = document.getElementsByClassName("fix");
    var RESB = document.getElementsByClassName("RES");
    for(var i=0; i<checkB.length;i++){
        checkB[i].checked = false;
        RESB[i].innerText="Fijar";
    }

    $("#"+id).prop('checked', true);

    $.ajax({
        data:  {"id":Post_id},
        url:   'fijar.php',
        type:  'post',
        beforeSend: function () {
        $('#res'+Post_id).html("Fijando...");
        },
        success:  function (response) {
        $('#res'+Post_id).html(response);
        },
        error: function (request, status, error) {
        alert(request.responseText);
        }
        });

});
