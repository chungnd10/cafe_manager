jQuery.validator.setDefaults({
    debug: true,
    success: "valid"
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

function printErrorMessage(data) {
    html = '<div class="alert alert-danger">';
    for (var count = 0; count < data.errors.length; count++) {
        html += '<p>' + data.errors[count] + '</p>';
    }
    html += '</div>';
    return html;
}
