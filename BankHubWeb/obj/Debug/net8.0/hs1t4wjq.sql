CREATE TABLE IF NOT EXISTS `__EFMigrationsHistory` (
    `MigrationId` varchar(150) NOT NULL,
    `ProductVersion` varchar(32) NOT NULL,
    PRIMARY KEY (`MigrationId`)
);

START TRANSACTION;

CREATE TABLE `__efmigrationshistory` (
    `MigrationId` varchar(150) NOT NULL,
    `ProductVersion` varchar(32) NOT NULL,
    PRIMARY KEY (`MigrationId`)
);

CREATE TABLE `cache` (
    `key` varchar(255) NOT NULL,
    `value` mediumtext NOT NULL,
    `expiration` int NOT NULL,
    PRIMARY KEY (`key`)
);

CREATE TABLE `cache_locks` (
    `key` varchar(255) NOT NULL,
    `owner` varchar(255) NOT NULL,
    `expiration` int NOT NULL,
    PRIMARY KEY (`key`)
);

CREATE TABLE `failed_jobs` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `uuid` varchar(255) NOT NULL,
    `connection` text NOT NULL,
    `queue` text NOT NULL,
    `payload` longtext NOT NULL,
    `exception` longtext NOT NULL,
    `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

CREATE TABLE `job_batches` (
    `id` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL,
    `total_jobs` int NOT NULL,
    `pending_jobs` int NOT NULL,
    `failed_jobs` int NOT NULL,
    `failed_job_ids` longtext NOT NULL,
    `options` mediumtext NULL,
    `cancelled_at` int NULL,
    `created_at` int NOT NULL,
    `finished_at` int NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `jobs` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `queue` varchar(255) NOT NULL,
    `payload` longtext NOT NULL,
    `attempts` tinyint unsigned NOT NULL,
    `reserved_at` int unsigned NULL,
    `available_at` int unsigned NOT NULL,
    `created_at` int unsigned NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `migrations` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `migration` varchar(255) NOT NULL,
    `batch` int NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `password_reset_tokens` (
    `email` varchar(255) NOT NULL,
    `token` varchar(255) NOT NULL,
    `created_at` timestamp NULL,
    PRIMARY KEY (`email`)
);

CREATE TABLE `personas` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `nombre` varchar(255) NOT NULL,
    `apellido` varchar(255) NOT NULL,
    `fecha_nacimiento` date NOT NULL,
    `documento_identidad` varchar(255) NOT NULL,
    `direccion` varchar(255) NOT NULL,
    `telefono` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `created_at` timestamp NULL,
    `updated_at` timestamp NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `sessions` (
    `id` varchar(255) NOT NULL,
    `user_id` bigint unsigned NULL,
    `ip_address` varchar(45) NULL,
    `user_agent` text NULL,
    `payload` longtext NOT NULL,
    `last_activity` int NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `users` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `email_verified_at` timestamp NULL,
    `password` varchar(255) NOT NULL,
    `remember_token` varchar(100) NULL,
    `created_at` timestamp NULL,
    `updated_at` timestamp NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `cuentas_bancarias` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `persona_id` bigint unsigned NOT NULL,
    `tipo_cuenta` varchar(255) NOT NULL,
    `saldo` decimal(10,2) NOT NULL,
    `moneda` varchar(255) NOT NULL,
    `created_at` timestamp NULL,
    `updated_at` timestamp NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `cuentas_bancarias_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE
);

CREATE TABLE `transacciones` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `cuenta_bancaria_id` bigint unsigned NOT NULL,
    `tipo_transaccion` varchar(255) NOT NULL,
    `monto` decimal(10,2) NOT NULL,
    `fecha_transaccion` datetime NOT NULL,
    `created_at` timestamp NULL,
    `updated_at` timestamp NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `transacciones_cuenta_bancaria_id_foreign` FOREIGN KEY (`cuenta_bancaria_id`) REFERENCES `cuentas_bancarias` (`id`) ON DELETE CASCADE
);

CREATE INDEX `cuentas_bancarias_persona_id_foreign` ON `cuentas_bancarias` (`persona_id`);

CREATE UNIQUE INDEX `failed_jobs_uuid_unique` ON `failed_jobs` (`uuid`);

CREATE INDEX `jobs_queue_index` ON `jobs` (`queue`);

CREATE UNIQUE INDEX `personas_documento_identidad_unique` ON `personas` (`documento_identidad`);

CREATE UNIQUE INDEX `personas_email_unique` ON `personas` (`email`);

CREATE INDEX `sessions_last_activity_index` ON `sessions` (`last_activity`);

CREATE INDEX `sessions_user_id_index` ON `sessions` (`user_id`);

CREATE INDEX `transacciones_cuenta_bancaria_id_foreign` ON `transacciones` (`cuenta_bancaria_id`);

CREATE UNIQUE INDEX `users_email_unique` ON `users` (`email`);

INSERT INTO `__EFMigrationsHistory` (`MigrationId`, `ProductVersion`)
VALUES ('20240428211115_InitialCreate', '8.0.4');

COMMIT;

