//function store
function storeCategory(url, formData) {
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
function getCategory(url) {
    return $.ajax({
        url: url,
        dataType: "json"
    });
}

//function update
function updateCategory(url, formData) {
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
function deleteCategory(url) {
    return $.ajax({
        url: url
    });
}

