<?php echo $this->Html->css('ferramentas'); ?>
<div id="txtInstalaBanco">
	
<?php if ($data_source=='Database/Postgres') : ?>
<h2>PostgreSQL</h2>
<p class='sql_tit'>
Peça ao Administrador do Banco de dados para executar os comandos abaixo.<br />
Talvez o administrador tenha que rodar um comando de cada vez.
</p>
<pre class='txt_sql'>
create user <?= $login ?> with password '<?= $senha ?>';
create database <?= $banco; ?> owner <?= $login ?> encoding '<?= $encoding ?>';
grant all privileges on database <?= $banco; ?> to <?= $login; ?>;
</pre>
<pre></pre>
Certifique-se também, com o Administrador, de que a extensão <strong>unaccent</strong> foi instalada com o comando abaixo:<br />
<pre class='txt_sql'>CREATE EXTENSION unaccent</pre>
Depois com o banco selecionado ele deve executar:
<pre class='txt_sql'>
alter function unaccent(text) immutable
</pre>

<?php endif ?>

<?php if ($data_source=='Database/Mysql') : ?>
<h2>Mysql</h2>
<p class='sql_tit'>Peça ao Administrador do Banco de dados para executar os comandos abaixo.</p>
<pre class='txt_sql'>
create database <?php echo $banco; ?> CHARACTER SET <?= $encoding ?>;
grant all privileges on <?php echo $banco; ?>.* to <?php echo $login."@".$host." identified by \"".$senha."\" with grant option;\n"; ?>
flush privileges;
</pre>
<?php endif ?>
<p class='sql_obs3'>Feita a instalação e configuração do Banco de Dados, cliquei <a href="<?php echo $this->here; ?>">aqui</a> para atualizar.</p>
<p class='sql_obs2'>* Para alterar as configurações do banco de dados, edite o arquivo <strong><?= WWW_ROOT ?>config/database.php</strong></p>

</div>
