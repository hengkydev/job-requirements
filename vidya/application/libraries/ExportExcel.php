<?php 
/*
	Copyright (c) 2016, AKSAMEDIA - JASA PEMBUATAN WEBSITE
*/


class ExportExcel  {
	
	public static function exportTransaction(array $config){

			$form 						= @$config['from'];
			$filename 					= @$config['filename'];
			$title 						= @$config['title'];
			$label 						= @$config['label'];
			$transaction 				= @$config['transaction'];
			
			$excel 						= new PHPExcel();

			$excel->getProperties()->setCreator($form)
										 ->setLastModifiedBy($form)
										 ->setTitle($title)
										 ->setSubject($title)
										 ->setDescription($title)
										 ->setKeywords($label)
										 ->setCategory($label);

			$sheet 						= $excel->setActiveSheetIndex(0);
			// Set properties


			// defined color
			
			// properties title
			$sheet->setCellValue('A1', 'Dari');
			$sheet->setCellValue('B1', $form);
			$sheet->setCellValue('A2', 'Export Pada');
			$sheet->setCellValue('B2', tgl_indo(date('Y-m-d')));
			$sheet->setCellValue('A3', 'Filter Status');
			$sheet->setCellValue('B3', $label);
			$sheet->setCellValue('A4', 'Filter Tanggal');
			$sheet->setCellValue('B4', $title);

			for ($i=1; $i <4 ; $i++) { 
				$sheet->mergeCells('B'.$i.':C'.$i);
			}

			$sheet->getStyle('A1:C4')->applyFromArray([
				 'borders' => array(
			          'allborders' => array(
			              'style' => PHPExcel_Style_Border::BORDER_THIN,
			               'color' => array('rgb' => '000000')
			          )
			      )
			]);

			$sheet->getStyle('A1:A4')->applyFromArray([
				'fill'	=> [
						'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
						'color'	=> array('rgb' => 'e4dfe2')
				]
			]);


			
			// render template
			// --- INFORMASI PEMBELI
			$sheet->setCellValue('A6', 'INFORMASI PEMBELI');
			$sheet->mergeCells('A6:H7');
			$sheet->getStyle('A6:H7')->applyFromArray([
				'fill'	=> [
						'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
						'color'	=> array('rgb' => 'fabf8f')
				]
			]);

			$sheet->setCellValue('A8', 'INVOICE');
			$sheet->setCellValue('B8', 'TANGGAL');
			$sheet->setCellValue('C8', 'OLEH');			
			$sheet->setCellValue('D8', 'NAMA LENGKAP');
			$sheet->setCellValue('E8', 'EMAIL');
			$sheet->setCellValue('F8', 'NO TELEPON');
			$sheet->setCellValue('G8', 'ALAMAT');
			$sheet->setCellValue('H8', 'KODE POS');
			

			$sheet->getStyle('A8:H8')->applyFromArray([
				'fill'	=> [
						'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
						'color'	=> array('rgb' => 'e26b0a')
				]
			]);


			// --- INFORMASI PENGIRIMAN
			$sheet->setCellValue('I6', 'INFORMASI PENGIRIMAN');
			$sheet->mergeCells('I6:R6');
			$sheet->getStyle('I6:R6')->applyFromArray([
				'fill'	=> [
						'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
						'color'	=> array('rgb' => 'c4d79b')
				]
			]);

			$sheet->setCellValue('I7', 'DARI');
			$sheet->mergeCells('I7:J7');

			$sheet->setCellValue('K7', 'TUJUAN');
			$sheet->mergeCells('K7:M7');

			$sheet->setCellValue('N7', 'OPSI PENGIRIMAN');
			$sheet->mergeCells('N7:R7');

			$sheet->getStyle('I7:R7')->applyFromArray([
				'fill'	=> [
						'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
						'color'	=> array('rgb' => '76933c')
				]
			]);

			$sheet->setCellValue('I8', 'PROVINSI');
			$sheet->setCellValue('J8', 'KOTA');
			$sheet->setCellValue('K8', 'PROVINSI');
			$sheet->setCellValue('L8', 'KOTA');
			$sheet->setCellValue('M8', 'KECAMATAN');
			$sheet->setCellValue('N8', 'TOTAL BERAT');
			$sheet->setCellValue('O8', 'KURIR');
			$sheet->setCellValue('P8', 'PAKET');
			$sheet->setCellValue('Q8', 'ESTIMASI');
			$sheet->setCellValue('R8', 'ONGKIR');
				
			
			$sheet->getStyle('I8:R8')->applyFromArray([
				'fill'	=> [
						'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
						'color'	=> array('rgb' => '4f6228')
				]
			]);




			// --- INFORMASI PENGIRIMAN
			$sheet->setCellValue('S6', 'INFORMASI TRANSAKSI');
			$sheet->mergeCells('S6:X6');
			
			$sheet->getStyle('S6:X6')->applyFromArray([
				'fill'	=> [
						'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
						'color'	=> array('rgb' => 'c5d9f1')
				]
			]);

			$sheet->setCellValue('S7', 'INFOR KUPON');
			$sheet->mergeCells('S7:T7');

			$sheet->setCellValue('U7', 'TOTAL HARGA BARANG');
			$sheet->mergeCells('U7:U8');

			$sheet->setCellValue('V7', 'TOTAL BIAYA');
			$sheet->mergeCells('V7:V8');

			$sheet->setCellValue('W7', 'STATUS');
			$sheet->mergeCells('W7:W8');

			$sheet->setCellValue('X7', 'PEMBAYARAN');
			$sheet->mergeCells('X7:X8');

			$sheet->getStyle('S7:X8')->applyFromArray([
				'fill'	=> [
						'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
						'color'	=> array('rgb' => '538dd5')
				]
			]);

			$sheet->setCellValue('S8', 'KODE');
			$sheet->setCellValue('T8', 'POTONGAN');

			$sheet->getStyle('S8:T8')->applyFromArray([
				'fill'	=> [
						'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
						'color'	=> array('rgb' => '16365c')
				]
			]);

		    $style = array(
		        'alignment' => array(
		        	'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        ),
		        'borders' => array(
			          'allborders' => array(
			              'style' => PHPExcel_Style_Border::BORDER_THIN,
			               'color' => array('rgb' => '000000')
			          )
			      )
		    );

		    $sheet->getStyle("A6:X8")->applyFromArray($style);

		    $sheet->getStyle('A7:X8')->applyFromArray([
				'font'	=> [
						'color'	=> array('rgb' => 'FFFFFF')
				]
			]);

			$row 					= 8;
			$total['pending'] 		= 0;
			$total['cancel'] 		= 0;
			$total['done'] 			= 0;
			$total['all'] 			= 0;

		    foreach ($transaction as $key => $result) {
		    	$row 				= $key + 9;

		    	if($result->status=="order" || $result->status=="request"){
		    		$total['pending'] 	+= $result->price_total;	
		    	}
		    	else if($result->status=="cancel"){
		    		$total['cancel'] 	+= $result->price_total;	
		    	}
		    	else if($result->status=="done" || $result->status=="approve" || $result->status=="packing"){
		    		$total['done'] 		+= $result->price_total;	
		    	}

		    	$total['all'] 			+= $result->price_total;
		    	

		    	$sheet->setCellValue('A'.$row, $result->invoice);
		    	$sheet->getCell('A'.$row)->getHyperlink()->setUrl("sheet://'".$result->invoice."'!A1");
		    	$sheet->getStyle('A'.$row)->applyFromArray([
					'font'	=> [
							'bold' 	=> true,
							'color'	=> array('rgb' => '3688dc')
					],
					'alignment' => [
				        	'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
		        	]
				]);
		    	
		    	$date = strtotime($result->date);
	            $sheet->setCellValue('B'.$row, PHPExcel_Shared_Date::PHPToExcel($date));
	            $sheet->getStyle('B'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);

			    $sheet->setCellValue('C'.$row, ($result->id_member!="") ? 'Member' : 'Umum');
		    	$sheet->setCellValue('D'.$row, $result->name);
		    	$sheet->setCellValue('E'.$row, $result->email);
		    	$sheet->setCellValue('F'.$row, $result->phone);
		    	$sheet->setCellValue('G'.$row, $result->address);
		    	$sheet->setCellValue('H'.$row, $result->postalcode);

		    	$sheet->setCellValue('I'.$row, $result->origin_province);
		    	$sheet->setCellValue('J'.$row, $result->origin_city);

		    	$sheet->setCellValue('K'.$row, $result->province);
		    	$sheet->setCellValue('L'.$row, $result->city);
		    	$sheet->setCellValue('M'.$row, $result->district);

		    	$sheet->setCellValue('N'.$row, $result->weight);
		    	$sheet->setCellValue('O'.$row, $result->courier);
		    	$sheet->setCellValue('P'.$row, $result->courier_service_name);
		    	$sheet->setCellValue('Q'.$row, $result->courier_estimate);
		    	$sheet->setCellValue('R'.$row, $result->courier_price);

		    	$sheet->setCellValue('S'.$row, $result->code_coupon);
		    	$sheet->setCellValue('T'.$row, $result->coupon_price);
		    	$sheet->setCellValue('U'.$row, $result->price);
		    	$sheet->setCellValue('V'.$row, $result->price_total);

		    	$color['order'] 		= '66ccff';
		    	$color['request']		= 'ffff66';
		    	$color['approve'] 		= '00ffff';
		    	$color['packing'] 		= '66ff66';
		    	$color['done'] 			= 'ff99ff';
		    	$color['cancel'] 		= 'd9d9d9';

		    	$sheet->setCellValue('W'.$row, strtoupper($result->status));
		    	$sheet->getStyle('W'.$row)->applyFromArray([
					'fill'	=> [
							'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
							'color'	=> array('rgb' => $color[$result->status])
					],
					'alignment' => [
				        	'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        	]
				]);

				$sheet->setCellValue('X'.$row, $result->method_name);



				// ------------------------------- create dynamic sheeet for detail
				$sheetDetail 		= $excel->createSheet(($key+1)); //Setting index when creating
				$sheetDetail->setTitle($result->invoice);

				// Back to data transaction
				$sheetDetail->setCellValue('A1', '< KEMBALI KE DATA TRANSAKSI');
				$sheetDetail->mergeCells('A1:B1');
				$sheetDetail->getStyle('A1')->applyFromArray([
					'fill'	=> [
							'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
							'color'	=> array('rgb' => '00b050')
					],
					'font'	=> [
							'color'	=> array('rgb' => 'FFFFFF')
					],
					'alignment' => [
				        	'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        	]
				]);

				$sheetDetail->getCell('A1')->getHyperlink()->setUrl("sheet://'Data Transaksi'!A1");
				$sheetDetail->getRowDimension('1')->setRowHeight(20);


				// Informasi Pembeli
				$sheetDetail->setCellValue('A3', 'Informasi Pembeli');
				$sheetDetail->mergeCells('A3:C3');
				$sheetDetail->getStyle('A3')->applyFromArray([
					'fill'	=> [
							'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
							'color'	=> array('rgb' => 'fabf8f')
					],
					'alignment' => [
				        	'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        	]
				]);

				$sheetDetail->setCellValue('A4', 'No Invoice');
				$sheetDetail->setCellValue('B4', $result->invoice);

				$sheetDetail->setCellValue('A5', 'Tanggal Transaksi');
				$sheetDetail->setCellValue('B5', tgl_indo($result->date));

				$sheetDetail->setCellValue('A6', 'Oleh');
				$sheetDetail->setCellValue('B6', ($result->id_member!="") ? 'Member' : 'Umum');

				$sheetDetail->setCellValue('A7', 'Nama Lengkap');
				$sheetDetail->setCellValue('B7', $result->name);

				$sheetDetail->setCellValue('A8', 'Alamat Email');
				$sheetDetail->setCellValue('B8', $result->email);

				$sheetDetail->setCellValue('A9', 'Alamat No Telepon');
				$sheetDetail->setCellValue('B9', $result->phone);

				$sheetDetail->setCellValue('A10', 'Alamat Lengkap');
				$sheetDetail->setCellValue('B10', $result->address);

				$sheetDetail->setCellValue('A11', 'Kode Pos');
				$sheetDetail->setCellValue('B11', $result->postalcode);

				for ($i=4; $i < 12; $i++) { 
					$sheetDetail->mergeCells('B'.$i.':C'.$i);
				}
				
				$sheetDetail->getStyle('A4:A11')->applyFromArray([
					'fill'	=> [
							'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
							'color'	=> array('rgb' => 'e26b0a')
					],
					'font'	=> [
							'color'	=> array('rgb' => 'FFFFFF')
					],
				]);

				$sheetDetail->getStyle('A3:C11')->applyFromArray([
					'borders'	=> [
						'allborders'	=> [
							'style' 	=> PHPExcel_Style_Border::BORDER_THIN,
							'color' 	=> array('rgb' => '000000')
						],
					]
				]);


				// Informasi Transaksi
				$sheetDetail->setCellValue('A13', 'Informasi Transaksi');
				$sheetDetail->mergeCells('A13:C13');
				$sheetDetail->getStyle('A13')->applyFromArray([
					'fill'	=> [
							'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
							'color'	=> array('rgb' => 'c5d9f1')
					],
					'alignment' => [
				        	'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        	]
				]);

				$sheetDetail->setCellValue('A14', 'Status');
				$sheetDetail->setCellValue('B14', strtoupper($result->status));

				$sheetDetail->setCellValue('A15', 'Pembayaran');
				$sheetDetail->setCellValue('B15', $result->method_name);

				$sheetDetail->setCellValue('A16', 'Kode Kupon');
				$sheetDetail->setCellValue('B16', $result->code_coupon);

				$sheetDetail->setCellValue('A17', 'Potongan Kupon');
				$sheetDetail->setCellValue('B17', $result->coupon_price);

			

				for ($i=14; $i < 18; $i++) { 
					$sheetDetail->mergeCells('B'.$i.':C'.$i);
				}
				
				$sheetDetail->getStyle('A14:A17')->applyFromArray([
					'fill'	=> [
							'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
							'color'	=> array('rgb' => '538dd5')
					],
					'font'	=> [
							'color'	=> array('rgb' => 'FFFFFF')
					],
				]);

				$sheetDetail->getStyle('A13:C17')->applyFromArray([
					'borders'	=> [
						'allborders'	=> [
							'style' 	=> PHPExcel_Style_Border::BORDER_THIN,
							'color' 	=> array('rgb' => '000000')
						],
					]
				]);



				// Informasi Pengiriman
				$sheetDetail->setCellValue('G3', 'Informasi Pengiriman');
				$sheetDetail->mergeCells('G3:I4');
				$sheetDetail->getStyle('G3')->applyFromArray([
					'fill'	=> [
							'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
							'color'	=> array('rgb' => 'c4d79b')
					],
					'alignment' => [
				        	'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        	]
				]);

				for ($i=6; $i < 18 ; $i++) { 
					$sheetDetail->getStyle('G'.$i)->applyFromArray([
						'fill'	=> [
								'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'	=> array('rgb' => '76933c')
						],
						'alignment' => [
					        	'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
					        	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			        	],
						'font'	=> [
								'color'	=> array('rgb' => 'FFFFFF')
						]
					]);
				}

				$sheetDetail->setCellValue('G5', 'Asal Pengiriman');
				$sheetDetail->mergeCells('G5:I5');

				$sheetDetail->setCellValue('G6', 'Provinsi');
				$sheetDetail->setCellValue('H6', $result->origin_province);
				$sheetDetail->mergeCells('H6:I6');

				$sheetDetail->setCellValue('G7', 'Kota');
		    	$sheetDetail->setCellValue('H7', $result->origin_city);
		    	$sheetDetail->mergeCells('H7:I7');

		    	$sheetDetail->setCellValue('G8', 'Tujuan Pengiriman');
				$sheetDetail->mergeCells('G8:I8');

				$sheetDetail->setCellValue('G9', 'Provinsi');
				$sheetDetail->setCellValue('G10', 'Kota');
				$sheetDetail->setCellValue('G11', 'Kecamatan');

				$sheetDetail->setCellValue('H9', $result->province);
				$sheetDetail->setCellValue('H10', $result->city);
				$sheetDetail->setCellValue('H11', $result->district);

				$sheetDetail->mergeCells('H9:I9');
				$sheetDetail->mergeCells('H10:I10');
				$sheetDetail->mergeCells('H11:I11');

				$sheetDetail->setCellValue('G12', 'Opsi Pengiriman');
				$sheetDetail->mergeCells('G12:I12');

				$sheetDetail->setCellValue('G13', 'Total Berat');
				$sheetDetail->setCellValue('G14', 'Jasa Kurir');
				$sheetDetail->setCellValue('G15', 'Paket Kurir');
				$sheetDetail->setCellValue('G16', 'Estimasi');
				$sheetDetail->setCellValue('G17', 'Biaya Pengiriman');

		    	$sheetDetail->setCellValue('H13', $result->weight.' Gram');
		    	$sheetDetail->setCellValue('H14', $result->courier);
		    	$sheetDetail->setCellValue('H15', $result->courier_service_name);
		    	$sheetDetail->setCellValue('H16', $result->courier_estimate);
		    	$sheetDetail->setCellValue('H17', $result->courier_price);

				$sheetDetail->mergeCells('H13:I13');
				$sheetDetail->mergeCells('H14:I14');
				$sheetDetail->mergeCells('H15:I15');
				$sheetDetail->mergeCells('H16:I16');
				$sheetDetail->mergeCells('H17:I17');


			
				$style 				= [
											'fill'	=> [
													'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
													'color'	=> array('rgb' => '4f6228')
											],
											'alignment' => [
										        	'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
										            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								        	],
											'font'	=> [
													'color'	=> array('rgb' => 'FFFFFF')
											]
										];

				// Pengiriman Asal Pengiriman
				$sheetDetail->getStyle('G5')->applyFromArray($style);
				$sheetDetail->getStyle('G8')->applyFromArray($style);
				$sheetDetail->getStyle('G12')->applyFromArray($style);

				$sheetDetail->getStyle('G3:I17')->applyFromArray([
					'borders'	=> [
						'allborders'	=> [
							'style' 	=> PHPExcel_Style_Border::BORDER_THIN,
							'color' 	=> array('rgb' => '000000')
						],
					]
				]);
				
				$sheetDetail->setCellValue('A20', 'No Resi');
				$sheetDetail->setCellValue('B20', 'Nama Produk');
				$sheetDetail->setCellValue('C20', 'Jenis Produk');
				$sheetDetail->setCellValue('D20', 'Masa Hari');
				$sheetDetail->setCellValue('E20', 'Berat');
				$sheetDetail->setCellValue('F20', 'Harga');
				$sheetDetail->setCellValue('G20', 'Jumlah');
				$sheetDetail->setCellValue('H20', 'Total Berat');
				$sheetDetail->setCellValue('I20', 'Sub Total');

				$style 				= [
										'fill'	=> [
												'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
												'color'	=> array('rgb' => '202a38')
										],
										'alignment' => [
									        	'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
									            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							        	],
										'font'	=> [
												'color'	=> array('rgb' => 'FFFFFF')
										]
									];

				// Pengiriman Asal Pengiriman
				$sheetDetail->getStyle('A20:I20')->applyFromArray($style);

				foreach ($result->detail as $key => $detail) {
					$i 						= $key + 21;

					$sheetDetail->setCellValue('A'.$i,($detail->waybill==null || $detail->waybill=="") ? 'Tidak Ada No Resi' : $detail->waybill);
					$sheetDetail->setCellValue('B'.$i,$detail->name);
					$sheetDetail->setCellValue('C'.$i,$detail->type);
					$sheetDetail->setCellValue('D'.$i,($detail->timeout>0) ? $detail->timeout.' Hari' : 'Tidak Ada');
					$sheetDetail->setCellValue('E'.$i,$detail->weight.' Gram');
					$sheetDetail->setCellValue('F'.$i,$detail->price);
					$sheetDetail->setCellValue('G'.$i,$detail->qty);
					$sheetDetail->setCellValue('H'.$i,$detail->weight_total.' Gram');
					$sheetDetail->setCellValue('I'.$i,$detail->price_total);
				}

				$sheetDetail->setCellValue('A'.($i+1), 'Total Awal');
			    $sheetDetail->setCellValue('I'.($i+1), $result->price);
			    $sheetDetail->mergeCells('A'.($i+1).':H'.($i+1));

			    $sheetDetail->setCellValue('A'.($i+2), 'Biaya Pengiriman (+)');
			    $sheetDetail->setCellValue('I'.($i+2), $result->courier_price);
			    $sheetDetail->mergeCells('A'.($i+2).':H'.($i+2));

			    $sheetDetail->setCellValue('A'.($i+3), 'Potongan Kupon (-)');
			    $sheetDetail->setCellValue('I'.($i+3), $result->coupon_price);
			    $sheetDetail->mergeCells('A'.($i+3).':H'.($i+3));

			    $sheetDetail->setCellValue('A'.($i+4), 'Total Biaya');
			    $sheetDetail->setCellValue('I'.($i+4), $result->price_total);
			    $sheetDetail->mergeCells('A'.($i+4).':H'.($i+4));

			    for ($j=1; $j < 4; $j++) { 
			    	$sheetDetail->getRowDimension($i+$i)->setRowHeight(20);
			    }

			    $sheetDetail->getStyle('A'.($i+1).':H'.($i+4))->applyFromArray([
					'alignment' => [
					        'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		        	]
				]);

				$sheetDetail->getStyle('A'.($i+1).':I'.($i+3))->applyFromArray([
					'fill'	=> [
							'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
							'color'	=> array('rgb' => 'f2f2f2')
					]
				]);

				$sheetDetail->getStyle('A'.($i+4).':I'.($i+4))->applyFromArray([
					'fill'	=> [
							'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
							'color'	=> array('rgb' => 'd9d9d9')
					],
					'font'	=> [
							'bold'	=> true,
					]
				]);

				$code 					= '_-[$Rp-421]* #,##0_-;-[$Rp-421]* #,##0_-;_-[$Rp-421]* "-"_-;_-@_-';

			    // Set Currency ke rupiah
			    $sheetDetail->getStyle('F21:F'.$i)->getNumberFormat()->setFormatCode($code);
			    $sheetDetail->getStyle('I21:I'.($i+4))->getNumberFormat()->setFormatCode($code);

			    $sheetDetail->getStyle('B17')->getNumberFormat()->setFormatCode($code);
			    $sheetDetail->getStyle('H17')->getNumberFormat()->setFormatCode($code);

			    $sheetDetail->getStyle('A20:I'.($i+4))->applyFromArray([
					'borders'	=> [
						'allborders'	=> [
							'style' 	=> PHPExcel_Style_Border::BORDER_THIN,
							'color' 	=> array('rgb' => '000000')
						],
					]
				]);

			    $sheetDetail->getDefaultStyle()->applyFromArray([
					'alignment' => [
					        'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
		        	]
				]);
				$sheetDetail->getSheetView(($key+1))->setZoomScale(90);
				$sheetDetail->getDefaultColumnDimension()->setWidth(20);
				// ------------------------- END DYNAMIC SHEET

		    }


		    $sheet->setCellValue('A'.($row+1), 'Total Transaksi Pending ( Order, Request )');
		    $sheet->setCellValue('V'.($row+1), $total['pending']);
		    $sheet->mergeCells('A'.($row+1).':U'.($row+1));

		    $sheet->setCellValue('A'.($row+2), 'Total Transaksi Batal ( Cancel )');
		    $sheet->setCellValue('V'.($row+2), $total['cancel']);
		    $sheet->mergeCells('A'.($row+2).':U'.($row+2));

		    $sheet->setCellValue('A'.($row+3), 'Total Transaksi Selesai ( Approve , Packing , Done )');
		    $sheet->setCellValue('V'.($row+3), $total['done']);
		    $sheet->mergeCells('A'.($row+3).':U'.($row+3));

		    $sheet->setCellValue('A'.($row+4), 'Total Transaksi Keseluruhan');
		    $sheet->setCellValue('V'.($row+4), $total['all']);
		    $sheet->mergeCells('A'.($row+4).':U'.($row+4));

		    $sheet->getDefaultRowDimension()->setRowHeight(15);

		    for ($i=1; $i < 4; $i++) { 
		    	$sheet->getRowDimension($row+$i)->setRowHeight(20);
		    }


		    	

			$sheet->getStyle('A'.($row+1).':U'.($row+4))->applyFromArray([
				'alignment' => [
				        'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
			            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
	        	]
			]);

			$sheet->getStyle('A'.($row+1).':X'.($row+3))->applyFromArray([
				'fill'	=> [
						'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
						'color'	=> array('rgb' => 'f2f2f2')
				]
			]);

			$sheet->getStyle('A'.($row+4).':X'.($row+4))->applyFromArray([
				'fill'	=> [
						'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
						'color'	=> array('rgb' => 'd9d9d9')
				],
				'font'	=> [
						'bold'	=> true,
				]
			]);


		    $style = array(
		        'borders' => array(
			          'allborders' => array(
			              'style' => PHPExcel_Style_Border::BORDER_THIN,
			               'color' => array('rgb' => '000000')
			          )
			      )
		    );

		    $sheet->getStyle("A6:X".($row+4))->applyFromArray($style);


		    for ($i='A'; $i < 'X' ; $i++) { 
		    	$sheet->getColumnDimension($i)->setWidth(20);
		    }

		    $code 					= '_-[$Rp-421]* #,##0_-;-[$Rp-421]* #,##0_-;_-[$Rp-421]* "-"_-;_-@_-';

		    // Set Currency ke rupiah
		    $sheet->getStyle('R9:V'.$row)->getNumberFormat()->setFormatCode($code);
			$sheet->getStyle('T9:V'.$row)->getNumberFormat()->setFormatCode($code);
			$sheet->getStyle('U9:V'.$row)->getNumberFormat()->setFormatCode($code);
		    $sheet->getStyle('V9:V'.($row+4))->getNumberFormat()->setFormatCode($code);
					

		    $sheet->getColumnDimension('A')->setWidth(35);
		    $sheet->getColumnDimension('U')->setWidth(25);
		    $sheet->getColumnDimension('X')->setWidth(25);
		    $sheet->getColumnDimension('V')->setWidth(35);

		    $sheet->getDefaultStyle()->applyFromArray([
				'alignment' => [
				        'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        	]
			]);

			$excel->getActiveSheet(0)->setTitle('Data Transaksi');
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$excel->setActiveSheetIndex(0);
			$excel->getActiveSheet(0)->freezePane('G9');			
			$sheet->getSheetView(0)->setZoomScale(70);
			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$objWriter->save('php://output');
			exit();
	}

}