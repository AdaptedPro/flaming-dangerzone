CREATE TABLE IF NOT EXISTS facebookuser (
	`id` int(11) NOT NULL AUTO_INCREMENT
	,`email` varchar(150)
	,`first_name` varchar(255)
	,`last_name` varchar(255)
	,`gender` varchar(5)
	,`locale` varchar(10)
	,`link` varchar(255)
	,`username` varchar(255)
	,PRIMARY KEY(`id`)
);