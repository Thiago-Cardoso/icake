<h1 style="margin: 0px; padding: 0px;">Perfis</h1>
<div style="padding: 5px; width: 600px; margin: 0px auto; line-height: 30px;">
<pre>
O Cadastro de perfis pode ser acessado pela opção de menu 'Sistema/Perfis'.
Inicialmente são criado 4 perfis:
- ADMINISTRADOR
- GERENTE
- USUÁRIO
- VISITANTE

O Perfi administrador é o único obrigatório, o sistema não vai conseguir excluí-lo, bem como definir restrições a ele.
Nos demais perfis é possível definir restrições.
<?php if (in_array('ADMINISTRADOR',$this->Session->read('Usuario.Perfis'))) : ?>
Veja mais sobre restrições em 'Sistema/Perfis'.
<?php endif ?>


</pre>
</div>


