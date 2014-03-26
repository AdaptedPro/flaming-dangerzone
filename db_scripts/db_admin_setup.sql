/* DB SETUP FOR ADMIN SCEMA */
--/------------------------------------------+	CREATE TABLES
--/ Add indexes to tables with large sets of data.
CREATE OR REPLACE TABLE APPLICATIONS
(
	APPLICATION_ID INTEGER(10) NOT NULL
	,APPLICATION_NAME VARCHAR2(50) NOT NULL
	,CREATED_ON DATE
	,CREATED_BY VARCHAR2(20)
	,UPDATED_ON DATE NOT NULL
	,UPDATED_BY VARCHAR2(20) NOT NULL
);

--/------------------------------------------+	CREATE VIEWS
--/ Each of these views should represent a generated report.

--/------------------------------------------+	CREATE FUNCTIONS

--/EMAIL FUNCTONS

--/------------------------------------------+	CREATE SEQUENCES
CREATE OR REPLACE SEQUENCE APPLICATION_SEQ
	START WITH 1
	INCREMENT BY 1
	CACHE 20
	NOORDER;

	
--/------------------------------------------+	TABLE INSERTS
INSERT INTO APPLICATIONS
VALUES (
	APLICATION_SEQ.NEXTVAL
	,''
	,''
	,''
	,''
	,''
);