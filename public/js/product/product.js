$(document).ready(function () {
    //START: config datatable
    let product_table = $('#product_table');
    product_table.DataTable({
        "order": [],
        "language": {
            url: urlLanguageDatatable(),
        },
        "processing": true,
        "serverSide": true,
        "response": true,
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
                data: 'avatar',
                name: 'avatar',
                render: function (data) {
                    return "<img class=img-bordered alt=image src=upload/images/products/" + data + " width='80' />"
                },
                orderable: false
            },
            {
                data: 'price',
                name: 'price',
            },
            {
                data: 'description',
                name: 'description',
                orderable: false
            },
            {
                data: 'category.name',
                name: 'category.name',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
    //END: config datatable

    //START: validate
    let product_form = $("#product_form");
    product_form.validate({
        rules: {
            name: {
                required: true,
                maxlength: 255,
            },
            price: {
                required: true,
                digits: true,
                maxlength: 16
            },
            category_id: {
                required: true,
            },
            avatar: {
                extension: "jpg|jpeg|png"
            }
        },
        messages: {
            name: {
                maxlength: "*Không được vượt quá 255 ký tự.",
            },
            price: {
                maxlength: "*Không được nhập quá 16 ký tự.",
            },
            avatar: {
                extension: "*Chỉ chấp nhận định dạng jpg, jpeg, png.",
            }
        }
    });
    //END: validate


    // START: display image for input
    let inputImage = $("#avatar");
    inputImage.on('change', function () {
        let file = this.files[0];
        let img_display = $("#img_display");

        if (file) {
            getBase64(file, img_display);
        }
    });
    // END: display image for input


    // START: while click button create
    let create_button = $('#create_record');
    create_button.click(function () {
        let action = $('#action');
        let form_modal = $('#form_modal');

        action.val('Thêm');
        form_modal.modal('show');
    });
    // END: while click button create


    // START: handle while close modal
    let form_modal = $('#form_modal');
    form_modal.on('hidden.bs.modal', function () {
        let img_display = $("#img_display");
        let img_default = 'product-default.jpg';
        let urlImage = 'upload/images/products/';

        product_form[0].reset();
        product_form.find('label.error').text('');
        product_form.find('input').removeClass('error');
        product_form.find('select').removeClass('error');
        img_display.attr("src", urlImage + img_default);
    });
    // END: handle while close modal


    // START: create category new
    product_form.on('submit', function () {

        let formData = new FormData(this);
        let action = $("#action").val();

        if (product_form.valid()) {

            let form_modal = $('#form_modal');
            if (action === "Thêm") {
                storeModel(urlStore, formData).done(function (data) {
                    if (data.errors) {
                        swalError(data);
                    }
                    if (data.success) {
                        form_modal.modal('hide');
                        product_form[0].reset();
                        product_table.DataTable().ajax.reload();
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
                        product_form[0].reset();
                        product_table.DataTable().ajax.reload();
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


    // START: show  for edit
    $(document).on('click', '.edit', function () {

        let id = $(this).attr('id');
        let urlEdit = "products/" + id + "/edit";

        getModel(urlEdit).done(function (data) {

            let hidden_id = $("#hidden_id");
            let input_name = $("#name");
            let input_price = $("#price");
            let category_id = $("#category_id");
            let description = $("#description");

            let img_display = $("#img_display");
            let modal_title = $('.modal-title');
            let action = $('#action');
            let form_modal = $('#form_modal');
            let urlImage = 'upload/images/products/';

            hidden_id.val(data.id);
            input_name.val(data.name);
            input_price.val(data.price);
            category_id.val(data.category_id);
            description.val(data.description);

            img_display.attr('src', urlImage + data.avatar);
            modal_title.text('Sửa sản phẩm');
            action.val('Cập nhật');
            form_modal.modal('show');
        })
    });
    // END: show for edit


    // START: delete category
    $(document).on('click', '.delete', function () {
        let product_id = $(this).attr('id');
        let urlDelete = "products/destroy/" + product_id;

        Swal.fire(
            swalConfirmDelete()
        ).then((result) => {
            if (result.value) {
                deleteModel(urlDelete).done(function (data) {
                    if (data.success) {
                        swalDeleteSuccess();
                        product_table.DataTable().ajax.reload();
                    }
                }).fail(function () {
                    swalErrorDefault();
                });
            }
        });
    });
    // END: delete category
});
