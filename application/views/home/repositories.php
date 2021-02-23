<?php section_start('howto');?>
    <div id="modal-dialog-howto" class="modal is-clipped">
        <div class="modal-background"></div>
        <div class="modal-content">
            <section class="modal-card-body">
                <p>Contoh instalasi paket bernama <i class="has-text-success">themable</i>:</p>
                <p><pre><code>php rakit package:install themable</code></pre></p>
                <br>
                <p>Instalasi manual:</p>
                <p class="notification has-text-left is-unselectable">
                    <small>
                    1. Unduh paket <span class="has-text-danger">themable</span> tersebut<br>
                    2. Ekstrak ke folder <span class="has-text-danger">packages/</span><br>
                    3. Jika paket tersebut memiliki aset, salin asetnya ke <span class="has-text-danger">assets/packages/themable/</span><br>
                    </small>
                </p>
                <br>
                <button class="button is-info" id="modal-close-howto">Oke, Mengerti</button>
            </section>
        </div>
    </div>
<?php section_stop();?>

<?php section_start('add-package');?>
    <div id="modal-dialog-add-package" class="modal is-clipped">
        <div class="modal-background"></div>
        <div class="modal-content">
            <section class="modal-card-body">
                <p>Cara berbagi paket:</p>
                <p class="notification has-text-left is-unselectable">
                    <small>
                    1. Login ke github dan edit file <a href="https://github.com/esyede/rakit/edit/master/repositories.json" target="_blank">repositories.json</a> untuk menambahkan data paket anda.<br>
                    2. Kirim pull request berupa perubahan yang anda buat tersebut.<br>
                    3. Buat thread baru di subforum <a href="<?php echo url('forum').'/forum9-paket-library.html';?>" target="_blank">Paket & library</a> sesuai nama paket anda dan jelaskan detailnya.<br>
                    </small>
                </p>
                <p>Jika rilis versi baru:</p>
                <p class="notification has-text-left is-unselectable">
                    <small>
                    1. Ulangi langkah "Cara berbagi paket" diatas.<br>
                    2. Edit postingan pertama di thread anda dan tambahkan detail versi baru anda.<br>
                    </small>
                </p>
                <br>
                <button class="button is-success" id="modal-close-add-package">Oke, Mengerti</button>
            </section>
        </div>
    </div>
<?php section_stop();?>

<?php section_start('pages_title');?>
    <br>
    <h1 class="title">Repositori Paket</h1>
    <p class="subtitle">Download dan bagikan paket anda bersama pengembang lain</p>
    <div class="buttons is-block">
        <button id="show-modal-howto" class="button is-info">Cara Install?</button>
        <button id="show-modal-add-package" class="button is-success">Bagikan Paket</button>
    </div>
    <?php echo yield_content('howto');?>
    <?php echo yield_content('add-package');?>
    <br>
<?php section_stop();?>


<?php section_start('listings');?>
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-3-desktop is-3-tablet">
                    <aside class="menu">
                        <p class="menu-label">Kategori</p>
                        <ul class="menu-list">
                            <?php foreach ($categories as $category): ?>
                            <li>
                                <a href="<?php echo url('repositories/'.Str::slug(e($category['name'])));?>"><?php echo Str::title(e($category['name']));?> <span class="tag is-info is-light is-rounded"> <?php echo e($category['count']);?> </span></a>
                            </li>
                            <?php endforeach; ?>
                            <li>
                                <a href="<?php echo url('repositories');?>">Semua <span class="tag is-info is-light is-rounded"> <?php echo e($totalcount);?> </span></a>
                            </li>
                        </ul>
                    </aside>
                </div>
                <div class="column is-9-desktop is-9-tablet">
                    <div class="container">
                        <p class="menu-label is-size-6"><?php echo e($catname); ?></p>
                        <br>
                        <?php for ($i = 0; $i < count($packages); $i++):?>
                            <div class="box">
                              <article class="media">
                                <div class="media-left">
                                  <figure class="image is-64x64">
                                    <img src="<?php echo asset('main/images/package.png');?>" alt="Image">
                                  </figure>
                                </div>
                                <div class="media-content">
                                  <div class="content">
                                    <div class="is-pulled-right is-hidden-mobile">
                                        <?php if ($packages[$i]['maintained']): ?>
                                            <span class="button is-success is-rounded is-small" title="Paket ini masih dimaintain oleh pembuatnya">maintained</span>
                                        <?php else: ?>
                                            <span class="button is-warning is-rounded is-small" title="Paket ini sudah tidak dimaintain oleh pembuatnya">unmaintained</span>
                                        <?php endif; ?>
                                    </div>
                                    <p>
                                        <a class="is-size-4" title="Kunjungi repositori milik paket ini" href="<?php echo $packages[$i]['repository'];?>"  target="_blank"><?php echo e($packages[$i]['name']);?></a>
                                    <br>
                                        <?php echo nl2br(e($packages[$i]['description']));?>
                                    </p>
                                    <br>
                                    <div class="is-pulled-left">
                                        <a class="tag is-small is-primary" href="<?php echo URL::to('repositories/'.Str::slug(e($packages[$i]['category'])));?>" title="Kategori: <?php echo e($packages[$i]['category']);?>"><?php echo Str::title(e($packages[$i]['category']));?></a>
                                    </div>
                                    <span class="is-pulled-right is-size-7">
                                        Kompatibel: <?php echo e(implode(', ', array_keys($packages[$i]['compatibilities']))); ?>
                                    </span>
                                  </div>
                                </div>
                              </article>
                            </div>
                        <?php endfor;?>

                        <nav class="pagination is-rounded" role="navigation">
                            <?php if ($currpage > 1):?>
                                <a class="pagination-previous" href="?page=<?php echo($currpage - 1);?>">&laquo; Sebelumnya</a>
                            <?php else:?>
                                <a class="pagination-previous" href="#" disabled>&laquo; Sebelumnya</a>
                            <?php endif;?>

                            <?php if ($currpage < $totalpage):?>
                                <a class="pagination-next" href="?page=<?php echo($currpage + 1);?>">Selanjutnya &raquo;</a>
                            <?php else:?>
                                <a class="pagination-next" href="#" disabled>Selanjutnya &raquo;</a>
                            <?php endif;?>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php section_stop();?>

<?php section_start('main');?>
    <?php echo yield_content('listings');?>
<?php section_stop();?>

<?php echo view('layouts.main')->with(get_defined_vars())->render();?>
