<?php

namespace Database\Seeders;

use App\Models\Berkas;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Seeder: PendaftaranSeeder
 *
 * Populates sample applicants (peserta), internship applications (pendaftaran),
 * and dummy verification documents (berkas) across all workflow statuses:
 * - diajukan (Pending review)
 * - diverifikasi (Verified documents)
 * - diterima (Accepted)
 * - ditolak (Rejected)
 *
 * Run: php artisan db:seed --class=PendaftaranSeeder
 */
class PendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Minimal valid 1-page PDF string to allow real file downloading without 404
        $dummyPdfContent = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n3 0 obj<</Type/Page/MediaBox[0 0 612 792]/Parent 2 0 R/Resources<<>>>>endobj\nxref\n0 4\n0000000000 65535 f\n0000000010 00000 n\n0000000053 00000 n\n0000000102 00000 n\ntrailer<</Size 4/Root 1 0 R>>\nstartxref\n178\n%%EOF\n";

        $applicants = [
            // ──────────────────────────────────────────────
            // 1. Status: DIAJUKAN (Baru mendaftar)
            // ──────────────────────────────────────────────
            [
                'name'            => 'Mochammad Rizky Pratama',
                'email'           => 'rizky.pratama@mhs.unsoed.ac.id',
                'phone'           => '081234567801',
                'universitas'     => 'Universitas Jenderal Soedirman',
                'jurusan'         => 'S1 Teknik Elektro',
                'alamat'          => 'Jl. Prof. Dr. HR Boenyamin No. 708, Grendeng, Purwokerto',
                'status'          => Pendaftaran::STATUS_DIAJUKAN,
                'tanggal_daftar'  => Carbon::now()->subDays(4)->toDateString(),
                'tanggal_mulai'   => Carbon::now()->addWeeks(3)->startOfWeek()->toDateString(),
                'tanggal_selesai' => Carbon::now()->addWeeks(15)->endOfWeek()->toDateString(),
                'catatan_admin'   => null,
                'berkas'          => [
                    Berkas::JENIS_CV              => 'CV_Mochammad_Rizky_Pratama.pdf',
                    Berkas::JENIS_TRANSKRIP       => 'Transkrip_Mochammad_Rizky_Pratama.pdf',
                    Berkas::JENIS_SURAT_PENGANTAR => 'Surat_Pengantar_Unsoed_Rizky.pdf',
                    Berkas::JENIS_KTM             => 'KTM_Rizky_Pratama.pdf',
                ],
            ],
            [
                'name'            => 'Anisa Nur Aini',
                'email'           => 'anisa.nuraini@mhs.telkomuniversity.ac.id',
                'phone'           => '082134567802',
                'universitas'     => 'Institut Teknologi Telkom Purwokerto',
                'jurusan'         => 'S1 Teknik Informatika',
                'alamat'          => 'Jl. DI Panjaitan No. 128, Karangklesem, Purwokerto Selatan',
                'status'          => Pendaftaran::STATUS_DIAJUKAN,
                'tanggal_daftar'  => Carbon::now()->subDays(2)->toDateString(),
                'tanggal_mulai'   => Carbon::now()->addWeeks(4)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addWeeks(12)->toDateString(),
                'catatan_admin'   => null,
                'berkas'          => [
                    Berkas::JENIS_CV              => 'CV_Anisa_Nur_Aini.pdf',
                    Berkas::JENIS_TRANSKRIP       => 'Transkrip_Anisa_Nur_Aini.pdf',
                    Berkas::JENIS_SURAT_PENGANTAR => 'Surat_Pengantar_ITTP_Anisa.pdf',
                ],
            ],
            [
                'name'            => 'Tiara Putri Anggraini',
                'email'           => 'tiara.putri@mhs.unsoed.ac.id',
                'phone'           => '081298765403',
                'universitas'     => 'Universitas Jenderal Soedirman',
                'jurusan'         => 'S1 Teknik Sipil',
                'alamat'          => 'Jl. Dr. Angka No. 15, Sokanegara, Purwokerto Timur',
                'status'          => Pendaftaran::STATUS_DIAJUKAN,
                'tanggal_daftar'  => Carbon::now()->subDay()->toDateString(),
                'tanggal_mulai'   => Carbon::now()->addWeeks(6)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addWeeks(14)->toDateString(),
                'catatan_admin'   => null,
                'berkas'          => [
                    Berkas::JENIS_CV              => 'CV_Tiara_Putri.pdf',
                    Berkas::JENIS_TRANSKRIP       => 'Transkrip_Nilai_Tiara.pdf',
                    Berkas::JENIS_SURAT_PENGANTAR => 'Surat_Pengantar_Kampus_Tiara.pdf',
                    Berkas::JENIS_PROPOSAL        => 'Proposal_Magang_PLN_Tiara.pdf',
                ],
            ],
            [
                'name'            => 'Nabila Rahmadani',
                'email'           => 'nabila.rahmadani@mhs.udinus.ac.id',
                'phone'           => '081234567812',
                'universitas'     => 'Universitas Dian Nuswantoro',
                'jurusan'         => 'S1 Rekayasa Perangkat Lunak',
                'alamat'          => 'Jl. Imam Bonjol No. 207, Pendrikan Kidul, Semarang',
                'status'          => Pendaftaran::STATUS_DIAJUKAN,
                'tanggal_daftar'  => Carbon::now()->toDateString(),
                'tanggal_mulai'   => Carbon::now()->addWeeks(5)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addWeeks(17)->toDateString(),
                'catatan_admin'   => null,
                'berkas'          => [
                    Berkas::JENIS_CV              => 'CV_Nabila_Rahmadani.pdf',
                    Berkas::JENIS_TRANSKRIP       => 'Transkrip_Nabila.pdf',
                    Berkas::JENIS_SURAT_PENGANTAR => 'Surat_Pengantar_Udinus.pdf',
                ],
            ],

            // ──────────────────────────────────────────────
            // 2. Status: DIVERIFIKASI (Berkas Lolos Verifikasi)
            // ──────────────────────────────────────────────
            [
                'name'            => 'Bagas Wahyu Hidayat',
                'email'           => 'bagas.hidayat@students.undip.ac.id',
                'phone'           => '081345678904',
                'universitas'     => 'Universitas Diponegoro',
                'jurusan'         => 'S1 Teknik Elektro (Tenaga Listrik)',
                'alamat'          => 'Jl. Prof. Soedarto No. 13, Tembalang, Semarang',
                'status'          => Pendaftaran::STATUS_DIVERIFIKASI,
                'tanggal_daftar'  => Carbon::now()->subDays(10)->toDateString(),
                'tanggal_mulai'   => Carbon::now()->addWeeks(3)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addWeeks(11)->toDateString(),
                'catatan_admin'   => 'Berkas administrasi lengkap dan valid. Menunggu konfirmasi ketersediaan mentor teknisi distribusi.',
                'berkas'          => [
                    Berkas::JENIS_CV              => 'CV_Bagas_Wahyu_Hidayat.pdf',
                    Berkas::JENIS_TRANSKRIP       => 'Transkrip_Akademik_Bagas.pdf',
                    Berkas::JENIS_SURAT_PENGANTAR => 'Surat_Pengantar_Undip_Bagas.pdf',
                    Berkas::JENIS_KTM             => 'KTM_Undip_Bagas.pdf',
                ],
            ],
            [
                'name'            => 'Dinda Ayu Larasati',
                'email'           => 'dinda.larasati@mail.ugm.ac.id',
                'phone'           => '085245678905',
                'universitas'     => 'Universitas Gadjah Mada',
                'jurusan'         => 'S1 Sistem Informasi',
                'alamat'          => 'Jl. Kaliurang KM 5, Caturtunggal, Sleman, D.I. Yogyakarta',
                'status'          => Pendaftaran::STATUS_DIVERIFIKASI,
                'tanggal_daftar'  => Carbon::now()->subDays(8)->toDateString(),
                'tanggal_mulai'   => Carbon::now()->addWeeks(4)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addWeeks(16)->toDateString(),
                'catatan_admin'   => 'Dokumen persyaratan lengkap. Sesuai dengan formasi Sistem Informasi & Pelayanan Pelanggan.',
                'berkas'          => [
                    Berkas::JENIS_CV              => 'Curriculum_Vitae_Dinda_UGM.pdf',
                    Berkas::JENIS_TRANSKRIP       => 'Transkrip_Nilai_Dinda.pdf',
                    Berkas::JENIS_SURAT_PENGANTAR => 'Surat_Permohonan_KP_UGM.pdf',
                ],
            ],
            [
                'name'            => 'Dimas Aditya Prasetyo',
                'email'           => 'dimas.aditya@ugm.ac.id',
                'phone'           => '081398765406',
                'universitas'     => 'Universitas Gadjah Mada',
                'jurusan'         => 'S1 Teknik Elektro',
                'alamat'          => 'Jl. Raya Jatilawang No. 42, Jatilawang, Banyumas',
                'status'          => Pendaftaran::STATUS_DIVERIFIKASI,
                'tanggal_daftar'  => Carbon::now()->subDays(6)->toDateString(),
                'tanggal_mulai'   => Carbon::now()->addWeeks(3)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addWeeks(15)->toDateString(),
                'catatan_admin'   => 'Berkas lengkap dan sesuai kualifikasi bidang Teknik Tenaga Listrik PLN ULP Wangon.',
                'berkas'          => [
                    Berkas::JENIS_CV              => 'CV_Dimas_Aditya.pdf',
                    Berkas::JENIS_TRANSKRIP       => 'Transkrip_Dimas_UGM.pdf',
                    Berkas::JENIS_SURAT_PENGANTAR => 'Surat_Rekomendasi_Kampus_Dimas.pdf',
                ],
            ],

            // ──────────────────────────────────────────────
            // 3. Status: DITERIMA (Approved)
            // ──────────────────────────────────────────────
            [
                'name'            => 'Fajar Dwi Wicaksono',
                'email'           => 'fajar.wicaksono@polines.ac.id',
                'phone'           => '081945678907',
                'universitas'     => 'Politeknik Negeri Semarang',
                'jurusan'         => 'D4 Teknik Telekomunikasi',
                'alamat'          => 'Jl. Soekarno-Hatta No. 45, Banyumas',
                'status'          => Pendaftaran::STATUS_DITERIMA,
                'tanggal_daftar'  => Carbon::now()->subDays(25)->toDateString(),
                'tanggal_mulai'   => Carbon::now()->addDays(5)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addMonths(3)->toDateString(),
                'catatan_admin'   => 'Selamat! Anda diterima KP di Bagian Pemeliharaan & Operasi Distribusi PLN ULP Wangon. Harap hadir saat briefing hari pertama pukul 08:00 WIB mengenakan pakaian rapi dan jas almamater.',
                'berkas'          => [
                    Berkas::JENIS_CV              => 'CV_Fajar_Dwi_Wicaksono.pdf',
                    Berkas::JENIS_TRANSKRIP       => 'Transkrip_Polines_Fajar.pdf',
                    Berkas::JENIS_SURAT_PENGANTAR => 'Surat_Pengantar_Polines_Fajar.pdf',
                    Berkas::JENIS_KTM             => 'KTM_Fajar_Polines.pdf',
                ],
            ],
            [
                'name'            => 'Siti Mutiah Zahra',
                'email'           => 'siti.zahra@amikompurwokerto.ac.id',
                'phone'           => '087745678908',
                'universitas'     => 'Universitas Amikom Purwokerto',
                'jurusan'         => 'S1 Informatika',
                'alamat'          => 'Jl. Letjend Pol. Soemarto No. 127, Purwokerto Utara',
                'status'          => Pendaftaran::STATUS_DITERIMA,
                'tanggal_daftar'  => Carbon::now()->subDays(28)->toDateString(),
                'tanggal_mulai'   => Carbon::now()->addDays(7)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addMonths(2)->toDateString(),
                'catatan_admin'   => 'Selamat! Diterima magang di Unit Layanan Pelanggan & Teknologi Informasi. Harap membawa surat tugas asli dari kampus saat hari pertama.',
                'berkas'          => [
                    Berkas::JENIS_CV              => 'CV_Siti_Mutiah_Zahra.pdf',
                    Berkas::JENIS_TRANSKRIP       => 'Transkrip_Siti_Zahra.pdf',
                    Berkas::JENIS_SURAT_PENGANTAR => 'Surat_Pengantar_Amikom.pdf',
                ],
            ],
            [
                'name'            => 'Muhammad Ilham Pratama',
                'email'           => 'ilham.pratama@pnc.ac.id',
                'phone'           => '081345678909',
                'universitas'     => 'Politeknik Negeri Cilacap',
                'jurusan'         => 'D3 Teknik Elektronika',
                'alamat'          => 'Jl. Dr. Soetomo No. 1, Sidakaya, Cilacap',
                'status'          => Pendaftaran::STATUS_DITERIMA,
                'tanggal_daftar'  => Carbon::now()->subDays(30)->toDateString(),
                'tanggal_mulai'   => Carbon::now()->addDays(10)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addMonths(3)->toDateString(),
                'catatan_admin'   => 'Selamat! Anda diterima magang di PLN ULP Wangon bagian Transmisi & Pemeliharaan Jaringan. Silakan koordinasi dengan supervisor pembimbing.',
                'berkas'          => [
                    Berkas::JENIS_CV              => 'CV_Ilham_PNC.pdf',
                    Berkas::JENIS_TRANSKRIP       => 'Transkrip_Akademik_Ilham.pdf',
                    Berkas::JENIS_SURAT_PENGANTAR => 'Surat_Pengantar_PNC.pdf',
                ],
            ],

            // ──────────────────────────────────────────────
            // 4. Status: DITOLAK (Rejected)
            // ──────────────────────────────────────────────
            [
                'name'            => 'Gilang Ramadhan',
                'email'           => 'gilang.ramadhan@ump.ac.id',
                'phone'           => '085845678910',
                'universitas'     => 'Universitas Muhammadiyah Purwokerto',
                'jurusan'         => 'S1 Manajemen Bisnis',
                'alamat'          => 'Jl. Raya Dukuhwaluh, Kembaran, Banyumas',
                'status'          => Pendaftaran::STATUS_DITOLAK,
                'tanggal_daftar'  => Carbon::now()->subDays(20)->toDateString(),
                'tanggal_mulai'   => Carbon::now()->addWeeks(2)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addWeeks(10)->toDateString(),
                'catatan_admin'   => 'Mohon maaf, kuota peserta magang untuk divisi Administrasi & Keuangan pada periode yang diajukan sudah terpenuhi.',
                'berkas'          => [
                    Berkas::JENIS_CV              => 'CV_Gilang_Ramadhan.pdf',
                    Berkas::JENIS_TRANSKRIP       => 'Transkrip_UMP_Gilang.pdf',
                    Berkas::JENIS_SURAT_PENGANTAR => 'Surat_Pengantar_UMP_Gilang.pdf',
                ],
            ],
            [
                'name'            => 'Hendra Kurniawan',
                'email'           => 'hendra.kurniawan@unwiku.ac.id',
                'phone'           => '082245678911',
                'universitas'     => 'Universitas Wijayakusuma Purwokerto',
                'jurusan'         => 'S1 Teknik Elektro',
                'alamat'          => 'Jl. Raya Wangon - Ajibarang No. 88, Wangon, Banyumas',
                'status'          => Pendaftaran::STATUS_DITOLAK,
                'tanggal_daftar'  => Carbon::now()->subDays(18)->toDateString(),
                'tanggal_mulai'   => Carbon::now()->addWeeks(2)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addWeeks(10)->toDateString(),
                'catatan_admin'   => 'Surat permohonan/pengantar dari perguruan tinggi belum dibubuhi tanda tangan Dekan dan cap stempel basah resmi. Silakan mengajukan kembali dengan berkas lengkap.',
                'berkas'          => [
                    Berkas::JENIS_CV              => 'CV_Hendra_Kurniawan.pdf',
                    Berkas::JENIS_TRANSKRIP       => 'Transkrip_Hendra_Unwiku.pdf',
                    Berkas::JENIS_SURAT_PENGANTAR => 'Surat_Pengantar_Unwiku.pdf',
                ],
            ],
        ];

        foreach ($applicants as $item) {
            // 1. Create / update candidate user account
            $user = User::firstOrCreate(
                ['email' => $item['email']],
                [
                    'name'              => $item['name'],
                    'password'          => Hash::make('password123'),
                    'phone'             => $item['phone'],
                    'universitas'       => $item['universitas'],
                    'jurusan'           => $item['jurusan'],
                    'alamat'            => $item['alamat'],
                    'email_verified_at' => now(),
                ]
            );

            // Ensure candidate has 'peserta' role
            if (! $user->hasRole('peserta')) {
                $user->assignRole('peserta');
            }

            // 2. Create / update pendaftaran record
            $pendaftaran = Pendaftaran::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'tanggal_mulai'   => $item['tanggal_mulai'],
                    'tanggal_selesai' => $item['tanggal_selesai'],
                    'status'          => $item['status'],
                    'tanggal_daftar'  => $item['tanggal_daftar'],
                    'catatan_admin'   => $item['catatan_admin'],
                ]
            );

            // 3. Create dummy uploaded berkas files
            foreach ($item['berkas'] as $jenis => $namaAsli) {
                $uniqueFileName = Str::random(40) . '.pdf';
                $storagePath    = "berkas/{$pendaftaran->id}/{$uniqueFileName}";

                // Write dummy PDF file to private disk if not already existing
                $existingBerkas = Berkas::where('pendaftaran_id', $pendaftaran->id)
                    ->where('jenis_berkas', $jenis)
                    ->first();

                if ($existingBerkas) {
                    if (! Storage::disk('private')->exists($existingBerkas->file_path)) {
                        Storage::disk('private')->put($existingBerkas->file_path, $dummyPdfContent);
                    }
                } else {
                    Storage::disk('private')->put($storagePath, $dummyPdfContent);

                    Berkas::create([
                        'pendaftaran_id' => $pendaftaran->id,
                        'jenis_berkas'   => $jenis,
                        'nama_asli'      => $namaAsli,
                        'file_path'      => $storagePath,
                        'mime_type'      => 'application/pdf',
                        'file_size'      => strlen($dummyPdfContent),
                    ]);
                }
            }
        }

        $this->command->info('✅ Berhasil membuat data seeder pendaftar magang (12 peserta):');
        $this->command->info('   - Diajukan     : 4 pendaftar');
        $this->command->info('   - Diverifikasi : 3 pendaftar');
        $this->command->info('   - Diterima     : 3 pendaftar');
        $this->command->info('   - Ditolak      : 2 pendaftar');
        $this->command->info('   Password default untuk semua akun peserta: password123');
    }
}
