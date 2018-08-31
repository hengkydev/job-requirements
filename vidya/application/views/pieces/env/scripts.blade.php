<script type="text/javascript">
	var APP_STATUS 	= "{{getenv('APP_STATUS')}}";
	var APP_URL   	= "{{base_url()}}";
	var APP_API_KEY	= "{{getenv('API_KEY')}}";
	var APP_SOCKET 	= "{{getenv('APP_SOCKET')}}";
	@if(getenv('G_RECaPTCHA'))
	var G_RECAPTCHA_SITE_KEY = "{{getenv('G_RECAPTCHA_SITE_KEY')}}";
	@endif
</script>