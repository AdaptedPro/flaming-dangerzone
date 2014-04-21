CREATE TABLE IF NOT EXISTS dashboard (
	`id` int(11) NOT NULL AUTO_INCREMENT
	,`user_id` int(11)
	,`layout_id` int(11)
	,`created_on` varchar(50)
	,`updated_on` varchar(50)
	,PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS layout (
	`id` int(11) NOT NULL AUTO_INCREMENT
	,`layout_author_id` int(11)
	,`created_on` varchar(50)
	,`updated_on` varchar(50)
	,PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS layout_authors (
	`id` int(11) NOT NULL AUTO_INCREMENT
	,`layout_author_name` varchar(40)
	,`layout_author_excerpt` varchar(255)
	,`layout_author_bio` varchar(500)		
	,`created_on` varchar(50)
	,`updated_on` varchar(50)
	,PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS facebookuser (
	`id` int(11) NOT NULL AUTO_INCREMENT
	,`email` varchar(20)
	,`first_name` varchar(50)
	,`last_name` varchar(50)
	,`gender` varchar(5)
	,`locale` varchar(10)
	,`link` varchar(255)
	,`username` varchar(50)
	,`created_on` varchar(50)
	,`updatedon` varchar(50)
	,PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS tempuser (
	`id` int(11) NOT NULL AUTO_INCREMENT
	,`email` varchar(50)
	,`first_name` varchar(50)
	,`last_name` varchar(50)
	,`gender` varchar(5)
	,`locale` varchar(10)
	,`link` varchar(255)
	,`username` varchar(50)
	,`hashed_password` varchar(50)
	,`password_salt` varchar(50)
	,`created_on` varchar(50)
	,`updatedon` varchar(50)
	,PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS user (
	`id` int(11) NOT NULL AUTO_INCREMENT
	,`facebook_id` varchar(20)	
	,`email` varchar(50)
	,`first_name` varchar(50)
	,`last_name` varchar(50)
	,`gender` varchar(5)
	,`locale` varchar(10)
	,`link` varchar(255)
	,`username` varchar(50)
	,`hashed_password` varchar(50)
	,`password_salt` varchar(50)	
	,`created_on` varchar(50)
	,`updatedon` varchar(50)
	,PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS login (
	`id` int(11) NOT NULL AUTO_INCREMENT
	,`user_id` int(11)
	,`ip_address` varchar(50)
	,`browser` varchar(255)
	,`login_access_type_d` varchar(10)
	,`created_on` varchar(50)
	,PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS login_access_type (
	`id` int(11) NOT NULL AUTO_INCREMENT
	,`user_id` int(11)
	,`login_access_type` varchar(10)
	,`created_on` varchar(50)
	,PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS updates (
	`id` int(11) NOT NULL AUTO_INCREMENT
	,`user_id` int(11)
	,`created_on` varchar(50)
	,`updatedon` varchar(50)
	,PRIMARY KEY(`id`)
);

--LINK UPDATES TO ALL TABLES TO RECORD ANY CHANGES