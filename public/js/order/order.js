$(document).ready(function () {
    //START: config datatable
    let order_table = $('#order_table');
    order_table.DataTable({
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
                data: 'table.name',
                name: 'table.name',
            },
            {
                data: 'created_by.full_name',
                name: 'created_by.full_name',
            },
            {
                data: 'order_status.name',
                name: 'order_status.name',
            },
            {
                data: 'bartender.full_name',
                name: 'bartender.full_name',
                defaultContent: "Chưa có",
            },
            {
                data: 'created_at',
                name: 'created_at',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
    });
    //END: config datatable


    //START: validate
    let order_form = $("#order_form");
    order_form.validate({
        rules: {
            table_id: {
                required: true
            }
        },
        messages: {
            table_id: {
                required: "*Vui lòng chọn bàn."
            }
        }
    });
    //END: validate


    // START: while click button create
    let create_button = $('#create_record');
    create_button.click(function () {
        let action = $('#action');
        let form_modal = $('#form_modal');
        let product_hidden = $("#product_hidden");

        product_hidden.append(rowProductOrder());
        action.val('Thêm');
        form_modal.modal('show');
    });
    // END: while click button create


    // START: handle while close modal create and update
    let form_modal = $('#form_modal');
    form_modal.on('hidden.bs.modal', function () {
        let order_form = $("#order_form");
        let product_order = $("#product_order tbody");

        product_order.html('');
        order_form[0].reset();
        order_form.find('label.error').text('');
        order_form.find('input').removeClass('error');
        order_form.find('select').removeClass('error');
    });

    // END: handle while close modal


    // START: handle while close modal info
    let modal_info = $("#modal_info");
    modal_info.on('hidden.bs.modal', function () {
        let product_info = $("#modal_info tbody");
        product_info.html('');
    });
    // END: handle while close modal

    // START: change quantity product
    $(document).on('click', '.add', function () {
        $(this).prev().val(+$(this).prev().val() + 1);
    });
    $(document).on('click', '.sub', function () {
        if ($(this).next().val() > 1) {
            if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
        }
    });
    //END: change quantity product


    // START: append data selected
    let product_select = $("#product_id");
    let tBody = $("#product_order tbody");

    product_select.on('change', function () {
        let id = product_select.val();
        let name = $("#product_id option:selected").html();
        let product_hidden = $("#product_hidden");

        let checkExists = $("#product_" + id).val();

        if (checkExists === undefined) {
            tBody.append(rowProduct(id, name));
        } else {
            swalWarningExists();
        }

        product_hidden.remove();
    });
    // END: append data selected


    //START: remove product order
    $(document).on("click", ".remove_product", function () {
        $(this).closest('tr').remove();
    });
    //END: remove product order


    // START: create and update
    order_form.on('submit', function () {

        let formData = new FormData(this);
        let action = $("#action").val();

        if (order_form.valid()) {
            let form_modal = $('#form_modal');
            if (action === "Thêm") {
                storeModel(urlStore, formData).done(function (data) {
                    if (data.errors) {
                        swalError(data);
                    }
                    if (data.success) {
                        form_modal.modal('hide');
                        order_form[0].reset();
                        order_table.DataTable().ajax.reload();
                        swalCreateSuccess();
                    }
                }).fail(function () {
                    form_modal.modal('hide');
                    order_table.DataTable().ajax.reload();
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
                        order_form[0].reset();
                        order_table.DataTable().ajax.reload();
                        hidden_id.val('');
                        swalUpdateSuccess();
                    }
                }).fail(function () {
                    form_modal.modal('hide');
                    order_table.DataTable().ajax.reload();
                    swalErrorDefault();
                });
            }
        }
    });
    // END: create and update

    // START: show  for edit
    $(document).on('click', '.edit', function () {

        let id = $(this).attr('id');
        let urlEdit = "orders/" + id + "/edit";

        getModel(urlEdit).done(function (data) {

            let hidden_id = $("#hidden_id");
            let table_id = $("#table_id");
            let order_status_id = $("#order_status_id");
            let modal_title = $('.modal-title');
            let action = $('#action');
            let form_modal = $('#form_modal');
            let tBody = $("#product_order tbody");
            let product_hidden = $("#product_hidden");

            $.each(data.order_product, function (index, order_product) {
                let nameProduct = '';
                $.each(data.products, function (index, products) {
                    if (products.id === order_product.product_id) {
                        nameProduct = products.name;
                    }
                });
                let products = rowProductEdit(order_product.product_id, nameProduct, order_product.quantity);
                tBody.append(products);
            });

            product_hidden.remove();
            hidden_id.val(data.id);
            table_id.val(data.table_id);
            order_status_id.val(data.order_status_id);
            modal_title.text('Sửa order');
            action.val('Cập nhật');
            form_modal.modal('show');
        })
    });
    // END: show for edit

    // START: delete
    $(document).on('click', '.delete', function () {
        let order_id = $(this).attr('id');
        let urlDelete = "orders/destroy/" + order_id;

        Swal.fire(
            swalConfirmDelete()
        ).then((result) => {
            if (result.value) {
                deleteModel(urlDelete).done(function (data) {
                    if (data.success) {
                        swalDeleteSuccess();
                        order_table.DataTable().ajax.reload();
                    }
                }).fail(function () {
                    order_table.DataTable().ajax.reload();
                    swalErrorDefault();
                });
            }
        });
    });
    // END: delete

    // START: show inf
    $(document).on('click', '.view', function () {
        let order_id = $(this).attr('id');
        let urlEdit = "orders/" + order_id + "/edit";

        getModel(urlEdit).done(function (data) {
            let modal_info = $("#modal_info");
            let info_table = $("#info_table");
            let info_created_by = $("#info_created_by");
            let info_status = $("#info_status");
            let info_bartender = $("#info_bartender");
            let tBody = $("#modal_info tbody");

            modal_info.modal('show');
            info_table.text(data.table.name);
            info_created_by.text(data.created_by.full_name);
            info_status.text(data.order_status.name);
            if (data.bartender == null) {
                info_bartender.text('Chưa có');
            } else {
                info_bartender.text(data.bartender.full_name);
            }

            $.each(data.order_product, function (index, order_product) {
                let nameProduct = '';
                $.each(data.products, function (index, products) {
                    if (products.id === order_product.product_id) {
                        nameProduct = products.name;
                    }
                });
                let products = rowProductInfo(index + 1, nameProduct, order_product.quantity);
                tBody.append(products);
            });

        });
    });
    // END: show info
});
