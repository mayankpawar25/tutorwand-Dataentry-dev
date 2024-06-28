@php
	$message = "Please wait Loading...";
	if(isset($msg) && !empty($msg)) {
		$message = $msg;
		$height = 'style=height:100% !important';
		$lheight = 'style=top:0';
		$imgWidth = '32';
	}
@endphp
<div id="loader-wrapper" {{ isset($height) ? $height : "" }}>
	<div id="loader1" {{ isset($lheight) ? $lheight : "" }}> 
		{!! config('constants.icons.loader-icon') !!}
		<!-- <br><small>{{ $message }}</small> -->
	</div>
</div>
