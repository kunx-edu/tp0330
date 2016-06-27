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
CREATE TABLE goods_category (
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

INSERT INTO goods_category VALUES(1,'平板电视',9,3,4,3,'',1);
INSERT INTO goods_category VALUES(2,'空调',9,5,6,3,'',1);
INSERT INTO goods_category VALUES(3,'冰箱',9,7,8,3,'',1);
INSERT INTO goods_category VALUES(4,'取暖器',8,11,14,3,'',1);
INSERT INTO goods_category VALUES(5,'净化器',8,15,16,3,'',1);
INSERT INTO goods_category VALUES(6,'加湿器',8,17,18,3,'',1);
INSERT INTO goods_category VALUES(7,'小太阳',4,12,13,4,'',1);
INSERT INTO goods_category VALUES(8,'生活电器',10,10,19,2,'',1);
INSERT INTO goods_category VALUES(9,'大家电',10,2,9,2,'',1);
INSERT INTO goods_category VALUES(10,'家用电器',0,1,20,1,'',1);