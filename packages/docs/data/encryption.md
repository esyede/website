# Enkripsi

<!-- MarkdownTOC autolink="true" autoanchor="true" levels="2,3" bracket="round" lowercase="only_ascii" -->

- [Pengetahuan Dasar](#pengetahuan-dasar)
- [Enkripsi String](#enkripsi-string)
- [Dekripsi String](#dekripsi-string)

<!-- /MarkdownTOC -->


<a id="pengetahuan-dasar"></a>
## Pengetahuan Dasar

Komponen `Crypter` menyediakan cara sederhana untuk menangani enkripsi dua arah yang aman.
Secara default, kelas ini menyediakan enkripsi dan dekripsi berbasis AES-256 yang kuat melalui
ekstensi [PHP OpenSSL](https://www.php.net/manual/en/book.openssl.php).

>  Jangan lupa untuk menginstall ekstensi [PHP OpenSSL](https://www.php.net/manual/en/book.openssl.php)
   di server anda jika belum ada, dan pastikan application key sudah diisi.


<a id="enkripsi-string"></a>
## Enkripsi String


#### Mengenkripsi sebuah string:

Untuk mengenkripsi data, gunakan method `encrypt()` seperti berikut:

```php
$data = 'rahasia';

$encrypted = Crypter::encrypt($data);
// 'sGcqP0xG5qHyAJvnNa11pBOGk3c3iBUyDnFoyl81vKKPGNd4iMKVD/0NycbYBUMbwesSYi5xcKLFWD3nP6UYJA=='
```

<a id="dekripsi-string"></a>
## Dekripsi String


#### Mendekripsi sebuah string:

Untuk mendenkripsi data, gunakan method `decrypt()` seperti berikut:

```php
$decrypted = Crypter::decrypt($encrypted); // 'rahasia'
```

>  Sangat penting untuk dicatat bahwa method ini hanya akan mendekripsi string yang dienkripsi menggunakan `application key` yang sama.
