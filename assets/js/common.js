$(document).ready(function() {
	if ( $( ".tej-alert-dismiss" ).length ) {
		setTimeout(function() {$('.tej-alert-dismiss').hide('slow');}, 5000);
	}
	
	/*toastr.options = {
	  "closeButton": false,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": false,
	  "positionClass": "toast-top-right",
	  "preventDuplicates": false,
	  "onclick": null,
	  "showDuration": "300",
	  "hideDuration": "1000",
	  "timeOut": "5000",
	  "extendedTimeOut": "1000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}

	toastr.success('Are you the 6 fingered man?');
	toastr.error('Are you the 6 fingered man?');
	toastr.info('Are you the 6 fingered man?');*/
});

function isNumber(selector) {
    var val = document.getElementById(selector).value;
    // If val is Not a Number
    if (isNaN(val)) {
        document.getElementById(selector).value = '';
    }
}

function checkAlpha(thisobj) {
	var inputtxt = $(thisobj).val();
	var letters = /^[a-zA-Z\s]+$/;  
	if(!inputtxt.match(letters))  
     {  
		$(thisobj).val('');
      //document.getElementById(txt2).value="";
     }

	//$("#txtName").keypress(function (e) {
		/*var keyCode = e.keyCode || e.which;
		
		//$("#lblError").html("");

		//Regex for Valid Characters i.e. Alphabets.
		var regex = /^[A-Za-z ]+$/;

		//Validate TextBox value against the Regex.
		var isValid = regex.test(String.fromCharCode(keyCode));
		if (!isValid) {
			e.preventDefault();
			//alert(keyCode)
			//$("#lblError").html("Only Alphabets allowed.");
		}

		return isValid;*/
	//});
}