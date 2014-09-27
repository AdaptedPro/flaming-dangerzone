CREATE TABLE IF NOT EXISTS route
(
    `route_id` int(11) not null auto_increment
    ,`user_id` int(11)
    ,`route_name` varchar(40)
    ,`origin` varchar(40)
    ,`destination` varchar(40)
	,`travel_mode` varchar(50)
    ,PRIMARY KEY(`route_id`)
);

CREATE TABLE IF NOT EXISTS location
(
    `location_id` int(11) not null auto_increment
    ,`user_id` int(11)
    ,`location_name` varchar(40)
    ,`address_1` varchar(40)
    ,`address_2` varchar(40)
    ,`city` varchar(40)
    ,`state` varchar(40)
    ,`country` varchar(40)
    ,`zip` varchar(40)
    ,PRIMARY KEY(`location_id`)
);