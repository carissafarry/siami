--------------------------------------------------------
--  DDL for Table STANDAR
--------------------------------------------------------

  CREATE TABLE "SIAMI"."STANDAR" 
   (	"ID" NUMBER, 
	"KODE" VARCHAR2(225 BYTE), 
	"STANDAR" VARCHAR2(225 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP
   )
