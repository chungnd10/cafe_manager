jQuery.validator.setDefaults({
    debug: true,
    success: function (element) {
        $(element).closest('.form-group').removeClass('has-error');
        element.remove();
    }
});

function getBase64(file, selector) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function () {
        $(selector).attr('src', reader.result);
    };
    reader.onerror = function (error) {
        console.log('error: ', error);
    };
}


// store
function storeModel(url, formData) {
    return $.ajax({
        url: url,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        dataType: "json"
    });
}

// show
function getModel(url) {
    return $.ajax({
        url: url,
        dataType: "json"
    });
}

// update
function updateModel(url, formData) {
    return $.ajax({
        url: url,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        dataType: "json"
    });
}

// delete
function deleteModel(url) {
    return $.ajax({
        url: url
    });
}

// display row product order
function rowProduct(id, name) {
    return "<tr>" +
        "<td>" + name + "</td>" +
        "<td>" +
        "<button type='button' class='sub btn btn-default '>-</button>" +
        "<input type='number' class='input-quantity' name='quantity[]' value='1' min='1'/>" +
        "<button type='button' class='add btn btn-default'>+</button></td>" +
        "<input type='hidden'  name='products_id[]' id='product_" + id + "' value='" + id + "'/>" +
        "<td>" +
        "<button type='button' class='remove_product btn btn-warning'>" +
        "<i class='fa fa-trash'></i>" +
        "</button>" +
        "</td>" +
        "</tr>";
}

// display row product order for edit
function rowProductEdit(id, name, quantity) {
    return "<tr>" +
        "<td>" + name + "</td>" +
        "<td>" +
        "<button type='button' class='sub btn btn-default '>-</button>" +
        "<input type='number' class='input-quantity' name='quantity[]'  value='" + quantity + "' min='1'/>" +
        "<button type='button' class='add btn btn-default'>+</button></td>" +
        "<input type='hidden'  name='products_id[]' id='product_" + id + "' value='" + id + "'/>" +
        "<td>" +
        "<button type='button' class='remove_product btn btn-warning'>" +
        "<i class='fa fa-trash'></i>" +
        "</button>" +
        "</td>" +
        "</tr>";
}

// display row input product order
function rowProductOrder() {
    return "<tr>" +
        "<td>" +
        "<input type='hidden' name='quantity[]' value=''>" +
        "<input type='hidden' name='products_id[]' value=''>" +
        "</td>" +
        "</tr>";
}

// display row input product info
function rowProductInfo(index, name, quantity) {
    return "<tr>" +
        "<td>" +
        "<span>" + index + "</span>" +
        "</td>" +
        "<td>" +
        "<span>" + name + "</span>" +
        "</td>" +
        "<td>" +
        "<span>" + quantity + "</span>" +
        "</td>" +
        "</tr>";
}

// message swal error
function swalError(data) {
    return Swal.fire(
        'Lỗi!',
        data.errors[0],
        'error'
    )
}

// message swal error
function swalErrorDefault() {
    return Swal.fire(
        'Lỗi!',
        'Có lỗi gì đó, hãy thử lại',
        'error'
    )
}

//message swal create success
function swalCreateSuccess() {
    return Swal.fire(
        'Thành công!',
        'Thêm mới thành công!',
        'success'
    )
}

//message swal update success
function swalUpdateSuccess() {
    return Swal.fire(
        'Thành công!',
        'Cập nhật thành công!',
        'success'
    )
}

//message swal delete success
function swalDeleteSuccess() {
    return Swal.fire(
        'Thành công!',
        'Dữ liệu đã được xóa thành công!',
        'success'
    )
}

//message swal exists
function swalWarningExists() {
    return Swal.fire(
        'Đã tồn tại',
        'Sản phẩm đã tồn tại trong order',
        'warning'
    )
}

//message swal success
function swalConfirmDelete() {
    return {
        title: 'Bạn có chắc chắn muốn xóa không?',
        text: "Dữ liệu liên quan cũng sẽ bị xóa",
        icon: 'warning',
        showCancelButton: true,
        reverseButtons: true
    }
}

// urlLanguageDatatable
function urlLanguageDatatable() {
    return 'admin_assets/bower_components/datatables.net-bs/lang/vietnamese-lang.json';
}


