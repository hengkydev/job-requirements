@extends('email.template')

@section('content')
<tr >
	<td align="center" valign="top">
		<!-- CENTERING TABLE // -->
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align="center" valign="top">
					<!-- FLEXIBLE CONTAINER // -->
					<table border="0" cellpadding="20" cellspacing="0" width="500" class="flexibleContainer">
						<tr>
							<td  align="center" valign="top" width="500" class="flexibleContainerCell">

								<!-- CONTENT TABLE // -->
								<table align="left" border="0" cellpadding="0" cellspacing="0" class="flexibleContainer">
									<tr>
										<td align="left" valign="top" class="textContent">
											<h3>Hallo , {{$transaction->name}}</h3>
											<div style="text-align:justify;font-family:Helvetica,Arial,sans-serif;font-size:12px;margin-bottom:0;margin-top:10px;color:#888;line-height:135%;">
												Ini merupakan email invoice dari kami setelah anda melakukan pembelian produk di website kami
												<a href="{{base_url()}}">{{getEnv('MAIN_DOMAIN')}}</a>
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

<tr>
	<td align="center" valign="top">
		<!-- CENTERING TABLE // -->
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align="center" valign="top">
					<!-- FLEXIBLE CONTAINER // -->
					<table border="0" cellpadding="20" cellspacing="0" width="500" class="flexibleContainer">
						<tr style="border-top: 2px dashed #ddd">
							<td  align="left" valign="top" width="500" class="flexibleContainerCell">
								<div style="font-size: 12px;margin-bottom: 15px;">
									Invoice ini di tujukan kepada :
								</div>
								<!-- CONTENT TABLE // -->
								<table align="left" border="0" cellpadding="0" cellspacing="0" class="flexibleContainer">
									<tr>
										<td align="left" valign="top" class="textContent">
											<table align="left" width="100%" style="font-size: 12px;">
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>Nama Lengkap</b></td>
													<td>{{$transaction->name}}</td>
												</tr>
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>Alamat Email</b></td>
													<td>{{$transaction->email}}</td>
												</tr>
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>No Telepon</b></td>
													<td>{{$transaction->phone}}</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
								<!-- // CONTENT TABLE -->

							</td>
						</tr>
						<tr style="border-top: 2px dashed #ddd">
							<td  align="left" valign="top" width="500" class="flexibleContainerCell">
								<div style="font-size: 12px;margin-bottom: 15px;">
									Informasi tempat dimana barang akan dikirim :
								</div>
								<!-- CONTENT TABLE // -->
								<table align="left" border="0" cellpadding="0" cellspacing="0" class="flexibleContainer">
									<tr>
										<td align="left" valign="top" class="textContent">
											<table align="left" width="100%" style="font-size: 12px;">
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>Provinsi</b></td>
													<td>{{$transaction->destination->province}}</td>
												</tr>
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>Kota / Kabupaten</b></td>
													<td>{{$transaction->destination->city}}</td>
												</tr>
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>Kecamatan</b></td>
													<td>{{$transaction->destination->district}}</td>
												</tr>
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>Kode Pos</b></td>
													<td>{{$transaction->zipcode}}</td>
												</tr>
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>Alamat</b></td>
													<td>{{$transaction->address}}</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
								<!-- // CONTENT TABLE -->

							</td>
						</tr>
						<tr style="border-top: 2px dashed #ddd">
							<td  align="left" valign="top" width="500" class="flexibleContainerCell">
								<div style="font-size: 12px;">
									Barang yang anda pesan di kelompokan sesuai toko dari pemilik barang tersebut
								</div>
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

@foreach($transaction->shipping as $key => $shipping)
<tr style="border-top: 1px solid #eee">
	<td align="center" valign="top">
		<!-- CENTERING TABLE // -->
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr style="padding-top:0;">
				<td align="left" valign="top">
					<table style="width: 100%" cellpadding="5">
						<tr>
							<td width="30" align="center" style="background: #3688DC;color: #fff;font-size: 12px">{{$key + 1}}</td>
							<td align="right" style="font-size: 12px;background: #eee">
								Toko : <b style="color: #3688DC">{{$shipping->detail->first()->vendor_name}}</b>
								&nbsp;&nbsp;
								ID : <b style="color: #3688DC">{{@$shipping->detail->first()->vendor->username}}</b>
							</td>
						</tr>
					</table>
					<table style="width: 100%;font-size: 12px;color: #888;">
						<thead style="border-bottom: 1px solid #eee">
							<tr>
								<th align="left" style="padding: 8px">Produk</th>
								<th align="left" style="padding: 8px">Info</th>
								<th align="left" style="padding: 8px">QTY</th>
								<th align="left" style="padding: 8px">Total</th>
							</tr>
						</thead>
						<tbody>
						@foreach($shipping->detail as $result)
						<tr style="border-bottom: 1px solid #eee">
							<td style="padding: 8px" width="200">
								<a href="{{@$result->product->url}}" target="_blank">
									{{$result->name}}
								</a>
								<div style="height: 8px"></div>
								<span style="font-size: 10px">Berat : 
									{{number_format($result->weight,0,',','.')}} gram
								</span>
							</td>
							<td style="padding: 8px">
								{{$result->price_text->product_price}}
							</td>
							<td style="padding: 8px">{{$result->qty}}</td>
							<td style="padding: 8px">
								{{$result->price_text->total}}
							</td>
						</tr>
						@endforeach
						</tbody>
						<tfoot style="border-bottom: 1px solid #eee">
							<tr>
								<th align="left" style="padding: 8px 8px;text-align: right;" colspan="3">
									Total
								</th>
								<th align="left" style="padding:8px;">
									<b>Rp. {{number_format($shipping->detail->sum('grand_total'),0,',','.')}}</b>
								</th>
							</tr>
						</tfoot>
					</table>
					
				</td>
			</tr>
		</table>
		<!-- // CENTERING TABLE -->
	</td>
</tr>
<tr>
	<td align="center" valign="top">
		<!-- CENTERING TABLE // -->
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align="center" valign="top">
					<!-- FLEXIBLE CONTAINER // -->
					<table border="0" cellpadding="20" cellspacing="0" width="500" class="flexibleContainer">
						<tr>
							<td  align="left" valign="top" width="500" class="flexibleContainerCell">
								<div style="font-size: 12px;margin-bottom: 15px;">
									Informasi pengiriman barang untuk toko ini :
								</div>
								<!-- CONTENT TABLE // -->
								<table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" class="flexibleContainer">
									<tr>
										<td align="left" valign="top" class="textContent">
											<table align="left" width="100%" style="font-size: 12px;">
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>Asal pengiriman</b></td>
													<td>{{$shipping->origin->text}}</td>
												</tr>
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>Berat Total</b></td>
													<td>{{number_format($shipping->weight,0,',','.')}} gram</td>
												</tr>
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>Layanan Kurir</b></td>
													<td>
														{{$shipping->name}}
													</td>
												</tr>
												@if($shipping->type=="general")
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>Paket Kurir</b></td>
													<td>{{$shipping->service}}</td>
												</tr>
												@endif
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>Biaya Pengiriman</b></td>
													<td>{{$shipping->cost_text}}</td>
												</tr>
												@if($shipping->type=="custom")
												<tr>
													<td colspan="2">
															<div style="font-size: 12px;color:#888;margin-top: 10px;">
																anda menggunakan layanan kurir sendiri , kami akan menginformasikan lebih lanjut
																untuk proses pengiriman barang anda
															</div>
													</td>
												</tr>
												@endif
											</table>
											
										</td>
									</tr>
								</table>
								<!-- // CONTENT TABLE -->
							</td>
						</tr>
					</table>
					<table style="width: 100%" cellpadding="5">
						<tr>
							
							<td align="right" style="font-size: 12px;background: #eee">
								Total Keseluruhan untuk toko ini
							</td>
							<td width="150" align="center" style="background: #3688DC;color: #fff;font-size: 12px">
								Rp. {{number_format($shipping->detail->sum('grand_total') + $shipping->cost,0,',','.')}}
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<!-- // CENTERING TABLE -->
	</td>
</tr>
@endforeach
<tr>
	<td align="center" valign="top">
		<!-- CENTERING TABLE // -->
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align="center" valign="top">
					<!-- FLEXIBLE CONTAINER // -->
					<table border="0" cellpadding="20" cellspacing="0" width="500" class="flexibleContainer">
						<tr>
							<td  align="left" valign="top" width="500" class="flexibleContainerCell">
								<div style="font-size: 12px;margin-bottom: 15px;">
									Total rincian biaya akhir untuk pembelian anda :
								</div>
								<!-- CONTENT TABLE // -->
								<table align="left" border="0" cellpadding="0" cellspacing="0" class="flexibleContainer">
									<tr>
										<td align="left" valign="top" class="textContent">
											<table align="left" width="100%" style="font-size: 12px;">
												<tr>
													<td width="200" style="padding-bottom: 8px;"><b>Total Pembelian Produk</b></td>
													<td>
														<b style="color:#D35400">{{$transaction->price_text->total}}</b>
													</td>
												</tr>
												<tr>
													<td width="200" style="padding-bottom: 8px;"><b>Total Biaya pengiriman</b></td>
													<td>
														<b style="color:#D35400">{{$transaction->price_text->courier_cost}}</b>
													</td>
												</tr>
												<tr>
													<td width="200" style="padding-bottom: 8px;"><b>Total Keseluruhan</b></td>
													<td>
														<b style="background:#D35400;color: #fff;padding: 3px 5px;">
															{{$transaction->price_text->grand_total}}
														</b>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
								<!-- // CONTENT TABLE -->

							</td>
						</tr>
						<tr style="border-top: 2px dashed #ddd">
							<td  align="left" valign="top" width="500" class="flexibleContainerCell">
								<div style="font-size: 12px;margin-bottom: 15px;">
									Berikut instruksi pembayaran agar pembelian anda kami proses : 
								</div>
								<div style="font-size: 12px;margin-bottom: 15px;text-align: justify;line-height: 1.5">
									1. Silahkan transfer ke salah satu akun rekening berikut , sesuai dengan nominal pembelian anda
								</div>
								<!-- CONTENT TABLE // -->
								
								<table align="left" width="100%" border="0" style="margin-bottom: 10px;" cellpadding="0" cellspacing="0" class="flexibleContainer">
									@foreach($account as $result)
									<tr>
										<td align="left" valign="top" class="textContent">
											<table align="left" width="100%" style="font-size: 12px;">
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>Nama BANK</b></td>
													<td>{{$result->bank}}</td>
												</tr>
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>Atas Nama</b></td>
													<td>{{$result->name}}</td>
												</tr>
												<tr>
													<td width="150" style="padding-bottom: 8px;"><b>No rekening</b></td>
													<td>{{$result->number}}</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<div style="height: 10px"></div>
										</td>
									</tr>
									@endforeach
								</table>
								<div style="font-size: 12px;margin-bottom: 15px;text-align: justify;line-height: 1.5">
									2. Setelah selesai melakukan pembayaran harap segera konfirmasikan pembayaran anda
									di link berikut , dan berikut no Invoice pembayaran anda yang di gunakan saat konfirmasi pembayaran anda
								</div>
								<div style="margin-bottom: 20px;background: #eee;padding: 8px;border-radius: 3px;border:1px solid #ccc;text-align: center;">
									{{$transaction->invoice}}
								</div>
								<div style="text-align: center;text-align: center;margin-bottom: 15px;font-size: 12px;line-height: 1">
									<a style="color:#3688DC;font-weight:bold;text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:18px;line-height:135%;padding-top:10px;padding-bottom:10px;padding-right:20px;padding-left:20px;border:3px solid #3688DC;display: inline-block;" href="{{base_url('confirmation?invoice='.$transaction->invoice)}}" target="_blank"><b>Konfirmasi</b></a>
									<br><br>
									Tombol tidak berfungsi ? , gunakan link di bawah ini
									<br><br>
									<a href="{{base_url('confirmation?invoice='.$transaction->invoice)}}">
										{{base_url('confirmation?invoice='.$transaction->invoice)}}
									</a>
								</div>
								<!-- // CONTENT TABLE -->

							</td>
						</tr>
						<tr style="border-top: 2px dashed #ddd">
							<td  align="left" valign="top" width="500" class="flexibleContainerCell">
								<div style="font-size: 12px;">
									<span style="padding: 3px 8px;background: #E67E22;color: #fff;border-radius: 2px">
										Pemberitahuan
									</span>
									<br><br>
									Transaksi ini berlaku sampai dengan tanggal <b style="color: #EE2B31">{{tgl_indo($transaction->expired)}} {{toTime($transaction->expired)}}</b> , harap segera melunasi pembayaran anda sebelum batas tanggal habis
								</div>
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

@endsection