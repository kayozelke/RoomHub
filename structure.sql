-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema students_house_db_prod
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema students_house_db_prod
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `students_house_db_prod` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ;
USE `students_house_db_prod` ;

-- -----------------------------------------------------
-- Table `students_house_db_prod`.`building`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `students_house_db_prod`.`building` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `address` VARCHAR(1024) NULL DEFAULT NULL,
  `name` VARCHAR(255) NULL DEFAULT NULL,
  `description` VARCHAR(2048) NULL DEFAULT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `students_house_db_prod`.`room_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `students_house_db_prod`.`room_type` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `price_month` DECIMAL(10,2) NOT NULL,
  `max_residents` INT NULL DEFAULT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `students_house_db_prod`.`room`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `students_house_db_prod`.`room` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `building_id` INT NOT NULL,
  `number` VARCHAR(10) NOT NULL,
  `floor_eu` INT NULL DEFAULT NULL,
  `room_type_id` INT UNSIGNED NOT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `building_id`),
  INDEX `fk_room_building1_idx` (`building_id` ASC),
  INDEX `fk_room_room_type1_idx` (`room_type_id` ASC),
  CONSTRAINT `fk_room_building1`
    FOREIGN KEY (`building_id`)
    REFERENCES `students_house_db_prod`.`building` (`id`),
  CONSTRAINT `fk_room_room_type1`
    FOREIGN KEY (`room_type_id`)
    REFERENCES `students_house_db_prod`.`room_type` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 91
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `students_house_db_prod`.`slot`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `students_house_db_prod`.`slot` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL DEFAULT NULL,
  `room_id` INT NOT NULL,
  `room_building_id` INT NOT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `room_id`, `room_building_id`),
  INDEX `fk_slot_room1_idx` (`room_id` ASC, `room_building_id` ASC),
  CONSTRAINT `fk_slot_room1`
    FOREIGN KEY (`room_id` , `room_building_id`)
    REFERENCES `students_house_db_prod`.`room` (`id` , `building_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 182
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `students_house_db_prod`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `students_house_db_prod`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NULL DEFAULT NULL,
  `firstname` VARCHAR(255) NULL DEFAULT NULL,
  `lastname` VARCHAR(255) NULL DEFAULT NULL,
  `privileges_level` INT NOT NULL DEFAULT '0',
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 129
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `students_house_db_prod`.`reservation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `students_house_db_prod`.`reservation` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `slot_id` INT NOT NULL,
  `slot_room_id` INT NOT NULL,
  `slot_room_building_id` INT NOT NULL,
  `notes` VARCHAR(255) NULL DEFAULT NULL,
  `start_time` DATE NULL DEFAULT NULL,
  `end_time` DATE NULL DEFAULT NULL,
  `type` TINYINT NULL DEFAULT '1',
  `price` DECIMAL(10,2) NULL DEFAULT NULL,
  `payment_done` TINYINT NULL DEFAULT '0',
  `contract_number` INT NOT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `user_id`, `slot_id`, `slot_room_id`, `slot_room_building_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_reservation_user1_idx` (`user_id` ASC),
  INDEX `fk_reservation_slot1_idx` (`slot_id` ASC, `slot_room_id` ASC, `slot_room_building_id` ASC),
  CONSTRAINT `fk_reservation_slot1`
    FOREIGN KEY (`slot_id` , `slot_room_id` , `slot_room_building_id`)
    REFERENCES `students_house_db_prod`.`slot` (`id` , `room_id` , `room_building_id`),
  CONSTRAINT `fk_reservation_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `students_house_db_prod`.`user` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 82
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
