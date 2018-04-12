$('#upload').prop('disabled', true);

$('#ProPicture').change ( function () {
    ($(this).get(0).files.length > 0) ? $('#upload').prop('disabled', false) : $('#upload').prop('disabled', true);
});

var onSuccess = function (data, status){
    if ( status == 'success' )
    {
        $('#ProfileUploader').on('hidden.bs.modal', function () {
            $('#imgProfile')[0].src = data.image;
        });

        $('#ProfileUploader').modal('hide');
    }
};

var onError = function (jqXHR, textStatus, errorThrown) {
    if (jqXHR.status == 400)
    {
        alert ( 'There was a problem in uploading your image, try again later' );
    }
};

$('#upload').click ( function () {
    var data = $('#ProPicture').get(0).files[0];

    var formData = new FormData ();
    formData.append('upload', data);

    $.ajax({
        method      : 'POST',
        url         : '/User/Profile/',
        processData : false,
        contentType : false,
        data        : formData,
        dataType    : 'JSON',
        success     : onSuccess,
        error       : onError,
        timeout     : 5000
    });
});