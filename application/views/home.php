<?php  
	
	$bytesID = random_bytes(16);
	$id = bin2hex($bytesID);

	function bulan_indo($month) {
        $bulan = (int) $month;
        $arrBln = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        return $arrBln[$bulan];
    }

	function format_tanggal_indo($tgl) {
        $tanggal = substr($tgl, 8, 2);
        $bulan = bulan_indo(substr($tgl, 5, 2));
        $tahun = substr($tgl, 0, 4);
        $day = date('D', strtotime($tgl));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );

        return $dayList[$day] . ', ' . $tanggal . ' ' . $bulan . ' '. $tahun;  
    }
	// echo $id;

	function encryptData( $action, $string ) {

		$output = false;
		$encrypt_method = "AES-256-CBC";

		$secret_key = 'kuribem';
		$secret_iv = 'blueteam@123';

		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);

		if ( $action == 'encrypt' ) {
			
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
	 
		} else if ( $action == 'decrypt' ) {

			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

		}

		return $output;

	}

    $conn = mysqli_connect("localhost", "root", "", "ci3_tutorial");
    $sqlTotalData = mysqli_query($conn, "SELECT * FROM tb_peserta");
    $jumlahData = mysqli_num_rows($sqlTotalData);
    $simpanArr = array(
    	'jumlah_data' => $jumlahData
    );

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> HALAMAN UTAMA WEBSITE </title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style type="text/css">
		
		tbody > tr:hover {
			background-color: lightyellow;
		}	

		tbody > tr > td {
			padding: 10px 10px;
		}	

	</style>
</head>
<body>

	<h1 style="margin-left: auto; margin-right: auto; margin-top: 30px; text-align: center; "> Data Peserta Lomba Agustusan </h1>

	<?php if ($this->session->flashdata('pesanih') ): ?>
			
		<?php  

			$dasndoa = $this->session->flashdata('pesanih');

		?>
		<?= "<script>alert('$dasndoa')</script>"; ?>

		<!-- Button trigger modal -->
		<button type="button" class="btn" data-toggle="modal" data-target="#exampleModal" style="margin-top: 50px; margin-left: 25%; background-color: gray; color: white;"> 
		  Daftarkan Peserta
		</button>

		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header" style="margin-left: auto; margin-right: auto; text-align: center;">
		        <h5 class="modal-title" id="exampleModalLabel"> Pendaftaran Lomba Agustusan </h5>
		      </div>
		      <div class="modal-body">

		      	<form action="<?= base_url('Welcome/insertData'); ?>" method="POST">

				  <div class="form-group row" style="margin-left: 10%;">
				    <label for="nama" class="col-sm-4 col-form-label">Nama Lengkap</label>
				    <div class="col-sm-8">
				      <!-- <input type="text" readonly class="form-control-plaintext" id="nama" value="email@example.com"> -->
				      <input type="text" required name="nama_lengkap" class="form-control" style="width: 90%; margin-left: 5%;" id="nama" placeholder="nama lengkap">
				    </div>
				  </div>

				  <div class="form-group row" style="margin-left: 10%;">
				    <label for="iktLomba" class="col-sm-4 col-form-label"> Ikut Lomba </label>
				    <div class="col-sm-8">
					    <select name="lomba" required class="form-control" style="width: 47%; margin-left: 5%;">
					    	<?php foreach ( $daftar_lomba as $df_lomba ) : ?>
	                                <option value="<?= $df_lomba->id; ?>" > <?= $df_lomba->nama_lomba; ?> </option>
	                        <?php endforeach; ?>
					    </select>
					</div>
				  </div>

				

		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Save changes</button>
		      </div>
		      	</form>
		    </div>
		  </div>
		</div>

		<!-- Modal Edit -->
		<?php $no = 0; ?>
		<?php foreach($data_peserta as $pst) : $no++; ?>

			<?php  

				$dkjasdEncrypt = $pst->id_nama_peserta;
	            $ciphering = "AES-128-CTR";

	            // Use OpenSSl Encryption method
	            $iv_length = openssl_cipher_iv_length($ciphering);
	            $options = 0;

	            // Non-NULL Initialization Vector for encryption
	            $encryption_iv = '1234567890123456';

	            // Store the encryption key
	            $bytesID = random_bytes(16);
	            $encryption_key = "";
	            $encryption = openssl_encrypt($dkjasdEncrypt, $ciphering, $encryption_key, $options, $encryption_iv);

	            // decrypt
				$ciphering = "AES-128-CTR";
				$options = 0;

				// Non-NULL Initialization Vector for encryption

				$decryption_iv = '1234567890123456';

				// Store the decryption key
				$decryption_key = "";

				// Use openssl_decrypt() function to decrypt the data
				$decryption = openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

			?>

			<div class="modal fade" id="editData<?= $encryption; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="margin-left: auto; margin-right: auto; text-align: center;">
			        <h5 class="modal-title" id="exampleModalLabel"> Pendaftaran Lomba Agustusan </h5>
			      </div>
			      <div class="modal-body">
			      	<form action="<?= base_url('Welcome/updateData'); ?>" method="POST">
			      	<input type="hidden" value="<?= $decryption; ?>" name="id_peserta">

					  <div class="form-group row" style="margin-left: 10%;">
					    <label for="nama" class="col-sm-4 col-form-label">Nama Lengkap</label>
					    <div class="col-sm-8">
					      <!-- <input type="text" readonly class="form-control-plaintext" id="nama" value="email@example.com"> -->
					      <input type="text" required name="nama_lengkap" class="form-control" style="width: 90%; margin-left: 5%;" id="nama" value="<?= $pst->nama; ?>">
					    </div>
					  </div>

					  <div class="form-group row" style="margin-left: 10%;">
					    <label for="iktLomba" class="col-sm-4 col-form-label"> Ikut Lomba </label>
					    <div class="col-sm-8">
						    <select name="lomba" required class="form-control" style="width: 47%; margin-left: 5%;">
						    	<?php foreach ( $daftar_lomba as $df_lomba ) : ?>
		                                <option value="<?= $df_lomba->id; ?>" <?= $df_lomba->id == $pst->lomba ? "selected" : null ?> > <?= $df_lomba->nama_lomba; ?> </option>
		                        <?php endforeach; ?>
						    </select>
						</div>
					  </div>	

			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-primary">Save changes</button>
			      </div>
			      	</form>
			    </div>
			  </div>
			</div>
		<?php endforeach; ?>

		<table border="1" width="50%" style="margin-left: auto; margin-right: auto; margin-top: 50px; text-align: center;">

			<thead>

				<tr style="background-color: lightgreen;">
					<th style="width: 50px;"> # </th>
					<th> Namaa </th>
					<th> Lombsa </th>
					<th> Tanggal Daftar </th>
					<!-- <th> TES </th> -->
					<th> Aksi </th>
				</tr>

			</thead>

			<tbody>
				
				<?php $no = 1; ?>
				<?php foreach ($data_peserta as $peserta): ?>

					<?php  

						$dkjasdEncrypt = $peserta->id_nama_peserta;
			            $ciphering = "AES-128-CTR";

			            // Use OpenSSl Encryption method
			            $iv_length = openssl_cipher_iv_length($ciphering);
			            $options = 0;

			            // Non-NULL Initialization Vector for encryption
			            $encryption_iv = '1234567890123456';

			            // Store the encryption key
			            $bytesID = random_bytes(16);
			            $encryption_key = "";
			            $encryption = openssl_encrypt($dkjasdEncrypt, $ciphering, $encryption_key, $options, $encryption_iv);

					?>
					<!-- <?= $id; ?> -->
					<tr>
						<td> <?= $no; ?> </td>
						<td> <?= $peserta->nama; ?> </td>
						<td> <?= $peserta->nama_lomba; ?> </td>
						<td> <?= format_tanggal_indo($peserta->tgl_daftar); ?> </td>
						<!-- <td> <?= $id; ?> </td> -->
						<td> 

							<button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#editData<?= $encryption; ?>"> Edit </button>
							<button class="btn btn-sm btn-danger" onclick="ConfirmDelete('<?= $peserta->id_nama_peserta; ?>')"> Delete </button>

						</td>
					</tr>
					
				<?php $no++ ?>
				<?php endforeach; ?>

			</tbody>

		</table>

	<?php else: ?>

		<!-- Button trigger modal -->
		<button type="button" class="btn" data-toggle="modal" data-target="#exampleModal" style="margin-top: 50px; margin-left: 25%; background-color: gray; color: white;"> 
		  Daftarkan Peserta
		</button>

		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header" style="margin-left: auto; margin-right: auto; text-align: center;">
		        <h5 class="modal-title" id="exampleModalLabel"> Pendaftaran Lomba Agustusan </h5>
		      </div>
		      <div class="modal-body">

		      	<form action="<?= base_url('Welcome/insertData'); ?>" method="POST">

				  <div class="form-group row" style="margin-left: 10%;">
				    <label for="nama" class="col-sm-4 col-form-label">Nama Lengkap</label>
				    <div class="col-sm-8">
				      <!-- <input type="text" readonly class="form-control-plaintext" id="nama" value="email@example.com"> -->
				      <input type="text" required name="nama_lengkap" class="form-control" style="width: 90%; margin-left: 5%;" id="nama" placeholder="nama lengkap">
				    </div>
				  </div>

				  <div class="form-group row" style="margin-left: 10%;">
				    <label for="iktLomba" class="col-sm-4 col-form-label"> Ikut Lomba </label>
				    <div class="col-sm-8">
					    <select name="lomba" required class="form-control" style="width: 47%; margin-left: 5%;">
					    	<?php foreach ( $daftar_lomba as $df_lomba ) : ?>
	                                <option value="<?= $df_lomba->id; ?>" > <?= $df_lomba->nama_lomba; ?> </option>
	                        <?php endforeach; ?>
					    </select>
					</div>
				  </div>

				

		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Save changes</button>
		      </div>
		      	</form>
		    </div>
		  </div>
		</div>

		<!-- Modal Edit -->
		<?php $no = 0; ?>
		<?php foreach($data_peserta as $pst) : $no++; ?>
			<?php  

				$dkjasdEncrypt = $pst->id_nama_peserta;
	            $ciphering = "AES-128-CTR";

	            // Use OpenSSl Encryption method
	            $iv_length = openssl_cipher_iv_length($ciphering);
	            $options = 0;

	            // Non-NULL Initialization Vector for encryption
	            $encryption_iv = '1234567890123456';

	            // Store the encryption key
	            $bytesID = random_bytes(16);
	            $encryption_key = "";
	            $encryption = openssl_encrypt($dkjasdEncrypt, $ciphering, $encryption_key, $options, $encryption_iv);

	            // decrypt
				$ciphering = "AES-128-CTR";
				$options = 0;

				// Non-NULL Initialization Vector for encryption

				$decryption_iv = '1234567890123456';

				// Store the decryption key
				$decryption_key = "";

				// Use openssl_decrypt() function to decrypt the data
				$decryption = openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

			?>
			<div class="modal fade" id="editData<?= $encryption; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="margin-left: auto; margin-right: auto; text-align: center;">
			        <h5 class="modal-title" id="exampleModalLabel"> Pendaftaran Lomba Agustusan </h5>
			      </div>
			      <div class="modal-body">
			      	<form action="<?= base_url('Welcome/updateData'); ?>" method="POST">
			      	<input type="hidden" value="<?= $decryption; ?>" name="id_peserta">

					  <div class="form-group row" style="margin-left: 10%;">
					    <label for="nama" class="col-sm-4 col-form-label">Nama Lengkap</label>
					    <div class="col-sm-8">
					      <!-- <input type="text" readonly class="form-control-plaintext" id="nama" value="email@example.com"> -->
					      <input type="text" required name="nama_lengkap" class="form-control" style="width: 90%; margin-left: 5%;" id="nama" value="<?= $pst->nama; ?>">
					    </div>
					  </div>

					  <div class="form-group row" style="margin-left: 10%;">
					    <label for="iktLomba" class="col-sm-4 col-form-label"> Ikut Lomba </label>
					    <div class="col-sm-8">
						    <select name="lomba" required class="form-control" style="width: 47%; margin-left: 5%;">
						    	<?php foreach ( $daftar_lomba as $df_lomba ) : ?>
		                                <option value="<?= $df_lomba->id; ?>" <?= $df_lomba->id == $pst->lomba ? "selected" : null ?> > <?= $df_lomba->nama_lomba; ?> </option>
		                        <?php endforeach; ?>
						    </select>
						</div>
					  </div>	

			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-primary">Save changes</button>
			      </div>
			      	</form>
			    </div>
			  </div>
			</div>
		<?php endforeach; ?>

		<table border="1" width="50%" style="margin-left: auto; margin-right: auto; margin-top: 50px; text-align: center;">

			<thead>

				<tr style="background-color: lightgreen;">
					<th style="width: 50px;"> # </th>
					<th> Nama </th>
					<th> Lomba </th>
					<th> Tanggal Daftar </th>
					<th> Aksi </th>
				</tr>

			</thead>

			<tbody>
				
				<?php $no = 1; ?>
				<?php foreach ($data_peserta as $peserta): ?>

					<?php 

						$dkjasd = $peserta->id_nama_peserta;
			            $ciphering = "AES-128-CTR";

			            // Use OpenSSl Encryption method
			            $iv_length = openssl_cipher_iv_length($ciphering);
			            $options = 0;

			            // Non-NULL Initialization Vector for encryption
			            $encryption_iv = '1234567890123456';

			            // Store the encryption key
			            $bytesID = random_bytes(16);
			            $encryption_key = "";
			            $encryption = openssl_encrypt($dkjasd, $ciphering, $encryption_key, $options, $encryption_iv);
						echo $dkjasd . "=" . $encryption . "<br>";

					?>

					<tr>
						<td> <?= $no; ?> </td>
						<td> <?= $peserta->nama; ?> </td>
						<td> <?= $peserta->nama_lomba; ?> </td>
						<td> <?= format_tanggal_indo($peserta->tgl_daftar); ?> </td>
						<td> 

							<button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#editData<?= $encryption; ?>"> Edit </button>
							<button class="btn btn-sm btn-danger" onclick="ConfirmDelete('<?= $peserta->id_nama_peserta; ?>')"> Delete </button>

						</td>
					</tr>

				<?php $no++ ?>
				<?php endforeach; ?>

			</tbody>

		</table>

	<?php endif; ?>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<script type="text/javascript">

		function ConfirmDelete(data_id) {

			let data = confirm(`Are you sure want to delete ${data_id} ?`);
			if (data) {
                location.href='<?= base_url("Welcome/deleteData/")  ; ?>' + data_id;
			}

     	}

	</script>

</body>
</html>