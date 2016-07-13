CREATE DATABASE tp0330 CHARSET utf8

;USE tp0330

;# 供货商表
CREATE TABLE supplier (
  id SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR (50) NOT NULL DEFAULT '' COMMENT '名称',
  intro TEXT COMMENT '简介',
  sort TINYINT NOT NULL DEFAULT 20 COMMENT '排序 数字越小越靠前',
  `status` TINYINT NOT NULL DEFAULT 1 COMMENT '状态-1删除   0隐藏   1正常'
) ENGINE = MYISAM COMMENT '供货商' ;
 
INSERT INTO supplier VALUES(NULL,'北京供货商','北京供货商的简介',20,1);
INSERT INTO supplier VALUES(NULL,'上海供货商','上海供货商的简介',20,1);
INSERT INTO supplier VALUES(NULL,'成都供货商','成都供货商的简介',20,1);
INSERT INTO supplier VALUES(NULL,'武汉供货商','武汉供货商的简介',20,1);
INSERT INTO supplier VALUES(NULL,'重庆供货商','重庆供货商的简介',20,1);


#修改重庆供货商，在其名字后添加_del后缀
;UPDATE supplier SET NAME=CONCAT(NAME,'_del') WHERE id=5







###########   day2   ################
CREATE TABLE `brand` (
  `id` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '名称',
  `intro` TEXT COMMENT '简介',
  `logo` VARCHAR(200) DEFAULT NULL,
  `sort` TINYINT(4) NOT NULL DEFAULT '20' COMMENT '排序 数字越小越靠前',
  `status` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '状态-1删除   0隐藏   1正常',
  PRIMARY KEY (`id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COMMENT='品牌'

;CREATE TABLE article_category(
        `id` TINYINT UNSIGNED  PRIMARY KEY AUTO_INCREMENT,
        `name` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '名称',
        `intro` TEXT COMMENT '简介@textarea',
        `status` TINYINT NOT NULL DEFAULT 1 COMMENT '状态@radio|1=是&0=否',
        `sort` TINYINT  NOT NULL DEFAULT 20 COMMENT '排序',
        `is_help` TINYINT NOT NULL DEFAULT 1 COMMENT '是否是帮助相关的分类'
)ENGINE=MYISAM COMMENT '文章分类'


;#article(文章)
CREATE TABLE article(
        `id` INT UNSIGNED  PRIMARY KEY AUTO_INCREMENT,
        `name` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '名称',
        `article_category_id` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '文章分类',
        `intro` TEXT COMMENT '简介@textarea',
        `status` TINYINT NOT NULL DEFAULT 1 COMMENT '状态@radio|1=是&0=否',
        `sort` TINYINT  NOT NULL DEFAULT 20 COMMENT '排序',
        `inputtime` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '录入时间',
        KEY(article_category_id)
)ENGINE=MYISAM COMMENT '文章'
 
 
#article_content(文章内容)
;CREATE TABLE article_content(
        `article_id` INT UNSIGNED  PRIMARY KEY,
      `content` TEXT COMMENT '文章内容'
)ENGINE=MYISAM COMMENT '文章内容'


###################  day3  ##############################
#goods_category(商品分类)
;CREATE TABLE goods_category (
  id TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR (50) NOT NULL DEFAULT '' COMMENT '名称',
  parent_id TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '父分类',
  lft SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '左边界',
  rght SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '右边界',
  `level` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '级别',
  intro TEXT COMMENT '简介@textarea',
  `status` TINYINT NOT NULL DEFAULT 1 COMMENT '状态@radio|1=是&0=否',
  INDEX (parent_id),
  INDEX (lft, rght)
) ENGINE = MYISAM COMMENT '商品分类'

;INSERT INTO goods_category VALUES(1,'平板电视',9,3,4,3,'',1);
INSERT INTO goods_category VALUES(2,'空调',9,5,6,3,'',1);
INSERT INTO goods_category VALUES(3,'冰箱',9,7,8,3,'',1);
INSERT INTO goods_category VALUES(4,'取暖器',8,11,14,3,'',1);
INSERT INTO goods_category VALUES(5,'净化器',8,15,16,3,'',1);
INSERT INTO goods_category VALUES(6,'加湿器',8,17,18,3,'',1);
INSERT INTO goods_category VALUES(7,'小太阳',4,12,13,4,'',1);
INSERT INTO goods_category VALUES(8,'生活电器',10,10,19,2,'',1);
INSERT INTO goods_category VALUES(9,'大家电',10,2,9,2,'',1);
INSERT INTO goods_category VALUES(10,'家用电器',0,1,20,1,'',1);

####################   day5    #########################
#商品基本信息表
;CREATE TABLE goods (
  `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR (50) NOT NULL DEFAULT '' COMMENT '名称',
  `sn` CHAR (15) NOT NULL DEFAULT '' COMMENT '货号',  # SN20150825000000000id
  `logo` VARCHAR (150) NOT NULL DEFAULT '' COMMENT '商品LOGO',
  `goods_category_id` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品分类',
  `brand_id` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '品牌',
  `supplier_id` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '供货商',
  `market_price` DECIMAL (10, 2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '市场价格',
  `shop_price` DECIMAL (10, 2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '本店价格',
  `stock` INT NOT NULL DEFAULT 0 COMMENT '库存',
  `goods_status` INT NOT NULL DEFAULT 0 COMMENT '商品状态',  #精品 新品 热销  使用二进制表示
  `is_on_sale` TINYINT NOT NULL DEFAULT 1 COMMENT '是否上架',  #1表示上架  0:不上架
  `status` TINYINT NOT NULL DEFAULT 1 COMMENT '状态@radio|1=是&0=否',
  `sort` TINYINT NOT NULL DEFAULT 20 COMMENT '排序',
  `inputtime` INT NOT NULL DEFAULT 0 COMMENT '录入时间',
  INDEX (`goods_category_id`),
  INDEX (`brand_id`),
  INDEX (`supplier_id`)
) ENGINE = INNODB COMMENT '商品'
 
#商品描述表
;CREATE TABLE goods_intro (
  `goods_id` BIGINT PRIMARY KEY COMMENT '商品ID',
  `content` TEXT COMMENT '商品描述'
) ENGINE = INNODB COMMENT '商品描述' 


# 每天创建的商品个数
;CREATE TABLE goods_num (
 `date` DATE PRIMARY KEY,
 num SMALLINT UNSIGNED 
)CHARSET utf8 ENGINE INNODB 

;TRUNCATE goods_num

##商品相册
;CREATE TABLE `goods_gallery` (
   `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` BIGINT(20) DEFAULT NULL COMMENT '商品ID',
  `path` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '商品图片地址',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=INNODB  DEFAULT CHARSET=utf8 COMMENT='商品相册'



#########################  day6   ##################################permission(权限表)
;CREATE TABLE permission (
  `id` SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR (50) NOT NULL DEFAULT '' COMMENT '名称',
  `path` VARCHAR (50) NOT NULL DEFAULT '' COMMENT 'URL',
  `parent_id` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '父分类',
  `lft` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '左边界',
  `rght` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '右边界',
  `level` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '级别',
  `intro` TEXT COMMENT '简介@textarea',
  `status` TINYINT NOT NULL DEFAULT 1 COMMENT '状态@radio|1=是&0=否',
  `sort` TINYINT NOT NULL DEFAULT 20 COMMENT '排序',
  INDEX (parent_id),
  INDEX (lft, rght)
) ENGINE = INNODB COMMENT '权限'
 
 
#role(角色表)
;CREATE TABLE role (
  `id` TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR (50) NOT NULL DEFAULT '' COMMENT '名称',
  `intro` TEXT COMMENT '简介@textarea',
  `status` TINYINT NOT NULL DEFAULT 1 COMMENT '状态@radio|1=是&0=否',
  `sort` TINYINT NOT NULL DEFAULT 20 COMMENT '排序'
) ENGINE = INNODB COMMENT '角色'
 
 
#role_permission(角色权限表)
;CREATE TABLE role_permission (
  `role_id` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '角色ID',
  `permission_id` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '权限ID',
  INDEX (`role_id`)
) ENGINE = INNODB COMMENT '角色权限关系'
 
 
#admin(管理员表)
;CREATE TABLE admin (
  `id` TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `username` VARCHAR (50) NOT NULL DEFAULT '' COMMENT '用户名' UNIQUE,
  `password` CHAR(32) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` CHAR(6) NOT NULL DEFAULT '' COMMENT '盐',
  `email` VARCHAR (30) NOT NULL DEFAULT '' COMMENT '邮箱' UNIQUE,
  `add_time` INT NOT NULL DEFAULT 0 COMMENT '注册时间',
  `last_login_time` INT NOT NULL DEFAULT 0 COMMENT '最后登录时间',
  `last_login_ip` BIGINT NOT NULL DEFAULT 0 COMMENT '最后登录IP'
) ENGINE = INNODB COMMENT '管理员'
 
 
#admin_role(管理员角色)
;CREATE TABLE admin_role (
  `admin_id` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '管理员ID',
  `role_id` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '角色ID',
  INDEX (`admin_id`)
) ENGINE = INNODB COMMENT '管理员角色关系'

######################################   day7  ##################################
#menu(菜单表)
;CREATE TABLE menu (
  `id` TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR (50) NOT NULL DEFAULT '' COMMENT '名称',
  `path` VARCHAR (50) NOT NULL DEFAULT '' COMMENT 'path:module/controller/action',
  `parent_id` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '父分类',
  `lft` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '左边界',
  `rght` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '右边界',
  `level` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '级别',
  `intro` TEXT COMMENT '简介@textarea',
  `status` TINYINT NOT NULL DEFAULT 1 COMMENT '状态@radio|1=是&0=否',
  `sort` TINYINT NOT NULL DEFAULT 20 COMMENT '排序',
  INDEX (`parent_id`),
  INDEX (`lft`, `rght`)
) ENGINE = INNODB COMMENT '菜单表'


#menu(菜单和权限的关系)
;CREATE TABLE menu_permission (
  `menu_id` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '菜单',
  `permission_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '权限ID',
  KEY (`permission_id`)
) ENGINE = INNODB COMMENT '菜单权限' 


##############  day8  #################
#获取role_id
;
SELECT DISTINCT 
  path 
FROM
  admin_role AS ar 
  JOIN role_permission AS rp 
    ON ar.`role_id` = rp.`role_id` 
  JOIN permission AS p 
    ON p.`id` = rp.`permission_id` 
WHERE path <> '' 
  AND admin_id = 1 
  
  
  
 ### 保存用户的自动登陆信息   
 
 ;CREATE TABLE admin_token (
  admin_id INT UNSIGNED PRIMARY KEY,
  token CHAR(40)
) CHARSET utf8 

;TRUNCATE permission

;INSERT INTO `permission` VALUES ('3', '商品管理', '', '0', '32', '41', '1', '商品管理', '1', '50');
INSERT INTO `permission` VALUES ('4', '商品删除', 'Admin/Goods/remove', '3', '33', '34', '2', '商品删除', '1', '50');
INSERT INTO `permission` VALUES ('12', '商品添加', 'Admin/Goods/add', '3', '35', '36', '2', '商品添加', '1', '50');
INSERT INTO `permission` VALUES ('13', '商品修改', 'Admin/Goods/edit', '3', '37', '38', '2', '商品修改', '1', '50');
INSERT INTO `permission` VALUES ('14', '商品列表', 'Admin/Goods/index', '3', '39', '40', '2', '商品列表', '1', '50');
INSERT INTO `permission` VALUES ('15', '文章管理', '', '0', '22', '31', '1', '文章管理', '1', '50');
INSERT INTO `permission` VALUES ('16', '文章发布', 'Admin/Article/add', '15', '23', '24', '2', '文章发布', '1', '50');
INSERT INTO `permission` VALUES ('17', '文章修改', 'Admin/Article/edit', '15', '25', '26', '2', '文章修改', '1', '50');
INSERT INTO `permission` VALUES ('18', '文章删除', 'Admin/Article/remove', '15', '27', '28', '2', '文章删除', '1', '50');
INSERT INTO `permission` VALUES ('19', '文章列表', 'Admin/Article/index', '15', '29', '30', '2', '文章列表', '1', '50');
INSERT INTO `permission` VALUES ('25', '供货商管理', '', '0', '2', '11', '1', '供货商管理', '1', '50');
INSERT INTO `permission` VALUES ('26', '供货商列表', 'Admin/Supplier/index', '25', '3', '4', '2', '供货商列表', '1', '50');
INSERT INTO `permission` VALUES ('27', '供货商添加', 'Admin/Supplier/add', '25', '5', '6', '2', '供货商添加', '1', '50');
INSERT INTO `permission` VALUES ('28', '供货商修改', 'Admin/Supplier/edit', '25', '7', '8', '2', '供货商修改', '1', '50');
INSERT INTO `permission` VALUES ('29', '供货商删除', 'Admin/Supplier/remove', '25', '9', '10', '2', '供货商删除', '1', '50');


## 获取用户可见菜单
;SELECT NAME,path,parent_id,id FROM menu_permission AS mp JOIN menu AS m ON mp.`menu_id`=m.`id` WHERE permission_id IN (1,2,3,4,5)

;SELECT `id`,`parent_id`,`name`,`path` FROM menu m INNER JOIN menu_permission AS mp ON mp.menu_id=m.id WHERE `permission_id` IN ('26','27','28','29','4','12','13','14')



##################################    day9        #######################
#member(会员)
;CREATE TABLE member (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR (50) NOT NULL DEFAULT '' COMMENT '用户名' UNIQUE,
  `password` CHAR(32) NOT NULL DEFAULT '' COMMENT '密码',
  tel CHAR(11) COMMENT '手机号码' ,
  email VARCHAR (30) NOT NULL DEFAULT '' COMMENT 'Email',
  add_time INT NOT NULL DEFAULT 0 COMMENT '加入时间',
  last_login_time INT NOT NULL DEFAULT 0 COMMENT '最后登录时间',
  last_login_ip BIGINT NOT NULL DEFAULT 0 COMMENT '最后登录IP',
  salt CHAR(6) NOT NULL DEFAULT '' COMMENT '盐',
  `status` TINYINT NOT NULL DEFAULT 0 COMMENT '状态: -1 删除  0 禁用  1:正常'
) ENGINE = MYISAM COMMENT '会员' 

;ALTER TABLE member ADD register_token CHAR(32) AFTER email 



####################   day11    ##########################

#goods_click(商品的浏览次数)
;CREATE TABLE goods_click (
  goods_id INT UNSIGNED PRIMARY KEY NOT NULL DEFAULT 0 COMMENT '商品',
  click_times INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '点击次数'
) ENGINE = MYISAM COMMENT '商品的浏览次数' 

;#shopping_car(购物车)
;CREATE TABLE shopping_car (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  goods_id INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品',
  amount INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '数量',
  member_id INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户ID',
  INDEX (member_id)
) ENGINE = MYISAM COMMENT '购物车' 


################################   day12  #########################

;DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` INT(10) UNSIGNED NOT NULL,
  `level` TINYINT(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=5025 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE address (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR (20) NOT NULL DEFAULT '' COMMENT '收货人',
  province_id INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '省份',
  city_id INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '城市',
  area_id INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '区县',
  detail_address VARCHAR (40) NOT NULL DEFAULT 0 COMMENT '详细地址',
  tel CHAR(11) NOT NULL DEFAULT '' COMMENT '手机号',
  is_default TINYINT NOT NULL DEFAULT 0 COMMENT '默认地址',
  member_id INT NOT NULL DEFAULT 0 COMMENT '会员ID'
) ENGINE = MYISAM COMMENT '收货地址'

;ALTER TABLE address 
  ADD province_name VARCHAR (255) AFTER province_id,
  ADD city_name VARCHAR (255) AFTER city_id,
  ADD area_name VARCHAR (255) AFTER area_id 
  
  
###############   day13    ##########################

#delivery(送货方式)
;CREATE TABLE delivery (
  id TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR (20) NOT NULL DEFAULT '' COMMENT '名称',
  price DECIMAL (7, 2) NOT NULL DEFAULT 0 COMMENT '运费',
  intro TEXT COMMENT '简介@textarea',
  `status` TINYINT NOT NULL DEFAULT 1 COMMENT '状态@radio|1=是&0=否',
  sort TINYINT NOT NULL DEFAULT 20 COMMENT '排序',
  is_default TINYINT NOT NULL DEFAULT 0 COMMENT '默认送货方式'
) ENGINE = MYISAM COMMENT '送货方式'

#支付方式
;CREATE TABLE payment (
  `id` TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR (20) NOT NULL DEFAULT '' COMMENT '名称',
  `intro` TEXT COMMENT '简介@textarea',
  `status` TINYINT NOT NULL DEFAULT 1 COMMENT '状态@radio|1=是&0=否',
  `sort` TINYINT NOT NULL DEFAULT 20 COMMENT '排序',
  `is_default` TINYINT NOT NULL DEFAULT 0 COMMENT '默认支付方式'
) ENGINE = MYISAM COMMENT '支付方式' 

#invoice(发票)
;CREATE TABLE invoice (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR (20) NOT NULL DEFAULT '' COMMENT '名称',
  # 如果选择个人,使用当前用户名作为发票的名字, 如果选择公司,就是用填写的内容作为发票的名称
  content TEXT COMMENT '发票内容',
  price DECIMAL (10, 2) NOT NULL DEFAULT 0 COMMENT '发票金额',
  inputtime INT NOT NULL DEFAULT 0 COMMENT '发票时间',
  member_id INT NOT NULL DEFAULT 0 COMMENT '会员ID',
  order_info_id INT NULL DEFAULT 0 COMMENT '订单ID'
) ENGINE = INNODB COMMENT '发票' 


;CREATE TABLE order_info (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  member_id INT NOT NULL DEFAULT 0 COMMENT '会员ID',
  `name` VARCHAR (20) NOT NULL DEFAULT '' COMMENT '收货人',
  province_name VARCHAR (30) NOT NULL DEFAULT 0 COMMENT '省份',
  city_name VARCHAR (30) NOT NULL DEFAULT 0 COMMENT '城市',
  area_name VARCHAR (30) NOT NULL DEFAULT 0 COMMENT '区县',
  detail_address VARCHAR (40) NOT NULL DEFAULT 0 COMMENT '详细地址',
  tel CHAR(11) NOT NULL DEFAULT '' COMMENT '手机号',
  delivery_id TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '配送方式的ID',
  #主要是为了将来的高级查询使用
  delivery_name VARCHAR (30) NOT NULL DEFAULT '' COMMENT '配送方式的名字',#反三范式
  #为了展示订单时方便查看到配送方式的名字
  delivery_price DECIMAL (7, 2) NOT NULL DEFAULT 0 COMMENT '运费',#运费价格可能变化
  pay_type_id TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT '支付方式',
  pay_type_name VARCHAR(30) NOT NULL DEFAULT 1 COMMENT '支付方式名字',#反三范式
  price DECIMAL (10, 2) NOT NULL DEFAULT 0 COMMENT '商品金额',
  `status` TINYINT NOT NULL DEFAULT 1 COMMENT '订单状态 0已取消 1待付款 2待发货 3待收货 4完成',
  trade_no CHAR(30) NOT NULL DEFAULT '' COMMENT '第三方支付的交易号'
) ENGINE = INNODB COMMENT '订单'

#order_info_item(订单明细)
;CREATE TABLE order_info_item (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  order_info_id INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单ID',
  goods_id INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品ID',
  goods_name VARCHAR (32) NOT NULL DEFAULT '' COMMENT '商品的名称',
  logo VARCHAR (255) NOT NULL DEFAULT '' COMMENT 'LOGO',
  price DECIMAL (10, 2) NOT NULL DEFAULT 0 COMMENT '价格',
  amount INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '数量',
  total_price DECIMAL (10, 2) NOT NULL DEFAULT 0 COMMENT '小计'
) ENGINE = INNODB COMMENT '订单明细' 


;TRUNCATE order_info
;TRUNCATE order_info_item
;TRUNCATE invoice



#member_level(会员级别)
 ;CREATE TABLE `member_level` (
  `id` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '名称',
  `bottom` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '积分下限',
  `top` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '积分上限',
  `discount` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '折扣率80 90 100',
  `intro` TEXT COMMENT '简介@textarea',
  `status` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '状态@radio|1=是&0=否',
  `sort` TINYINT(4) NOT NULL DEFAULT '20' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `bottom` (`bottom`,`top`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COMMENT='会员级别'



#member_goods_price(会员商品价格)
;CREATE TABLE `member_goods_price` (
id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `goods_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品ID',
  `member_level_id` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '级别的ID',
  `price` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  KEY `goods_id` (`goods_id`),
  KEY `goods_id_2` (`goods_id`,`member_level_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COMMENT='会员商品价格'

# 在用户表中增加字段保存用户积分
;ALTER TABLE member ADD score INT DEFAULT 0 UNSIGNED AFTER email


####  day14   #####
#修改订单表,添加订单创建时间字段
;ALTER TABLE order_info ADD inputtime INT UNSIGNED 