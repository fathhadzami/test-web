<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Test - web</title>

	<!-- JQuery -->
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>

	<!-- BOOTSTRAP -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

	<script type="text/javascript">
		//$(document).ready( function () {
		//});
		
		function search () {
			jQuery.ajax({
				type      : "GET",
				url       : "http://api.openweathermap.org/data/2.5/forecast/daily",
				cache     : false,
				data :{
					q     : $("#city").val(),
					mode  : "json",
					units : "metric",
					cnt   : $("#day").val(),
				},
				dataType  : "json",
				timeout   : 60000,
				success:function(response){
					renderdata(response);
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert("Sorry, something error");
				}
			});
		}
		function renderdata(json) {
			//alert(json["list"].length);
			var avg_day = 0;
			var avg_var = 0;
			var tbl = "<thead>\n\
				<tr>\n\
					<td id='tbl_header_city'>City</td>\n\
					<td id='tbl_header_avg'>Average</td>\n\
					<td id='tbl_header_avg_var'>Variance</td>\n\
				</tr>\n\
			</thead>\n\
			<tbody>\n";
			var tbl_row = "";
			for (var i = 0; i < json["list"].length; i++) {
				tbl_row += "<tr>\n";
				tbl_row += "<td>"+(new Date(json["list"][i]["dt"]))+"</td>\n";
				tbl_row += "<td>"+(json["list"][i]["temp"]["day"]).toFixed(2)+"C</td>\n";
				tbl_row += "<td>"+(json["list"][i]["temp"]["max"] - json["list"][i]["temp"]["min"]).toFixed(2)+"C</td>\n";
				tbl_row += "</tr>\n";
				avg_day += json["list"][i]["temp"]["day"];
				avg_var += json["list"][i]["temp"]["max"] - json["list"][i]["temp"]["min"];
			};
			tbl += tbl_row + "</tbody>\n";
			$("#tbl").empty();
			$("#tbl").append(tbl);
			
			$("#tbl_header_city").empty();
			$("#tbl_header_city").append("<strong>" + json["city"]["name"] + "</strong>");
			
			$("#tbl_header_avg").empty();
			$("#tbl_header_avg").append("<strong>" + json["cnt"] + "-day average: " + (avg_day/i).toFixed(2) + "C</strong>");
			
			$("#tbl_header_avg_var").empty();
			$("#tbl_header_avg_var").append("<strong>" + json["cnt"] + "-day average variance: " + (avg_var/i).toFixed(2) + "C</strong>");
		}
	</script>

</head>
<body>
	<div class="container">
		<br />
		<div class="row">
			<div class="col-xs-3 col-md-3">
				<div class="input-group">
					<span class="input-group-addon">day</span>
					<select id="day" class="form-control">
<?php
	for ($i=1; $i <= 17; $i++) { 
?>
						<option <?= ($i!=7) ? "" : "SELECTED" ; ?>><?= $i; ?></option>
<?php
	}
?>
					</select>
				</div>
			</div>
			<div class="col-xs-3 col-md-3">
				<div class="input-group">
					<span class="input-group-addon">city</span>
					<select id="city" class="form-control">
						<option value="Jakarta">Jakarta</option>
						<option value="Tokyo">Tokyo</option>
						<option value="London">London</option>
					</select>
				</div>
			</div>
			<div class="col-xs-3 col-md-3">
				<button type="button" class="btn btn-primary" onclick="search();">search</button>
			</div>
		</div>
		<br />
		<table id="tbl" class="table table-bordered table-striped">
		</table>
	</div>
</body>
</html>