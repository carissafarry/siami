--------------------------------------------------------
--  DDL for Table ROLE
--------------------------------------------------------

  CREATE TABLE "SIAMI"."ROLE" 
   (	"ID" NUMBER, 
	"ROLE" VARCHAR2(225 BYTE), 
	"DESKRIPSI" VARCHAR2(225 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP
   )
