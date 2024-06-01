<?php 
    // session_start();
    require_once '../config.php';
    class Alternatif{

        private $db;

        public function __construct()
        {
            $this->db = connectDatabase();
        }

        public function getDataAlternatif()
        {
            // return $this->db->query("SELECT * FROM alternatif");
            return $this->db->query("SELECT a.nama_alternatif, a.id_alternatif, a.latitude, a.longitude, a.alamat, a.gambar, a.rating, a.biaya_alt, a.fasilitas_alt, a.jarak_alt, kak.id_alt_kriteria,
                MAX(CASE WHEN k.id_kriteria = 'C1' THEN kak.id_alt_kriteria END) AS id_alt_C1,
                MIN(CASE WHEN k.id_kriteria = 'C2' THEN kak.id_alt_kriteria END) AS id_alt_C2,
                MIN(CASE WHEN k.id_kriteria = 'C3' THEN kak.id_alt_kriteria END) AS id_alt_C3,
                MAX(CASE WHEN k.id_kriteria = 'C4' THEN kak.id_alt_kriteria END) AS id_alt_C4,
                MAX(CASE WHEN k.id_kriteria = 'C5' THEN kak.id_alt_kriteria END) AS id_alt_C5,
                MAX(CASE WHEN k.id_kriteria = 'C1' THEN kak.f_id_sub_kriteria END) AS id_sub_C1,
                MIN(CASE WHEN k.id_kriteria = 'C2' THEN kak.f_id_sub_kriteria END) AS id_sub_C2,
                MIN(CASE WHEN k.id_kriteria = 'C3' THEN kak.f_id_sub_kriteria END) AS id_sub_C3,
                MAX(CASE WHEN k.id_kriteria = 'C4' THEN kak.f_id_sub_kriteria END) AS id_sub_C4,
                MAX(CASE WHEN k.id_kriteria = 'C5' THEN kak.f_id_sub_kriteria END) AS id_sub_C5,
                MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.nama_sub_kriteria END) AS nama_C1,
                MIN(CASE WHEN k.id_kriteria = 'C2' THEN sk.nama_sub_kriteria END) AS nama_C2,
                MIN(CASE WHEN k.id_kriteria = 'C3' THEN sk.nama_sub_kriteria END) AS nama_C3,
                MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.nama_sub_kriteria END) AS nama_C4,
                MAX(CASE WHEN k.id_kriteria = 'C5' THEN sk.nama_sub_kriteria END) AS nama_C5,
                MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.spesifikasi END) AS spesifikasi_C1,
                MIN(CASE WHEN k.id_kriteria = 'C2' THEN sk.spesifikasi END) AS spesifikasi_C2,
                MIN(CASE WHEN k.id_kriteria = 'C3' THEN sk.spesifikasi END) AS spesifikasi_C3,
                MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.spesifikasi END) AS spesifikasi_C4,
                MAX(CASE WHEN k.id_kriteria = 'C5' THEN sk.spesifikasi END) AS spesifikasi_C5
                FROM alternatif a
                JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
                JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
                JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria
                GROUP BY a.nama_alternatif ORDER BY a.id_alternatif DESC;");
        }

        public function tambahAlternatif($dataAlternatif,$dataSubKriteria)
        {
            
            $cekData = $this->db->query("SELECT * FROM `alternatif` WHERE LOWER(nama_alternatif) = '".strtolower($dataAlternatif['nama_alternatif'])."'");
            if ($cekData->num_rows > 0) {
                return $_SESSION['error'] = 'Data sudah ada!';
            } else {
                $stmtInsertAlt = $this->db->prepare("INSERT INTO alternatif(nama_alternatif, alamat, gambar, latitude, longitude, rating, biaya_alt, fasilitas_alt, jarak_alt) VALUES (?,?,?,?,?,?,?,?,?)");
                $stmtInsertAlt->bind_param("sssssiisd", $dataAlternatif['nama_alternatif'], $dataAlternatif['alamat'], $dataAlternatif['gambar'], $dataAlternatif['latitude'], $dataAlternatif['longitude'], $dataAlternatif['rating'],$dataAlternatif['biaya_alt'],$dataAlternatif['fasilitas_alt'],$dataAlternatif['jarak_alt']);
                $stmtInsertAlt->execute();
                $getId = $this->db->query("SELECT id_alternatif FROM `alternatif` WHERE nama_alternatif = '".$dataAlternatif['nama_alternatif']."'");
                $fetchId = mysqli_fetch_assoc($getId);
                foreach ($dataSubKriteria as $key => $id_sub_kriteria) {
                    $stmtInsertKecAltKriteria = $this->db->prepare("INSERT INTO kecocokan_alt_kriteria(f_id_alternatif, f_id_kriteria, f_id_sub_kriteria) VALUES (?,?,?)");
                    $stmtInsertKecAltKriteria->bind_param("isi", $fetchId['id_alternatif'], $key, $id_sub_kriteria);
                    $stmtInsertKecAltKriteria->execute();
                }
                if ($stmtInsertAlt->affected_rows > 0 && $stmtInsertKecAltKriteria->affected_rows > 0) {
                    return $_SESSION['success'] = 'Data berhasil disimpan!';
                } else {
                    return $_SESSION['error'] = 'Terjadi kesalahan dalam menyimpan data.';
                }
                $stmtInsertAlt->close();
                $stmtInsertKecAltKriteria->close();

            }
            

        }
        public function editAlternatif($dataAlternatif,$dataSubKriteria)
        {
            // $stmtUpdateAlt = $this->db->prepare("UPDATE alternatif SET nama_alternatif=?, alamat=?, latitude=?, longitude=? WHERE id_alternatif=?");
            // $stmtUpdateAlt->bind_param("ssssi", $dataAlternatif['nama_alternatif'], $dataAlternatif['alamat'], $dataAlternatif['latitude'], $dataAlternatif['longitude'], $dataAlternatif['id_alternatif']);
            // $stmtUpdateAlt->execute();
            $query = "UPDATE alternatif SET nama_alternatif='" . $dataAlternatif['nama_alternatif'] . "', alamat='" . $dataAlternatif['alamat'] . "' , gambar='" . $dataAlternatif['gambar'] . "', latitude='" . $dataAlternatif['latitude'] . "', longitude='" . $dataAlternatif['longitude'] . "', rating='" . $dataAlternatif['rating'] . "', biaya_alt='" . $dataAlternatif['biaya_alt'] . "', fasilitas_alt='" . $dataAlternatif['fasilitas_alt'] . "', jarak_alt='" . $dataAlternatif['jarak_alt'] . "' WHERE id_alternatif=" . $dataAlternatif['id_alternatif'];
            $stmtUpdateAlt = $this->db->query($query);
            
            if ($stmtUpdateAlt) {
                $getId = $this->db->query("SELECT id_alt_kriteria FROM `kecocokan_alt_kriteria` WHERE f_id_alternatif = '" . $dataAlternatif['id_alternatif'] . "'");
                $arr = [];
                while ($row = mysqli_fetch_row($getId)) {
                    for ($i = 0; $i < count($row); $i++) {
                        array_push($arr, $row[$i]);
                    }
                }
            
                for ($i = 0; $i < count($arr); $i++) {
                    $queryKecKriteria = "UPDATE kecocokan_alt_kriteria SET f_id_alternatif='" . $dataAlternatif['id_alternatif'] . "', f_id_kriteria='C" . ($i + 1) . "', f_id_sub_kriteria='" . $dataSubKriteria[$i] . "' WHERE id_alt_kriteria=" . $arr[$i];
                    $stmtUpdateKecKriteria = $this->db->query($queryKecKriteria);
                }
            
                if ($stmtUpdateKecKriteria) {
                    $_SESSION['success'] = 'Data berhasil diubah!';
                } else {
                    $_SESSION['error'] = 'Terjadi kesalahan dalam mengubah data.';
                }
            } else {
                $_SESSION['error'] = 'Terjadi kesalahan dalam mengubah data.';
            }
            
            // $stmtUpdateAlt->close();
            
        }
        public function hapusAlternatif($id) {
            $stmtDelete = $this->db->prepare("DELETE FROM alternatif WHERE id_alternatif=?");
            $stmtDelete->bind_param("i", $id);
            $stmtDelete->execute();

            if ($stmtDelete->affected_rows > 0) {
                $_SESSION['success'] = 'Data berhasil dihapus!';
            } else {
                $_SESSION['error'] = 'Terjadi kesalahan dalam menghapus data.';
            }
            $stmtDelete->close();
        }

        public function getSubBiaya()
        {
            return $this->db->query("SELECT id_sub_kriteria, nama_sub_kriteria, spesifikasi FROM sub_kriteria WHERE f_id_kriteria = 'C1'");
        }
        public function getSubFasilitas()
        {
            return $this->db->query("SELECT id_sub_kriteria, nama_sub_kriteria, spesifikasi FROM sub_kriteria WHERE f_id_kriteria = 'C2'");
        }
        public function getSubPusatKota()
        {
            return $this->db->query("SELECT id_sub_kriteria, nama_sub_kriteria, spesifikasi FROM sub_kriteria WHERE f_id_kriteria = 'C3'");
        }
        public function getSubJumlahPengunjung()
        {
            return $this->db->query("SELECT id_sub_kriteria, nama_sub_kriteria, spesifikasi FROM sub_kriteria WHERE f_id_kriteria = 'C4'");
        }

    }
    $getDataAlternatif = new Alternatif();

?>