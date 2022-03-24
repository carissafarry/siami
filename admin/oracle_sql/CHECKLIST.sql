--------------------------------------------------------
--  DDL for Table CHECKLIST
--------------------------------------------------------

  CREATE TABLE "SIAMI"."CHECKLIST" 
   (	"ID" NUMBER, 
	"AMI_ID" NUMBER, 
	"STATUS_ID" NUMBER, 
	"AUDITEE_ID" NUMBER, 
	"TGL_TERBIT" DATE, 
	"NO_IDENTIFIKASI" VARCHAR2(20 BYTE), 
	"NO_REVISI" VARCHAR2(20 BYTE), 
	"STATUS" VARCHAR2(20 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP
   )