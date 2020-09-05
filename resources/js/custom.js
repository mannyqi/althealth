$(function () {
    var altApp = {
        error: []
    };

    // ----------------------------------------------------------------------------
    // CLIENTS
    // ----------------------------------------------------------------------------
    altApp.validateClientForm = function(form) {
        altApp.error = [];
        $('#error-messages').hide();

        if (altApp.validateID($('#idnum').val()) == false) {
            altApp.error.push('Invalid South African ID number');
        }

        if (altApp.validateEmail($('#email').val()) == false) {
            altApp.error.push('Invalid email address');
        }

        if (altApp.validatePhone($('#telh').val()) == false) {
            altApp.error.push('Invalid home telephone number format');
        }

        if (altApp.validatePhone($('#telw').val()) == false) {
            altApp.error.push('Invalid work telephone number format');
        }

        if (altApp.validatePhone($('#cell').val()) == false) {
            altApp.error.push('Invalid cellphone number format');
        }

        if ($('#reference').val() == '') {
            altApp.error.push('Please select a reference');
        }

        if (altApp.error.length > 0) {
            form.preventDefault();
            altApp.showError();
        }
    };
    altApp.validateID = function (idNumber) {
        // Ref: http://www.sadev.co.za/content/what-south-african-id-number-made
        // SA ID Number have to be 13 digits
        if (idNumber.length != 13 || isNaN(idNumber)) {
            return false;
        }

        // get first 6 digits as a valid date
        var tempDate = new Date(idNumber.substring(0, 2), idNumber.substring(2, 4) - 1, idNumber.substring(4, 6));

        var id_date = tempDate.getDate();
        var id_month = tempDate.getMonth();

        if (!((tempDate.getYear() == idNumber.substring(0, 2)) && (id_month == idNumber.substring(2, 4) - 1) && (id_date == idNumber.substring(4, 6)))) {
            return false;
        }

        // apply Luhn formula for check-digits
        // Ref: https://en.wikipedia.org/wiki/Luhn_algorithm
        var tempTotal = 0;
        var checkSum = 0;
        var multiplier = 1;
        for (var i = 0; i < 13; ++i) {
            tempTotal = parseInt(idNumber.charAt(i)) * multiplier;
            if (tempTotal > 9) {
                tempTotal = parseInt(tempTotal.toString().charAt(0)) + parseInt(tempTotal.toString().charAt(1));
            }
            checkSum = checkSum + tempTotal;
            multiplier = (multiplier % 2 == 0) ? 1 : 2;
        }
        if ((checkSum % 10) != 0) {
            return false;
        };

        return true;
    };

    // ----------------------------------------------------------------------------
    // SUPPLIERS
    // ----------------------------------------------------------------------------
    altApp.validateSupplierForm = function(form) {

        altApp.error = [];
        $('#error-messages').hide();

        if (altApp.validatePhone($('#tel').val()) == false) {
            altApp.error.push('Invalid telephone number format');
        }

        if (altApp.error.length > 0) {
            form.preventDefault();
            altApp.showError();
        }
    };

    // ----------------------------------------------------------------------------
    // SUPPLEMENTS
    // ----------------------------------------------------------------------------
    altApp.validateSupplementForm = function(form) {

        altApp.error = [];
        $('#error-messages').hide();

        if ($('#supplier').val() == '') {
            altApp.error.push('Please select a supplier');
        }

        if (altApp.error.length > 0) {
            form.preventDefault();
            altApp.showError();
        }
    };

    altApp.calcCostInclusive = function() {
        var costExcl = $('#costexcl').val();
        var taxRate = $('#rate').val();
        var CostExclEl = $('#costincl');

        if (
            $.isNumeric(costExcl) && $.isNumeric(taxRate) &&
            costExcl > 0
        ) {
            var costIncl = costExcl;
            if (taxRate > 0) {
                costIncl = costExcl * ((taxRate / 100) + 1);
            }
            CostExclEl.val(costIncl.toFixed(2));
        } else {
            CostExclEl.val('0.00');
        }
    };

    // ----------------------------------------------------------------------------
    // INVOICES
    // ----------------------------------------------------------------------------
    altApp.getClientInfo = function (e) {
        var el = $(e.target);
        $('#invoice-client-confirm-info').hide();

        $.get('/clients/json/' + el.val(), function (data) {
            try {
                data = JSON.parse(data);
                if (data) {
                    $('#invoice-client-confirm-info .invoice-client-confirm-name span').html(data.C_name + ' ' + data.C_surname);
                    $('#invoice-client-confirm-info .invoice-client-confirm-email span').html(data.C_Email);
                    $('#invoice-client-confirm-info .invoice-client-confirm-cell span').html(data.C_tel_cell);
                    $('#invoice-client-confirm-info .invoice-client-confirm-address span').html(data.Address + ', ' + data.Code);
                    $('#invoice-client-confirm-info').show();
                }
            } catch (e) {
                return false;
            }

        });
    };

    altApp.createDraftInvoice = function () {
        $.post('/invoices/create-draft',
            {
                'client_id': $('#invoice-clients').val(),
                '_token': $('input[name="_token"]').val()
            },
            function (data, status) {
                console.log(status);
                if (status != 'success') {
                    altApp.error.push('Problem creating draft invoice. Please try again later.');
                    altApp.showError();
                } else {
                    location.reload();
                }
            }
        );
    };

    altApp.addInvoiceLineItem = function () {
        var line_item = $('.invoice-lineitem-template').contents();
        $('.invoice-line-items tbody').append(line_item);
    };

    // ----------------------------------------------------------------------------
    // GLOBAL
    // ----------------------------------------------------------------------------
    altApp.validateEmail = function (email) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
            return true;
        }
        return false;
    };

    altApp.validatePhone = function (phone) {
        if (phone.length == 18) {
            if (
                phone.charAt(0) == '(' &&
                (!isNaN(phone.substring(1,4)) && phone.substring(1,4).length == 3) &&
                phone.charAt(4) == ')' &&
                phone.charAt(5) == '-' &&

                phone.charAt(6) == '(' &&
                (!isNaN(phone.substring(7,10)) && phone.substring(7,10).length == 3) &&
                phone.charAt(10) == ')' &&
                phone.charAt(11) == '-' &&

                phone.charAt(12) == '(' &&
                (!isNaN(phone.substring(13,17)) && phone.substring(13,17).length == 4) &&
                phone.charAt(17) == ')'
            ) {
                return true;
            }
        }
        return false;
    };

    altApp.formatPhone = function (phone) {
        phone = $(phone.target);
        realNumber = phone.val().replace(/\(|\)|-/g, '');
        if (realNumber.length > 3 && realNumber.length <= 6) {

            phone.val('(' + realNumber.substring(0,3) + ')-' + realNumber.substring(3));

        } else if (realNumber.length > 6 && realNumber.length < 10) {

            phone.val('(' + realNumber.substring(0,3) + ')-(' + realNumber.substring(3,6) + ')-' + realNumber.substring(6));

        } else if (realNumber.length == 10) {
            phone.val('(' + realNumber.substring(0,3) + ')-(' + realNumber.substring(3,6) + ')-(' + realNumber.substring(6) + ')');
        }

        if (realNumber.length != 13 || isNaN(parseFloat(realNumber))) {
            altApp.error.push('Invalid phone number');
        }
    };

    altApp.showError = function () {
        var html = '<p>Some error(s) has occured:</p><ul>';
        for (var i = 0; i < altApp.error.length; i++) {
            html += '<li>' + altApp.error[i] + '</li>';
        }
        html += '</ul>';

        $('#error-messages').html(html).show();
    };

    // ----------------------------------------------------------------------------
    // LISTENERS
    // ----------------------------------------------------------------------------
    $('.client-form-btn').click(altApp.validateClientForm);
    $('.suppliers-form-btn').click(altApp.validateSupplierForm);
    $('.supplement-form-btn').click(altApp.validateSupplementForm);

    $("#telh, #telw, #cell, #tel").on("keyup", altApp.formatPhone);

    $('#costexcl, #rate').on("keyup", altApp.calcCostInclusive);

    // Invoices
    $("#invoice-clients").on("change", altApp.getClientInfo);
    $("#invoice-client-confirm").click(altApp.createDraftInvoice);
    // append new line item
    $("#create-invoice-lineitem").click(altApp.addInvoiceLineItem);
    //
});
