SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `con_contatos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `con_contatos` ;

CREATE  TABLE IF NOT EXISTS `con_contatos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(80) NOT NULL ,
  `endereco` VARCHAR(60) NOT NULL ,
  `bairro` VARCHAR(60) NOT NULL ,
  `cep` VARCHAR(9) NOT NULL ,
  `cidade_id` INT NOT NULL DEFAULT 2302 ,
  `estado_id` INT NOT NULL DEFAULT 1 ,
  `tel1` VARCHAR(13) NOT NULL ,
  `tel2` VARCHAR(13) NOT NULL ,
  `tel3` VARCHAR(45) NOT NULL ,
  `cpf` VARCHAR(11) NOT NULL ,
  `email` VARCHAR(80) NOT NULL ,
  `twitter` VARCHAR(50) NOT NULL ,
  `facebook` VARCHAR(50) NOT NULL ,
  `gtalk` VARCHAR(50) NOT NULL ,
  `msn` VARCHAR(50) NOT NULL ,
  `aniversario` VARCHAR(4) NOT NULL ,
  `obs` TEXT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `i_nome` (`nome` ASC) ,
  INDEX `i_cidade_id` (`cidade_id` ASC) ,
  INDEX `i_estado_id` (`estado_id` ASC) ,
  INDEX `i_tel` (`tel1` ASC, `tel2` ASC, `tel3` ASC) ,
  INDEX `i_email` (`email` ASC) ,
  INDEX `i_im` (`twitter` ASC, `facebook` ASC, `gtalk` ASC, `msn` ASC) ,
  INDEX `i_aniversario` (`aniversario` ASC) ,
  INDEX `i_obs` (`obs`(1000) ASC) ,
  INDEX `i_cpf` (`cpf` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `con_emails`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `con_emails` ;

CREATE  TABLE IF NOT EXISTS `con_emails` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(99) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `i_email` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `con_grupos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `con_grupos` ;

CREATE  TABLE IF NOT EXISTS `con_grupos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `i_nome` (`nome` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `con_emails_con_grupos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `con_emails_con_grupos` ;

CREATE  TABLE IF NOT EXISTS `con_emails_con_grupos` (
  `con_email_id` INT NOT NULL ,
  `con_grupo_id` INT NOT NULL ,
  PRIMARY KEY (`con_email_id`, `con_grupo_id`) ,
  INDEX `fk_con_emails_has_con_grupos_con_grupos1` (`con_grupo_id` ASC) ,
  INDEX `fk_con_emails_has_con_grupos_con_emails` (`con_email_id` ASC) ,
  CONSTRAINT `fk_con_emails_has_con_grupos_con_emails`
    FOREIGN KEY (`con_email_id` )
    REFERENCES `con_emails` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_con_emails_has_con_grupos_con_grupos1`
    FOREIGN KEY (`con_grupo_id` )
    REFERENCES `con_grupos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
