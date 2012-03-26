DROP TABLE IF EXISTS estados CASCADE;
CREATE TABLE estados
(
	id 				SERIAL 		NOT NULL,
	nome 			VARCHAR(60) NOT NULL,
	uf 				VARCHAR(2) 	NOT NULL,
	created 		TIMESTAMP 	NOT NULL DEFAULT current_timestamp,
	modified 		TIMESTAMP 	NOT NULL DEFAULT current_timestamp,
	PRIMARY KEY (id)
);
CREATE INDEX i_estados_nome ON estados(unaccent(lower(nome)));

DROP TABLE IF EXISTS cidades CASCADE;
CREATE TABLE cidades
(
	id 			SERIAL 		NOT NULL,
	nome 		VARCHAR(60) NOT NULL,
	estado_id 	INT 		NOT NULL DEFAULT 1 REFERENCES estados(id),
	created 	TIMESTAMP 	NOT NULL DEFAULT current_timestamp,
	modified 	TIMESTAMP 	NOT NULL DEFAULT current_timestamp,
	PRIMARY KEY (id) 
);
CREATE INDEX i_cidades_nome ON cidades(unaccent(lower(nome)));

DROP TABLE IF EXISTS usuarios CASCADE;
CREATE TABLE usuarios 
(
  id 			SERIAL 		NOT NULL ,
  login	 		VARCHAR(45) NOT NULL DEFAULT '',
  senha 		VARCHAR(45) NOT NULL DEFAULT '',
  created 		TIMESTAMP 	NOT NULL DEFAULT current_timestamp ,
  modified 		TIMESTAMP 	NOT NULL DEFAULT current_timestamp ,
  ativo 		BOOLEAN 	NOT NULL DEFAULT true ,
  nome 			VARCHAR(60) NOT NULL DEFAULT '',
  email 		VARCHAR(45) NOT NULL DEFAULT '',
  celular 		VARCHAR(13) NOT NULL DEFAULT '',
  ultimo_acesso TIMESTAMP 	NOT NULL DEFAULT current_timestamp ,
  acessos 		INT 		NOT NULL DEFAULT 0 ,
  trocar_senha	BOOLEAN 	NOT NULL DEFAULT false ,

  cidade_id 	INT 		NOT NULL DEFAULT 2302 REFERENCES cidades(id) ,
  estado_id 	INT 		NOT NULL DEFAULT 1 REFERENCES estados(id),

  PRIMARY KEY (id) ,
  CONSTRAINT i_usuarios_login UNIQUE(login)
);

CREATE INDEX i_usuarios_ativo 	ON usuarios(ativo);
CREATE INDEX i_usuarios_nome 	ON usuarios(nome);
CREATE INDEX i_usuarios_email 	ON usuarios(email);
CREATE INDEX i_usuarios_acessos ON usuarios(acessos);

DROP TABLE IF EXISTS perfis CASCADE;
CREATE TABLE perfis
(
	id 			SERIAL 		NOT NULL,
	nome 		VARCHAR(45) NOT NULL,
	restricao 	VARCHAR(45) NOT NULL,
	created 	TIMESTAMP 	NOT NULL DEFAULT current_timestamp,
	modified 	TIMESTAMP 	NOT NULL DEFAULT current_timestamp,
	PRIMARY KEY (id),
	CONSTRAINT i_perfis_nome UNIQUE(nome)
);
CREATE INDEX i_perfis_restricao ON perfis(restricao);

DROP TABLE IF EXISTS usuarios_perfis CASCADE;
CREATE TABLE usuarios_perfis
(
	usuario_id 	INT NOT NULL DEFAULT 0,
	perfil_id	INT NOT NULL DEFAULT 0,
	PRIMARY KEY (usuario_id, perfil_id)
);
CREATE INDEX i_usuarios_perfis_perfil  ON usuarios_perfis(perfil_id);
CREATE INDEX i_usuarios_perfis_usuario ON usuarios_perfis(usuario_id);
