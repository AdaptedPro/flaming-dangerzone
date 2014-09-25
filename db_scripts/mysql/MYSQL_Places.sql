CREATE TABLE IF NOT EXISTS places
(
    `place_id` int(11) not null auto_increment
    ,`user_id` int(11)
    ,`place_name` varchar(40)
    ,`address_1` varchar(40)
    ,`address_2` varchar(40)
    ,`city` varchar(40)
    ,`state` varchar(40)
    ,`country` varchar(40)
    ,`zip` varchar(40)
    ,PRIMARY KEY(`place_id`)
);