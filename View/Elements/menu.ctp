<?php ?>
<div id='menu'>
<!-- menu aqui -->
<?php $l = 10; ?>
<ul class="menuh">

	<?php
		if ($this->Session->check('menus'))
		{
			$menu 	= $this->Session->read('menus');
			$itens	= array('cadastro'=>'Cadastro','relatorios'=>'Relatórios','ferramentas'=>'Ferramentas','ajuda'=>'Ajuda');
			$l		= 1;
			foreach($menu as $_nome => $_arrOpcoes)
			{
				$tit = isset($_arrOpcoes['tit']) ? $_arrOpcoes['tit'] : $_nome;
				echo "<li id='submen-$l' class='subv'><a href='#' class='menu_cadastro'>".$tit."</a>\n";
				echo "<ul class='menuv'>\n";
				$m = $l;
				foreach($itens as $_item => $_titItem)
				{
					if (isset($_arrOpcoes[$_item]))
					{
						echo "<li id='submenu-".($l*10+$m)."' class='submenu'>\n\t<a href='#' class='menu_$_item'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$_titItem</a>\n";
						echo "\t<ul class='menuv'>\n";
						$n = $l;
						foreach($_arrOpcoes[$_item] as $_subItem => $_subLink)
						{
							echo "\t\t<li id='submenu-".($l*100+$n)."' class='submenu'><a href='$_subLink'>$_subItem</a></li>\n";
							$n++;
						}
						echo "\t</ul>\n";
						echo "</li>\n\n";
					}
					$m++;
				}
				$l++;
				echo "</ul>\n\n";
				echo "</li>\n\n";
			}
		}
	?>
	<?php if (in_array('ADMINISTRADOR',$this->Session->read('Usuario.Perfis'))) : ?>
	<li id="submenu-6" class="subv"><a href="#" class="menu_sistema">Sistema</a>
		<ul class="menuv">
			<li id="submenu-61" class="submenu"><a href="<?= Router::url('/',true).'usuarios' ?>">Cadastro de Usuários</a></li>
			<li id="submenu-62" class="submenu"><a href="<?= Router::url('/',true).'cidades' ?>">Cadastro de Cidades</a></li>
			<li id="submenu-63" class="submenu"><a href="<?= Router::url('/',true).'estados' ?>">Cadastro de Estados</a></li>
			<li id="submenu-64" class="submenu"><a href="<?= Router::url('/',true).'perfis' ?>">Cadastro de Perfis</a></li>
			<li><div class='hr'><hr></div></li>
			<li id="submenu-65" class="submenu"><a href="<?= Router::url('/',true).'ferramentas/instalar_plugin' ?>">Instalar Plugin</a></li>
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
