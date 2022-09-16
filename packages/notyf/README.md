<p align="center"><img src="screenshot.png" alt="notyf"></p>

Paket flash message sederhana berbasis [notyf-js](https://github.com/ardalanamini/notyf) untuk rakit framework.

## Instalasi
Jalankan perintah ini via rakit console:

```sh
php rakit package:install notyf
```


## Mendaftarkan paket

Tambahkan kode berikut ke file `application/packages.php`:

```php
'notyf' => ['autoboot' => true],
```

Lalu tambahkan kode berikut ke file view anda untuk memuat asset notyf:

```php
<head>
  ...
  <?php echo Esyede\Notyf::styles() ?>
</head>
...
...

<?php echo Esyede\Notyf::scripts() ?>
</body>
```


## Cara pengunaan

Pada controller anda, silahkan import notyf dan langsung menggunakannya:

```php
use Esyede\Notyf;

class Balance_Controller extends Base_Controller
{
    public function action_index()
    {
        Notyf::success('Saldo berhasil ditambahkan');
        // Notyf::error('Saldo gagal ditambahkan');

        return Redirect::to('/user/balance');
    }
}
```

## Kustomisasi

Anda dapat memodifikasi beberapa aspek dari library ini:

```php
Notyf::($dismissible = false, $duration = 2000, $position = 'right_top', $ripple = true);
// Notyf::success('Saldo berhasil ditambahkan');
```

Dimana parameter konfigurasi dijelaskan pada tabel berikut:

| Parameter       | Tipe      | Default     | Keterangan                                    |
| --------------- | --------- | ----------- |---------------------------------------------- |
| `$dismissible`  | boolean   | `true`      | Notifikasi akan menutup dengan sendirinya     |
| `$duration`     | integer   | `2000`      | Durasi tampil notifikasi, dalam mili-detik    |
| `$position`     | string    | `right_top` | Posisi tampilan notifikasi di layar           |
| `$ripple`       | boolean   | `true`      | Tampilkan efek ombak ketika notifikasi muncul |


**Opsi tersedia untuk position:**

`right_top` `right_center` `right_bottom`
`left_top` `left_center` `left_bottom`
`center_top` `center_center` `center_bottom`


## Lisensi

Paket ini dirilis dibawah [Lisensi MIT](https://github.com/esyede/notyf/blob/main/LICENSE)
