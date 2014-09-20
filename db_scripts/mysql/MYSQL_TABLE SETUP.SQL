CREATE TABLE IF NOT EXISTS pages
(
    `id` int(11) not null auto_increment
    ,`page_name` varchar(40)
    ,`path` varchar(500)
    ,`position` int(11)
	,`new_window` varchar(50)
    ,`created_by` varchar(40)
	,`updated_on` varchar(50)
    ,`updated_by` varchar(40)
    ,PRIMARY KEY(`id`)
);

INSERT INTO pages
VALUES
(1,'Shop','#','0','false','ajames','','')
,(2,'Blog','#','1','false','ajames','','')
,(3,'Characters','characters','2','false','ajames','','')
,(4,'Galleries','galleries','3','false','ajames','','')
,(5,'About','about','4','false','ajames','','')
,(6,'Fun Stuff','fun','5','false','ajames','','')
,(7,'Contact','contact','6','false','ajames','','');

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

CREATE TABLE IF NOT EXISTS project
(
    `id` int(11) not null auto_increment
    ,`project_name` varchar(40)
    ,`project_description` varchar(500)
	,`created_on` varchar(50)
    ,`created_by` varchar(40)
	,`updated_on` varchar(50)
    ,`updated_by` varchar(40)
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
	,`updated_on` varchar(50)
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
	,`updated_on` varchar(50)
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
	,`updated_on` varchar(50)
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
	,`updated_on` varchar(50)
	,PRIMARY KEY(`id`)
);