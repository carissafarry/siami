--------------------------------------------------------
--  DDL for Table AREA
--------------------------------------------------------

  CREATE TABLE "SIAMI"."AREA" 
   (	"ID" NUMBER, 
	"NAMA" VARCHAR2(255 BYTE), 
	"IS_PRODI" VARCHAR2(1 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP
   )
