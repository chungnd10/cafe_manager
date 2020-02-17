$(document).ready(function () {

    //START: config datatable
    let user_table = $('#user_table');
    user_table.DataTable({
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
                data: 'full_name',
                name: 'full_name',
            },
            {
                data: 'avatar',
                name: 'avatar',
                render: function (data) {
                    return "<img class=img-bordered alt=image src=upload/images/users/" + data + " width='80' />"
                },
                orderable: false
            },
            {
                data: 'phone_number',
                name: 'phone_number',
            },
            {
                data: 'role.name',
                name: 'role.name',
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
    let user_form = $("#user_form");
    user_form.validate({
        rules: {
            full_name: {
                required: true,
                maxlength: 255,
            },
            email: {
                required: true,
                emailGood: true,
            },
            phone_number: {
                required: true,
                phoneNumberVietNam: true
            },
            birthday: {
                required: true,
            },
            role_id: {
                required: true,
            },
            address: {
                required: true,
                maxlength: 255,
            },
            avatar: {
                extension: "jpg|jpeg|png"
            },
            password: {
                required: true,
                minlength: 8,
                maxlength: 40,
            },
            cf_password: {
                required: true,
                equalTo: password,
            },
        },
        messages: {
            full_name: {
                maxlength: '*Không được vượt quá 255 ký tự.',
            },
            address: {
                maxlength: '*Không được vượt quá 255 ký tự.',
            },
            avatar: {
                extension: "*Chỉ chấp nhận ảnh jpg, jpeg, png."
            },
            password: {
                minlength: '*Yêu cầu mật khẩu từ 8-40 ký tự',
                maxlength: '*Yêu cầu mật khẩu từ 8-40 ký tự',
            },
            cf_password: {
                equalTo: '*Nhập lại mật khẩu không đúng.',
            },
        }
    });
    //END: validate

    //START: config datapicker
    $('#birthday').datepicker({
        autoclose: true,
        dateFormat: 'yyyy-mm-dd'
    });
    //END: config datapicker


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
        let password = $('#password');
        let cf_password = $('#cf_password');
        let required_password = $(".required-password");

        action.val('Thêm');
        form_modal.modal('show');
        password.rules('add', 'required');
        cf_password.rules('add', 'required');
        required_password.text('*');
    });
    // END: while click button create


    // START: handle while close modal
    let form_modal = $('#form_modal');
    form_modal.on('hidden.bs.modal', function () {
        let img_display = $("#img_display");
        let img_default = 'avatar-default.jpg';
        let urlImage = 'upload/images/users/';
        let required_password = $(".required-password");

        user_form[0].reset();
        user_form.find('label.error').text('');
        user_form.find('input').removeClass('error');
        user_form.find('select').removeClass('error');
        img_display.attr("src", urlImage + img_default);
        required_password.text('');
    });
    // END: handle while close modal


    // START: create and update
    user_form.on('submit', function () {
        let formData = new FormData(this);
        let action = $("#action").val();

        if (user_form.valid()) {
            let form_modal = $('#form_modal');
            if (action === "Thêm") {
                storeModel(urlStore, formData).done(function (data) {
                    if (data.errors) {
                        swalError(data);
                    }
                    if (data.success) {
                        form_modal.modal('hide');
                        user_form[0].reset();
                        user_table.DataTable().ajax.reload();
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
                        user_form[0].reset();
                        user_table.DataTable().ajax.reload();
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

    // START: show  for edit
    $(document).on('click', '.edit', function () {

        let id = $(this).attr('id');
        let urlEdit = "users/" + id + "/edit";

        getModel(urlEdit).done(function (data) {

            let hidden_id = $("#hidden_id");

            let full_name = $("#full_name");
            let email = $("#email ");
            let phone_number = $("#phone_number ");
            let birthday = $("#birthday ");
            let role_id = $("#role_id ");
            let address = $("#address ");

            let img_display = $("#img_display");
            let modal_title = $('.modal-title');
            let action = $('#action');
            let form_modal = $('#form_modal');
            let urlImage = 'upload/images/users/';

            hidden_id.val(data.id);
            full_name.val(data.full_name);
            email.val(data.email);
            phone_number.val(data.phone_number);
            birthday.val(data.birthday);
            role_id.val(data.role_id);
            address.val(data.address);

            img_display.attr('src', urlImage + data.avatar);
            modal_title.text('Sửa người dùng');
            action.val('Cập nhật');
            form_modal.modal('show');

            let password = $('#password');
            let cf_password = $('#cf_password');
            password.rules('remove', 'required');
            cf_password.rules('remove', 'required');
        })
    });
    // END: show for edit


    // START: delete
    $(document).on('click', '.delete', function () {
        let product_id = $(this).attr('id');
        let urlDelete = "users/destroy/" + product_id;

        Swal.fire(
            swalConfirmDelete()
        ).then((result) => {
            if (result.value) {
                deleteModel(urlDelete).done(function (data) {
                    if (data.success) {
                        swalDeleteSuccess();
                        user_table.DataTable().ajax.reload();
                    }
                }).fail(function () {
                    swalErrorDefault();
                });
            }
        });
    });
    // END: delete
});
