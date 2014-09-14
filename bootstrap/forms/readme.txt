1.
parsley-js/ contains the validations

2.
all_elements_1.html is the main file

3.
for date picker we have the jquery ui datepicker
files :
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
			<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
			<script>
				$(function() {
					//add a datepicker to the date of birth field
					$( "#dob" ).datepicker({
			  			changeMonth: true,
			  			changeYear: true
					});
		  		});
			</script>
4.
parsley.css file is for the validation beutification

