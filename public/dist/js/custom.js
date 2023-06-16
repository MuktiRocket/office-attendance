function processFunction(link, callback, payload) {
    var result = {};
    $.ajax({
        url: link,
        async: true,
        cache: false,
        type: 'get',
        data: payload,
        success: function (data) {
            result = JSON.parse(data);
            callback(result);
        },
        error: function () {
            result['status'] = 'error';
            result['message'] = 'Something went wrong';
            callback(result);
        }
    });
}

function deactivateFunction(link) {
    event.preventDefault(); // prevent form submit
    swal({
        title: "Are you sure?",
        text: "You want to deactivate this user!",
        icon: "warning",
        buttons: true,
        dangerMode: false,
    })
        .then((willDelete) => {
            if (willDelete) {
                processFunction(link, function (result) {
                    if (result) {
                        if (result.status === 'success') {
                            swal("Poof! Deactivation successful", {
                                icon: "success",
                            });
                            setTimeout(function () {
                                window.location.href = window.location.origin + '/employee/list';
                            }, 1500);
                        } else if (result.status === 'error') {
                            swal(result.message, {
                                icon: "error",
                            });
                        }
                    }
                });
            } else {
                swal("Your request is cancelled");
            }
        });
}

function reactivateFunction(link) {
    event.preventDefault(); // prevent form submit
    swal({
        title: "Are you sure?",
        text: "You want to reactivate this data!",
        icon: "warning",
        buttons: true,
        dangerMode: false,
    })
        .then((willDelete) => {
            if (willDelete) {
                processFunction(link, function (result) {
                    if (result) {
                        if (result.status === 'success') {
                            swal("Poof! Reactivation successful", {
                                icon: "success",
                            });
                            setTimeout(function () {
                                window.location.href = window.location.origin + '/employee/list';
                            }, 1500);
                        } else if (result.status === 'error') {
                            swal(result.message, {
                                icon: "error",
                            });
                        }
                    }
                });
            } else {
                swal("Your request is cancelled");
            }
        });
}

