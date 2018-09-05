@if($hasSuccess)
	<div class="alert bg-success alert-styled-left">
		<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
		<span class="text-semibold">Success !</span> {{$hasSuccess}}
    </div>
@endif