CREATE TABLE IF NOT EXISTS facebookuser (
	`id` int(11) NOT NULL AUTO_INCREMENT
	,`email` varchar(50)
	,`first_name` varchar(50)
	,`last_name` varchar(50)
	,`gender` varchar(5)
	,`locale` varchar(10)
	,`link` varchar(255)
	,`username` varchar(50)
	,PRIMARY KEY(`id`)
);