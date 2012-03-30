<?php

// página inicial do plugin
Router::connect('/con', array('plugin'=>'con','controller' => 'contatos', 'action'=>'listar'));

// páginas de ajuda do plugin
Router::connect('/con/ajuda/*', array('plugin'=>'con', 'controller' => 'ajuda', 'action' => 'pag'));
