CREATE TABLE AUTH_USER (
USERNAME VARCHAR(255),
HASHED_PASSWORD VARCHAR(255),
CREATED_ON DATE,
IP_ADDRESS VARCHAR(255),
FACEBOOK_ID VARCHAR(255)
);

INSERT INTO AUTH_USER
VALUES (
'ADAM.JAMES@ADAPTEDPRO.NET'
,'PASSWORD'
, ''
,''
,''
);

--INSERT INTO AUTH_USER VALUES ( 'ADAM.JAMES@ADAPTEDPRO.NET' ,'PASSWORD' , '' ,'' ,'' )
--ALTER TABLE `user` ADD `created_on` DATE NOT NULL , ADD `ip_address` VARCHAR(20) NOT NULL , ADD `facebook_id` VARCHAR(50) NOT NULL ;