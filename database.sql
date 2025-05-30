-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table perfectpay.asaas_clientes
CREATE TABLE IF NOT EXISTS `asaas_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asaas_id` varchar(500) DEFAULT NULL,
  `asaas_dateCreated` date DEFAULT NULL,
  `name` varchar(500) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `company` varchar(500) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `mobilePhone` varchar(50) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `addressNumber` varchar(500) DEFAULT NULL,
  `complement` varchar(500) DEFAULT NULL,
  `province` varchar(500) DEFAULT NULL,
  `postalCode` varchar(500) DEFAULT NULL,
  `cpfCnpj` varchar(50) DEFAULT NULL,
  `personType` varchar(50) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `cityName` varchar(500) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(500) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `cc_holderName` varchar(500) DEFAULT NULL,
  `cc_number` varchar(50) DEFAULT NULL,
  `cc_expiryMonth` varchar(2) DEFAULT NULL,
  `cc_expiryYear` varchar(4) DEFAULT NULL,
  `cc_ccv` varchar(10) DEFAULT NULL,
  `json_request` mediumtext DEFAULT NULL,
  `json_response` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `asaas_id` (`asaas_id`),
  KEY `personType` (`personType`),
  KEY `name` (`name`),
  KEY `email` (`email`),
  KEY `postalCode` (`postalCode`),
  KEY `deleted_at` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table perfectpay.asaas_clientes: ~0 rows (approximately)

-- Dumping structure for table perfectpay.asaas_cobrancas
CREATE TABLE IF NOT EXISTS `asaas_cobrancas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(500) DEFAULT NULL,
  `asaas_clientes_id` varchar(500) DEFAULT NULL,
  `asaas_id` varchar(500) DEFAULT NULL,
  `dateCreated` date DEFAULT NULL,
  `value` decimal(20,2) DEFAULT NULL,
  `netValue` decimal(20,2) DEFAULT NULL,
  `customer` varchar(500) DEFAULT NULL,
  `billingType` varchar(50) DEFAULT NULL,
  `dueDate` date DEFAULT NULL,
  `originalDueDate` date DEFAULT NULL,
  `status` varchar(200) DEFAULT NULL,
  `invoiceUrl` varchar(2000) DEFAULT NULL,
  `invoiceNumber` varchar(500) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `externalReference` varchar(2000) DEFAULT NULL,
  `bankSlipUrl` varchar(2000) DEFAULT NULL,
  `barCode` varchar(500) DEFAULT NULL,
  `encodedImage_pixQrCode` text DEFAULT NULL,
  `payload_pix` text DEFAULT NULL,
  `cc_holderName` varchar(500) DEFAULT NULL,
  `cc_cpfCnpj` varchar(50) DEFAULT NULL,
  `cc_number` varchar(50) DEFAULT NULL,
  `cc_expiryMonth` varchar(2) DEFAULT NULL,
  `cc_expiryYear` varchar(4) DEFAULT NULL,
  `cc_ccv` varchar(10) DEFAULT NULL,
  `json_request` mediumtext DEFAULT NULL,
  `json_response` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deleted_at` (`deleted_at`),
  KEY `asaas_clientes_id` (`asaas_clientes_id`),
  KEY `customer` (`customer`),
  KEY `billingType` (`billingType`),
  KEY `asaas_id` (`asaas_id`),
  KEY `dueDate` (`dueDate`),
  KEY `dateCreated` (`dateCreated`),
  KEY `status` (`status`),
  KEY `hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table perfectpay.asaas_cobrancas: ~0 rows (approximately)

-- Dumping structure for table perfectpay.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table perfectpay.cache: ~0 rows (approximately)

-- Dumping structure for table perfectpay.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table perfectpay.cache_locks: ~0 rows (approximately)

-- Dumping structure for table perfectpay.estados
CREATE TABLE IF NOT EXISTS `estados` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uf` varchar(2) NOT NULL,
  `nome` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `estados_uf_unique` (`uf`),
  UNIQUE KEY `estados_nome_unique` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table perfectpay.estados: ~27 rows (approximately)
INSERT INTO `estados` (`id`, `uf`, `nome`) VALUES
	(1, 'AC', 'Acre'),
	(2, 'AL', 'Alagoas'),
	(3, 'AP', 'Amapá'),
	(4, 'AM', 'Amazonas'),
	(5, 'BA', 'Bahia'),
	(6, 'CE', 'Ceará'),
	(7, 'DF', 'Distrito Federal'),
	(8, 'ES', 'Espírito Santo'),
	(9, 'GO', 'Goiás'),
	(10, 'MA', 'Maranhão'),
	(11, 'MT', 'Mato Grosso'),
	(12, 'MS', 'Mato Grosso do Sul'),
	(13, 'MG', 'Minas Gerais'),
	(14, 'PA', 'Pará'),
	(15, 'PB', 'Paraíba'),
	(16, 'PR', 'Paraná'),
	(17, 'PE', 'Pernambuco'),
	(18, 'PI', 'Piauí'),
	(19, 'RJ', 'Rio de Janeiro'),
	(20, 'RN', 'Rio Grande do Norte'),
	(21, 'RS', 'Rio Grande do Sul'),
	(22, 'RO', 'Rondônia'),
	(23, 'RR', 'Roraima'),
	(24, 'SC', 'Santa Catarina'),
	(25, 'SP', 'São Paulo'),
	(26, 'SE', 'Sergipe'),
	(27, 'TO', 'Tocantins');

-- Dumping structure for table perfectpay.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table perfectpay.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table perfectpay.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table perfectpay.jobs: ~0 rows (approximately)

-- Dumping structure for table perfectpay.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table perfectpay.job_batches: ~0 rows (approximately)

-- Dumping structure for table perfectpay.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table perfectpay.migrations: ~0 rows (approximately)

-- Dumping structure for table perfectpay.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table perfectpay.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table perfectpay.produtos_servicos
CREATE TABLE IF NOT EXISTS `produtos_servicos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chave` varchar(200) DEFAULT NULL,
  `nome` varchar(200) DEFAULT NULL,
  `descricao` varchar(1000) DEFAULT NULL,
  `valor` decimal(20,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `produtos_servicos_chave_unique` (`chave`),
  KEY `produtos_servicos_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table perfectpay.produtos_servicos: ~4 rows (approximately)
INSERT INTO `produtos_servicos` (`id`, `chave`, `nome`, `descricao`, `valor`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'PRODUTO-1', 'Produto 1', 'Teste tipo de produto 1', 150.00, '2025-05-28 01:12:17', '2025-05-28 01:12:17', NULL),
	(2, 'PRODUTO-2', 'Produto 2', 'Teste tipo de produto 2', 299.00, '2025-05-28 01:12:17', '2025-05-28 01:12:17', NULL),
	(3, 'SERVICO-1', 'Serviço 1', 'Teste tipo de Serviço 1', 355.00, '2025-05-28 01:12:17', '2025-05-28 01:12:17', NULL),
	(4, 'SERVICO-2', 'Serviço 2', 'Teste tipo de Serviço 2', 1230.00, '2025-05-28 01:12:17', '2025-05-28 01:12:17', NULL);

-- Dumping structure for table perfectpay.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table perfectpay.sessions: ~0 rows (approximately)

-- Dumping structure for table perfectpay.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table perfectpay.users: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
