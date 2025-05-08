<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataPendukungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_data_pendukung' => 1, 'id_detail_kriteria' => 1, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Statuta Politeknik Negeri Malang', 'hyperlink_data' => 'Statuta Polinema 2019.pdf - Google Drive', 'status_validasi' => 1],
            ['id_data_pendukung' => 2, 'id_detail_kriteria' => 2, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Link Sosialisasi VMTS via website', 'hyperlink_data' => 'Visi dan Misi – JTI Polinema', 'status_validasi' => 2],
            ['id_data_pendukung' => 3, 'id_detail_kriteria' => 3, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Laporan AMI', 'hyperlink_data' => 'Folder - Google Drive', 'status_validasi' => 3],
            ['id_data_pendukung' => 4, 'id_detail_kriteria' => 4, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Dokumen Notulensi RPM', 'hyperlink_data' => 'Kumpulan RTM - Google Drive', 'status_validasi' => 4],
            ['id_data_pendukung' => 5, 'id_detail_kriteria' => 5, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Dokumen Rencana Kerja', 'hyperlink_data' => 'Dokumen Perencanaan (2019-2022) - Google Drive', 'status_validasi' => 5],
            ['id_data_pendukung' => 6, 'id_detail_kriteria' => 6, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Sistem Penjaminan Mutu Internal (SPMI)', 'hyperlink_data' => 'SPMI_2021.pdf - Google Drive', 'status_validasi' => 6],
            ['id_data_pendukung' => 7, 'id_detail_kriteria' => 7, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'SK FGD', 'hyperlink_data' => 'Folder - Google Drive', 'status_validasi' => 7],
            ['id_data_pendukung' => 8, 'id_detail_kriteria' => 8, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Survey Kepuasan Dosen dan Tendik', 'hyperlink_data' => 'KJM', 'status_validasi' => 8],
            ['id_data_pendukung' => 9, 'id_detail_kriteria' => 9, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'PTPP SIB', 'hyperlink_data' => 'PTPP GENAP 2023 - D4 SISTEM INFORMASI BISNIS.pdf - Google Drive', 'status_validasi' => 9],
            ['id_data_pendukung' => 10, 'id_detail_kriteria' => 10, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Notulen RTM', 'hyperlink_data' => 'RTM - Google Drive', 'status_validasi' => 10],
            ['id_data_pendukung' => 11, 'id_detail_kriteria' => 11, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Renstra POLINEMA 2020', 'hyperlink_data' => 'Renstra-Polinema-2020-2024.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 12, 'id_detail_kriteria' => 12, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Dokumen PMB', 'hyperlink_data' => 'Tabel Pelaksanaan Pendaftaran Mahasiswa - Google Spreadsheet', 'status_validasi' => null],
            ['id_data_pendukung' => 13, 'id_detail_kriteria' => 13, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Hasil Kuisioner KJM', 'hyperlink_data' => 'KJM', 'status_validasi' => null],
            ['id_data_pendukung' => 14, 'id_detail_kriteria' => 14, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Rapat Evaluasi Jurusan', 'hyperlink_data' => 'Folder - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 15, 'id_detail_kriteria' => 15, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Kegiatan Peningkatan Prestasi Mahasiswa', 'hyperlink_data' => 'https://drive.google.com/drive/folders/1RCni1T7naffl17Vc98icviq4MIKZRt-J?usp=sharing', 'status_validasi' => null],
            ['id_data_pendukung' => 16, 'id_detail_kriteria' => 16, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Renstra Politeknik Negeri Malang Tahun 2020-2024', 'hyperlink_data' => 'Renstra-Polinema-2020-2024.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 17, 'id_detail_kriteria' => 17, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Ijazah DTPR', 'hyperlink_data' => 'https://drive.google.com/drive/folders/1KF3DidDWcH_cZpdXBb39C8l2GRCxBOqa?usp=drive_link', 'status_validasi' => null],
            ['id_data_pendukung' => 18, 'id_detail_kriteria' => 18, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Audit Mutu Internal', 'hyperlink_data' => 'LAPORAN KEGIATAN AUDIT MUTU INTERNAL 2021 FIX.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 19, 'id_detail_kriteria' => 19, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Rapat Evaluasi Jurusan', 'hyperlink_data' => 'Folder - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 20, 'id_detail_kriteria' => 20, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Persentase SDM yang Meningkat Karirnya dalam Jabatan Lektor Kepala', 'hyperlink_data' => '6. Pendamping untuk Jabatan Lektor Kepala - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 21, 'id_detail_kriteria' => 21, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Peraturan Menristekdikti No.50 Tahun 2018', 'hyperlink_data' => 'Permenristekdikti_no.50_Tahun_2018_tentang_Perubahan_atas_Permenristekdikti_no._44_Tahun_2015_tentang_Standar_Nasional_Pendidijan_Tinggi.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 22, 'id_detail_kriteria' => 22, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Juknis Perencanaan Anggaran Polinema', 'hyperlink_data' => 'Juknis_Perencanaan_2022.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 23, 'id_detail_kriteria' => 23, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Dokumentasi Rapat Evaluasi Jurusan', 'hyperlink_data' => 'Folder - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 24, 'id_detail_kriteria' => 24, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Notulensi RTM', 'hyperlink_data' => 'Notulen Rapat Tinjauan Manajemen 1 NOVEMBER 2022.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 25, 'id_detail_kriteria' => 25, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Dokumen Renja', 'hyperlink_data' => 'Dokumen Perencanaan (2019-2022) - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 26, 'id_detail_kriteria' => 26, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Permentistekdikti No. 44 Tahun 2015 tentang SN Dikti', 'hyperlink_data' => 'Permenristekdikti No. 44 tahun 2015 tentang SN Dikti.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 27, 'id_detail_kriteria' => 27, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Jadwal Perkuliahan', 'hyperlink_data' => 'Jadwal Dosen - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 28, 'id_detail_kriteria' => 28, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Daftar Pertanyaan Kuesioner Penilaian Mahasiswa Terhadap Dosen dan Proses Pembelajaran', 'hyperlink_data' => 'Daftar pertanyaan kuesioner kepuasan mahasiswa.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 29, 'id_detail_kriteria' => 29, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Rapat Evaluasi Jurusan', 'hyperlink_data' => 'Folder - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 30, 'id_detail_kriteria' => 30, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Program Hibah Buku Jar ber-ISBN', 'hyperlink_data' => 'Hibah Buku ISBN.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 31, 'id_detail_kriteria' => 31, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Surat Keputusan Direktur Politeknik Negeri Malang Nomor 108/SK/2007 tertanggal 31 Januari 2007', 'hyperlink_data' => 'SK_Direktur Polinema Nomor 108_SK_2007.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 32, 'id_detail_kriteria' => 32, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Renstra Penelitian Polinema', 'hyperlink_data' => 'Renstra Penelitian POLINEMA 2021-2025 - Bab 1 - 6.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 33, 'id_detail_kriteria' => 33, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Kuiisioner dari KJM', 'hyperlink_data' => 'KJM', 'status_validasi' => null],
            ['id_data_pendukung' => 34, 'id_detail_kriteria' => 34, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Notulen RTM tahun 2020', 'hyperlink_data' => 'Notulen Rapat Tinjauan Manajemen 26 November 2020.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 35, 'id_detail_kriteria' => 35, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Laporan Kegiatan Audit Mutu Internal', 'hyperlink_data' => 'LAPORAN KEGIATAN AUDIT MUTU INTERNAL 2021 FIX (1).pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 36, 'id_detail_kriteria' => 36, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Peraturan Menteri Pendidikan, Kebudayaan, Riset, Dan Teknologi Republik Indonesia Nomor 4 Tahun 2023', 'hyperlink_data' => 'Permendikbudristek Nomor 4 Tahun 2023.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 37, 'id_detail_kriteria' => 37, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Renstra PkM Polinema 2021 – 2025', 'hyperlink_data' => 'Dokumen Renstra PPM Bab 1 - 6.pdf.BOrDAE - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 38, 'id_detail_kriteria' => 38, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Surat Keputusan Direktur Politeknik Negeri Malang Nomor 108/SK/2007 tanggal 31 Januari 2007', 'hyperlink_data' => 'SK_Direktur Polinema Nomor 108_SK_2007.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 39, 'id_detail_kriteria' => 39, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'RTM 2023', 'hyperlink_data' => 'RTM GANJIL 2023 (DESEMBER)_new ttd.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 40, 'id_detail_kriteria' => 40, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Laporan Kegiatan Audit Mutu Internal', 'hyperlink_data' => 'LAPORAN KEGIATAN AUDIT MUTU INTERNAL 2021 FIX (1).pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 41, 'id_detail_kriteria' => 41, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Renstra Polinema (Revisi) tahun 2020-2024', 'hyperlink_data' => 'Renstra Polinema 2020-2024 Revisi 1 v.1.1a Rt23Apr24.pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 42, 'id_detail_kriteria' => 42, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Pemenuhan CPL', 'hyperlink_data' => 'https://docs.google.com/spreadsheets/d/1kd0hcUkQ3WoqXB4XxZZVcoHHnauTBiFX/edit?usp=sharing&ouid=116857019133618928861&rtpof=true&sd=true', 'status_validasi' => null],
            ['id_data_pendukung' => 43, 'id_detail_kriteria' => 43, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Laporan AMI 2020', 'hyperlink_data' => 'LAPORAN AUDIT MUTU INTERNAL (PRODI) 2020 (PTPP).pdf - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 44, 'id_detail_kriteria' => 44, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'Rapat Evaluasi Jurusan Teknologi Informasi', 'hyperlink_data' => 'Rapat Evaluasi Jurusan - Google Drive', 'status_validasi' => null],
            ['id_data_pendukung' => 45, 'id_detail_kriteria' => 45, 'deskripsi_data' => 'asal sebut aja', 'nama_data' => 'FGD Kurikulum', 'hyperlink_data' => 'FGD - Google Drive', 'status_validasi' => null],
        ];

        DB::table('t_data_pendukung')->insert($data);
    }
}