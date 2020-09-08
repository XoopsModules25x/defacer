CREATE TABLE defacer_page (
  page_id       INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  page_moduleid INT(5)           NOT NULL DEFAULT '0',
  page_title    VARCHAR(255)     NOT NULL DEFAULT '',
  page_url      VARCHAR(255)     NOT NULL DEFAULT '',
  page_status   TINYINT(1)       NOT NULL DEFAULT '1',
  PRIMARY KEY (`page_id`)
)
  ENGINE = MyISAM;

CREATE TABLE defacer_theme (
  theme_id   INT(10) UNSIGNED NOT NULL DEFAULT '0',
  theme_name VARCHAR(100)     NOT NULL DEFAULT '',
  PRIMARY KEY (`theme_id`)
)
  ENGINE = MyISAM;

CREATE TABLE defacer_meta (
  meta_id          INT(10) UNSIGNED NOT NULL DEFAULT '0',
  meta_sitename    VARCHAR(100)     NOT NULL DEFAULT '',
  meta_pagetitle   VARCHAR(100)     NOT NULL DEFAULT '',
  meta_slogan      VARCHAR(100)     NOT NULL DEFAULT '',
  meta_keywords    TEXT             NOT NULL,
  meta_description TEXT             NOT NULL,
  PRIMARY KEY (`meta_id`)
)
  ENGINE = MyISAM;

CREATE TABLE defacer_permission (
  permission_id     INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  permission_groups VARCHAR(255)     NOT NULL DEFAULT '',
  PRIMARY KEY (`permission_id`)
)
  ENGINE = MyISAM;
