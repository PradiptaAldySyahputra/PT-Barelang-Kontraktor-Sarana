<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Peran;
use App\Models\Pengguna;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

/**
 * Buat akun Admin (atau Direktur) pertama - TANPA password default di kode.
 *
 * ⚠️ KENAPA PERINTAH INI ADA (checklist hardening B1-5):
 *
 * Seeder lama menanam akun `admin@bks.test` / `password` langsung di repo
 * publik. Siapa pun yang bisa membaca repo tahu password default server.
 * Itu celah keamanan nyata untuk aplikasi yang menyimpan data keuangan.
 *
 * Di server produksi, JANGAN pakai seeder. Jalankan perintah ini sekali saat
 * instalasi:
 *
 *     php artisan app:buat-admin
 *     php artisan app:buat-admin --direktur   # untuk akun Direktur
 *
 * Password diminta lewat prompt (tidak tampil di layar) dan TIDAK PERNAH
 * disimpan di kode, riwayat shell, atau repo.
 */
class BuatAdmin extends Command
{
    protected $signature = 'app:buat-admin
                            {--direktur : Buat akun Direktur (default: Admin)}';

    protected $description = 'Buat akun Admin/Direktur pertama lewat prompt (tanpa password default)';

    public function handle(): int
    {
        $peran = $this->option('direktur') ? Peran::Direktur : Peran::Admin;

        $this->info("Membuat akun {$peran->label()} baru.");
        $this->newLine();

        $nama = (string) $this->ask('Nama lengkap');

        if (trim($nama) === '') {
            $this->error('Nama wajib diisi.');

            return self::FAILURE;
        }

        $email = (string) $this->ask('Email');

        // Validasi email DULU (sebelum minta password) supaya admin tidak
        // diminta mengetik password dua kali hanya untuk ditolak di akhir.
        $emailValidator = Validator::make(
            ['email' => $email],
            ['email' => ['required', 'email', 'max:200', 'unique:pengguna,email']],
            [
                'email.unique' => 'Email sudah dipakai akun lain.',
                'email.email' => 'Format email tidak valid.',
            ]
        );

        if ($emailValidator->fails()) {
            foreach ($emailValidator->errors()->all() as $pesan) {
                $this->error($pesan);
            }

            return self::FAILURE;
        }

        $password = (string) $this->secret('Password (min 8 karakter, huruf & angka)');

        $passwordValidator = Validator::make(
            ['password' => $password],
            ['password' => ['required', 'string', Password::default()]],
            ['password.required' => 'Password wajib diisi.']
        );

        if ($passwordValidator->fails()) {
            foreach ($passwordValidator->errors()->all() as $pesan) {
                $this->error($pesan);
            }

            return self::FAILURE;
        }

        $ulangi = (string) $this->secret('Ulangi password');

        // Konfirmasi password
        if ($password !== $ulangi) {
            $this->error('Konfirmasi password tidak cocok.');

            return self::FAILURE;
        }

        Pengguna::create([
            'nama' => trim($nama),
            'email' => trim($email),
            'password' => Hash::make($password),
            'peran' => $peran,
            'is_aktif' => true,
        ]);

        $this->newLine();
        $this->info("✓ Akun {$peran->label()} '{$email}' berhasil dibuat.");

        return self::SUCCESS;
    }
}
