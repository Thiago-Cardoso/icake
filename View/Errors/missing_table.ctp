<?php if ($this->Session->request->params['controller'] != 'ferramentas' && $this->Session->request->params['action']!='instalatb' ) : ?>
<?php $sessaoId = $this->Session->check('Usuario.id') ? $this->Session->read('Usuario.id') : null; if (!$sessaoId) : ?>
<script>document.location.href = '<?= Router::url('/',true); ?>ferramentas/instalatb';</script>
<?php endif ?>
<?php endif ?>

<h2><?php echo __d('cake_dev', 'Missing Database Table'); ?></h2>
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'Database table %1$s for model %2$s was not found.', '<em>' . $table . '</em>',  '<em>' . $class . '</em>'); ?>
</p>
<p class="notice">
	<strong><?php echo __d('cake_dev', 'Notice'); ?>: </strong>
	<?php echo __d('cake_dev', 'If you want to customize this error message, create %s', APP_DIR . DS . 'View' . DS . 'Errors' . DS . 'missing_table.ctp'); ?>
</p>

<?php echo $this->element('exception_stack_trace'); ?>
