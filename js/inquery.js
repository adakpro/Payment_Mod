
$(document).ready(function(){ 
		document.getElementById('res2').innerHTML = ""; 
    $("#datepicker1").datepicker({
		isRTL:true,
		dateFormat: 'yy/mm/dd'
	});
    $("#datepicker1").click(function(event) {
		event.preventDefault();
        $("#datepicker1").focus();
    });
    $("#datepicker2").datepicker({
		isRTL:true,
		dateFormat: 'yy/mm/dd'
	});
    $("#datepicker2").click(function(event) {
		event.preventDefault();
        $("#datepicker2").focus();
    });


	$("#searchbtn").click(function (e) { 
		document.getElementById('res2').innerHTML = ""; 
		var value = $('#datepicker1').val();
		var patt = /(13|14)([0-9][0-9])\/(((0?[1-6])\/((0?[1-9])|([12][0-9])|(3[0-1])))|(((0?[7-9])|(1[0-2]))\/((0?[1-9])|([12][0-9])|(30))))/g;
		var result = patt.test(value);
			if (result) {
				var pos = value.indexOf('/');
				var year = parseInt(value.substring(0,pos));
				var nextPos = parseInt(value.indexOf('/',pos+1));
				var month = parseInt(value.substring(pos+1,nextPos));
				var day = parseInt(value.substring(nextPos+1));										
				if(month==12 && (year+1) % 4!=0 && day==30) { // kabise = 1379, 1383, 1387,... (year +1) divides on 4 remains 0
					result = false;
				}   
				if(day>31)	result = false;	
				if(month>6 && month<12 && day>30)	result = false;
				
			}
	
		var value2 = $('#datepicker2').val();
		var patt2 = /(13|14)([0-9][0-9])\/(((0?[1-6])\/((0?[1-9])|([12][0-9])|(3[0-1])))|(((0?[7-9])|(1[0-2]))\/((0?[1-9])|([12][0-9])|(30))))/g;
		var result2 = patt2.test(value2);
			if (result2) {
				var pos2 = value2.indexOf('/');
				var year2 = parseInt(value2.substring(0,pos2));
				var nextPos2 = parseInt(value2.indexOf('/',pos2+1));
				var month2 = parseInt(value2.substring(pos2+1,nextPos2));
				var day2 = parseInt(value2.substring(nextPos2+1));										
				if(month2==12 && (year2+1) % 4!=0 && day2==30) { // kabise = 1379, 1383, 1387,... (year +1) divides on 4 remains 0
					result2 = false;
				}   
				if(day2>31)	result2 = false;	
				if(month2>6 && month2<12 && day2>30)	result2 = false;  
			}
			
			if(!result){
				e.preventDefault();
				document.getElementById('res2').innerHTML = "متغير از تاريخ درست مقدار دهي نشده است ";
				return false;
			}
			
			if(!result2){
				e.preventDefault();
				document.getElementById('res2').innerHTML = "متغير تا تاريخ درست مقدار دهي نشده است ";
				return false;
			}
	});
});