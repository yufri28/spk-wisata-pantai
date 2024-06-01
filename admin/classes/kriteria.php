<?php 

require_once '../config.php';
class Kriteria{
    private $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }

    public function getKriteria()
    {
        return $this->db->query("SELECT * FROM `kriteria`");
    }
    public function tambahKriteria($dataKriteria)
    {
        if($this->count_kriterial() < 5){
            $cek = $this->db->query("SELECT * FROM kriteria WHERE id_kriteria='".$dataKriteria['id_kriteria']."'");
            if (mysqli_num_rows($cek) > 0) {
                return $_SESSION['error'] = 'Kode Kriteria sudah ada!';
            } else{
                $stmtInsert = $this->db->prepare("INSERT INTO kriteria(id_kriteria,nama_kriteria) VALUES (?,?)");
                $stmtInsert->bind_param("ss",$dataKriteria['id_kriteria'],$dataKriteria['nama_kriteria']);
                $stmtInsert->execute();
                if ($stmtInsert->affected_rows > 0) {
                    return $_SESSION['success'] = 'Data berhasil ditambahkan!';
                } else{
                    return $_SESSION['error'] = 'Terjadi kesalahan dalam menyimpan data.';
                }
            }
        }else{
            return $_SESSION['error'] = 'Tidak bisa menambah kriteria lagi. Maksimal 4 kriteria.';
        }
        
        $stmtInsert->close();
    }
    public function editKriteria($dataKriteria)
    {
        $stmtUpdate = $this->db->prepare("UPDATE kriteria SET nama_kriteria=? WHERE id_kriteria=?");
        $stmtUpdate->bind_param("ss",$dataKriteria['nama_kriteria'],$dataKriteria['id_kriteria']);
        $stmtUpdate->execute();
        if ($stmtUpdate->affected_rows > 0) {
            return $_SESSION['success'] = 'Data berhasil diedit!';
        } else{
            return $_SESSION['error'] = 'Terjadi kesalahan dalam mengedit data.';
        }
        $stmtUpdate->close();
        
    }
    public function hapusKriteria($idKriteria)
    {
        $stmtDelete = $this->db->prepare("DELETE FROM kriteria WHERE id_kriteria=?");
        $stmtDelete->bind_param("s",$idKriteria);
        $stmtDelete->execute();
        if ($stmtDelete->affected_rows > 0) {
            return $_SESSION['success'] = 'Data berhasil dihapus!';
        } else{
            return $_SESSION['error'] = 'Terjadi kesalahan dalam menghapus data.';
        }
        $stmtDelete->close();
        
    }
    public function count_kriterial(){
        $jumlahKriteria = $this->db->query("SELECT COUNT(*) AS jumlah_kriteria FROM kriteria")->fetch_assoc();
        return $jumlahKriteria['jumlah_kriteria'];
    }
}
$Kriteria = new Kriteria();

?>