var table = $('#users').DataTable ({
    'processing'    : true,
    'serverSide'    : true,
    'responsive'    : true,
    'lengthMenu'    : [5,10,15],
    'ajax'          :
        {
            url     : '/Users/List/',
            type    : 'POST'
        },
    'columns'       :
    [
        {
            'data'      : 0,
            'render'    : function (data, type, row) {
                return data + ' ' + row [1];
            },
            'searchable': true,
            'orderable' : true
        },
        {
            'data'      : 2,
            'searchable': true,
            'orderable' : true
        },
        {
            'data'      : 3,
            'searchable': false,
            'orderable' : true
        },
        {
            'data'      : 4,
            'searchable': false,
            'orderable' : true
        },
        {
            'data'      : 5,
            'render'    : function (data, type, row) {
                if ( data !== '' )
                    return "<a href=\"/Users/Edit/" + data + "\"><i class=\"far fa-edit\"></i></a>";
                return "";
            },
            'searchable': false,
            'orderable' : false
        },
        {
            'data'      : 6,
            'render'    : function (data, type, row, meta) {
                if ( data !== '' )
                    return "<button type=\"button\" data-toggle=\"modal\" data-target=\"#DeleteUser\" data-row=\"" + meta.row + "\" data-UserID=\"" + data + "\"><i class=\"far fa-trash-alt\"></i></button>";
                return "";
            },
            'searchable': false,
            'orderable' : false
        }
    ],
    'order'         : [[0, 'asc']]
});

$('#DeleteUser').on('show.bs.modal', function (event) {
   var button = $(event.relatedTarget);
   var UserID = button.data('userid');
   var TableRow = button.data('row');
   $('#delete').off( 'click' );
   $('#delete').on( 'click', function (){
      $.ajax ({
          type       : 'POST',
          url        : '/Users/Delete/',
          data       : {'UserId' : UserID},
          success    : function (data, status) {
              $('#DeleteUser').off('hidden.bs.modal');
              $('#DeleteUser').on('hidden.bs.modal', function () {
                  table.row(TableRow).remove().draw();
              });
              $('#DeleteUser').modal('hide');
          },
          error      : function (jqXHR, textStatus, errorThrown){
              alert ('An error has occurred, please try again later');
          },
          timeout   : 5000
      });
   });
});
