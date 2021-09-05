# Console

<!-- MarkdownTOC autolink="true" autoanchor="true" levels="2,3" bracket="round" lowercase="only_ascii" -->

- [Pengetahuan Dasar](#pengetahuan-dasar)
- [Perintah Bawaan](#perintah-bawaan)
    - [Umum](#umum)
    - [Make](#make)

<!-- /MarkdownTOC -->


<a id="pengetahuan-dasar"></a>
## Pengetahuan Dasar

Rakit datang dengan membawa CLI tool agar semakin memudahkan pekerjaan anda dalam membuat
controller, model, file migrasi dan lain-lain. Bahkan, anda dapat menambahkan perintah baru kedalamnya.

Untuk melihat daftar perintah yang tersedia, silahkan ketikkan perintah berikut di terminal:

```bash
php rakit
```

<a id="perintah-bawaan"></a>
## Perintah Bawaan

Berikut adalah daftar lengkap perintah bawaan rakit console yang dapat anda gunakan:

<a id="umum"></a>
### Umum

| Perintah         | Contoh                     | Keterangan                  |
| ---------------- | -------------------------- | --------------------------- |
| `key:generate`   | `php rakit key:generate`   | Ciptakan application key.   |
| `serve`          | `php rakit serve`          | Jalankan web server bawaan. |


<a id="make"></a>
### Make

| Perintah          | Contoh                           | Keterangan                               |
| ----------------  | -------------------------------- | ---------------------------------------- |
| `make:controller` | `php rakit make:controller user` | Buat file controller bernama `user.php`. |
