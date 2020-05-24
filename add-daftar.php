<?php

include_once("helper/config-log.php");

$id_pasien=$_GET['id'];

$tarik_asuransi = mysqli_query($koneksi, "Select * from asuransi");
$tarik_poli = mysqli_query($koneksi, "Select * from poliklinik");

$detect = mysqli_query($koneksi, "SELECT * from antrian_pasien where id_pasien=$id_pasien");

while($data = mysqli_fetch_array($detect))
{
    $nama = $data['nm_pasien'];
    $tgl_lahir = $data['tgl_lahir'];
    $alamat = $data['alamat'];
}
?>
<?php
	if (isset($_POST['submit'])) {
		$nama = $_POST['nama'];
		$tgl_lahir = $_POST['tgl_lahir'];
		$jns_kelamin = $_POST['jenis_kelamin'];
		$asuransi = $_POST['asuransi'];
		$poli = $_POST['poli'];
		$alamat = $_POST['alamat'];

		if(empty($nama) || empty($tgl_lahir)|| empty($jns_kelamin) || empty($asuransi) || empty($poli) || empty($alamat)){
   			header("Location: index.php?page=daftar-pasien&notif=required");
   		}else{
			include_once("helper/config.php");
			$input = mysqli_query($koneksi, "INSERT INTO daftar_pasien(nm_pasien, tgl_lahir, jns_kelamin, poliklinik, asuransi, alamat)
													   VALUES ('$nama', '$tgl_lahir', '$jns_kelamin', '$poli', '$asuransi', '$alamat')");

				if ($input) {
					//echo "Pengguna Sukses ditambahkan. <a href='index.php'>Lihat Pengguna</a>";
					header("Location: index.php?page=daftar-pasien&notif=muncul-add");
				}else{
					header("Location: index.php?page=daftar-pasien&notif=fail");
				}
		}
	}

?>
<div id="content_add-daftar">

	<form action="add-daftar.php" method="post">

		<div class="element-form">
			<label>Nama Lengkap</label>
			<span><input type="text" name="nama" value="<?php echo $nama; ?>" /></span>
		</div>

		<div class="element-form">
			<label>Tanggal Lahir </label>
			<span><input type="date" name="tgl_lahir" value="<?php echo $tgl_lahir; ?>"/></span>
		</div>

		<div class="element-form">
			<label>Jenis Kelamin</label>
			<span>
				<label><input type="radio" name="jenis_kelamin" value="Laki-laki" /> Laki-laki</label>
            	<label><input type="radio" name="jenis_kelamin" value="Perempuan" /> Perempuan</label>
        	</span>
		</div>
		<div class="element-form">
			<label>Asuransi </label>
			<span>
				<select name="asuransi">
					<?php
						while ($data_asuransi = mysqli_fetch_assoc($tarik_asuransi)){
                			echo "<option value=".$data_asuransi['nm_asuransi'].">".$data_asuransi['nm_asuransi']."</option>";
	               		}
	               	?>
            	</select>
        	</span>
		</div>
		<div class="element-form">
			<label>Poliklinik </label>
			<span>
					<select name="poli">
                		<?php
							while ($data_poli = mysqli_fetch_assoc($tarik_poli)){
                			echo "<option value=".$data_poli['nm_poli'].">".$data_poli['nm_poli']."</option>";
	               			}
	               		?>
            		</select>
        </div>
		<div class="element-form">
			<label>Alamat</label>
			<span><textarea name="alamat"><?php echo $alamat;?></textarea></span>
		</div>

		<div class="element-form">
			<span><input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"></span>
			<span><input type="submit" name="submit" value="Masukan"/></span>
		</div>
	</form>
</div>