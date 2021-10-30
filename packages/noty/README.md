# Noty

Paket untuk memasukkan notifikasi noty yang indah ke dalam rakit sebagai pesan flash.

*Diuji coba pada [noty](https://github.com/needim/noty) versi 3.2.0.*

## Requirements

 - PHP >= 5.4.0
 - Rakit 1.0.0
 - [noty](https://github.com/needim/noty)

## Installation

Via manajer paket

``` bash
$ php rakit package:install noty
```

Konfigurasi paket ini ada di `config/noty.php`.

## Persiapan

Sebelum menggunakan paket ini, pastikan anda menyertakan library [noty](https://github.com/needim/noty):

```html
<head>
    <link rel="stylesheet" href="/noty.css"/>
    <script type="text/javascript" src="/noty.js"></script>
</head>
```
dan kemudian tambahkan ini di file view/layout anda:

```php
@include('noty::noty')
```

## Penggunaan

Sintaks:
```php
Noty::success('Data berhasil disimpan');
Noty::warning('User telah meghapus akunnya');
Noty::info('Pesanan sudah sampai');
```

Di dalam controller, sekarang anda dapat melakukan:

```php
public function action_index()
{
    Noty::success('Data berhasil disimpan');

    return Redirect::back();
}
```

Anda juga dapat menambahkan opsi kustom ke parameter ke-tiga:

```php
Noty::success('Data berhasil disimpan', ['layout' => 'top', 'timeout' => 5000]);
```
Daftar opsi kustom yang dapat anda tambahkan dapat dibaca halaman dokumentasi noty.

## Lisensi

Paket ini dirilis dibawah [Lisensi MIT](https://github.com/esyede/noty/blob/main/LICENSE)
