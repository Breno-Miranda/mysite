
<div class="">
		<img src="<?= $Blogs_static_site_view[0]->imagem ?>" style="width: 100%; height: 550px;">
	</div>
<div class="row"  style="width: 100%; margin-bottom: 2%">
</div>
<ul class="accordion" data-accordion>
  <li class="row accordion-navigation">
    <p style="padding: 1%;">
    	<i class="fa fa-sun-o" aria-hidden="true"></i> <?= date('d/m/Y'); ?> 
    	<i class="fa fa-clock-o fa-1x" aria-hidden="true"></i> postagens <?= $Blogs_static_site_view[0]->data ?>
    </p> 
	<h3 align="center"> <?= $Blogs_static_site_view[0]->slug ?></h3>
    <div id="panel1a" class=" row content active">
      <?= $Blogs_static_site_view[0]->texto ?>
    </div>
  </li>
</ul>


<div class="row">
  <div class="col-8">
  </div>
  <div class="col-4">col-4</div>
</div>
