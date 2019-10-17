/*
 Navicat Premium Data Transfer

 Source Server         : lokal root
 Source Server Type    : MySQL
 Source Server Version : 50529
 Source Host           : localhost:3306
 Source Schema         : db_kia

 Target Server Type    : MySQL
 Target Server Version : 50529
 File Encoding         : 65001

 Date: 24/02/2019 00:12:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_bidan
-- ----------------------------
DROP TABLE IF EXISTS `tb_bidan`;
CREATE TABLE `tb_bidan`  (
  `id_bidan` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `telp` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_bidan`) USING BTREE,
  INDEX `fk_id_bidan`(`username`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_bidan
-- ----------------------------
INSERT INTO `tb_bidan` VALUES ('001', 'Andi Nurul', '', '', 'bidan1');
INSERT INTO `tb_bidan` VALUES ('002', 'Susi Susanti', '', '', 'bidan2');

-- ----------------------------
-- Table structure for tb_cat_ibu_hamil
-- ----------------------------
DROP TABLE IF EXISTS `tb_cat_ibu_hamil`;
CREATE TABLE `tb_cat_ibu_hamil`  (
  `no_reg` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `hamil_ke` tinyint(2) NULL DEFAULT NULL,
  `jml_persalinan` tinyint(2) UNSIGNED NULL DEFAULT NULL,
  `jml_keguguran` tinyint(2) UNSIGNED NULL DEFAULT NULL,
  `jml_gravida` tinyint(2) NULL DEFAULT NULL,
  `jml_paritas` tinyint(2) NULL DEFAULT NULL,
  `jml_abortus` tinyint(2) NULL DEFAULT NULL,
  `jml_anak_hidup` tinyint(2) UNSIGNED NULL DEFAULT NULL,
  `jml_lhr_mati` tinyint(2) UNSIGNED NULL DEFAULT NULL,
  `jml_anak_lhr_krg_bln` tinyint(2) UNSIGNED NULL DEFAULT NULL,
  `jarak_kehamilan` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `bulan_tt` varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tahun_tt` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `penolong_persalinan` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cara_persalinan` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`no_reg`) USING BTREE,
  CONSTRAINT `tb_cat_ibu_hamil_ibfk_1` FOREIGN KEY (`no_reg`) REFERENCES `tb_reg_ibu` (`no_reg`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_cat_ibu_hamil
-- ----------------------------
INSERT INTO `tb_cat_ibu_hamil` VALUES ('REG0001', 2, 1, 0, 0, 1, 0, 1, 0, 0, '3 Tahun', 'Januari', '2016', 'Nina', 'Spontan/Normal');

-- ----------------------------
-- Table structure for tb_cat_imunisasi
-- ----------------------------
DROP TABLE IF EXISTS `tb_cat_imunisasi`;
CREATE TABLE `tb_cat_imunisasi`  (
  `no_ket_lahir` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `vaksin` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tgl_vaksin` date NULL DEFAULT NULL,
  PRIMARY KEY (`no_ket_lahir`, `vaksin`) USING BTREE,
  CONSTRAINT `tb_cat_imunisasi_ibfk_1` FOREIGN KEY (`no_ket_lahir`) REFERENCES `tb_reg_anak` (`no_ket_lahir`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_cat_imunisasi
-- ----------------------------
INSERT INTO `tb_cat_imunisasi` VALUES ('001', 'DPT-HB-Hib 1', '2018-10-16');
INSERT INTO `tb_cat_imunisasi` VALUES ('001', 'HB-0', '2018-10-01');
INSERT INTO `tb_cat_imunisasi` VALUES ('001', 'Polio', '2018-10-08');
INSERT INTO `tb_cat_imunisasi` VALUES ('002', 'HB-0', '2018-10-03');

-- ----------------------------
-- Table structure for tb_donor
-- ----------------------------
DROP TABLE IF EXISTS `tb_donor`;
CREATE TABLE `tb_donor`  (
  `no_reg` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nama_donor` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `telp` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`no_reg`, `telp`) USING BTREE,
  CONSTRAINT `fk_no_reg2` FOREIGN KEY (`no_reg`) REFERENCES `tb_persiapan` (`no_reg`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_donor
-- ----------------------------
INSERT INTO `tb_donor` VALUES ('REG0001', 'Siti', '42342343');

-- ----------------------------
-- Table structure for tb_kabupaten
-- ----------------------------
DROP TABLE IF EXISTS `tb_kabupaten`;
CREATE TABLE `tb_kabupaten`  (
  `id` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_provinsi` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `regencies_province_id_index`(`id_provinsi`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_kabupaten
-- ----------------------------
INSERT INTO `tb_kabupaten` VALUES ('7301', '73', 'KABUPATEN KEPULAUAN SELAYAR');
INSERT INTO `tb_kabupaten` VALUES ('7302', '73', 'KABUPATEN BULUKUMBA');
INSERT INTO `tb_kabupaten` VALUES ('7303', '73', 'KABUPATEN BANTAENG');
INSERT INTO `tb_kabupaten` VALUES ('7304', '73', 'KABUPATEN JENEPONTO');
INSERT INTO `tb_kabupaten` VALUES ('7305', '73', 'KABUPATEN TAKALAR');
INSERT INTO `tb_kabupaten` VALUES ('7306', '73', 'KABUPATEN GOWA');
INSERT INTO `tb_kabupaten` VALUES ('7307', '73', 'KABUPATEN SINJAI');
INSERT INTO `tb_kabupaten` VALUES ('7308', '73', 'KABUPATEN MAROS');
INSERT INTO `tb_kabupaten` VALUES ('7309', '73', 'KABUPATEN PANGKAJENE DAN KEPULAUAN');
INSERT INTO `tb_kabupaten` VALUES ('7310', '73', 'KABUPATEN BARRU');
INSERT INTO `tb_kabupaten` VALUES ('7311', '73', 'KABUPATEN BONE');
INSERT INTO `tb_kabupaten` VALUES ('7312', '73', 'KABUPATEN SOPPENG');
INSERT INTO `tb_kabupaten` VALUES ('7313', '73', 'KABUPATEN WAJO');
INSERT INTO `tb_kabupaten` VALUES ('7314', '73', 'KABUPATEN SIDENRENG RAPPANG');
INSERT INTO `tb_kabupaten` VALUES ('7315', '73', 'KABUPATEN PINRANG');
INSERT INTO `tb_kabupaten` VALUES ('7316', '73', 'KABUPATEN ENREKANG');
INSERT INTO `tb_kabupaten` VALUES ('7317', '73', 'KABUPATEN LUWU');
INSERT INTO `tb_kabupaten` VALUES ('7318', '73', 'KABUPATEN TANA TORAJA');
INSERT INTO `tb_kabupaten` VALUES ('7322', '73', 'KABUPATEN LUWU UTARA');
INSERT INTO `tb_kabupaten` VALUES ('7325', '73', 'KABUPATEN LUWU TIMUR');
INSERT INTO `tb_kabupaten` VALUES ('7326', '73', 'KABUPATEN TORAJA UTARA');
INSERT INTO `tb_kabupaten` VALUES ('7371', '73', 'KOTA MAKASSAR');
INSERT INTO `tb_kabupaten` VALUES ('7372', '73', 'KOTA PAREPARE');
INSERT INTO `tb_kabupaten` VALUES ('7373', '73', 'KOTA PALOPO');

-- ----------------------------
-- Table structure for tb_kecamatan
-- ----------------------------
DROP TABLE IF EXISTS `tb_kecamatan`;
CREATE TABLE `tb_kecamatan`  (
  `id` char(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_kab` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `districts_id_index`(`id_kab`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_kecamatan
-- ----------------------------
INSERT INTO `tb_kecamatan` VALUES ('7301010', '7301', 'PASIMARANNU');
INSERT INTO `tb_kecamatan` VALUES ('7301011', '7301', 'PASILAMBENA');
INSERT INTO `tb_kecamatan` VALUES ('7301020', '7301', 'PASIMASSUNGGU');
INSERT INTO `tb_kecamatan` VALUES ('7301021', '7301', 'TAKABONERATE');
INSERT INTO `tb_kecamatan` VALUES ('7301022', '7301', 'PASIMASSUNGGU TIMUR');
INSERT INTO `tb_kecamatan` VALUES ('7301030', '7301', 'BONTOSIKUYU');
INSERT INTO `tb_kecamatan` VALUES ('7301040', '7301', 'BONTOHARU');
INSERT INTO `tb_kecamatan` VALUES ('7301041', '7301', 'BENTENG');
INSERT INTO `tb_kecamatan` VALUES ('7301042', '7301', 'BONTOMANAI');
INSERT INTO `tb_kecamatan` VALUES ('7301050', '7301', 'BONTOMATENE');
INSERT INTO `tb_kecamatan` VALUES ('7301051', '7301', 'BUKI');
INSERT INTO `tb_kecamatan` VALUES ('7302010', '7302', 'GANTARANG');
INSERT INTO `tb_kecamatan` VALUES ('7302020', '7302', 'UJUNG BULU');
INSERT INTO `tb_kecamatan` VALUES ('7302021', '7302', 'UJUNG LOE');
INSERT INTO `tb_kecamatan` VALUES ('7302030', '7302', 'BONTO BAHARI');
INSERT INTO `tb_kecamatan` VALUES ('7302040', '7302', 'BONTOTIRO');
INSERT INTO `tb_kecamatan` VALUES ('7302050', '7302', 'HERO LANGE-LANGE');
INSERT INTO `tb_kecamatan` VALUES ('7302060', '7302', 'KAJANG');
INSERT INTO `tb_kecamatan` VALUES ('7302070', '7302', 'BULUKUMPA');
INSERT INTO `tb_kecamatan` VALUES ('7302080', '7302', 'RILAU ALE');
INSERT INTO `tb_kecamatan` VALUES ('7302090', '7302', 'KINDANG');
INSERT INTO `tb_kecamatan` VALUES ('7303010', '7303', 'BISSAPPU');
INSERT INTO `tb_kecamatan` VALUES ('7303011', '7303', 'ULUERE');
INSERT INTO `tb_kecamatan` VALUES ('7303012', '7303', 'SINOA');
INSERT INTO `tb_kecamatan` VALUES ('7303020', '7303', 'BANTAENG');
INSERT INTO `tb_kecamatan` VALUES ('7303021', '7303', 'EREMERASA');
INSERT INTO `tb_kecamatan` VALUES ('7303030', '7303', 'TOMPOBULU');
INSERT INTO `tb_kecamatan` VALUES ('7303031', '7303', 'PA\'JUKUKANG');
INSERT INTO `tb_kecamatan` VALUES ('7303032', '7303', 'GANTARANGKEKE');
INSERT INTO `tb_kecamatan` VALUES ('7304010', '7304', 'BANGKALA');
INSERT INTO `tb_kecamatan` VALUES ('7304011', '7304', 'BANGKALA BARAT');
INSERT INTO `tb_kecamatan` VALUES ('7304020', '7304', 'TAMALATEA');
INSERT INTO `tb_kecamatan` VALUES ('7304021', '7304', 'BONTORAMBA');
INSERT INTO `tb_kecamatan` VALUES ('7304030', '7304', 'BINAMU');
INSERT INTO `tb_kecamatan` VALUES ('7304031', '7304', 'TURATEA');
INSERT INTO `tb_kecamatan` VALUES ('7304040', '7304', 'BATANG');
INSERT INTO `tb_kecamatan` VALUES ('7304041', '7304', 'ARUNGKEKE');
INSERT INTO `tb_kecamatan` VALUES ('7304042', '7304', 'TAROWANG');
INSERT INTO `tb_kecamatan` VALUES ('7304050', '7304', 'KELARA');
INSERT INTO `tb_kecamatan` VALUES ('7304051', '7304', 'RUMBIA');
INSERT INTO `tb_kecamatan` VALUES ('7305010', '7305', 'MANGARA BOMBANG');
INSERT INTO `tb_kecamatan` VALUES ('7305020', '7305', 'MAPPAKASUNGGU');
INSERT INTO `tb_kecamatan` VALUES ('7305021', '7305', 'SANROBONE');
INSERT INTO `tb_kecamatan` VALUES ('7305030', '7305', 'POLOMBANGKENG SELATAN');
INSERT INTO `tb_kecamatan` VALUES ('7305031', '7305', 'PATTALLASSANG');
INSERT INTO `tb_kecamatan` VALUES ('7305040', '7305', 'POLOMBANGKENG UTARA');
INSERT INTO `tb_kecamatan` VALUES ('7305050', '7305', 'GALESONG SELATAN');
INSERT INTO `tb_kecamatan` VALUES ('7305051', '7305', 'GALESONG');
INSERT INTO `tb_kecamatan` VALUES ('7305060', '7305', 'GALESONG UTARA');
INSERT INTO `tb_kecamatan` VALUES ('7306010', '7306', 'BONTONOMPO');
INSERT INTO `tb_kecamatan` VALUES ('7306011', '7306', 'BONTONOMPO SELATAN');
INSERT INTO `tb_kecamatan` VALUES ('7306020', '7306', 'BAJENG');
INSERT INTO `tb_kecamatan` VALUES ('7306021', '7306', 'BAJENG BARAT');
INSERT INTO `tb_kecamatan` VALUES ('7306030', '7306', 'PALLANGGA');
INSERT INTO `tb_kecamatan` VALUES ('7306031', '7306', 'BAROMBONG');
INSERT INTO `tb_kecamatan` VALUES ('7306040', '7306', 'SOMBA OPU');
INSERT INTO `tb_kecamatan` VALUES ('7306050', '7306', 'BONTOMARANNU');
INSERT INTO `tb_kecamatan` VALUES ('7306051', '7306', 'PATTALLASSANG');
INSERT INTO `tb_kecamatan` VALUES ('7306060', '7306', 'PARANGLOE');
INSERT INTO `tb_kecamatan` VALUES ('7306061', '7306', 'MANUJU');
INSERT INTO `tb_kecamatan` VALUES ('7306070', '7306', 'TINGGIMONCONG');
INSERT INTO `tb_kecamatan` VALUES ('7306071', '7306', 'TOMBOLO PAO');
INSERT INTO `tb_kecamatan` VALUES ('7306072', '7306', 'PARIGI');
INSERT INTO `tb_kecamatan` VALUES ('7306080', '7306', 'BUNGAYA');
INSERT INTO `tb_kecamatan` VALUES ('7306081', '7306', 'BONTOLEMPANGAN');
INSERT INTO `tb_kecamatan` VALUES ('7306090', '7306', 'TOMPOBULU');
INSERT INTO `tb_kecamatan` VALUES ('7306091', '7306', 'BIRINGBULU');
INSERT INTO `tb_kecamatan` VALUES ('7307010', '7307', 'SINJAI BARAT');
INSERT INTO `tb_kecamatan` VALUES ('7307020', '7307', 'SINJAI BORONG');
INSERT INTO `tb_kecamatan` VALUES ('7307030', '7307', 'SINJAI SELATAN');
INSERT INTO `tb_kecamatan` VALUES ('7307040', '7307', 'TELLU LIMPOE');
INSERT INTO `tb_kecamatan` VALUES ('7307050', '7307', 'SINJAI TIMUR');
INSERT INTO `tb_kecamatan` VALUES ('7307060', '7307', 'SINJAI TENGAH');
INSERT INTO `tb_kecamatan` VALUES ('7307070', '7307', 'SINJAI UTARA');
INSERT INTO `tb_kecamatan` VALUES ('7307080', '7307', 'BULUPODDO');
INSERT INTO `tb_kecamatan` VALUES ('7307090', '7307', 'PULAU SEMBILAN');
INSERT INTO `tb_kecamatan` VALUES ('7308010', '7308', 'MANDAI');
INSERT INTO `tb_kecamatan` VALUES ('7308011', '7308', 'MONCONGLOE');
INSERT INTO `tb_kecamatan` VALUES ('7308020', '7308', 'MAROS BARU');
INSERT INTO `tb_kecamatan` VALUES ('7308021', '7308', 'MARUSU');
INSERT INTO `tb_kecamatan` VALUES ('7308022', '7308', 'TURIKALE');
INSERT INTO `tb_kecamatan` VALUES ('7308023', '7308', 'LAU');
INSERT INTO `tb_kecamatan` VALUES ('7308030', '7308', 'BONTOA');
INSERT INTO `tb_kecamatan` VALUES ('7308040', '7308', 'BANTIMURUNG');
INSERT INTO `tb_kecamatan` VALUES ('7308041', '7308', 'SIMBANG');
INSERT INTO `tb_kecamatan` VALUES ('7308050', '7308', 'TANRALILI');
INSERT INTO `tb_kecamatan` VALUES ('7308051', '7308', 'TOMPU BULU');
INSERT INTO `tb_kecamatan` VALUES ('7308060', '7308', 'CAMBA');
INSERT INTO `tb_kecamatan` VALUES ('7308061', '7308', 'CENRANA');
INSERT INTO `tb_kecamatan` VALUES ('7308070', '7308', 'MALLAWA');
INSERT INTO `tb_kecamatan` VALUES ('7309010', '7309', 'LIUKANG TANGAYA');
INSERT INTO `tb_kecamatan` VALUES ('7309020', '7309', 'LIUKANG KALMAS');
INSERT INTO `tb_kecamatan` VALUES ('7309030', '7309', 'LIUKANG TUPABBIRING');
INSERT INTO `tb_kecamatan` VALUES ('7309031', '7309', 'LIUKANG TUPABBIRING UTARA');
INSERT INTO `tb_kecamatan` VALUES ('7309040', '7309', 'PANGKAJENE');
INSERT INTO `tb_kecamatan` VALUES ('7309041', '7309', 'MINASATENE');
INSERT INTO `tb_kecamatan` VALUES ('7309050', '7309', 'BALOCCI');
INSERT INTO `tb_kecamatan` VALUES ('7309051', '7309', 'TONDONG TALLASA');
INSERT INTO `tb_kecamatan` VALUES ('7309060', '7309', 'BUNGORO');
INSERT INTO `tb_kecamatan` VALUES ('7309070', '7309', 'LABAKKANG');
INSERT INTO `tb_kecamatan` VALUES ('7309080', '7309', 'MA\'RANG');
INSERT INTO `tb_kecamatan` VALUES ('7309091', '7309', 'SEGERI');
INSERT INTO `tb_kecamatan` VALUES ('7309092', '7309', 'MANDALLE');
INSERT INTO `tb_kecamatan` VALUES ('7310010', '7310', 'TANETE RIAJA');
INSERT INTO `tb_kecamatan` VALUES ('7310011', '7310', 'PUJANANTING');
INSERT INTO `tb_kecamatan` VALUES ('7310020', '7310', 'TANETE RILAU');
INSERT INTO `tb_kecamatan` VALUES ('7310030', '7310', 'BARRU');
INSERT INTO `tb_kecamatan` VALUES ('7310040', '7310', 'SOPPENG RIAJA');
INSERT INTO `tb_kecamatan` VALUES ('7310041', '7310', 'BALUSU');
INSERT INTO `tb_kecamatan` VALUES ('7310050', '7310', 'MALLUSETASI');
INSERT INTO `tb_kecamatan` VALUES ('7311010', '7311', 'BONTOCANI');
INSERT INTO `tb_kecamatan` VALUES ('7311020', '7311', 'KAHU');
INSERT INTO `tb_kecamatan` VALUES ('7311030', '7311', 'KAJUARA');
INSERT INTO `tb_kecamatan` VALUES ('7311040', '7311', 'SALOMEKKO');
INSERT INTO `tb_kecamatan` VALUES ('7311050', '7311', 'TONRA');
INSERT INTO `tb_kecamatan` VALUES ('7311060', '7311', 'PATIMPENG');
INSERT INTO `tb_kecamatan` VALUES ('7311070', '7311', 'LIBURENG');
INSERT INTO `tb_kecamatan` VALUES ('7311080', '7311', 'MARE');
INSERT INTO `tb_kecamatan` VALUES ('7311090', '7311', 'SIBULUE');
INSERT INTO `tb_kecamatan` VALUES ('7311100', '7311', 'CINA');
INSERT INTO `tb_kecamatan` VALUES ('7311110', '7311', 'BAREBBO');
INSERT INTO `tb_kecamatan` VALUES ('7311120', '7311', 'PONRE');
INSERT INTO `tb_kecamatan` VALUES ('7311130', '7311', 'LAPPARIAJA');
INSERT INTO `tb_kecamatan` VALUES ('7311140', '7311', 'LAMURU');
INSERT INTO `tb_kecamatan` VALUES ('7311141', '7311', 'TELLU LIMPOE');
INSERT INTO `tb_kecamatan` VALUES ('7311150', '7311', 'BENGO');
INSERT INTO `tb_kecamatan` VALUES ('7311160', '7311', 'ULAWENG');
INSERT INTO `tb_kecamatan` VALUES ('7311170', '7311', 'PALAKKA');
INSERT INTO `tb_kecamatan` VALUES ('7311180', '7311', 'AWANGPONE');
INSERT INTO `tb_kecamatan` VALUES ('7311190', '7311', 'TELLU SIATTINGE');
INSERT INTO `tb_kecamatan` VALUES ('7311200', '7311', 'AMALI');
INSERT INTO `tb_kecamatan` VALUES ('7311210', '7311', 'AJANGALE');
INSERT INTO `tb_kecamatan` VALUES ('7311220', '7311', 'DUA BOCCOE');
INSERT INTO `tb_kecamatan` VALUES ('7311230', '7311', 'CENRANA');
INSERT INTO `tb_kecamatan` VALUES ('7311710', '7311', 'TANETE RIATTANG BARAT');
INSERT INTO `tb_kecamatan` VALUES ('7311720', '7311', 'TANETE RIATTANG');
INSERT INTO `tb_kecamatan` VALUES ('7311730', '7311', 'TANETE RIATTANG TIMUR');
INSERT INTO `tb_kecamatan` VALUES ('7312010', '7312', 'MARIO RIWAWO');
INSERT INTO `tb_kecamatan` VALUES ('7312020', '7312', 'LALABATA');
INSERT INTO `tb_kecamatan` VALUES ('7312030', '7312', 'LILI RIAJA');
INSERT INTO `tb_kecamatan` VALUES ('7312031', '7312', 'GANRA');
INSERT INTO `tb_kecamatan` VALUES ('7312032', '7312', 'CITTA');
INSERT INTO `tb_kecamatan` VALUES ('7312040', '7312', 'LILI RILAU');
INSERT INTO `tb_kecamatan` VALUES ('7312050', '7312', 'DONRI DONRI');
INSERT INTO `tb_kecamatan` VALUES ('7312060', '7312', 'MARIO RIAWA');
INSERT INTO `tb_kecamatan` VALUES ('7313010', '7313', 'SABBANG PARU');
INSERT INTO `tb_kecamatan` VALUES ('7313020', '7313', 'TEMPE');
INSERT INTO `tb_kecamatan` VALUES ('7313030', '7313', 'PAMMANA');
INSERT INTO `tb_kecamatan` VALUES ('7313040', '7313', 'BOLA');
INSERT INTO `tb_kecamatan` VALUES ('7313050', '7313', 'TAKKALALLA');
INSERT INTO `tb_kecamatan` VALUES ('7313060', '7313', 'SAJOANGING');
INSERT INTO `tb_kecamatan` VALUES ('7313061', '7313', 'PENRANG');
INSERT INTO `tb_kecamatan` VALUES ('7313070', '7313', 'MAJAULENG');
INSERT INTO `tb_kecamatan` VALUES ('7313080', '7313', 'TANA SITOLO');
INSERT INTO `tb_kecamatan` VALUES ('7313090', '7313', 'BELAWA');
INSERT INTO `tb_kecamatan` VALUES ('7313100', '7313', 'MANIANG PAJO');
INSERT INTO `tb_kecamatan` VALUES ('7313101', '7313', 'GILIRENG');
INSERT INTO `tb_kecamatan` VALUES ('7313110', '7313', 'KEERA');
INSERT INTO `tb_kecamatan` VALUES ('7313120', '7313', 'PITUMPANUA');
INSERT INTO `tb_kecamatan` VALUES ('7314010', '7314', 'PANCA LAUTANG');
INSERT INTO `tb_kecamatan` VALUES ('7314020', '7314', 'TELLULIMPO E');
INSERT INTO `tb_kecamatan` VALUES ('7314030', '7314', 'WATANG PULU');
INSERT INTO `tb_kecamatan` VALUES ('7314040', '7314', 'BARANTI');
INSERT INTO `tb_kecamatan` VALUES ('7314050', '7314', 'PANCA RIJANG');
INSERT INTO `tb_kecamatan` VALUES ('7314051', '7314', 'KULO');
INSERT INTO `tb_kecamatan` VALUES ('7314060', '7314', 'MARITENGNGAE');
INSERT INTO `tb_kecamatan` VALUES ('7314061', '7314', 'WATANG SIDENRENG');
INSERT INTO `tb_kecamatan` VALUES ('7314070', '7314', 'PITU RIAWA');
INSERT INTO `tb_kecamatan` VALUES ('7314080', '7314', 'DUAPITUE');
INSERT INTO `tb_kecamatan` VALUES ('7314081', '7314', 'PITU RIASE');
INSERT INTO `tb_kecamatan` VALUES ('7315010', '7315', 'SUPPA');
INSERT INTO `tb_kecamatan` VALUES ('7315020', '7315', 'MATTIROSOMPE');
INSERT INTO `tb_kecamatan` VALUES ('7315021', '7315', 'LANRISANG');
INSERT INTO `tb_kecamatan` VALUES ('7315030', '7315', 'MATTIRO BULU');
INSERT INTO `tb_kecamatan` VALUES ('7315040', '7315', 'WATANG SAWITTO');
INSERT INTO `tb_kecamatan` VALUES ('7315041', '7315', 'PALETEANG');
INSERT INTO `tb_kecamatan` VALUES ('7315042', '7315', 'TIROANG');
INSERT INTO `tb_kecamatan` VALUES ('7315050', '7315', 'PATAMPANUA');
INSERT INTO `tb_kecamatan` VALUES ('7315060', '7315', 'CEMPA');
INSERT INTO `tb_kecamatan` VALUES ('7315070', '7315', 'DUAMPANUA');
INSERT INTO `tb_kecamatan` VALUES ('7315071', '7315', 'BATULAPPA');
INSERT INTO `tb_kecamatan` VALUES ('7315080', '7315', 'LEMBANG');
INSERT INTO `tb_kecamatan` VALUES ('7316010', '7316', 'MAIWA');
INSERT INTO `tb_kecamatan` VALUES ('7316011', '7316', 'BUNGIN');
INSERT INTO `tb_kecamatan` VALUES ('7316020', '7316', 'ENREKANG');
INSERT INTO `tb_kecamatan` VALUES ('7316021', '7316', 'CENDANA');
INSERT INTO `tb_kecamatan` VALUES ('7316030', '7316', 'BARAKA');
INSERT INTO `tb_kecamatan` VALUES ('7316031', '7316', 'BUNTU BATU');
INSERT INTO `tb_kecamatan` VALUES ('7316040', '7316', 'ANGGERAJA');
INSERT INTO `tb_kecamatan` VALUES ('7316041', '7316', 'MALUA');
INSERT INTO `tb_kecamatan` VALUES ('7316050', '7316', 'ALLA');
INSERT INTO `tb_kecamatan` VALUES ('7316051', '7316', 'CURIO');
INSERT INTO `tb_kecamatan` VALUES ('7316052', '7316', 'MASALLE');
INSERT INTO `tb_kecamatan` VALUES ('7316053', '7316', 'BAROKO');
INSERT INTO `tb_kecamatan` VALUES ('7317010', '7317', 'LAROMPONG');
INSERT INTO `tb_kecamatan` VALUES ('7317011', '7317', 'LAROMPONG SELATAN');
INSERT INTO `tb_kecamatan` VALUES ('7317020', '7317', 'SULI');
INSERT INTO `tb_kecamatan` VALUES ('7317021', '7317', 'SULI BARAT');
INSERT INTO `tb_kecamatan` VALUES ('7317030', '7317', 'BELOPA');
INSERT INTO `tb_kecamatan` VALUES ('7317031', '7317', 'KAMANRE');
INSERT INTO `tb_kecamatan` VALUES ('7317032', '7317', 'BELOPA UTARA');
INSERT INTO `tb_kecamatan` VALUES ('7317040', '7317', 'BAJO');
INSERT INTO `tb_kecamatan` VALUES ('7317041', '7317', 'BAJO BARAT');
INSERT INTO `tb_kecamatan` VALUES ('7317050', '7317', 'BASSESANGTEMPE');
INSERT INTO `tb_kecamatan` VALUES ('7317051', '7317', 'LATIMOJONG');
INSERT INTO `tb_kecamatan` VALUES ('7317052', '7317', 'BASSESANGTEMPE UTARA');
INSERT INTO `tb_kecamatan` VALUES ('7317060', '7317', 'BUPON');
INSERT INTO `tb_kecamatan` VALUES ('7317061', '7317', 'PONRANG');
INSERT INTO `tb_kecamatan` VALUES ('7317062', '7317', 'PONRANG SELATAN');
INSERT INTO `tb_kecamatan` VALUES ('7317070', '7317', 'BUA');
INSERT INTO `tb_kecamatan` VALUES ('7317080', '7317', 'WALENRANG');
INSERT INTO `tb_kecamatan` VALUES ('7317081', '7317', 'WALENRANG TIMUR');
INSERT INTO `tb_kecamatan` VALUES ('7317090', '7317', 'LAMASI');
INSERT INTO `tb_kecamatan` VALUES ('7317091', '7317', 'WALENRANG UTARA');
INSERT INTO `tb_kecamatan` VALUES ('7317092', '7317', 'WALENRANG BARAT');
INSERT INTO `tb_kecamatan` VALUES ('7317093', '7317', 'LAMASI TIMUR');
INSERT INTO `tb_kecamatan` VALUES ('7318010', '7318', 'BONGGAKARADENG');
INSERT INTO `tb_kecamatan` VALUES ('7318011', '7318', 'SIMBUANG');
INSERT INTO `tb_kecamatan` VALUES ('7318012', '7318', 'RANO');
INSERT INTO `tb_kecamatan` VALUES ('7318013', '7318', 'MAPPAK');
INSERT INTO `tb_kecamatan` VALUES ('7318020', '7318', 'MENGKENDEK');
INSERT INTO `tb_kecamatan` VALUES ('7318021', '7318', 'GANDANG BATU SILANAN');
INSERT INTO `tb_kecamatan` VALUES ('7318030', '7318', 'SANGALLA');
INSERT INTO `tb_kecamatan` VALUES ('7318031', '7318', 'SANGALA SELATAN');
INSERT INTO `tb_kecamatan` VALUES ('7318032', '7318', 'SANGALLA UTARA');
INSERT INTO `tb_kecamatan` VALUES ('7318040', '7318', 'MAKALE');
INSERT INTO `tb_kecamatan` VALUES ('7318041', '7318', 'MAKALE SELATAN');
INSERT INTO `tb_kecamatan` VALUES ('7318042', '7318', 'MAKALE UTARA');
INSERT INTO `tb_kecamatan` VALUES ('7318050', '7318', 'SALUPUTTI');
INSERT INTO `tb_kecamatan` VALUES ('7318051', '7318', 'BITTUANG');
INSERT INTO `tb_kecamatan` VALUES ('7318052', '7318', 'REMBON');
INSERT INTO `tb_kecamatan` VALUES ('7318053', '7318', 'MASANDA');
INSERT INTO `tb_kecamatan` VALUES ('7318054', '7318', 'MALIMBONG BALEPE');
INSERT INTO `tb_kecamatan` VALUES ('7318061', '7318', 'RANTETAYO');
INSERT INTO `tb_kecamatan` VALUES ('7318067', '7318', 'KURRA');
INSERT INTO `tb_kecamatan` VALUES ('7322010', '7322', 'SABBANG');
INSERT INTO `tb_kecamatan` VALUES ('7322020', '7322', 'BAEBUNTA');
INSERT INTO `tb_kecamatan` VALUES ('7322030', '7322', 'MALANGKE');
INSERT INTO `tb_kecamatan` VALUES ('7322031', '7322', 'MALANGKE BARAT');
INSERT INTO `tb_kecamatan` VALUES ('7322040', '7322', 'SUKAMAJU');
INSERT INTO `tb_kecamatan` VALUES ('7322050', '7322', 'BONE-BONE');
INSERT INTO `tb_kecamatan` VALUES ('7322051', '7322', 'TANA LILI');
INSERT INTO `tb_kecamatan` VALUES ('7322120', '7322', 'MASAMBA');
INSERT INTO `tb_kecamatan` VALUES ('7322121', '7322', 'MAPPEDECENG');
INSERT INTO `tb_kecamatan` VALUES ('7322122', '7322', 'RAMPI');
INSERT INTO `tb_kecamatan` VALUES ('7322130', '7322', 'LIMBONG');
INSERT INTO `tb_kecamatan` VALUES ('7322131', '7322', 'SEKO');
INSERT INTO `tb_kecamatan` VALUES ('7325010', '7325', 'BURAU');
INSERT INTO `tb_kecamatan` VALUES ('7325020', '7325', 'WOTU');
INSERT INTO `tb_kecamatan` VALUES ('7325030', '7325', 'TOMONI');
INSERT INTO `tb_kecamatan` VALUES ('7325031', '7325', 'TOMONI TIMUR');
INSERT INTO `tb_kecamatan` VALUES ('7325040', '7325', 'ANGKONA');
INSERT INTO `tb_kecamatan` VALUES ('7325050', '7325', 'MALILI');
INSERT INTO `tb_kecamatan` VALUES ('7325060', '7325', 'TOWUTI');
INSERT INTO `tb_kecamatan` VALUES ('7325070', '7325', 'NUHA');
INSERT INTO `tb_kecamatan` VALUES ('7325071', '7325', 'WASUPONDA');
INSERT INTO `tb_kecamatan` VALUES ('7325080', '7325', 'MANGKUTANA');
INSERT INTO `tb_kecamatan` VALUES ('7325081', '7325', 'KALAENA');
INSERT INTO `tb_kecamatan` VALUES ('7326010', '7326', 'SOPAI');
INSERT INTO `tb_kecamatan` VALUES ('7326020', '7326', 'KESU');
INSERT INTO `tb_kecamatan` VALUES ('7326030', '7326', 'SANGGALANGI');
INSERT INTO `tb_kecamatan` VALUES ('7326040', '7326', 'BUNTAO');
INSERT INTO `tb_kecamatan` VALUES ('7326050', '7326', 'RANTEBUA');
INSERT INTO `tb_kecamatan` VALUES ('7326060', '7326', 'NANGGALA');
INSERT INTO `tb_kecamatan` VALUES ('7326070', '7326', 'TONDON');
INSERT INTO `tb_kecamatan` VALUES ('7326080', '7326', 'TALLUNGLIPU');
INSERT INTO `tb_kecamatan` VALUES ('7326090', '7326', 'RANTEPAO');
INSERT INTO `tb_kecamatan` VALUES ('7326100', '7326', 'TIKALA');
INSERT INTO `tb_kecamatan` VALUES ('7326110', '7326', 'SESEAN');
INSERT INTO `tb_kecamatan` VALUES ('7326120', '7326', 'BALUSU');
INSERT INTO `tb_kecamatan` VALUES ('7326130', '7326', 'SA\'DAN');
INSERT INTO `tb_kecamatan` VALUES ('7326140', '7326', 'BENGKELEKILA');
INSERT INTO `tb_kecamatan` VALUES ('7326150', '7326', 'SESEAN SULOARA');
INSERT INTO `tb_kecamatan` VALUES ('7326160', '7326', 'KAPALA PITU');
INSERT INTO `tb_kecamatan` VALUES ('7326170', '7326', 'DENDE PIONGAN NAPO');
INSERT INTO `tb_kecamatan` VALUES ('7326180', '7326', 'AWAN RANTE KARUA');
INSERT INTO `tb_kecamatan` VALUES ('7326190', '7326', 'RINDINGALO');
INSERT INTO `tb_kecamatan` VALUES ('7326200', '7326', 'BUNTU PEPASAN');
INSERT INTO `tb_kecamatan` VALUES ('7326210', '7326', 'BARUPPU');
INSERT INTO `tb_kecamatan` VALUES ('7371010', '7371', 'MARISO');
INSERT INTO `tb_kecamatan` VALUES ('7371020', '7371', 'MAMAJANG');
INSERT INTO `tb_kecamatan` VALUES ('7371030', '7371', 'TAMALATE');
INSERT INTO `tb_kecamatan` VALUES ('7371031', '7371', 'RAPPOCINI');
INSERT INTO `tb_kecamatan` VALUES ('7371040', '7371', 'MAKASSAR');
INSERT INTO `tb_kecamatan` VALUES ('7371050', '7371', 'UJUNG PANDANG');
INSERT INTO `tb_kecamatan` VALUES ('7371060', '7371', 'WAJO');
INSERT INTO `tb_kecamatan` VALUES ('7371070', '7371', 'BONTOALA');
INSERT INTO `tb_kecamatan` VALUES ('7371080', '7371', 'UJUNG TANAH');
INSERT INTO `tb_kecamatan` VALUES ('7371081', '7371', 'KEPULAUAN SANGKARRANG');
INSERT INTO `tb_kecamatan` VALUES ('7371090', '7371', 'TALLO');
INSERT INTO `tb_kecamatan` VALUES ('7371100', '7371', 'PANAKKUKANG');
INSERT INTO `tb_kecamatan` VALUES ('7371101', '7371', 'MANGGALA');
INSERT INTO `tb_kecamatan` VALUES ('7371110', '7371', 'BIRING KANAYA');
INSERT INTO `tb_kecamatan` VALUES ('7371111', '7371', 'TAMALANREA');
INSERT INTO `tb_kecamatan` VALUES ('7372010', '7372', 'BACUKIKI');
INSERT INTO `tb_kecamatan` VALUES ('7372011', '7372', 'BACUKIKI BARAT');
INSERT INTO `tb_kecamatan` VALUES ('7372020', '7372', 'UJUNG');
INSERT INTO `tb_kecamatan` VALUES ('7372030', '7372', 'SOREANG');
INSERT INTO `tb_kecamatan` VALUES ('7373010', '7373', 'WARA SELATAN');
INSERT INTO `tb_kecamatan` VALUES ('7373011', '7373', 'SENDANA');
INSERT INTO `tb_kecamatan` VALUES ('7373020', '7373', 'WARA');
INSERT INTO `tb_kecamatan` VALUES ('7373021', '7373', 'WARA TIMUR');
INSERT INTO `tb_kecamatan` VALUES ('7373022', '7373', 'MUNGKAJANG');
INSERT INTO `tb_kecamatan` VALUES ('7373030', '7373', 'WARA UTARA');
INSERT INTO `tb_kecamatan` VALUES ('7373031', '7373', 'BARA');
INSERT INTO `tb_kecamatan` VALUES ('7373040', '7373', 'TELLUWANUA');
INSERT INTO `tb_kecamatan` VALUES ('7373041', '7373', 'WARA BARAT');

-- ----------------------------
-- Table structure for tb_kendaraan
-- ----------------------------
DROP TABLE IF EXISTS `tb_kendaraan`;
CREATE TABLE `tb_kendaraan`  (
  `no_reg` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pemilik_ambulance` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `telp` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`no_reg`, `telp`) USING BTREE,
  CONSTRAINT `fk_no_reg` FOREIGN KEY (`no_reg`) REFERENCES `tb_persiapan` (`no_reg`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_kendaraan
-- ----------------------------
INSERT INTO `tb_kendaraan` VALUES ('REG0001', 'Baco', '3423423');

-- ----------------------------
-- Table structure for tb_persiapan
-- ----------------------------
DROP TABLE IF EXISTS `tb_persiapan`;
CREATE TABLE `tb_persiapan`  (
  `no_reg` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `bulan_perkiraan` varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tahun_perkiraan` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_bidan1` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_bidan2` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dana_persalinan` varchar(63) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `metode_kb` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`no_reg`) USING BTREE,
  INDEX `id_bidan1`(`id_bidan1`) USING BTREE,
  INDEX `id_bidan2`(`id_bidan2`) USING BTREE,
  CONSTRAINT `tb_persiapan_ibfk_1` FOREIGN KEY (`no_reg`) REFERENCES `tb_reg_ibu` (`no_reg`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_persiapan_ibfk_2` FOREIGN KEY (`id_bidan1`) REFERENCES `tb_bidan` (`id_bidan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tb_persiapan_ibfk_3` FOREIGN KEY (`id_bidan2`) REFERENCES `tb_bidan` (`id_bidan`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_persiapan
-- ----------------------------
INSERT INTO `tb_persiapan` VALUES ('REG0001', 'Maret', '2019', '001', NULL, 'Ditanggung JKN', 'Spiral/AKDR');

-- ----------------------------
-- Table structure for tb_reg_anak
-- ----------------------------
DROP TABLE IF EXISTS `tb_reg_anak`;
CREATE TABLE `tb_reg_anak`  (
  `id_anak` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `no_reg_ibu` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `no_ket_lahir` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `jk` enum('Laki-laki','Perempuan') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tgl_lahir` date NULL DEFAULT NULL,
  `waktu_lahir` time NULL DEFAULT NULL,
  `jns_kelahiran` enum('Tunggal','Kembar 2','Kembar 3','Kembar 4','Kembar 5','Lainnya') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `kelahiran_ke` enum('1','2','3','4','5','6','7','8','9','10','11','12','13','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `berat_lahir` smallint(5) UNSIGNED NULL DEFAULT NULL,
  `panjang_badan` tinyint(3) UNSIGNED NULL DEFAULT NULL,
  `tempat_lahir` enum('Rumah Sakit','Puskesmas','Rumah Bersalin','Polindes') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nama_tempat_lahir` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `alamat_tempat_lahir` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nama` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nama_saksi1` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nama_saksi2` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_penolong_persalinan` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `umur_ibu` tinyint(3) NULL DEFAULT NULL,
  `umur_ayah` tinyint(3) NULL DEFAULT NULL,
  PRIMARY KEY (`id_anak`, `no_reg_ibu`) USING BTREE,
  INDEX `no_reg_ibu`(`no_reg_ibu`) USING BTREE,
  INDEX `id_penolong_persalinan`(`id_penolong_persalinan`) USING BTREE,
  INDEX `no_ket_lahir`(`no_ket_lahir`) USING BTREE,
  CONSTRAINT `tb_reg_anak_ibfk_1` FOREIGN KEY (`no_reg_ibu`) REFERENCES `tb_reg_ibu` (`no_reg`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_reg_anak_ibfk_2` FOREIGN KEY (`id_penolong_persalinan`) REFERENCES `tb_bidan` (`id_bidan`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_reg_anak
-- ----------------------------
INSERT INTO `tb_reg_anak` VALUES ('RA0001', 'REG0001', '002', 'Laki-laki', '2018-10-16', '23:30:00', 'Kembar 3', NULL, 3000, 20, 'Polindes', '', '', 'Hasan', '', '', '001', 36, 39);
INSERT INTO `tb_reg_anak` VALUES ('RA0002', 'REG0001', '003', 'Laki-laki', '2018-10-16', '23:02:00', 'Kembar 3', NULL, NULL, NULL, 'Puskesmas', '', '', 'Husain', '', '', '001', 36, 39);
INSERT INTO `tb_reg_anak` VALUES ('RA0003', 'REG0001', '', 'Laki-laki', '2018-10-16', '23:05:00', 'Kembar 3', NULL, NULL, NULL, 'Puskesmas', '', '', '', '', '', '001', 36, 39);
INSERT INTO `tb_reg_anak` VALUES ('RA0004', 'REG0003', '001', 'Laki-laki', '2018-10-21', '18:20:00', 'Tunggal', '2', 3000, 20, 'Puskesmas', '', '', 'Abdullah', '', '', '001', NULL, NULL);
INSERT INTO `tb_reg_anak` VALUES ('RA0005', 'REG0004', '123122', 'Laki-laki', '2019-02-23', '21:27:00', 'Kembar 2', '1', 3000, 120, 'Puskesmas', 'Puskesmas Sanrobone', 'Sanrobone', 'Abdul Rahman', 'Abdullah', '', '001', NULL, NULL);
INSERT INTO `tb_reg_anak` VALUES ('RA0006', 'REG0004', NULL, NULL, NULL, NULL, 'Kembar 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for tb_reg_ibu
-- ----------------------------
DROP TABLE IF EXISTS `tb_reg_ibu`;
CREATE TABLE `tb_reg_ibu`  (
  `no_reg` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_bidan` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nik` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nama` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tempat_lahir` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tgl_lahir` date NULL DEFAULT NULL,
  `kehamilan_ke` tinyint(2) NULL DEFAULT NULL,
  `umur_anak_terakhir` tinyint(2) NULL DEFAULT NULL,
  `agama` enum('Islam','Kristen Protestan','Kristen Katolik','Hindu','Buddha','Konghucu') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pendidikan` enum('Tidak Sekolah','SD','SMP','SMU','Akademi','Perguruan Tinggi') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `gol_darah` enum('0','A','B','AB') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pekerjaan` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `no_jkn` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nik_suami` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nama_suami` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tempat_lahir_suami` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tgl_lahir_suami` date NULL DEFAULT NULL,
  `agama_suami` enum('Islam','Kristen Protestan','Kristen Katolik','Hindu','Buddha','Konghucu') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pendidikan_suami` enum('Tidak Sekolah','SD','SMP','SMU','Akademi','Perguruan Tinggi') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `gol_darah_suami` enum('0','A','B','AB') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pekerjaan_suami` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `alamat_rumah` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_kab` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_kec` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `telp` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`no_reg`) USING BTREE,
  INDEX `fk_user_ibu`(`username`) USING BTREE,
  INDEX `fk_id_bidan`(`id_bidan`) USING BTREE,
  CONSTRAINT `fk_id_bidan` FOREIGN KEY (`id_bidan`) REFERENCES `tb_bidan` (`id_bidan`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_reg_ibu
-- ----------------------------
INSERT INTO `tb_reg_ibu` VALUES ('REG0001', '001', '123123123', 'Husniati Huda', 'Gowa', '1989-01-21', 2, 2, 'Islam', 'Perguruan Tinggi', '0', 'IRT', '', '3434234234333', 'Hasan Basri', 'Makassar', '1964-10-25', 'Islam', 'Perguruan Tinggi', '0', 'PNS', 'Jl. Kelapa No. 5', '7309', '7309091', '', 'husni');
INSERT INTO `tb_reg_ibu` VALUES ('REG0002', '001', '232332423', 'Siti Musdalifah', '', NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, '', '', '7309', '', '', 'siti');
INSERT INTO `tb_reg_ibu` VALUES ('REG0003', '001', '763737282348388002', 'Sri Mulyani', 'Ma\'rang', '1979-10-21', 3, 12, 'Islam', 'SMP', NULL, 'IRT', '', '767723233423', 'Wahid', 'Ma\'rang', '1979-10-21', 'Islam', 'Perguruan Tinggi', 'A', 'PNS', 'Jl. Perintis Kemerdekaan', '7305', '7305021', '0823132112322', 'sri');
INSERT INTO `tb_reg_ibu` VALUES ('REG0004', NULL, '56653463545443', 'Husni', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7309', NULL, NULL, 'husni02');

-- ----------------------------
-- Table structure for tb_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user`  (
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `jenis` enum('Ibu','Bidan') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` char(41) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`username`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_user
-- ----------------------------
INSERT INTO `tb_user` VALUES ('bidan1', 'Bidan', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257');
INSERT INTO `tb_user` VALUES ('bidan2', 'Bidan', '*68484737735FFCDEEB048B050540FAAF3C26EB4B');
INSERT INTO `tb_user` VALUES ('husni', 'Ibu', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257');
INSERT INTO `tb_user` VALUES ('husni02', 'Ibu', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257');
INSERT INTO `tb_user` VALUES ('siti', 'Ibu', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257');
INSERT INTO `tb_user` VALUES ('sri', 'Ibu', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257');

SET FOREIGN_KEY_CHECKS = 1;
