@extends('email.template')

@section('content')
<tr>
	<td align="center" valign="top">
		<!-- CENTERING TABLE // -->
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align="center" valign="top">
					<!-- FLEXIBLE CONTAINER // -->
					<table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer">
						<tr>
							<td  align="center" valign="top" width="500" class="flexibleContainerCell">

								<!-- CONTENT TABLE // -->
								<table align="left" border="0" cellpadding="0" cellspacing="0" class="flexibleContainer">
									<tr>
										<td align="left" valign="top" class="textContent">
											<h3>Hallo , {{$user->name}}</h3>
											<div style="text-align:justify;font-family:Helvetica,Arial,sans-serif;font-size:12px;margin-bottom:0;margin-top:10px;color:#888;line-height:135%;">
												Ini merupakan email aktivasi atau konfirmasi pendaftaran anda , dimana email ini sebagai bentuk validasi untuk alamat email itu sendiri . silahkan melakukan <b>konfirmasi</b> dengan mengeklik tombol konfirmasi di bawah berikut
											</div>
										</td>
									</tr>
								</table>
								<!-- // CONTENT TABLE -->

							</td>
						</tr>
					</table>
					<!-- // FLEXIBLE CONTAINER -->
				</td>
			</tr>
		</table>
		<!-- // CENTERING TABLE -->
	</td>
</tr>
<!-- // MODULE ROW -->


<!-- MODULE ROW // -->
<tr>
	<td align="center" valign="top">
		<!-- CENTERING TABLE // -->
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr style="padding-top:0;">
				<td align="center" valign="top">
					<!-- FLEXIBLE CONTAINER // -->
					<table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer">
						<tr>
							<td style="padding-top:0;" align="center" valign="top" width="500" class="flexibleContainerCell">

								<!-- CONTENT TABLE // -->
								<table border="0" cellpadding="0" cellspacing="0" width="40%" class="emailButton" style="background-color: #fff;">
									<tr>
										<td align="center" valign="middle" class="buttonContent" style="padding-top:10px;padding-bottom:10px;padding-right:10px;padding-left:10px;border:3px solid #F4A137">
											<a style="color:#F4A137;font-weight:bold;text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:18px;line-height:135%;" href="{{$user->urlconfirmation}}" target="_blank"><b>Konfirmasi</b></a>
										</td>
									</tr>
								</table>

								<br>
								<div style="padding:5px;background: #f4f4f4;border:1px solid #eee;text-align: center;font-size: 12px;">
									<a href="{{$user->urlconfirmation}}" target="_blank">
										{{$user->urlconfirmation}}
									</a>
								</div>
								<!-- // CONTENT TABLE -->

							</td>
						</tr>
					</table>
					<!-- // FLEXIBLE CONTAINER -->
				</td>
			</tr>
		</table>
		<!-- // CENTERING TABLE -->
	</td>
</tr>
<!-- // MODULE ROW -->
@endsection