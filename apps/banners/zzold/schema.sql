CREATE TABLE banner_stats (
exposures int UNSIGNED NOT NULL,
clicks int UNSIGNED NOT NULL,
ad_id int UNSIGNED NOT NULL,
index index_exposures (exposures),
index index_clicks (clicks),
index index_ad_id (ad_id)
);

CREATE TABLE banners (
ad_id int UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
banner_url varchar (255),
link_url varchar (255),
descr varchar (255),
pub_date datetime,
raw_html text,
active enum ('N','Y') DEFAULT 'Y' NOT NULL,
target varchar (255),
index index_active (active)
);

CREATE TABLE master_zones (
zone_id int UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
descr varchar (255),
next bigint NOT NULL
);

CREATE TABLE zones (
ad_id int UNSIGNED NOT NULL,
zone_id int UNSIGNED NOT NULL,
index index_ad_id (ad_id),
index index_zone_id (zone_id)
);









