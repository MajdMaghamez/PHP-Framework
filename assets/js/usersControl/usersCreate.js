onSuccess = function (data) {
    var html = "<h5>" + data.NAME + "</h5>";
    html += "<p>" + data.DESCRIPTION + "</p><hr/>";
    html += "<table class=\"table table-sm table-responsive-sm\"><thead><tr><th></th><th>Name</th><th>Description</th></tr></thead><tbody>";
    $.each ( data.PERMISSIONS, function ( index, element ) {
        html += "<tr><td><i class=\"far fa-check-square\"></i></td><td>" + element.NAME + "</td><td>" + element.DESCRIPTION + "</td></tr>";
    });
    html += "</tbody></table>";
    $(html).appendTo ('#roleDetails');
};

$('#role').change ( function () {
    var role = $(this).val();
    $('#roleDetails').html ('');
    if ( role > 0 )
        $.get ( '/Users/Role/Details/' + role, onSuccess, 'json' );
});