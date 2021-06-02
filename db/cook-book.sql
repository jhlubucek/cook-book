/*
Navicat MySQL Data Transfer

Source Server         : rpi_test
Source Server Version : 50560
Source Host           : 192.168.1.166:3306
Source Database       : cook_book

Target Server Type    : MYSQL
Target Server Version : 50560
File Encoding         : 65001

Date: 2021-06-02 17:33:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`name`  varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci
AUTO_INCREMENT=8

;

-- ----------------------------
-- Records of category
-- ----------------------------
BEGIN;
INSERT INTO `category` VALUES ('1', 'česká kuchyně'), ('2', 'indie'), ('3', 'vege'), ('6', 'test'), ('7', 'sladké');
COMMIT;

-- ----------------------------
-- Table structure for category_type
-- ----------------------------
DROP TABLE IF EXISTS `category_type`;
CREATE TABLE `category_type` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`name`  varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci
AUTO_INCREMENT=1

;

-- ----------------------------
-- Records of category_type
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for image_temporary
-- ----------------------------
DROP TABLE IF EXISTS `image_temporary`;
CREATE TABLE `image_temporary` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`file_name`  varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
`created`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`user_id`  int(11) NOT NULL ,
PRIMARY KEY (`id`, `user_id`),
FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
INDEX `fk_image_temporary_user1_idx` (`user_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci
AUTO_INCREMENT=62

;

-- ----------------------------
-- Records of image_temporary
-- ----------------------------
BEGIN;
INSERT INTO `image_temporary` VALUES ('1', '898cd1a12a8ec6fd8b5067eb8ce4c772.jpg', '2021-05-25 23:30:07', '1'), ('2', '79de1fe0c643067f7c639940085da54a.jpg', '2021-05-25 23:38:56', '1'), ('3', 'a6e472bd5658298b454102b03648aea4.jpg', '2021-05-25 23:39:21', '1'), ('4', 'a06feaf250f5434215c3d97b66aef648.png', '2021-05-27 20:55:57', '1'), ('5', '8b1f9d6901347892440cb683297efe8f.jpg', '2021-05-28 15:57:21', '1'), ('6', '4341590555e1ea13ceaea070be667901.jpg', '2021-05-28 15:57:47', '1'), ('7', 'e99e20fc36d3f9a2e8092fe170249adc.jpg', '2021-05-28 16:00:56', '1'), ('8', '5fc2f8cbfe9161d36efd85bb7b6e3456.jpg', '2021-05-28 16:01:12', '1'), ('9', '4b54cc210ef6d8a7848008981f79d598.jpg', '2021-05-28 16:02:01', '1'), ('10', 'bf93257cd1c74315d6078187c12576be.jpg', '2021-05-28 16:02:27', '1'), ('11', '3738c931c7389032eabe68d1e1f02fec.jpg', '2021-05-28 16:03:54', '1'), ('12', 'ca2dfecbbae9efb85d10fccc5db7f3a4.jpg', '2021-05-28 16:17:42', '1'), ('13', '5ca94ab36d87709b21b30f41d3aeea78.jpg', '2021-05-28 16:18:08', '1'), ('14', 'be096352d3fdd1282ff29f5142153fe5.jpg', '2021-05-28 16:18:28', '1'), ('15', 'd464fa2bfb296db18aedb70a694c6f34.jpg', '2021-05-28 16:19:14', '1'), ('16', '476ea84b41e770aa04f453b0b16b94ce.jpg', '2021-05-28 16:38:12', '1'), ('17', '892ebdcaa21f73228f615c5a87e73aa3.jpg', '2021-05-28 16:38:40', '1'), ('18', 'e2b1e12432b87383d9981ed8e0eb0f11.jpg', '2021-05-28 16:39:53', '1'), ('19', '225342de633bba53ff846971a21e4b21.jpg', '2021-05-28 16:49:04', '1'), ('20', '91ea19e46f9f2cb993b6f619d5b6cd35.jpg', '2021-05-28 16:49:33', '1'), ('21', '70e78d10df7ee539de5097c27586abe9.jpg', '2021-05-28 16:50:12', '1'), ('22', 'a17244a2528960a465142c3f020fa2f2.jpg', '2021-05-28 16:50:44', '1'), ('23', 'fc71de8871471665842f013e9f4e3bb9.jpg', '2021-05-28 16:53:09', '1'), ('24', '672e01b9c2fc7cebf1c5d90629f4ba9a.jpg', '2021-05-28 16:54:35', '1'), ('25', 'f82b3c64077cf0789f2a403116cc1f0e.jpg', '2021-05-28 16:55:10', '1'), ('26', '2726353aecbb24d5401a4aac4613ae35.jpg', '2021-05-28 16:56:36', '1'), ('27', 'b850612221d7b971e5ab583957c5333d.jpg', '2021-05-28 16:57:16', '1'), ('28', '116f7dd994c44befa4a643fab2dddd6b.jpg', '2021-05-28 16:57:19', '1'), ('29', '018f1daa3f41356fe00cc8cc2da18b71.jpg', '2021-05-28 16:58:24', '1'), ('30', 'cc2d48095740379df3cca0d2908eb268.jpg', '2021-05-28 17:02:53', '1'), ('31', 'cab0b7d4e94a75c80903cacd7198f418.jpg', '2021-05-28 17:08:13', '1'), ('32', '6abdd5229dbd05e7f74da36eddf81e40.jpg', '2021-05-28 22:05:50', '1'), ('33', 'cfc28b3a8da8aa11b2dbcab963f6dda9.jpg', '2021-05-28 22:06:08', '1'), ('34', '584bfaca59e6b6925da998f40039121c.jpg', '2021-05-28 22:07:51', '1'), ('35', '42d933c13fa69bc17f4fa0497def93dc.jpg', '2021-05-28 22:08:07', '1'), ('36', 'f71fab4387fcd9f42d9798b86dd467ad.jpg', '2021-05-28 22:13:44', '1'), ('37', 'e500f9331ba5544f169b6c05eb0a8b5e.jpg', '2021-05-28 22:46:59', '1'), ('38', '2746d7a7426f745aed78afbee532ca3e.jpg', '2021-05-28 22:47:47', '1'), ('39', '6caedd34088afa4f2f6af481e3810fdf.jpg', '2021-05-28 22:56:12', '1'), ('40', '47bfa5f84721b1a1261017ed63f31ef0.jpg', '2021-05-28 22:57:52', '1'), ('41', '5949482207d1f26b83fe52559fa81e7f.jpg', '2021-05-28 22:58:24', '1'), ('42', 'f6c92037e5a1c90584f6602a5cb321d3.jpg', '2021-05-28 23:03:54', '1'), ('43', '17660a72d653fd03ed3bcd6351909c09.jpg', '2021-05-28 23:04:23', '1'), ('44', '68e4e20fa12a630656fb9f4333f93316.jpg', '2021-05-28 23:04:35', '1'), ('45', '70b1a94dfc6fdeaecc06d5fe90f66728.jpg', '2021-05-28 23:05:07', '1'), ('46', '2408601cc6f6186f594fc17824ba7ba6.jpg', '2021-05-28 23:05:40', '1'), ('47', '1be1f03d51f5096dcb1085ca39c9872e.jpg', '2021-05-28 23:06:30', '1'), ('48', '7e95969be1549524e83b730595e65af1.jpg', '2021-05-28 23:07:48', '1'), ('49', '1eee869292963671d0d4c9aaf515bd34.jpg', '2021-05-28 23:08:57', '1'), ('50', '467526da1c008c2f731cd688b9f4902c.jpg', '2021-05-28 23:09:06', '1'), ('51', '673917c8cf1fd454104af919ac1680a0.jpg', '2021-05-28 23:11:24', '1'), ('52', 'b245ef1a7571d87793893339f34af2a8.jpg', '2021-05-28 23:13:39', '1'), ('53', 'a5d1fc213a2828a4c4d6e0c4945b7184.jpg', '2021-05-28 23:14:30', '1'), ('54', '4c4c8df7414e58175f7ab0077712630c.jpg', '2021-05-28 23:15:01', '1'), ('55', 'caffa5512cbed0e157552a63b2a9253d.jpg', '2021-05-29 10:24:25', '1'), ('56', '3ee9b767a8e43d286911fb98d4b5d704.jpg', '2021-05-29 10:24:46', '1'), ('57', 'c0cd780d476e25e17e8c81260c6571d1.jpg', '2021-05-29 13:43:12', '1'), ('58', '3901476e25863ddc4dce74a6855c155b.png', '2021-05-29 15:19:40', '1'), ('59', '9433342d96ada6b9a3851f857723a687.jpg', '2021-05-31 00:21:48', '1'), ('60', 'ec839840670350b098eb52a4a6328093.jpg', '2021-05-31 12:25:29', '1'), ('61', 'a268a36bfa16bd925b87e7363110668a.jpg', '2021-05-31 12:27:12', '1');
COMMIT;

-- ----------------------------
-- Table structure for ingredient
-- ----------------------------
DROP TABLE IF EXISTS `ingredient`;
CREATE TABLE `ingredient` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`name`  varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
`unit`  varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
`amount`  varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
`order`  int(2) NOT NULL ,
`recipe_id`  int(11) NOT NULL ,
PRIMARY KEY (`id`, `recipe_id`),
FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
INDEX `fk_ingredient_recepie1_idx` (`recipe_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci
AUTO_INCREMENT=87

;

-- ----------------------------
-- Records of ingredient
-- ----------------------------
BEGIN;
INSERT INTO `ingredient` VALUES ('75', 'cibule', 'piece', '25', '0', '92'), ('76', 'sůl', 'g', '12', '0', '92'), ('77', 'mouka', 'Kg', '25', '0', '92'), ('81', 'plain flour', 'g', '100', '0', '96'), ('82', 'milk', 'ml', '300', '0', '96'), ('83', 'egg', ' ', '2', '0', '96'), ('84', 'oil', ' ', '1', '0', '96'), ('85', 'sugar', ' ', '', '0', '96'), ('86', 'brambory typu C', 'Kg', '1', '0', '94');
COMMIT;

-- ----------------------------
-- Table structure for recipe
-- ----------------------------
DROP TABLE IF EXISTS `recipe`;
CREATE TABLE `recipe` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`name`  varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
`text`  varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
`image`  varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL ,
`user_id`  int(11) NOT NULL ,
PRIMARY KEY (`id`, `user_id`),
FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
INDEX `fk_recepie_user1_idx` (`user_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci
AUTO_INCREMENT=97

;

-- ----------------------------
-- Records of recipe
-- ----------------------------
BEGIN;
INSERT INTO `recipe` VALUES ('92', 'zelná polévka', 'Na olivovém oleji zpěňte nadrobno nakrájenou cibuli do světlo zlaté barvy. \r\n\r\nDo hrnce dejte nakrájenou mrkev, brambory a zelí, přidejte osmahnutou cibulku, vše zalijte vývarem kuřecím či zeleninovým a přiveďte k varu.\r\n\r\nMezitím na rajčatech udělejte křížek a spařte vařicí vodou, poté je oloupejte a pokrájejte na kousky. Přidejte k vroucí polévce (nebo můžete zvolit plechovku rajčat). Polévku vařte 10 minut.\r\n\r\nMezitím připravte směs na kuličky. Cibuli a petrželku pokrájejte nadrobno a přidejte k masu a promíchejte. Dále přidejte žloutek, strouhanku, sůl a pepř a vše pořádně promíchejte. Poté tvarujte kuličky.\r\n\r\nDo vroucí polévky vhoďte kuličky a vařte 15–20 minut. Nakonec polévku dochuťte solí, pepřem, lžičkou cukru a vmíchejte kysanou smetanu a nasekaný kopr.\r\n\r\nPolévka je skvělá s čerstvým pečivem. <p>asdfsdf</p>', 'bc75ea827dad7b83794f694cdd4293e2.jpg', '4'), ('94', 'Bramborové', 'Polovinu brambor uvařte a nechte zchladnout. Zbylou polovinu syrových brambor oškrábejte, nastrouhejte najemno, osolte a vymačkejte z nich vodu.\r\n\r\nUvařené brambory oloupejte, prolisujte a smíchejte s nastrouhanými a moukou. Tvořte knedlíčky, které pomalu vařte asi 6 minut.\r\n\r\nDrbáky vyndejte a promíchejte s kouskem sádla, díky kterému se neslepí. <b>test<b>', '9433342d96ada6b9a3851f857723a687.jpg', '4'), ('96', 'Easy pancakes', 'STEP 1 Put 100g plain flour, 2 large eggs, 300ml milk, 1 tbsp sunflower or vegetable oil and a pinch of salt into a bowl or large jug, then whisk to a smooth batter. \r\n\r\nSTEP 2 Set aside for 30 mins to rest if you have time, or start cooking straight away. \r\n\r\nSTEP 3 Set a medium frying pan or crêpe pan over a medium heat and carefully wipe it with some oiled kitchen paper. \r\n\r\nSTEP 4 When hot, cook your pancakes for 1 min on each side until golden, keeping them warm in a low oven as you go. \r\n\r\nSTEP 5 Serve with lemon wedges and caster sugar, or your favourite filling. Once cold, you can layer the pancakes between baking parchment, then wrap in cling film and freeze for up to 2 months.', 'a268a36bfa16bd925b87e7363110668a.jpg', '4');
COMMIT;

-- ----------------------------
-- Table structure for recipe_has_category
-- ----------------------------
DROP TABLE IF EXISTS `recipe_has_category`;
CREATE TABLE `recipe_has_category` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`category_id`  int(11) NOT NULL ,
`recipe_id`  int(11) NOT NULL ,
PRIMARY KEY (`id`, `category_id`, `recipe_id`),
FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
INDEX `fk_category_has_recepie_recepie1_idx` (`recipe_id`) USING BTREE ,
INDEX `fk_category_has_recepie_category1_idx` (`category_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci
AUTO_INCREMENT=71

;

-- ----------------------------
-- Records of recipe_has_category
-- ----------------------------
BEGIN;
INSERT INTO `recipe_has_category` VALUES ('62', '1', '92'), ('63', '2', '92'), ('64', '3', '92'), ('69', '2', '94'), ('70', '3', '94'), ('67', '3', '96'), ('68', '7', '96');
COMMIT;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`username`  varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
`email`  varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
`password`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
`roles`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci
AUTO_INCREMENT=7

;

-- ----------------------------
-- Records of user
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('1', 'kokos2', 'kaa@kaa.kk', '$argon2id$v=19$m=65536,t=4,p=1$ZHFaS24zR2xMZ2RBTVdBNA$dnXpVHWzvBMirnB/Awj45zvBn+Hcxgke8wxqH9rFzJ8', '[]'), ('2', 'kokos3', 'k@k.cz', '$argon2id$v=19$m=65536,t=4,p=1$L1NCWGN3bVcyVU5vb3B3MQ$qgdYjHERo8OpoRcfuVLaMb0xoCzeXfHYDdK+KMwxLSw', '[]'), ('3', 'kokos4', 'k@k.kk', '$argon2id$v=19$m=65536,t=4,p=1$UWwyd0RsNjhGeUs5RHBBcQ$1j11LzJjvS6U1XIKSXBIscpGlI7oERzj8gUCProMHrs', '[]'), ('4', 'admin1', 'admin@as.ad', '$argon2id$v=19$m=65536,t=4,p=1$aDdRQWU1WlhTZURLU1NCYg$a5mAE869cGXgoXy66HHygCirKWpoPWuyC7u8ucZIC/c', '[\"admin\"]'), ('5', 'kokos8', 'koko@koko.cz', '$argon2id$v=19$m=65536,t=4,p=1$QmNGZTdwTmxpb1ZVejI4NA$IMdAHMZSOXBonvJKFGRM4OdFRrUQqNkvHtda3ExVtmY', '[]'), ('6', 'Gardon', 'garo01@vse.cz', '$argon2id$v=19$m=65536,t=4,p=1$ejA1dW1Bdk1KVmk2SC81VA$6KxsS4mGc+VHzNNoE6zziYeVoBrRsspWPT2URXJAlqw', '[]');
COMMIT;

-- ----------------------------
-- Auto increment value for category
-- ----------------------------
ALTER TABLE `category` AUTO_INCREMENT=8;

-- ----------------------------
-- Auto increment value for category_type
-- ----------------------------
ALTER TABLE `category_type` AUTO_INCREMENT=1;

-- ----------------------------
-- Auto increment value for image_temporary
-- ----------------------------
ALTER TABLE `image_temporary` AUTO_INCREMENT=62;

-- ----------------------------
-- Auto increment value for ingredient
-- ----------------------------
ALTER TABLE `ingredient` AUTO_INCREMENT=87;

-- ----------------------------
-- Auto increment value for recipe
-- ----------------------------
ALTER TABLE `recipe` AUTO_INCREMENT=97;

-- ----------------------------
-- Auto increment value for recipe_has_category
-- ----------------------------
ALTER TABLE `recipe_has_category` AUTO_INCREMENT=71;

-- ----------------------------
-- Auto increment value for user
-- ----------------------------
ALTER TABLE `user` AUTO_INCREMENT=7;
SET FOREIGN_KEY_CHECKS=1;
