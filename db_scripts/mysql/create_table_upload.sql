CREATE TABLE IF NOT EXISTS upload (
	`ID` int(11) NOT NULL AUTO_INCREMENT
	,`FILE_ID` int(11)		
	,`FILE_PATH` varchar(50)		
	,`FILE_NAME` varchar(50)		
	,`FILE_SIZE` varchar(50)		
	,`APPLICATION_ID` int(11)		
	,`APPLICATION_LABELTEXT` varchar(50)		
	,`CREATED_BY` varchar(50)		
	,`CREATED_AT` varchar(50)		
	,PRIMARY KEY(`ID`)				
);

CREATE TABLE IF NOT EXISTS temp_upload (
	`ID` int(11) NOT NULL AUTO_INCREMENT
	,`FILE_ID` int(11)		
	,`FILE_PATH` varchar(50)		
	,`FILE_NAME` varchar(50)		
	,`FILE_SIZE` varchar(50)		
	,`APPLICATION_ID` int(11)		
	,`APPLICATION_LABELTEXT` varchar(50)		
	,`CREATED_BY` varchar(50)		
	,`CREATED_AT` varchar(50)		
	,PRIMARY KEY(`ID`)				
);