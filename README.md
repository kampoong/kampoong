# Kampoong

Kampoong (baca kampung) adalah sistem pengelolaan kegiatan dan keuangan kampung.
Kampoong dapat digunakan untuk kampung, RT, RW atau dukuh/dusun.

Kampoong dibuat berbasis aplikasi [Buku Masjid] yang dimodidikasi menjadi Kampoong.

Ide dari [Kampung Rekesan](https://laporan.kampungrekesan.id/) .

## Tujuan

- Meningkatkan transparansi laporan kegiatan dan keuangan kampung, RT, RW, dukuh/dusun.
- Memungkinkan akses online bagi warga kampung dan masyarakat umum untuk melihat laporan kas.
- Mempermudah bendahara kampung, RT, RW, dusun.dukuh dalam mencatat transaksi keuangan.
- Otomatisasi pembuatan laporan kas setiap kali ada transaksi.
- Mempermudah pengurus kampung, RT, RW, dukuh/dusun dalam mengelola kegiatan warga.

## Manfaat

- Meningkatkan kepercayaan warga terhadap pengelolaan dana kampung, RT, RW, dukuh/dusun.
- Mengurangi beban tugas bendahara dalam pembuatan laporan kas kampoong.
- Memungkinkan warga masyarakat untuk memantau jadwal kegiatan secara online.

## Sponsor / Mitra

Kami berterima kasih kepada sponsor yang mendukung pengembangan Kampoong.

Berikut adalah sponsor dari pengembangan Kampoong:
* [Binexa Technology](https://www.binexa.com)
* [Kampung Rekesan](https://www.kampungrekesan.id/)

Jika anda tertarik untuk menjadi sponsor/mitra Kampoong, silakan hubungi Whatsapp Tim Kampoong pada halaman [Kontak Tim Kampoong](https://kampoong.binexa.com/contact).

Kami mengucapkan terima kasih kepada tim pengembang [Buku Masjid](https://www.bukumasjid.com).

Berikut adalah sponsor dari pengembangan Buku Masjid:

* [Pondok Teknologi](https://pondokteknologi.com)
* [Pondok IT](https://pondokit.com)
* [Mushaira](https://mushaira.id)
* [Pyramidsoft Indonesia Group](https://ptpsig.com)
* [LKSA Al Ma'un Center](https://lynk.id/almauncenter)
* [STIMI Banjarmasin](https://stimi-bjm.ac.id)
* [Jetorbit](https://www.jetorbit.com)

Jika anda tertarik untuk menjadi sponsor/mitra Buku Masjid, silakan hubungi Whatsapp Tim Buku Masjid pada halaman [Kontak Buku Masjid](https://www.bukumasjid.com/contact).

## Fitur

1. Pengelolaan buku catatan: Setiap kegiatan dapat dicatat di buku catatan kas yang terpisah.
2. Pengelolaan kategori/kelompok pemasukan dan pengeluaran untuk setiap buku catatan.
3. Input pemasukan dan pengeluaran.
4. Laporan:
   - Laporan kas Bulanan
   - Laporan kas per Kategori
   - Laporan kas Mingguan
5. Pengelolaan jadwal kegiatan kampung, RT, RW, dukuh/dusun.

## Cara Install

Aplikasi ini dapat diinstal pada server lokal maupun online dengan spesifikasi berikut:

### Kebutuhan Server

1. PHP 8.1 (dan sesuai dengan [persyaratan server Laravel 11.x](https://laravel.com/docs/11.x/deployment#server-requirements)).
2. Database MySQL atau MariaDB.
3. SQLite (digunakan untuk pengujian otomatis).

### Langkah Instalasi

1. Clone repositori ini dengan perintah: `git clone https://github.com/kampoong/kampoong.git`
2. Masuk ke direktori kampoong: `$ cd kampoong`
3. Instal dependensi menggunakan: `$ composer install`
4. Salin berkas `.env.example` ke `.env`: `$ cp .env.example .env`
5. Generate kunci aplikasi: `$ php artisan key:generate`
6. Buat database MySQL untuk aplikasi ini.
7. Konfigurasi database dan pengaturan lainnya di berkas `.env`.
    ```
    APP_URL=http://localhost
    APP_TIMEZONE="Asia/Makassar"

    DB_DATABASE=kampoong
    DB_USERNAME=kampoong
    DB_PASSWORD=secret

    KAMPOONG_NAME="Kampong Rekesan"
    KAMPOONG_DEFAULT_BOOK_ID=1
    AUTH_DEFAULT_PASSWORD=password

    MONEY_CURRENCY_CODE="Rp"
    MONEY_PRECISION=2
    MONEY_DECIMAL_SEPARATOR=","
    MONEY_THOUSANDS_SEPARATOR="."
    ```
8. Jalankan migrasi database: `$ php artisan migrate --seed`
9. Buat kunci passport: `$ php artisan passport:keys`
10. Buat tautan penyimpanan: `$ php artisan storage:link`
11. Mulai server: `$ php artisan serve`
12. Buka web browser dengan alamat web: http://localhost:8000, kemudian masuk dengan akun bawaan:
    ```
    email: admin@example.net
    password: password
    ```

### Langkah Install dengan Docker

Untuk menggunakan docker silahkan jalankan perintah ini di terminal:

1. Buat file .env
    ```bash
    $ cp .env.example .env
    ```
2. Update untuk mengubah env `DB_HOST`:
    ```bash
    DB_HOST=mysql_host
    ```
    Atau Anda dapat mengotomatiskan proses ini menggunakan perintah ini.
    ```bash
    COPY .env.example .env.tmp
    sed 's/DB_HOST=127.0.0.1/DB_HOST=mysql_host/' .env.tmp > .env && rm .env.tmp
    ```
3. Build docker images dan jalankan container:
    ```bash
    docker-compose build
    docker-compose up -d
    ```
4. Jalankan database migration:
    ```bash
    docker-compose exec server php artisan migrate --seed
    ```
5. Buka web browser dengan alamat web: http://localhost:8000, kemudian login dengan default user:
    ```
    email: admin@example.net
    password: password
    ```
6. Untuk masuk ke docker container shell:
    ```bash
    docker-compose exec server sh
    docker-compose exec mysql bash
    ```

### Data Demo

Ketika sudah ter-install di localhost, kita bisa generate data dummy untuk simulasi sistem Kampoong. Datad demo dapat di-generate dengan perintah berikut:

Generate demo data (3 bulan terakhir):

```bash
$ php artisan kampoong:generate-demo-data
```

Hapus semua demo data (yang `created_at` nya `NULL`)

```bash
$ php artisan kampoong:remove-demo-data
```

Lengkapnya dapat dilihat pada: [Dokumentasi kampoong/demo-data](https://github.com/kampoong/demo-data#cara-pakai).

## Screenshot

#### Laporan Bulanan

![Laporan Bulanan](public/screenshots/01-monthly-report-for-public.jpg)

#### Laporan Per Kategori

![Laporan Per](public/screenshots/02-categorized-report-for-public.jpg)

#### Laporan Per Pekan

![Laporan Per](public/screenshots/03-weekly-report-for-public.jpg)

#### Jadwal Pengajian

![Jadwal Pengajian](public/screenshots/04-lecturing-schedule-for-this-week.jpg)

## Kontribusi

Jika Anda ingin berkontribusi pada proyek ini, kami sangat menghargainya. Berikut beberapa yang dapat Anda lakukan:

1. Laporkan [issue](https://github.com/kampoong/kampoong/issues) jika Anda menemui kesalahan atau bug.
2. Sampaikan [diskusi](https://github.com/kampoong/kampoong/discussions) jika Anda ingin mengusulkan fitur baru atau perubahan pada fitur yang sudah ada.
3. Ajukan [pull request](https://github.com/kampoong/kampoong/pulls) untuk perbaikan bug, penambahan fitur baru, atau perbaikan label.

## Kontak

Untuk Diskusi:

* [Forum Diskusi](https://github.com/kampoong/kampoong/discussions)

Untuk pengumuman dan update:

* [Follow Twitter](https://twitter.com/kampoong)
* [Like Facebook Page](https://facebook.com/kampoong)
* [Telegram Channel](https://t.me/kampoong)

## Lisensi

Proyek Kampoong merupakan perangkat lunak open-source yang dilisensikan di bawah [Lisensi MIT](LICENSE).
