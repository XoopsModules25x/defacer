CREATE TABLE defacer_page (
  page_id int(10) unsigned NOT NULL auto_increment,
  page_moduleid int(5) NOT NULL default '0',
  page_title varchar(255) NOT NULL default '',
  page_url varchar(255) NOT NULL default '',
  page_status tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`page_id`)
) ENGINE=MyISAM;

CREATE TABLE defacer_theme (
  theme_id int(10) unsigned NOT NULL default '0',
  theme_name varchar(100) NOT NULL default '',
  PRIMARY KEY  (`theme_id`)
) ENGINE=MyISAM;

CREATE TABLE defacer_meta (
  meta_id int(10) unsigned NOT NULL default '0',
  meta_sitename varchar(100) NOT NULL default '',
  meta_pagetitle varchar(100) NOT NULL default '',
  meta_slogan varchar(100) NOT NULL default '',
  meta_keywords text NOT NULL,
  meta_description text NOT NULL,
  PRIMARY KEY  (`meta_id`)
) ENGINE=MyISAM;

CREATE TABLE defacer_permission (
  permission_id int(10) unsigned NOT NULL auto_increment,
  permission_groups varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`permission_id`)
) ENGINE=MyISAM;
