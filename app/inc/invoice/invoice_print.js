function invoice_print( myObj) {
        var invoice_id = myObj.attr('invoice-id');
        
        myObj.prop('disabled', true).tooltip("hide");

        $.ajax({
            url: 'invoice_data.php?id=' + invoice_id,
            dataType : 'json',
            method: 'GET',
            error: function(x,e) { error_to_console(x,e) }
        }).success(function(data) {
            var response = data[0];
            
            $('#invoice_print #invoice_number span').text(response.invoice_number);
            $('#invoice_print #date_of_issue span').text(reformatDate(response.date_of_issue));
            $('#invoice_print #date_of_sale span').text(reformatDate(response.date_of_sale));
            $('#invoice_print #date_termin span').text(reformatDate(response.date_termin));
            $('#invoice_print #description span').text(response.description);
            $('#invoice_print .unit_price').text(reformatNumber(response.unit_price));
            $('#invoice_print .tax_amount').text(reformatNumber(response.tax_amount));
            $('#invoice_print .total').text(reformatNumber(response.total));
            $('#invoice_print .number_to_words').text(polishToWords(response.total));

            var box = invoice_print_box();
                            
                box
                .on('shown.bs.modal', function() {                  
                    $('#invoice_print').show(); 
                })
                .on('hide.bs.modal', function(e) {
                    $('#invoice_print').hide().appendTo('body');
                    myObj.prop('disabled', false);
                })
                .modal('show').find("div.modal-dialog").addClass("invoicePrint-width");
            
        });
        
} // end invoicePrint click


function invoice_print_box() {
    return bootbox.dialog({
            closeButton: true,
            title: '<h3><i class="glyphicon glyphicon glyphicon-print"></i><span> Wydruk faktury</span></h3>',
            message: $('#invoice_print'),
            show: false
        });
} 

$('#invPrint').on('click', function() {
    $("#invoice_print").printThis({
        loadCSS: "/gynkar-new/app/inc/invoice/invoice-print.css", 
        importCSS: false
    });
});


(function () {
    var HUNDREDS = ["", " sto ", " dwieście ", " trzysta ", " czterysta ", " pięćset ", " sześćset ", " siedemset ", " osiemset ", " dziewięćset "],
        TENS = ["", " dziesięć ", " dwadzieścia ", " trzydzieści ", " czterdzieści ", " pięćdziesiąt ", " sześćdziesiąt ", " siedemdziesiąt ", " osiemdziesiąt ", " dziewięćdziesiąt "],
        TEENS = ["", " jedenaście ", " dwanaście ", " trzynaście ", " czternaście ", " piętnaście ", " szesnaście ", " siedemnaście ", " osiemnaście ", " dziewiętnaście "],
        UNITIES = ["", " jeden ", " dwa ", " trzy ", " cztery ", " pięć ", " sześć ", " siedem ", " osiem ", " dziewięć "],
        ZERO = "zero",
        MINUS = " minus ",
        THOUSANDS = { one: " tysiąc ", few: " tysiące ", many: " tysięcy " },
        MILIONS = { one: " milion ", few: " miliony ", many: " milionów " },
        POSITIVE_OVERFLOW = "zbyt dużo",
        NEGATIVE_OVERFLOW = "zbyt mało";

    function process0999(digits) {
        var result = "";

        result += HUNDREDS[digits[0]];

        if (digits[1] === 1 && digits[2] !== 0) {
            result += TEENS[digits[2]];
        } else {
            result += TENS[digits[1]];
            result += UNITIES[digits[2]];
        }

        return result;
    };

    function classify(digits) {
        if (digits.join("") === "001") {
            return "one";
        } else if (digits[1] !== 1 && (digits[2] === 2 || digits[2] === 3 || digits[2] === 4)) {
            return "few";
        } else {
            return "many";
        }
    };

    function polishToWords(number) {
        var digits,
            result = "";

        var rest = (number % 1).toFixed(2).substring(2);
        var number = parseInt(number, 10);
        
        var digits = String(Math.floor(Math.abs(number))).split("");

        for (var i = 0; i < digits.length; i++) {
            digits[i] = parseInt(digits[i], 10);
        }

        if (digits.length > 9) {
            return number > 0 ? POSITIVE_OVERFLOW : NEGATIVE_OVERFLOW;
        }

        if (parseInt(number, 10) < 0) {
            result += MINUS;
        }

        while (digits.length < 9) {
            digits.unshift(0);
        }

        if (parseInt(number, 10) === 0) {
            result += ZERO;
        } else {
            result += process0999(digits.slice(0, 3));

            if (digits.slice(0, 3).join("") !== "000") {
                result += MILIONS[classify(digits.slice(0, 3))];
            }

            result += process0999(digits.slice(3, 6));

            if (digits.slice(3, 6).join("") !== "000") {
                result += THOUSANDS[classify(digits.slice(3, 6))];
            }

            result += process0999(digits.slice(6, 9));
        }

        return result.replace(/ +/g, " ").replace(/^ +| +$/g, "") + ' PLN ' + rest + '/100';
    }

    if (typeof exports !== "undefined") {
        if (typeof module !== "undefined" && module.exports) {
            exports = module.exports = polishToWords;
        }
        exports.polishToWords = polishToWords;
    } else {
        this.polishToWords = polishToWords;
    }
}).call(this);

