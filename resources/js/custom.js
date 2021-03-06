$(function () {
    // altApp is defined in the layouts/app.blade.php
    altApp.error = [];
    altApp.items = [];

    // ----------------------------------------------------------------------------
    // CLIENTS
    // ----------------------------------------------------------------------------
    altApp.validateClientForm = function(form) {
        altApp.error = [];
        $('#error-messages').hide();

        if ($('#name').val() == '') {
            altApp.error.push('Please enter a name');
        }
        if ($('#surname').val() == '') {
            altApp.error.push('Please select a surname');
        }

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
    /**
     * Code snippet from https://www.codegrepper.com/code-examples/csharp/south+african+id+number+example
     *
     * @param idNumber
     * @returns {boolean}
     */
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

    altApp.deleteClient = function() {
        var msg = confirm("Are you sure you want to delete this client?");
        if (msg == true) {
            return true;
        } else {
            return false;
        }
    };

    // ----------------------------------------------------------------------------
    // SUPPLIERS
    // ----------------------------------------------------------------------------
    altApp.validateSupplierForm = function(form) {

        altApp.error = [];
        $('#error-messages').hide();

        if ($('#name').val() == '') {
            altApp.error.push('Please enter a supplier name');
        }
        if ($('#contact').val() == '') {
            altApp.error.push('Please enter a contact persons name');
        }
        if (altApp.validatePhone($('#tel').val()) == false) {
            altApp.error.push('Invalid telephone number format');
        }
        if (altApp.validateEmail($('#email').val()) == false) {
            altApp.error.push('Invalid email address');
        }

        if (altApp.error.length > 0) {
            form.preventDefault();
            altApp.showError();
        }
    };

    altApp.deleteSupplier = function() {
        var msg = confirm("Are you sure you want to delete this supplier?");
        if (msg == true) {
            return true;
        } else {
            return false;
        }
    };

    // ----------------------------------------------------------------------------
    // SUPPLEMENTS
    // ----------------------------------------------------------------------------
    altApp.validateSupplementForm = function(form) {

        altApp.error = [];
        $('#error-messages').hide();

        if ($('input[name="name"]').val() == '') {
            altApp.error.push('Please enter a supplement name');
        }
        if ($('#supplier').val() == '') {
            altApp.error.push('Please select a supplier');
        }
        if (
            $('input[name="costexcl"]').val() == '' ||
            isNaN($('input[name="costexcl"]').val())
        ) {
            altApp.error.push('Please enter a valid supplement cost');
        }
        if (
            $('input[name="rate"]').val() == '' ||
            isNaN($('input[name="rate"]').val()) ||
            $('input[name="rate"]').val() < 0 ||
            $('input[name="rate"]').val() > 90 // We're assuming there won't be a tax rate greater than 90%
        ) {
            altApp.error.push('Please enter a valid VAT rate');
        }
        if (
            $('input[name="qty"]').val() == '' ||
            isNaN($('input[name="qty"]').val()) ||
            $('input[name="qty"]').val() < 1
        ) {
            altApp.error.push('Please enter the stock amount');
        }
        if (
            $('input[name="minlvl"]').val() == '' ||
            isNaN($('input[name="minlvl"]').val()) ||
            $('input[name="minlvl"]').val() < 1
        ) {
            altApp.error.push('Please enter a minimum level. Must be greater than 0');
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

    altApp.deleteSupplement = function() {
        var msg = confirm("Are you sure you want to delete this supplement?");
        if (msg == true) {
            return true;
        } else {
            return false;
        }
    };

    // ----------------------------------------------------------------------------
    // INVOICES
    // ----------------------------------------------------------------------------
    altApp.getClientInfo = function (e) {
        var el = $(e.target);
        $('#invoice-client-confirm-info').hide();

        $.get(altApp.app_url + '/clients/json/' + el.val(), function (data) {
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
        $.post(altApp.app_url + '/invoices/create-draft',
            {
                'client_id': $('#invoice-clients').val(),
                '_token': $('input[name="_token"]').val()
            },
            function (data, status) {
                if (status != 'success') {
                    altApp.error.push('Problem creating draft invoice. Please try again later.');
                    altApp.showError();
                } else {
                    location.reload();
                }
            }
        );
    };

    altApp.addInvoiceLineItem = function (e) {
        var line_item = $('#invoice-lineitem-template').html();
        $('.invoice-line-items tbody').append(line_item);

        altApp.afterAddInvoiceLineItem(e);
    };

    altApp.deleteInvoiceLineItem = function(e) {
        $(e.target).parents('tr').remove();
        altApp.calcLineitemTotal(e);
    };

    altApp.afterAddInvoiceLineItem = function(e) {
        $(".line-item-delete").off('click').click(altApp.deleteInvoiceLineItem);
        $(".invoice-lineitem-supplement").off('change').on("change", altApp.calcLineitemTotal);
        $(".line-item-qty").off('keyup').on("keyup", altApp.calcLineitemTotal);
    };

    altApp.calcLineitemTotal = function(e) {
        var item_row = $(e.target).parents('tr');
        var supplement = item_row.find('select.invoice-lineitem-supplement');
        var cost_excl = supplement.children("option:selected").attr('data-cost');
        var supplement_desc = supplement.children("option:selected").attr('data-title');

        if (supplement.val() == '') {
            supplement.addClass('border-danger');
        } else {
            supplement.removeClass('border-danger');
        }

        var qty = item_row.find('.line-item-qty').val();
        if (isNaN(qty)) {
            // highlight qty field should qty NOT be a number
            item_row.find('.line-item-qty').addClass('border-danger');
            qty = 0;
        } else {
            item_row.find('.line-item-qty').removeClass('border-danger');
        }

        var subtotal_excl = parseFloat(cost_excl) * parseInt(qty);
        var subtotal_incl = altApp.calcCostIncl(subtotal_excl);

        item_row.find('.item-description').html(supplement_desc);
        item_row.find('input[name="cost-excl"]').val(altApp.formatPrice(cost_excl));
        item_row.find('input[name="cost-excl-sum"]').val(altApp.formatPrice(subtotal_excl));
        item_row.find('.item-subtotal').html(altApp.formatPrice(subtotal_incl));

        // Populate invoice total
        altApp.calcInvoiceTotal();

        altApp.saveLineItems();
    };

    /**
     * Calculate invoice subtotals
     */
    altApp.calcInvoiceTotal = function() {
        var subtotal = 0;
        $('.invoice-line-items tr td input[name="cost-excl-sum"]').each(function () {
            var str_total = $(this).val();
            subtotal += parseFloat(str_total.replace('R ', ''));
        });

        var total_excl = altApp.formatPrice(parseFloat(subtotal));
        var total_incl = altApp.formatPrice(altApp.calcCostIncl(parseFloat(subtotal)));

        $('#invoice-total-excl').html(total_excl);
        $('#invoice-total-incl').html(total_incl);
    };

    /**
     * Populate invoice line item prices and calculate all totals
     */
    altApp.populateInvoiceItems = function() {
        var subtotal = 0;
        var totals = [];
        $('.invoice-line-items tbody tr').each(function () {
            var item_row = $(this);
            var supplement = item_row.find('select.invoice-lineitem-supplement');
            var cost_excl = supplement.children("option:selected").attr('data-cost');
            var supplement_desc = supplement.children("option:selected").attr('data-title');
            var qty = item_row.find('.line-item-qty').val();
            var subtotal_excl = parseFloat(cost_excl) * parseInt(qty);
            var subtotal_incl = altApp.calcCostIncl(subtotal_excl);

            item_row.find('.item-description').html(supplement_desc);
            item_row.find('input[name="cost-excl"]').val(altApp.formatPrice(cost_excl));
            item_row.find('input[name="cost-excl-sum"]').val(altApp.formatPrice(subtotal_excl));
            item_row.find('.item-subtotal').html(altApp.formatPrice(subtotal_incl));

            // Populate invoice total
            altApp.calcInvoiceTotal();
        });
        altApp.toggleIssueBtn();
    };

    altApp.saveLineItems = function() {
        // build json object with line item data
        // check for supplement id before adding line item to object
        // save json line item data to session
        var i = 0;
        var items = [];
        $('.invoice-line-items tbody tr').each(function () {
            var line_item = $(this);
            var suppl = line_item.find('select.invoice-lineitem-supplement').children("option:selected");
            if (suppl.val()) {
                items[i] = {};
                items[i].supplement_id = suppl.val();
                items[i].cost_excl = suppl.attr('data-cost');
                items[i].qty = line_item.find('.line-item-qty').val();

                i++;
            }
        });

        // save to session
        $.post(altApp.app_url + '/invoices/save-draft',
            {
                'items': JSON.stringify(items),
                '_token': $('input[name="_token"]').val()
            },
            function (data, status) {
                if (status != 'success') {
                    altApp.error.push('There was a problem saving your draft invoice. Please try again later.');
                    altApp.showError();
                } else {
                    altApp.toggleStockStatus(data);
                    //location.reload();
                }
            }
        );

        altApp.toggleIssueBtn();
    };

    /**
     * Check each line items quantity and show error for items with insuffiecient stock
     * @param data
     */
    altApp.toggleStockStatus = function(data) {
        for (var i = 0; i < data.length; i++) {
            var sufficient_stock = data[i].sufficient_stock;
            var supplement_id = data[i].supplement_id;

            var supplement_select = $('.invoice-line-items .invoice-lineitem-supplement option[value="' + supplement_id + '"]:selected');
            if (sufficient_stock == false && supplement_select.parents('tr').find('.line-item-qty-cell .invoice-line-item-error').length == 0) {
                supplement_select.parents('tr').find('.line-item-qty-cell').append('<label class="text-danger invoice-line-item-error">Not enough stock</label>');
            }
            if (sufficient_stock == true) {
                supplement_select.parents('tr').find('.line-item-qty-cell .invoice-line-item-error').remove();
            }
        }
    };

    altApp.deleteInvoice = function() {
        var msg = confirm("Are you sure you want to delete this invoice?");
        if (msg == true) {
            return true;
        } else {
            return false;
        }
    };

    altApp.toggleIssueBtn = function() {
        if ($('.invoice-line-items tbody tr').length) {
            $('#invoice-issue').show();
        } else {
            $('#invoice-issue').hide();
        }
    };

    altApp.issueInvoice = function() {
        // validate line items
        var hasError = false;
        $('.invoice-line-items tbody tr').each(function () {
            var line_item = $(this);
            var supplementEl = line_item.find('.invoice-lineitem-supplement');
            var qtyEl = line_item.find('.line-item-qty');

            if (isNaN(qtyEl.val()) || supplementEl.val() == '') {
                hasError = true;
                if (isNaN(qtyEl.val())) {
                    qtyEl.addClass('border-danger');
                }
                if (supplementEl.val() == '') {
                    supplementEl.addClass('border-danger');
                }
            }
        });
        if (hasError) {
            alert('Please ensure all quantities are valid integer values');
        } else {
            var msg = confirm("Are you sure you want to issue this invoice?\n\nNote that invoice will be saved to the database and emailed to client");
            if (msg == true) {
                window.location.href = altApp.app_url + "/invoices/issue";
            } else {
                return false;
            }
        }
    };

    altApp.discardInvoice = function() {
        var msg = confirm("Are you sure you want to discard this draft invoice?");
        if (msg == true) {
            window.location.href = altApp.app_url + "/invoices/discard-draft";
        } else {
            return false;
        }
    };

    $('#date_paid').datetextentry({
        show_tooltips : false,
        separator :'-',
        show_hints:true,
        field_width_day   : 2,
        field_width_month : 2,
        field_width_year  : 4,
        field_order: 'DMY',
        // errorbox_x    : -135,
        // errorbox_y    : 28,
    });

    // ----------------------------------------------------------------------------
    // GLOBAL
    // ----------------------------------------------------------------------------
    altApp.calcCostIncl = function(cost_excl) {
        return parseFloat(cost_excl) * (parseFloat(altApp.tax_rate) / 100 + 1)
    };

    altApp.formatPrice = function(price) {
        if (isNaN(price)) {
            return 'NaN';
        } else {
            var price_formatted = parseFloat(price).toFixed(2);
            return 'R ' + price_formatted;
        }
    };

    altApp.validateEmail = function (email) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
            return true;
        }
        return false;
    };

    altApp.validatePhone = function (phone, required) {
        if (required && phone == '') {
            return false;
        }
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
    altApp.afterAddInvoiceLineItem();
    altApp.populateInvoiceItems();
    // append new line item
    $("#create-invoice-lineitem").click(altApp.addInvoiceLineItem);
    $('#invoice-issue').click(altApp.issueInvoice);
    $('#invoice-discard').click(altApp.discardInvoice);
    //
});
