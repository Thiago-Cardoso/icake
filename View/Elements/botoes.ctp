<?php if (isset($botoes)) : ksort($botoes) ?>
<div id='botoes'>
<?php foreach($botoes as $_item => $_arrProp) if (isset($_arrProp['value'])) echo $this->Form->button($_arrProp['value'],$_arrProp)."\n"; ?>

</div>
<?php endif ?>
