SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `estados`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estados` ;

CREATE  TABLE IF NOT EXISTS `estados` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NOT NULL COMMENT 'nome do estado por extenso' ,
  `uf` VARCHAR(2) NOT NULL COMMENT 'sigla do estado' ,
  `created` DATETIME NOT NULL ,
  `modified` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `i_nome` (`nome` ASC) ,
  UNIQUE INDEX `i_sigla` (`uf` ASC) ,
  INDEX `i_modified` (`modified` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `cidades`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cidades` ;

CREATE  TABLE IF NOT EXISTS `cidades` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NOT NULL COMMENT 'nome da cidade' ,
  `created` DATETIME NOT NULL ,
  `modified` DATETIME NOT NULL ,
  `estado_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `i_nome` (`nome` ASC) ,
  INDEX `i_modified` (`modified` ASC) ,
  INDEX `fk_cidades_estados1` (`estado_id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Tabela que contém todas as cidades do brasil';


-- -----------------------------------------------------
-- Table `perfis`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `perfis` ;

CREATE  TABLE IF NOT EXISTS `perfis` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NOT NULL ,
  `restricao` VARCHAR(45) NOT NULL ,
  `created` DATETIME NOT NULL ,
  `modified` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `i_nome` (`nome` ASC) ,
  INDEX `i_restricao` (`restricao` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'perfis de usuários';


-- -----------------------------------------------------
-- Table `usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `usuarios` ;

CREATE  TABLE IF NOT EXISTS `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `login` VARCHAR(45) NOT NULL ,
  `senha` VARCHAR(45) NOT NULL ,
  `created` DATETIME NOT NULL ,
  `modified` DATETIME NOT NULL ,
  `ativo` TINYINT(1) NOT NULL DEFAULT true ,
  `nome` VARCHAR(60) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `celular` VARCHAR(13) NOT NULL ,
  `ultimo_acesso` DATETIME NOT NULL ,
  `acessos` INT NOT NULL DEFAULT 0 ,
  `trocar_senha` TINYINT(1) NOT NULL DEFAULT false ,
  `cidade_id` INT NOT NULL DEFAULT 2302 ,
  `estado_id` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `i_login` (`login` ASC) ,
  INDEX `i_ativo` (`ativo` ASC) ,
  INDEX `i_nome` (`nome` ASC) ,
  INDEX `i_email` (`email` ASC) ,
  INDEX `i_ultimo_acesso` (`ultimo_acesso` ASC) ,
  INDEX `i_acessos` (`acessos` ASC) ,
  INDEX `fk_usuarios_cidades1` (`cidade_id` ASC) ,
  INDEX `fk_usuarios_estados1` (`estado_id` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `usuarios_perfis`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `usuarios_perfis` ;

CREATE  TABLE IF NOT EXISTS `usuarios_perfis` (
  `usuario_id` INT NOT NULL ,
  `perfil_id` INT NOT NULL ,
  PRIMARY KEY (`usuario_id`, `perfil_id`) ,
  INDEX `i_usuarios_perfis_perfil` (`perfil_id` ASC) ,
  INDEX `i_usuarios_perfis_usuario` (`usuario_id` ASC) )
ENGINE = MyISAM;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
