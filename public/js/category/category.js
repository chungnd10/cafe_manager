$(document).ready(function () {

    // START: config datatable
    let category_table = $('#category-table');
    category_table.DataTable({
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
                orderable: false
            },
            {
                data: 'name',
                name: 'name',
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
    let category_form = $("#category_form");
    category_form.validate({
        rules: {
            name: {
                required: true,
                maxlength: 255
            }
        },
        messages: {
            name: {
                maxlength: "*Không được vượt quá 255 ký tự."
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
        let category_form = $("#category_form");

        category_form.find('label.error').text('');
        category_form.find('input').removeClass('error');
        category_form[0].reset();
    });
    // END: handle while close modal


    // START: create and update
    category_form.on('submit', function () {
        if (category_form.valid()) {

            let action = $("#action").val();
            let formData = new FormData(this);

            if (action === "Thêm") {
                storeModel(urlStore, formData).done(function (data) {
                    if (data.errors) {
                        swalError(data);
                    }
                    if (data.success) {
                        form_modal.modal('hide');
                        category_form[0].reset();
                        category_table.DataTable().ajax.reload();
                        swalCreateSuccess();
                    }
                }).fail(function () {
                    swalErrorDefault();
                });
            }

            if (action === "Cập nhật") {
                let hidden_id = $("#hidden_id");
                updateModel(urlUpdate, formData).done(function (data) {
                    if (data.errors) {
                        swalError(data);
                    }
                    if (data.success) {
                        form_modal.modal('hide');
                        category_form[0].reset();
                        category_table.DataTable().ajax.reload();
                        hidden_id.val('');
                        swalUpdateSuccess();
                    }
                }).fail(function () {
                    swalErrorDefault();
                });
            }
        }
    });
    // END: create and update


    // START: show for edit
    $(document).on('click', '.edit', function () {
        let id = $(this).attr('id');
        let urlEdit = "categories/" + id + "/edit";

        let hidden_id = $("#hidden_id");
        let input_name = $("#name");
        let modal_title = $('.modal-title');
        let action = $('#action');
        let action_button = $('#action_button');

        getModel(urlEdit).done(function (data) {
            hidden_id.val(data.id);
            input_name.val(data.name);

            modal_title.text('Sửa danh mục');
            action.val('Cập nhật');
            action_button.val('Cập nhật');

            form_modal.modal('show');
        }).fail(function () {
            swalErrorDefault();
        });
    });
    // END: show for edit


    // START: delete
    $(document).on('click', '.delete', function () {
        let user_id = $(this).attr('id');
        let urlDelete = "categories/destroy/" + user_id;

        Swal.fire(
            swalConfirmDelete()
        ).then((result) => {
            if (result.value) {
                deleteModel(urlDelete).done(function (data) {
                    if (data.success) {
                        swalDeleteSuccess();
                        category_table.DataTable().ajax.reload();
                    }
                }).fail(function () {
                    swalErrorDefault();
                });
            }
        });
    });
    // END: delete
});
