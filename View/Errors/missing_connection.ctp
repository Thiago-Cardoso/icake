<?php if ($this->Session->request->params['controller'] != 'ferramentas' && $this->Session->request->params['action']!='instalabd' ) : ?>
<script>document.location.href = '<?= Router::url('/',true); ?>ferramentas/instalabd';</script>
<?php endif ?>
