function sendForm(form) {
    var XHR = new XMLHttpRequest();
    var FD  = new FormData(document.getElementById(form));
    XHR.addEventListener('load', function(event) {
        // alert('Yeah! Data sent and response loaded.' + XHR.response);
        location.reload();
    });
    XHR.addEventListener('error', function(event) {
        alert('Oops! Something went wrong.');
    });
    XHR.open('POST', '/index.php?site=edit');
    XHR.send(FD);
}
//przepraszam
function sendData(data) {
    var XHR = new XMLHttpRequest();
    var FD  = new FormData();

    // Push our data into our FormData object
    for(name in data) {
        FD.append(name, data[name]);
    }

    // Define what happens on successful data submission
    XHR.addEventListener('load', function(event) {
        // alert('Yeah! Data sent and response loaded.' + XHR.response);
        location.reload();
    });

    // Define what happens in case of error
    XHR.addEventListener('error', function(event) {
        alert('Oops! Something went wrong.');
    });

    // Set up our request
    XHR.open('POST', '/index.php?site=edit');

    // Send our FormData object; HTTP headers are set automatically
    XHR.send(FD);
}

$('#output').on('click', '.delete-bt', function () {
    var state = $(this).closest('tr').attr('state');
    if (state == "edit") {
        location.reload();
    }
    if (state == "normal") {
        var table = $(this).closest('tr').attr('table');
        var id = parseInt($(this).closest('tr').find("td").first().text());
        sendData({"table": table, "action": "delete", "id": id});
    }

});


$('#output').on('click', '.edit-bt', function () {
    var state = $(this).closest('tr').attr('state');
    if (state == "normal") {
        $(this).closest('tr').attr('state', 'edit');
        var dict = {};
        var data = $(this).closest('tr').find("td").each(function () {
            var attr = $(this).attr('name');
            var value = $(this).text().trim();
            var temp = `<input type="text" class="form-control editing" placeholder="${attr}" value="${value}">`;
            if (attr == 'id') {
                return;
            }
            $(this).html(temp);
        })
    }
    if (state == "edit") {
        $(this).closest('tr').attr('state', 'normal');
        // send ajax and restart webpage
        var dict = {};
        var data = $(this).closest('tr').find("td").each(function () {
            var val = $(this).find('input').val();
            // alert(val);
            var attr = $(this).attr('name');
            dict[attr] = val;
        });
        var id = parseInt($(this).closest('tr').find("td").first().text());
        dict['id'] = id;
        var table = $(this).closest('tr').attr('table');
        dict['table'] = table;
        dict['action'] = "edit";
        sendData(dict);
    }
    /* alert(JSON.stringify(dict)); */
});

// jakby ktoś wcisnął enter podczas edycji produktów
$('#output').on('keypress', 'input.editing', function (e) {
    if (e.which == 13) {
        // zasymuluj wciśniecie przysisku edit
        $(this).closest('tr').find('.edit-bt').trigger("click");
    }
});
