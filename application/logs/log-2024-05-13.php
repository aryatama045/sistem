<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2024-05-13 09:00:28 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2024-05-13 09:21:50 --> Severity: error --> Exception: Class 'Model_biaya' not found D:\xampp\htdocs\leprindo\sistem\application\third_party\MX\Loader.php 228
ERROR - 2024-05-13 09:27:58 --> Severity: error --> Exception: Call to undefined function lowecase() D:\xampp\htdocs\leprindo\sistem\application\modules\master\views\biaya\index.php 186
ERROR - 2024-05-13 09:36:55 --> Severity: error --> Exception: Call to undefined method MY_Loader::asset() D:\xampp\htdocs\leprindo\sistem\application\modules\master\views\biaya\jenis\index.php 186
ERROR - 2024-05-13 09:41:28 --> Severity: error --> Exception: Call to undefined method MY_Loader::asset() D:\xampp\htdocs\leprindo\sistem\application\modules\master\views\jenis\index.php 186
ERROR - 2024-05-13 09:42:32 --> Query error: Unknown column 'kd_jenis_biaya' in 'where clause' - Invalid query: SELECT *
FROM `mst_jenis_biaya`
WHERE `kd_jenis_biaya` LIKE '%%' ESCAPE '!'
ORDER BY `kd_jenis_biaya` ASC
 LIMIT 10
ERROR - 2024-05-13 09:42:32 --> Language file contains no data: language/indonesian/db_lang.php
ERROR - 2024-05-13 09:42:32 --> Could not find the language line "db_error_heading"
ERROR - 2024-05-13 09:42:32 --> Query error: Unknown column 'kd_jenis_biaya' in 'where clause' - Invalid query: SELECT *
FROM `mst_jenis_biaya`
WHERE `kd_jenis_biaya` LIKE '%%' ESCAPE '!'
ORDER BY `kd_jenis_biaya` ASC
 LIMIT 10
ERROR - 2024-05-13 09:42:32 --> Language file contains no data: language/indonesian/db_lang.php
ERROR - 2024-05-13 09:42:32 --> Could not find the language line "db_error_heading"
ERROR - 2024-05-13 09:43:09 --> Severity: Warning --> number_format() expects parameter 1 to be float, string given D:\xampp\htdocs\leprindo\sistem\application\helpers\main_helper.php 94
ERROR - 2024-05-13 09:43:09 --> Severity: Warning --> number_format() expects parameter 1 to be float, string given D:\xampp\htdocs\leprindo\sistem\application\helpers\main_helper.php 94
ERROR - 2024-05-13 09:43:09 --> Severity: Warning --> number_format() expects parameter 1 to be float, string given D:\xampp\htdocs\leprindo\sistem\application\helpers\main_helper.php 94
ERROR - 2024-05-13 09:43:09 --> Severity: Warning --> number_format() expects parameter 1 to be float, string given D:\xampp\htdocs\leprindo\sistem\application\helpers\main_helper.php 94
ERROR - 2024-05-13 09:43:09 --> Severity: Warning --> number_format() expects parameter 1 to be float, string given D:\xampp\htdocs\leprindo\sistem\application\helpers\main_helper.php 94
ERROR - 2024-05-13 09:43:09 --> Severity: Warning --> number_format() expects parameter 1 to be float, string given D:\xampp\htdocs\leprindo\sistem\application\helpers\main_helper.php 94
ERROR - 2024-05-13 09:43:09 --> Severity: Warning --> number_format() expects parameter 1 to be float, string given D:\xampp\htdocs\leprindo\sistem\application\helpers\main_helper.php 94
ERROR - 2024-05-13 09:43:09 --> Severity: Warning --> number_format() expects parameter 1 to be float, string given D:\xampp\htdocs\leprindo\sistem\application\helpers\main_helper.php 94
ERROR - 2024-05-13 09:43:09 --> Severity: Warning --> number_format() expects parameter 1 to be float, string given D:\xampp\htdocs\leprindo\sistem\application\helpers\main_helper.php 94
ERROR - 2024-05-13 09:43:09 --> Severity: Warning --> number_format() expects parameter 1 to be float, string given D:\xampp\htdocs\leprindo\sistem\application\helpers\main_helper.php 94
ERROR - 2024-05-13 09:43:09 --> Severity: Warning --> number_format() expects parameter 1 to be float, string given D:\xampp\htdocs\leprindo\sistem\application\helpers\main_helper.php 94
ERROR - 2024-05-13 09:43:09 --> Severity: Warning --> number_format() expects parameter 1 to be float, string given D:\xampp\htdocs\leprindo\sistem\application\helpers\main_helper.php 94
ERROR - 2024-05-13 09:59:54 --> Query error: Unknown column 'nilai' in 'where clause' - Invalid query: SELECT *
FROM `mst_jenis_biaya`
WHERE `nilai` LIKE '%b%' ESCAPE '!'
OR  `kd_jenis` LIKE '%b%' ESCAPE '!'
ORDER BY `kd_jenis` ASC
 LIMIT 10
ERROR - 2024-05-13 09:59:54 --> Language file contains no data: language/indonesian/db_lang.php
ERROR - 2024-05-13 09:59:54 --> Could not find the language line "db_error_heading"
ERROR - 2024-05-13 10:42:59 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2024-05-13 10:42:59 --> Severity: Notice --> Undefined offset: 0 D:\xampp\htdocs\leprindo\sistem\application\models\Model_menu.php 81
ERROR - 2024-05-13 10:42:59 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
AND `permissions`.`status` = 1
AND `deleted_at` IS NULL
GROUP BY `permission_r' at line 4 - Invalid query: SELECT `permissions`.*
FROM `permissions`
INNER JOIN `permission_roles` ON `permissions`.`id` = `permission_roles`.`permission_id`
WHERE `permission_roles`.`role_id` IN()
AND `permissions`.`status` = 1
AND `deleted_at` IS NULL
GROUP BY `permission_roles`.`permission_id`
ERROR - 2024-05-13 10:42:59 --> Language file contains no data: language/indonesian/db_lang.php
ERROR - 2024-05-13 10:42:59 --> Could not find the language line "db_error_heading"
ERROR - 2024-05-13 10:45:10 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\leprindo\sistem\application\models\Model_menu.php 87
ERROR - 2024-05-13 10:45:10 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
AND `permissions`.`status` = 1
AND `deleted_at` IS NULL
GROUP BY `permission_r' at line 4 - Invalid query: SELECT `permissions`.*
FROM `permissions`
INNER JOIN `permission_roles` ON `permissions`.`id` = `permission_roles`.`permission_id`
WHERE `permission_roles`.`role_id` IN()
AND `permissions`.`status` = 1
AND `deleted_at` IS NULL
GROUP BY `permission_roles`.`permission_id`
ERROR - 2024-05-13 10:45:10 --> Language file contains no data: language/indonesian/db_lang.php
ERROR - 2024-05-13 10:45:10 --> Could not find the language line "db_error_heading"
ERROR - 2024-05-13 10:47:13 --> Severity: Notice --> Undefined offset: 0 D:\xampp\htdocs\leprindo\sistem\application\models\Model_menu.php 80
ERROR - 2024-05-13 10:47:13 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
AND `permissions`.`status` = 1
AND `deleted_at` IS NULL
GROUP BY `permission_r' at line 4 - Invalid query: SELECT `permissions`.*
FROM `permissions`
INNER JOIN `permission_roles` ON `permissions`.`id` = `permission_roles`.`permission_id`
WHERE `permission_roles`.`role_id` IN()
AND `permissions`.`status` = 1
AND `deleted_at` IS NULL
GROUP BY `permission_roles`.`permission_id`
ERROR - 2024-05-13 10:47:13 --> Language file contains no data: language/indonesian/db_lang.php
ERROR - 2024-05-13 10:47:13 --> Could not find the language line "db_error_heading"
ERROR - 2024-05-13 10:47:42 --> Language file contains no data: language/indonesian/form_validation_lang.php
