//function update
function store(url, formData) {
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

// function get data
function getProduct(url) {
    return $.ajax({
        url: url,
        dataType: "json"
    });
}

//function update
function update(url, formData) {
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

// funtion delete
function deleteProduct(url) {
    return $.ajax({
        url: url
    });
}
