#
# Table structure for table 'tx_news_domain_model_news'
#
CREATE TABLE tx_news_domain_model_news (

	yawave_publication_id varchar(255) DEFAULT '' NOT NULL,
	news_type varchar(255) DEFAULT '' NOT NULL,
	url varchar(255) DEFAULT '',
	page_height varchar(255) DEFAULT '' NOT NULL,
	cover int(11) unsigned DEFAULT '0',
	metric int(11) unsigned DEFAULT '0',
	main_category int(11) DEFAULT '0' NOT NULL,
	image int(11) unsigned DEFAULT '0',
	header int(11) unsigned DEFAULT '0',
	tool int(11) unsigned DEFAULT '0' NOT NULL,

);


#
# Table structure for table 'tx_yawave_domain_model_tools'
#
CREATE TABLE tx_yawave_domain_model_tools (

	publications int(11) unsigned DEFAULT '0' NOT NULL,

	yawave_tools_id varchar(255) DEFAULT '' NOT NULL,
	tool_type varchar(255) DEFAULT '' NOT NULL,
	tool_label varchar(255) DEFAULT '' NOT NULL,
	icon int(11) unsigned DEFAULT '0' NOT NULL,
	reference int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_yawave_domain_model_icons'
#
CREATE TABLE tx_yawave_domain_model_icons (

	tools int(11) unsigned DEFAULT '0' NOT NULL,

	source varchar(255) DEFAULT '' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	type varchar(255) DEFAULT '' NOT NULL,

);


#
# Table structure for table 'tx_yawave_domain_model_references'
#
CREATE TABLE tx_yawave_domain_model_references (

	tools int(11) unsigned DEFAULT '0' NOT NULL,

	link_url varchar(255) DEFAULT '',

);

#
# Table structure for table 'tx_yawave_domain_model_tools'
#
CREATE TABLE tx_yawave_domain_model_tools (

	publications int(11) unsigned DEFAULT '0' NOT NULL,

);


#
# Table structure for table 'tx_yawave_domain_model_relatedcontent'
#
CREATE TABLE tx_yawave_domain_model_relatedcontent (

	title varchar(255) DEFAULT '' NOT NULL,

);


#
# Table structure for table 'tx_yawave_domain_model_images'
#
CREATE TABLE tx_yawave_domain_model_images (

    url varchar(255) DEFAULT '' NOT NULL,
    image int(11) unsigned DEFAULT '0',
	title varchar(255) DEFAULT '' NOT NULL,
	width varchar(255) DEFAULT '',
	height varchar(255) DEFAULT '',
	focus_x varchar(255) DEFAULT '',
	focus_y varchar(255) DEFAULT '',

);

#
# Table structure for table 'tx_yawave_domain_model_covers'
#
CREATE TABLE tx_yawave_domain_model_covers (

	title varchar(255) DEFAULT '' NOT NULL,
	title_image int(11) unsigned DEFAULT '0' NOT NULL,
	description text,
	images int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_yawave_domain_model_metrics'
#
CREATE TABLE tx_yawave_domain_model_metrics (

	yawave_publication_id varchar(255) DEFAULT '' NOT NULL,
	views varchar(255) DEFAULT '' NOT NULL,
	recipients varchar(255) DEFAULT '' NOT NULL,
	engagements varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_yawave_domain_model_portals'
#
CREATE TABLE tx_yawave_domain_model_portals (

	yawave_portal_id varchar(255) DEFAULT '' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	description text,
	publications int(11) unsigned DEFAULT '0' NOT NULL,
	images int(11) unsigned DEFAULT '0' NOT NULL,
	releted_content int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_yawave_domain_model_update'
#
CREATE TABLE tx_yawave_domain_model_update (

	publication_uuid varchar(255) DEFAULT '' NOT NULL,
	status varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_news_domain_model_tag'
#
CREATE TABLE tx_news_domain_model_tag (

	yawave_tag_id varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'sys_category'
#
CREATE TABLE sys_category (

	yawave_category_id varchar(255) DEFAULT '' NOT NULL,
	yawave_category_parent_id varchar(255) DEFAULT '' NOT NULL,

);


#
# Table structure for table 'tx_yawave_domain_model_headers'
#
CREATE TABLE tx_yawave_domain_model_headers (

	title varchar(255) DEFAULT '' NOT NULL,
	description text,
	image int(11) unsigned DEFAULT '0' NOT NULL,

);




#
# Table structure for table 'tx_yawave_covers_images_mm'
#
CREATE TABLE tx_yawave_covers_images_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_yawave_covers_title_image_mm'
#
CREATE TABLE tx_yawave_covers_title_image_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_yawave_portals_publications_mm'
#
CREATE TABLE tx_yawave_portals_publications_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_yawave_portals_relatedcontent_mm'
#
CREATE TABLE tx_yawave_portals_relatedcontent_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_yawave_portals_images_mm'
#
CREATE TABLE tx_yawave_portals_images_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);


#
# Table structure for table 'tx_yawave_domain_model_images'
#
CREATE TABLE tx_yawave_domain_model_images (

	headers int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_yawave_domain_model_icons'
#
CREATE TABLE tx_yawave_domain_model_icons (

	tools int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_yawave_domain_model_references'
#
CREATE TABLE tx_yawave_domain_model_references (

	tools int(11) unsigned DEFAULT '0' NOT NULL,

);