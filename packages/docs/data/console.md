# Console

<!-- MarkdownTOC autolink="true" autoanchor="true" levels="2,3,4" bracket="round" lowercase="only_ascii" -->

- [Pengetahuan Dasar](#pengetahuan-dasar)
- [Daftar Perintah](#daftar-perintah)
    - [Umum](#umum)
        - [key:generate](#keygenerate)
        - [serve](#serve)
    - [Make](#make)
        - [make:controller](#makecontroller)
        - [make:model](#makemodel)

<!-- /MarkdownTOC -->


<a id="pengetahuan-dasar"></a>
## Pengetahuan Dasar
Rakit Console menyediakan sejumlah perintah konsol yang berguna untuk anda
gunakan saat mengembangkan aplikasi anda.

Apa saja yang bisa dilakukan oleh rakit console?
Bagaimana cara menggunakannya? Mari kita lihat.


<a id="daftar-perintah"></a>
## Daftar Perintah

Untuk melihat daftar perintah yang tersedia, anda dapat hanya perlu memanggil rakit console
tanpa argumen apapun:

```bash
php rakit
```

<a id="umum"></a>
### Umum

<a id="keygenerate"></a>
#### key:generate

Perintah ini digunakan untuk pembuatan application key untuk kunci pengaman aplikasi anda:

```bash
php rakit key:generate
```


<a id="serve"></a>
#### serve

Perintah ini digunakan untuk menjalankan webserver lokal saat pengembangan rakit:

```bash
php rakit serve
```
Secara default, webserver akan dijalankan pada port `8000`, namun anda juga dapat mengubahnya jika diperlukan:

```bash
php rakit serve 9000
```


<a id="make"></a>
### Make

<a id="makecontroller"></a>
#### make:controller

Perintah ini digunakan untuk membuat file controller:

```bash
php rakit make:controller dashboard
```

Perintah diatas akan menciptakan sebuah file controller baru di folder `application/controllers/`.
Lalu, bagaimana jika saya ingin membuat controller untuk sebuah paket? Mudah saja:

```bash
php rakit make:controller nama_paket::dashboard
```


<a id="makemodel"></a>
#### make:model

Perintah ini digunakan untuk membuat file model:

```bash
php rakit make:model user
```

Perintah diatas akan menciptakan sebuah file model baru di folder `application/models/`.
Lalu, bagaimana jika saya ingin membuat model untuk sebuah paket? Mudah saja:

```bash
php rakit make:model nama_paket::user
```
