$("#categorySection").change(function(){
    var value = $("#categorySection").val();
    $.ajax({
        data:  {"value":value},
        url:   'actualizar.php',
        type:  'post',
        beforeSend: function () {
            $('#resultado').html("<img src='img/loading.gif'>");
        },
        success:  function (response) {
            $('#resultado').html("");
            $('#categoryselect').html(response);
        },
        error: function (request, status, error) {
            console.log(request.responseText);
        }
    });
});
