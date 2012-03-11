<?php
// Configurando o cache em File como cache padrão.
Cache::config('default', array('engine' => 'File'));

// Carregando o bootstrap de todos os plugins disponíveis
CakePlugin::loadAll(array(array('bootstrap' => true)));

