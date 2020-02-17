$(document).ready(function () {

    // START: config datatable
    let table_table = $('#table_table');
    table_table.DataTable({
        "order": [],
        "language": {
            url: urlLanguageDatatable(),
        },
        "processing": true,
        "serverSide": true,
        ajax: {
            url: urlIndex,
        },
        columns: [
            {
                data: 'id',
                name: 'id',
            },
            {
                data: 'name',
                name: 'name',
            },
            {
                data: 'number_of_seats',
                name: 'number_of_seats',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }

        ]
    });
    // END: config datatcomable


    //START: validate
    let table_form = $("#table_form");
    table_form.validate({
        rules: {
            name: {
                required: true,
                maxlength: 255
            },
            number_of_seats: {
                required: true,
                digits: true,
                maxlength: 10
            }
        },
        messages: {
            name: {
                maxlength: "*Không được vượt quá 255 ký tự."
            },
            number_of_seats: {
                maxlength: "*Không được vượt quá 10 ký tự."
            }
        }
    });
    //END: validate


    // START: while click button create
    let create_buton = $('#create_record');
    create_buton.click(function () {
        let action = $('#action');
        let form_modal = $('#form_modal');

        action.val('Thêm');
        form_modal.modal('show');
    });
    // END: while click button create


    // START: handle while close modal
    let form_modal = $('#form_modal');
    form_modal.on('hidden.bs.modal', function () {
        let table_form = $("#table_form");

        table_form.find('label.error').text('');
        table_form.find('input').removeClass('error');
        table_form[0].reset();
    });
    // END: handle while close modal


    // START: create category new
    table_form.on('submit', function () {
        if (table_form.valid()) {
            let action = $("#action").val();
            let formData = new FormData(this);

            if (action === "Thêm") {
                storeModel(urlStore, formData).done(function (data) {
                    if (data.errors) {
                        swalError(data);
                    }
                    if (data.success) {
                        form_modal.modal('hide');
                        table_form[0].reset();
                        table_table.DataTable().ajax.reload();
                        swalCreateSuccess();
                    }
                }).fail(function () {
                    swalErrorDefault();
                });
            }

            if (action === "Cập nhật") {
                updateModel(urlUpdate, formData).done(function (data) {
                    if (data.errors) {
                        swalError(data);
                    }
                    if (data.success) {
                        let hidden_id = $("#hidden_id");
                        form_modal.modal('hide');
                        table_form[0].reset();
                        table_table.DataTable().ajax.reload();
                        hidden_id.val('');
                        swalUpdateSuccess();
                    }
                }).fail(function () {
                    swalErrorDefault();
                });
            }
        }
    });
    // END: create category new


    // START: show category for edit
    $(document).on('click', '.edit', function () {
        let id = $(this).attr('id');
        let urlEdit = "tables/" + id + "/edit";

        let hidden_id = $("#hidden_id");
        let input_name = $("#name");
        let number_of_seats = $("#number_of_seats");

        let modal_title = $('.modal-title');
        let action = $('#action');
        let action_button = $('#action_button');

        getModel(urlEdit).done(function (data) {
            hidden_id.val(data.id);
            input_name.val(data.name);
            number_of_seats.val(data.number_of_seats);

            modal_title.text('Sửa bàn');
            action.val('Cập nhật');
            action_button.val('Cập nhật');

            form_modal.modal('show');
        }).fail(function () {
            swalErrorDefault();
        });
    });
    // END: show category for edit


    // START: delete category
    $(document).on('click', '.delete', function () {
        let user_id = $(this).attr('id');
        let urlDelete = "tables/destroy/" + user_id;

        Swal.fire(
            swalConfirmDelete()
        ).then((result) => {
            if (result.value) {
                deleteModel(urlDelete).done(function (data) {
                    if (data.success) {
                        swalDeleteSuccess();
                        table_table.DataTable().ajax.reload();
                    }
                }).fail(function () {
                    swalErrorDefault();
                });
            }
        });
    });
    // END: delete category
});
