--------------------------------------------------------
--  DDL for Table PERMISSION
--------------------------------------------------------

  CREATE TABLE "SIAMI"."PERMISSION" 
   (	"ID" NUMBER, 
	"PERMISSION" VARCHAR2(225 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP
   )
