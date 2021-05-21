<?php
class Create
{
  public $server = "localhost";
  public $user = "root";
  public $pass = "mysql"; //
  public $connection;
  public $result;
  public $sql;
  public $mess = [];

  function createDb($dbName)
  {
    //----db----

    $this->sql = "CREATE DATABASE $dbName;";

    $this->connection = new mysqli($this->server, $this->user, $this->pass);

    if ($this->connection->query($this->sql)) {
      array_push($this->mess, "DB created successfully");
    } else {
      array_push($this->mess, "Error creating tables: " . $this->connection->error);
    }
    $this->connection->close();
    //----tables----

    $mysqli = new mysqli($this->server, $this->user, $this->pass, $dbName); ////////////////////

    $mysqli->query("SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';");
    $mysqli->query("SET AUTOCOMMIT = 0;");
    $mysqli->query("SET time_zone = '+00:00';");
    $mysqli->query("CREATE TABLE `adventscalendar` (
      `id` int(11) NOT NULL,
      `userid` varchar(50) NOT NULL,
      `isFinished` int(2) NOT NULL,
      `door` int(2) NOT NULL,
      `text` varchar(10) DEFAULT NULL,
      `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `timestamp_finished` timestamp NULL DEFAULT NULL,
      `timestamp_checked` timestamp NULL DEFAULT NULL
    )");
    $mysqli->query("CREATE TABLE `adventscalendar` (
      `id` int(11) NOT NULL,
      `userid` varchar(50) NOT NULL,
      `isFinished` int(2) NOT NULL,
      `door` int(2) NOT NULL,
      `text` varchar(10) DEFAULT NULL,
      `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `timestamp_finished` timestamp NULL DEFAULT NULL,
      `timestamp_checked` timestamp NULL DEFAULT NULL
    )");
    $mysqli->query("CREATE TABLE `contests` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
      `question` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
      `contest_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `options` longtext COLLATE utf8mb4_unicode_ci,
      `participation_info` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
      `participation_end` datetime NOT NULL,
      `contest_start` datetime NOT NULL,
      `contest_end` datetime NOT NULL,
      `published` tinyint(1) NOT NULL DEFAULT '1',
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    );");
    $mysqli->query("CREATE TABLE `failed_jobs` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
      `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
      `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
      `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
      `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;");
    $mysqli->query("CREATE TABLE `gewinnspiel_answers` (
      `id` int(11) NOT NULL,
      `answer` varchar(20) NOT NULL,
      `firstname` varchar(100) NOT NULL,
      `lastname` varchar(100) NOT NULL,
      `birthday` date NOT NULL,
      `tel` varchar(50) NOT NULL,
      `email` varchar(255) NOT NULL,
      `privacy` int(10) UNSIGNED NOT NULL DEFAULT '1',
      `participation` int(10) UNSIGNED NOT NULL DEFAULT '1',
      `contest_id` int(11) NOT NULL DEFAULT '0',
      `participation_date` datetime DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;");
    $mysqli->query("CREATE TABLE `imprint_data` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
      `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;");
    $mysqli->query("CREATE TABLE `latests` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
      `img` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
      `published` tinyint(1) NOT NULL DEFAULT '1',
      `created_by` int(10) UNSIGNED DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    $mysqli->query("CREATE TABLE `migrations` (
      `id` int(10) UNSIGNED NOT NULL,
      `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
      `batch` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;");
    $mysqli->query("CREATE TABLE `news` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
      `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
      `img` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `img2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `img3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `published` binary(1) NOT NULL DEFAULT '1',
      `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;");
    $mysqli->query("CREATE TABLE `participation` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
      `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;");
    $mysqli->query("CREATE TABLE `password_resets` (
      `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
      `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;");
    $mysqli->query("CREATE TABLE `privacy_policy` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
      `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
      `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;");
    $mysqli->query("CREATE TABLE `recipe` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
      `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;");
    $mysqli->query("CREATE TABLE `telescope_monitoring` (
      `tag` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    $mysqli->query("CREATE TABLE `timestamp` (
      `id` int(11) NOT NULL,
      `timestamp` datetime NOT NULL,
      `status` int(1) NOT NULL DEFAULT '0' COMMENT '0 =can be edited / 1 =used already',
      `blocked` int(1) NOT NULL DEFAULT '0',
      `created_at` datetime DEFAULT NULL,
      `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    $mysqli->query("CREATE TABLE `timestamp_timestampwinner` (
      `id` int(11) NOT NULL,
      `timestamp_id` int(11) NOT NULL,
      `timestamp_winner_id` int(11) NOT NULL,
      `created_at` datetime DEFAULT NULL,
      `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    $mysqli->query("CREATE TABLE `timestamp_winner` (
      `id` int(11) NOT NULL,
      `firstname` varchar(100) DEFAULT NULL,
      `lastname` varchar(100) DEFAULT NULL,
      `zip` varchar(20) DEFAULT NULL,
      `city` varchar(50) DEFAULT NULL,
      `birthday` date DEFAULT NULL,
      `email` varchar(50) DEFAULT NULL,
      `telephone` varchar(20) DEFAULT NULL,
      `created_at` datetime DEFAULT NULL,
      `updated_at` datetime DEFAULT NULL,
      `street` varchar(80) DEFAULT NULL,
      `uuid` varchar(60) DEFAULT NULL,
      `housenumber` varchar(10) DEFAULT NULL,
      `mainprice` int(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    $mysqli->query("CREATE TABLE `users` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
      `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
      `email_verified_at` timestamp NULL DEFAULT NULL,
      `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
      `admin` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL,
      `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;");
    $mysqli->query("ALTER TABLE `adventscalendar`
      ADD PRIMARY KEY (`id`);");
    $mysqli->query("ALTER TABLE `contests`
      ADD PRIMARY KEY (`id`) USING BTREE;");
    $mysqli->query("ALTER TABLE `failed_jobs`
      ADD PRIMARY KEY (`id`) USING BTREE;");
    $mysqli->query("ALTER TABLE `gewinnspiel_answers`
      ADD PRIMARY KEY (`id`) USING BTREE;");
    $mysqli->query("ALTER TABLE `imprint_data`
      ADD PRIMARY KEY (`id`) USING BTREE;");

    $mysqli->query("ALTER TABLE `latests`
    ADD PRIMARY KEY (`id`) USING BTREE;");
    $mysqli->query("ALTER TABLE `migrations`
      ADD PRIMARY KEY (`id`) USING BTREE;");
    $mysqli->query("ALTER TABLE `news`
      ADD PRIMARY KEY (`id`) USING BTREE,
      ADD UNIQUE KEY `IDX1` (`title`,`id`) USING BTREE;");
    $mysqli->query("ALTER TABLE `participation`
      ADD PRIMARY KEY (`id`) USING BTREE;");
    $mysqli->query("ALTER TABLE `password_resets`
      ADD KEY `password_resets_email_index` (`email`) USING BTREE;");
    $mysqli->query("ALTER TABLE `privacy_policy`
      ADD PRIMARY KEY (`id`) USING BTREE;");
    $mysqli->query("ALTER TABLE `recipe`
      ADD PRIMARY KEY (`id`) USING BTREE;");
    $mysqli->query("ALTER TABLE `timestamp`
      ADD PRIMARY KEY (`id`) USING BTREE;");
    $mysqli->query("ALTER TABLE `timestamp_timestampwinner`
      ADD PRIMARY KEY (`id`) USING BTREE;");
    $mysqli->query("ALTER TABLE `timestamp_winner`
      ADD PRIMARY KEY (`id`) USING BTREE;");
    $mysqli->query("ALTER TABLE `users`
      ADD PRIMARY KEY (`id`) USING BTREE,
      ADD UNIQUE KEY `users_email_unique` (`email`) USING BTREE;");
    $mysqli->query("ALTER TABLE `adventscalendar`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=747224;");
    $mysqli->query("ALTER TABLE `contests`
      MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;");
    $mysqli->query("ALTER TABLE `failed_jobs`
      MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
    $mysqli->query("ALTER TABLE `gewinnspiel_answers`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;");
    $mysqli->query("ALTER TABLE `imprint_data`
      MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;");
    $mysqli->query("ALTER TABLE `latests`
      MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;");
    $mysqli->query("ALTER TABLE `migrations`
      MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;");
    $mysqli->query("ALTER TABLE `news`
      MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;");
    $mysqli->query("ALTER TABLE `participation`
      MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;");
    $mysqli->query("ALTER TABLE `privacy_policy`
      MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;");
    $mysqli->query("ALTER TABLE `recipe`
      MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;");
    $mysqli->query("ALTER TABLE `timestamp`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;");
    $mysqli->query("ALTER TABLE `timestamp_timestampwinner`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;");
    $mysqli->query("ALTER TABLE `timestamp_winner`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15300;");
    $mysqli->query("ALTER TABLE `users`
      MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;");




    return $this->mess;
  }

  function showDB()
  {
    $this->connection = mysqli_connect($this->server, $this->user, $this->pass);
    $this->result = mysqli_query($this->connection, "SHOW DATABASES LIKE '%_db5634'");
    while ($row = mysqli_fetch_assoc($this->result)) {
      $data[] = $row;
    }
    return $data;
    $this->connection->close();
  }
}
