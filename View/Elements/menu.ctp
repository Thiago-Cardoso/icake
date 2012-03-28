<?php ?>
<div id='menu'>
<!-- menu aqui -->
<?php $l = 10; ?>
<ul class="menuh">

	<li id="submenu-1" class="subv"><a  href="#"  class="menu_cadastro" >Cadastros</a>
		<ul class="menuv">
			<?php 
			if ($this->Session->check('menus.0.cadastro'))
			{
				$menu = $this->Session->read('menus.0.cadastro');
				foreach($menu as $_tit => $_link)
				{
					$l++;
					if ($_tit=='-') echo '<li><div class="hr"><hr></div></li>'."\n"; else echo '<li id="submenu-'.$l.'" class="submenu"><a href="'.$_link.'">'.$_tit.'</a></li>'."\n";
				}
			}
			$l++;
			?>
		</ul>
	</li>
	
	<?php if (!in_array('I',$this->Session->read('Usuario.Restricoes'))) : ?>
	<li id="submenu-2" class="subv"><a href="#" class="menu_relatorios">Relatórios</a>
		<ul class="menuv">
			<?php 
			$l = 20;
			if ($this->Session->check('menus.0.relatorios'))
			{
				$menu = $this->Session->read('menus.0.relatorios');
				foreach($menu as $_tit => $_link)
				{
					$l++;
					if ($_tit=='-') echo '<li><div class="hr"><hr></div></li>'."\n"; else echo '<li id="submenu-'.$l.'" class="submenu"><a href="'.$_link.'">'.$_tit.'</a></li>'."\n";
				}
			}
			$l++;
			?>
			<li id="submenu-<?= $l ?>" class="submenu"><a href="">Listas</a>
			<ul class="menuv">
				<li id="submenu-321" class="submenu"><a href="<?= Router::url('/',true).'usuarios' ?>/rel_lista">Usuários</a>
				<li id="submenu-322" class="submenu"><a href="<?= Router::url('/',true).'cidades' ?>/rel_lista">Cidades</a></li>
				<li id="submenu-323" class="submenu"><a href="<?= Router::url('/',true).'estados' ?>/rel_lista">Estados</a></li>
				<li id="submenu-324" class="submenu"><a href="<?= Router::url('/',true).'perfis' ?>/rel_lista">Perfis</a></li>
			</ul>
		</ul>
	</li>
	<?php endif ?>

	<!-- FERRAMENTAS -->
	<?php if (!in_array('F',$this->Session->read('Usuario.Restricoes'))) : ?>
	<li id="submenu-3" class="subv"><a href="#" class="menu_ferramenta">Ferramentas</a>
		<ul class="menuv">
			<?php 
			$l = 30;
			if ($this->Session->check('menus.0.ferramentas'))
			{
				$menu = $this->Session->read('menus.0.ferramentas');
				foreach($menu as $_tit => $_link)
				{
					$l++;
					if ($_tit=='-') echo '<li><div class="hr"><hr></div></li>'."\n"; else echo '<li id="submenu-'.$l.'" class="submenu"><a href="'.$_link.'">'.$_tit.'</a></li>'."\n";
				}
			}
			$l++;
			?>
		<?php if (in_array('ADMINISTRADOR',$this->Session->read('Usuario.Perfis'))) : ?>
		<li id="submenu-39" class="submenu"><a href="<?= Router::url('/',true).'ferramentas' ?>">Instalar Plugin</a></li>
		<?php endif ?>
		</ul>
	</li>
	<?php endif ?>

	<?php if (in_array('ADMINISTRADOR',$this->Session->read('Usuario.Perfis'))) : ?>
	<li id="submenu-6" class="subv"><a href="#" class="menu_sistema">Sistema</a>
		<ul class="menuv">
			<li id="submenu-61" class="submenu"><a href="<?= Router::url('/',true).'usuarios' ?>">Usuários</a></li>
			<li id="submenu-62" class="submenu"><a href="<?= Router::url('/',true).'cidades' ?>">Cidades</a></li>
			<li id="submenu-63" class="submenu"><a href="<?= Router::url('/',true).'estados' ?>">Estados</a></li>
			<li id="submenu-64" class="submenu"><a href="<?= Router::url('/',true).'perfis' ?>">Perfis</a></li>
		</ul>
	</li>
	<?php endif ?>

	<li id="submenu-8" class="subv"><a href="#" class="menu_ajuda">Ajuda</a>
		<ul class="menuv">
			<?php 
			$l = 80;
			if ($this->Session->check('menus.0.ajuda'))
			{
				$menu = $this->Session->read('menus.0.ajuda');
				foreach($menu as $_tit => $_link)
				{
					$l++;
					if ($_tit=='-') echo '<li><div class="hr"><hr></div></li>'."\n"; else echo '<li id="submenu-'.$l.'" class="submenu"><a href="'.$_link.'">'.$_tit.'</a></li>'."\n";
				}
			}
			$l++;
			?>
			<li id="submenu-<?= $l+1 ?>" class="submenu"><a href="<?= Router::url('/',true).'ajuda/restricoes' ?>">Restrições</a></li>
			<li id="submenu-<?= $l+2 ?>" class="submenu"><a href="<?= Router::url('/',true).'ajuda/perfis' ?>">Perfis</a></li>
			<li><div class='hr'><hr></div></li>
			<li id="submenu-<?= $l+3 ?>" class="submenu"><a href="<?= Router::url('/',true).'ajuda/online' ?>">Usuários on-line</a></li>
			<li><div class='hr'><hr></div></li>
			<li id="submenu-<?= $l+4 ?>" class="submenu"><a href="<?= Router::url('/',true).'ajuda/sobre' ?>">Sobre o <?= Configure::read('SISTEMA') ?></a></li>
		</ul>
	</li>

	<li id="submenu-9" class="subv"><a href="<?= Router::url('/',true).'usuarios/sair' ?>" class="menu_sair">Sair</a></li>

</ul>
<!-- fim menu -->
</div>
