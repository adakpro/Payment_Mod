

/********************************* just number **************************************/
(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };
}(jQuery));

/********************************* number to letter **************************************/
$(document).ready(function(){ 
    $("#paymentbtn").attr('disabled','disabled');
	$("#cc-amount").inputFilter(function(value) {
		return /^\d*$/.test(value);    // Allow digits only, using a RegExp
	});
    $("#cc-amount").keyup(function() {		
				s = this.value.replace(/^0+/, '');		
				//document.getElementById('res').innerHTML = s.toPersianLetter();
				//document.getElementById('res2').innerHTML = "";
				var amount = parseFloat(s) + (s * 0.09);
				document.getElementById('res3').innerHTML = separateNum(amount);
				var amount = (s * 0.03);
				//document.getElementById('avarez').innerHTML = separateNum(amount);
				var amount = (s * 0.06);
				//document.getElementById('maliat').innerHTML = separateNum(amount);
				//this.value(s.toLocaleString());
				separateNum(s,this);
				//$("#cc-amount").val(ReplaceNumberWithCommas(this.value));	
		
		
	});		
/********************************* Start Pay **************************************/
$('form input').keydown(function (e) {
	if (e.keyCode == 13) {
        e.preventDefault();
        return false;
    }
});
$('form input').keyup(function (e) {
	var s = $("#cc-amount").val().replace(/,/g, '');
	var captcha = $("#captcha_code").val();
	var msg ="";
	if(s.length < 4){
			msg="حداقل مبلغ قابل پرداخت 1000 ريال مي باشد";
	}
	else if(!(s%1000==0)){
		msg = "مبلغ نهايي بايد مضربي از 1000 باشد";
	}
	else if(s > 458715595){
		msg = "با توجه به محدوديت سقف خريدهاي اينترنتي تا 500 ميليون ريال ، لطفا مبلغ درخواستي (با توجه به افزايش 9% ارزش افزوده) اصلاح شود";
	}
	else if(captcha.length < 1){
		msg="کلمه امنيتي را وارد نماييد";
	}
	if(msg == ""){
		$('input[type="submit"]').removeAttr('disabled');
		document.getElementById('res2').innerHTML = "";		
	}
	else {
		document.getElementById('res2').innerHTML = msg;
			
		document.getElementById('cc-amount').innerHTML = "";
	}
});


});  
function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
             return false;
        return true;
    }
	
function separateNum(value, input) {
        /* seprate number input 3 number */
        var nStr = value + '';
        nStr = nStr.replace(/\,/g, "");
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        if (input !== undefined) {

            input.value = x1 + x2;
        } else {
            return x1 + x2;
        }
    }
	
function validate(form) {
    var s = $("#cc-amount").val().replace(/,/g, '');
	
	var amount = parseFloat(s) + (s * 0.09);
	if (window.confirm("آيا پرداخت "+separateNum(amount)+" ريال معادل " + amount.toPersianLetter() + " باحتساب ارزش افزوده را تاييد مي نماييد؟")) {
		//document.getElementById('amt').value = s;
		return true;
	}
	else {
		return false
	}

}