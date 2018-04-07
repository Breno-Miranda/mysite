<!doctype html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?= base_url('public/site/icon/favicon.ico') ?>">
    <title><?= $titulo ?></title>
    <link href="<?= base_url('public/site/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/site/css/product.css') ?>" rel="stylesheet">
  </head>

  <style>
    .cabecalo{
      background-color: #000;
      height: 160px;
      color: #fff;
    }
  </style>

  <div class="container-fluid cabecalo">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <p style="padding:2%" class="text-center">Olá, <strong><?= $c_usuario ?></strong></p>
          </div>
        </div>
      </div>

      <div class="container">
            <nav class="site-header sticky-top py-1">
              <div class="container d-flex flex-column flex-md-row justify-content-between">
                <a class="py-2 d-none d-md-inline-block" href="<?= base_url('dashboard') ?>">Dashboard</a>
                <a class="py-2 d-none d-md-inline-block" href="<?= base_url('dashboard/solicitacao') ?>">Solicitações</a>
                <a class="py-2 d-none d-md-inline-block" href="<?= base_url('dashboard/perfil') ?>">Meu Perfil</a>
                <a class="py-2 d-none d-md-inline-block" href="<?= base_url('dashboard/suporte') ?>">Supporte</a>
                <a class="py-2 d-none d-md-inline-block" href="<?= base_url('dashboard/sair') ?>">Sair</a>
              </div>
            </nav>
      </div>
  </div>

    <div class="container py-5">
        <?php if($this->session->flashdata('flashdata')): ?><div class="alert alert-<?= ($this->session->flashdata('flashdata')['class']) ?>" role="alert"><?= ($this->session->flashdata('flashdata')['msm']) ?></div><?php endif; ?>
        <?php $this->load->view($pagina) ?>
    </div>
    
    <footer class="container py-5">
      <div class="row">
        <div class="col-12 col-md">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-block mb-2"><circle cx="12" cy="12" r="10"></circle><line x1="14.31" y1="8" x2="20.05" y2="17.94"></line><line x1="9.69" y1="8" x2="21.17" y2="8"></line><line x1="7.38" y1="12" x2="13.12" y2="2.06"></line><line x1="9.69" y1="16" x2="3.95" y2="6.06"></line><line x1="14.31" y1="16" x2="2.83" y2="16"></line><line x1="16.62" y1="12" x2="10.88" y2="21.94"></line></svg>
          <small class="d-block mb-3 text-muted">&copy; 2017-2018</small>
        </div>
        <div class="col-6 col-md">
          <h5>Pagamento</h5>
          <ul class="list-unstyled text-small">
            <li><a class="text-muted" href="#">Pagar</a></li>
            <li><a class="text-muted" href="#">Historico de Pagamentos</a></li>
          </ul>
        </div>
        <div class="col-6 col-md">
          <h5>Termos</h5>
          <ul class="list-unstyled text-small">
            <li><a class="text-muted" href="#">Termos de Politica</a></li>
            <li><a class="text-muted" href="#">Termos de licenças</a></li>
            <li><a class="text-muted" href="#">Resoluções</a></li>
          </ul>
        </div>
        <div class="col-6 col-md">
          <h5>Sobre mim</h5>
          <ul class="list-unstyled text-small">
            <li><a class="text-muted" href="#">Blog</a></li>
            <li><a class="text-muted" href="#">Minha profissão</a></li>
            <li><a class="text-muted" href="#">Meus trabalhos</a></li>
          </ul>
        </div>
      </div>
    </footer>

    <script src="<?= base_url('public/site/js/jquery-3.2.1.slim.min.js') ?>" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="<?= base_url('public/site/js/jquery-slim.min.js') ?>"><\/script>')</script>
    <script src="<?= base_url('public/site/js/popper.min.js') ?>"></script>
    <script src="<?= base_url('public/site/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('public/site/js/holder.min.js') ?>"></script>
    <script>
      Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
      });
    </script>
  </body>
</html>
