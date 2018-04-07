<div class="row">
    <div class="col-md-4">
            <?= form_open_multipart($c_action , array('clss' => 'form-inline ')) ?>
            <?php echo form_error(); ?>
                <div class="form-group">
                <?= form_label('Login'); ?>
                <?= form_input(array(
                        'name' => 'usuario',
                        'class' => 'form-control ',
                        'id' => 'data'
                )); ?>
                </div>
                <div class="form-group">
                <?= form_label('Senha'); ?>
                <?= form_password(array(
                        'name' => 'senha',
                        'class' => 'form-control ',
                        'id' => 'data'
                )); ?>
                </div>
            <p><a href="<?=BaseController('login' , 'esqueci_minha_senha' , null , 'site')?>">Esqueci a Senha</a></p>
            <?= form_submit(array('value' => 'Entrar', 'class' => 'btn btn-lg btn-success')) ?>
            <?= form_close() ?>
    </div> 
    <div class="col-md-6">
       <img src="http://www.atperson.com/images/stories/virtuemart/product/app.jpg" alt="">
    </div>
</div>