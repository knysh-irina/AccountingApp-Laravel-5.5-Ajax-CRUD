$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function ($) {


    $('#open').on('click', function () {
        $('#myModal').modal('show');
    });
    $('#close').on('click', function () {
        $('#myModal').modal('hide');
    });

    $('#saveOperation').on('click', function () {
        var name = $("input[name=name]").val();
        var val_grn = $("input[name=val_grn]").val();
        var from = $('#from').prop('value');
        var to = $('#to').prop('value');
        if (name && val_grn) {
            $.post("addOperation", {name: name, val_grn: val_grn, from: from, to: to}, function (data) {
                $('#operations').html(data);
            });
            $('#myModal').modal('hide');
        } else {
            $("#alert").html("Fill all fields!");
        }
    });

  var id_edit_global;

    $('#operations').on('click','.edit', function () {
        var id_edit = this.className.split(' ')[3].substr(2);
        id_edit_global = id_edit;
        var name_edit = $(this).parent().siblings()[1].innerHTML;
        var val_grn_edit = $(this).parent().siblings()[2].innerHTML;
        $('#name_edit').prop('value', name_edit);
        $('#val_grn_edit').prop('value', val_grn_edit);
        $('#editModal').modal('show');

        console.log(name_edit+" "+val_grn_edit);


    });
    $('#close_edit').on('click', function () {
        $('#editModal').modal('hide');
    });


    $('#editOperation').on('click', function (e) {

        var name_edit2 = $("input[name=name_edit]").val();
        var val_grn_edit2 = $("input[name=val_grn_edit]").val();
        var from = $('#from').prop('value');
        var to = $('#to').prop('value');

        console.log(from+ to);
        if (name_edit2 && val_grn_edit2) {
            $.post("editOperation", {name: name_edit2, val_grn: val_grn_edit2, id_edit: id_edit_global, from: from, to: to}, function (data) {
                $('#operations').html(data);
            });
            $('#editModal').modal('hide');
        } else {
            $("#alert_edit").html("Fill all fields!");
        }
    });




    $('#operations').on('click','.delete',  function () {

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this operation!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
            if (willDelete) {
                var oper_id = this.className.split(' ')[3].substr(2);
                $.post("deleteOperation", {id_delete: oper_id}, function (data) {
                    $('#operations').html(data);
                });
                swal("Poof! Your operation has been deleted!", {
                    icon: "success",
                });
            } else {
                swal("Your operation is safe!");
    }
    });


    });

    $('#from').add('#to').on('change', function () {
        var from = $('#from').prop('value');
        var to = $('#to').prop('value');
        $.post("filterByDate", {from: from, to: to}, function (data) {
            $('#operations').html(data);
        });
    });


});