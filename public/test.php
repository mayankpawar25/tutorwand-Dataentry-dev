<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="append_options">
					Option 1 <input class="form-control" name="name1" onpaste="return false"><br />
					Option 2 <input class="form-control" name="name2" onpaste="return false"><br />
					Option 3 <input class="form-control" name="name3" onpaste="return false"><br />
				</div>	
			</div>
			<div class="col-sm-6">
				<p>a. Cl - ions form fcc lattice and Na+ ions occupy all octahedral voids of the unit cell</p>
				<p>b.) Ca2+ ions form fcc lattice and Fions occupy all the eight tetrahedral voids of the unit cell</p>
				<p>(c) O2- ions form fcc lattice and Na+ ions occupy all the eight tetrahedral voids of the unit cell</p>
				<p>d.) S 2- ions form fcc lattice and Zn2+ ions go into alternate tetrahedral voids of the unit cell</p>
				<p>e.) S 2- ions form fcc lattice and Zn2+ ions go into alternate tetrahedral voids of the unit cell</p>
				<p>(f.) S 2- ions form fcc lattice and Zn2+ ions go into alternate tetrahedral voids of the unit cell</p>
				<p>(g.) S 2- ions form fcc lattice and Zn2+ ions go into alternate tetrahedral voids of the unit cell</p>
				<p>(i) S 2- ions form fcc lattice and Zn2+ ions go into alternate tetrahedral voids of the unit cell</p>
				<p>(ii) S 2- ions form fcc lattice and Zn2+ ions go into alternate tetrahedral voids of the unit cell</p>
				<p>(iii) S 2- ions form fcc lattice and Zn2+ ions go into alternate tetrahedral voids of the unit cell</p>
				<p>iv. S 2- ions form fcc lattice and Zn2+ ions go into alternate tetrahedral voids of the unit cell</p>
				<p>v. S 2- ions form fcc lattice and Zn2+ ions go into alternate tetrahedral voids of the unit cell</p>
				<p>f. S 2- ions form fcc lattice and Zn2+ ions go into alternate tetrahedral voids of the unit cell</p>
				<p>(1) S 2- ions form fcc lattice and Zn2+ ions go into alternate tetrahedral voids of the unit cell</p>
				<p>(2) S 2- ions form fcc lattice and Zn2+ ions go into alternate tetrahedral voids of the unit cell</p>
			</div>
		</div>
		
</div>
	

</body>
<script src="//code.jquery.com/jquery-3.1.1.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
	$( function() {
		document.addEventListener( 'paste', function( e ) {
			var index = 0;
			var inputLength = $('input[name="name[]"]').length;
			var replacetext = e.clipboardData.getData( 'Text' ).replace(/\n{1,}|\t{1,}|\s{2,}\s/g, "$$$$");
			var testtext = replacetext.split("$$");
			var count = 0;
			$.each(testtext, function(index, val) {
			if(val.length > 1 ){
				count++;
				let newValue = val.replace(/^(([(][a-zA-Z]{1,}[)]\s)|([0-9]{1,}[)]\s)|([a-z]{1,}[)]\s)|([a-z]{1,}[.)]\s)|([a-zA-Z]{1,}[.]\s))/g, "");
				if($(`input[name=name${count}]`)[0]) {
					$(`input[name=name${count}]`).val($.trim(newValue));
				} else if($(`input[name=name${count}]`)[0] == undefined) {
					$('.append_options').append(`Option ${count} <input class="form-control" type="text" name="name${count}" onpaste="return false" value="${$.trim(newValue)}"><br />`);
				}
			}
			});
		} );
		} );

</script>
</html>