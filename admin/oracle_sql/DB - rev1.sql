--------------------------------------------------------
--  File created - Sunday-May-15-2022   
--------------------------------------------------------
DROP SEQUENCE "SIAMI"."AMI_SEQ";
DROP SEQUENCE "SIAMI"."AREA_SEQ";
DROP SEQUENCE "SIAMI"."CHECKLIST_SEQ";
DROP SEQUENCE "SIAMI"."KRITERIA_SEQ";
DROP SEQUENCE "SIAMI"."PERMISSION_SEQ";
DROP SEQUENCE "SIAMI"."ROLE_SEQ";
DROP SEQUENCE "SIAMI"."STANDAR_SEQ";
DROP SEQUENCE "SIAMI"."STATUS_SEQ";
DROP SEQUENCE "SIAMI"."USER_DETAILS_SEQ";
DROP TABLE "SIAMI"."AMI" cascade constraints;
DROP TABLE "SIAMI"."AREA" cascade constraints;
DROP TABLE "SIAMI"."AUDITEE" cascade constraints;
DROP TABLE "SIAMI"."AUDITOR" cascade constraints;
DROP TABLE "SIAMI"."CHECKLIST" cascade constraints;
DROP TABLE "SIAMI"."KRITERIA" cascade constraints;
DROP TABLE "SIAMI"."PERMISSION" cascade constraints;
DROP TABLE "SIAMI"."ROLE" cascade constraints;
DROP TABLE "SIAMI"."SPM" cascade constraints;
DROP TABLE "SIAMI"."STANDAR" cascade constraints;
DROP TABLE "SIAMI"."STATUS" cascade constraints;
DROP TABLE "SIAMI"."USER_DETAILS" cascade constraints;
DROP FUNCTION "SIAMI"."CUSTOM_AUTH";
DROP FUNCTION "SIAMI"."CUSTOM_HASH";
--------------------------------------------------------
--  DDL for Sequence AMI_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "SIAMI"."AMI_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence AREA_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "SIAMI"."AREA_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 21 CACHE 20 NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence CHECKLIST_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "SIAMI"."CHECKLIST_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence KRITERIA_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "SIAMI"."KRITERIA_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence PERMISSION_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "SIAMI"."PERMISSION_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence ROLE_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "SIAMI"."ROLE_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 21 CACHE 20 NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence STANDAR_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "SIAMI"."STANDAR_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence STATUS_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "SIAMI"."STATUS_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence USER_DETAILS_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "SIAMI"."USER_DETAILS_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 50 CACHE 20 NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Table AMI
--------------------------------------------------------

  CREATE TABLE "SIAMI"."AMI" 
   (	"ID" NUMBER, 
	"SPM_ID" NUMBER, 
	"TAHUN" VARCHAR2(20 BYTE), 
	"JADWAL_MULAI" DATE, 
	"JADWAL_SELESAI" DATE, 
	"IS_TINDAK_LANJUT" VARCHAR2(1 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp
   ) ;
--------------------------------------------------------
--  DDL for Table AREA
--------------------------------------------------------

  CREATE TABLE "SIAMI"."AREA" 
   (	"ID" NUMBER, 
	"NAMA" VARCHAR2(255 BYTE), 
	"IS_PRODI" VARCHAR2(1 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp
   ) ;
--------------------------------------------------------
--  DDL for Table AUDITEE
--------------------------------------------------------

  CREATE TABLE "SIAMI"."AUDITEE" 
   (	"USER_ID" NUMBER, 
	"USER_TYPE" NUMBER
   ) ;
--------------------------------------------------------
--  DDL for Table AUDITOR
--------------------------------------------------------

  CREATE TABLE "SIAMI"."AUDITOR" 
   (	"USER_ID" NUMBER, 
	"USER_TYPE" NUMBER
   ) ;
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
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp
   ) ;
--------------------------------------------------------
--  DDL for Table KRITERIA
--------------------------------------------------------

  CREATE TABLE "SIAMI"."KRITERIA" 
   (	"ID" VARCHAR2(20 BYTE), 
	"STANDAR_ID" NUMBER, 
	"KODE" VARCHAR2(20 BYTE), 
	"KRITERIA" VARCHAR2(225 BYTE), 
	"KET_NILAI" VARCHAR2(225 BYTE), 
	"CATATAN" VARCHAR2(225 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp
   ) ;
--------------------------------------------------------
--  DDL for Table PERMISSION
--------------------------------------------------------

  CREATE TABLE "SIAMI"."PERMISSION" 
   (	"ID" NUMBER, 
	"PERMISSION" VARCHAR2(225 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp
   ) ;
--------------------------------------------------------
--  DDL for Table ROLE
--------------------------------------------------------

  CREATE TABLE "SIAMI"."ROLE" 
   (	"ID" NUMBER, 
	"ROLE" VARCHAR2(225 BYTE), 
	"DESKRIPSI" VARCHAR2(225 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp
   ) ;
--------------------------------------------------------
--  DDL for Table SPM
--------------------------------------------------------

  CREATE TABLE "SIAMI"."SPM" 
   (	"USER_ID" NUMBER, 
	"USER_TYPE" NUMBER
   ) ;
--------------------------------------------------------
--  DDL for Table STANDAR
--------------------------------------------------------

  CREATE TABLE "SIAMI"."STANDAR" 
   (	"ID" NUMBER, 
	"KODE" VARCHAR2(225 BYTE), 
	"STANDAR" VARCHAR2(225 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp
   ) ;
--------------------------------------------------------
--  DDL for Table STATUS
--------------------------------------------------------

  CREATE TABLE "SIAMI"."STATUS" 
   (	"ID" NUMBER, 
	"STATUS" VARCHAR2(225 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp
   ) ;
--------------------------------------------------------
--  DDL for Table USER_DETAILS
--------------------------------------------------------

  CREATE TABLE "SIAMI"."USER_DETAILS" 
   (	"ID" NUMBER, 
	"NET_ID" VARCHAR2(50 BYTE), 
	"ROLE_ID" NUMBER, 
	"AREA_ID" NUMBER, 
	"FOTO" VARCHAR2(255 BYTE), 
	"TELP" VARCHAR2(255 BYTE), 
	"JABATAN" VARCHAR2(255 BYTE), 
	"PERIODE" VARCHAR2(255 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT current_timestamp
   ) ;
REM INSERTING into SIAMI.AMI
SET DEFINE OFF;
REM INSERTING into SIAMI.AREA
SET DEFINE OFF;
Insert into SIAMI.AREA (ID,NAMA,IS_PRODI,CREATED_AT,UPDATED_AT) values ('1','Teknik Informatika','1',to_timestamp('24-04-2022 15.38.43,814000000','DD-MM-RRRR HH24.MI.SSXFF'),to_timestamp('24-04-2022 15.38.43,814000000','DD-MM-RRRR HH24.MI.SSXFF'));
Insert into SIAMI.AREA (ID,NAMA,IS_PRODI,CREATED_AT,UPDATED_AT) values ('2','Perencanaan','0',to_timestamp('24-04-2022 15.38.52,291000000','DD-MM-RRRR HH24.MI.SSXFF'),to_timestamp('24-04-2022 15.38.52,291000000','DD-MM-RRRR HH24.MI.SSXFF'));
REM INSERTING into SIAMI.AUDITEE
SET DEFINE OFF;
REM INSERTING into SIAMI.AUDITOR
SET DEFINE OFF;
REM INSERTING into SIAMI.CHECKLIST
SET DEFINE OFF;
REM INSERTING into SIAMI.KRITERIA
SET DEFINE OFF;
REM INSERTING into SIAMI.PERMISSION
SET DEFINE OFF;
REM INSERTING into SIAMI.ROLE
SET DEFINE OFF;
Insert into SIAMI.ROLE (ID,ROLE,DESKRIPSI,CREATED_AT,UPDATED_AT) values ('1','SPM','SPM dong',to_timestamp('24-04-2022 15.38.07,552000000','DD-MM-RRRR HH24.MI.SSXFF'),to_timestamp('24-04-2022 15.38.07,552000000','DD-MM-RRRR HH24.MI.SSXFF'));
Insert into SIAMI.ROLE (ID,ROLE,DESKRIPSI,CREATED_AT,UPDATED_AT) values ('2','Auditor','Auditor dong',to_timestamp('24-04-2022 15.38.21,204000000','DD-MM-RRRR HH24.MI.SSXFF'),to_timestamp('24-04-2022 15.38.21,204000000','DD-MM-RRRR HH24.MI.SSXFF'));
REM INSERTING into SIAMI.SPM
SET DEFINE OFF;
REM INSERTING into SIAMI.STANDAR
SET DEFINE OFF;
REM INSERTING into SIAMI.STATUS
SET DEFINE OFF;
REM INSERTING into SIAMI.USER_DETAILS
SET DEFINE OFF;
Insert into SIAMI.USER_DETAILS (ID,NET_ID,ROLE_ID,AREA_ID,FOTO,TELP,JABATAN,PERIODE,CREATED_AT,UPDATED_AT) values ('31','carissafarry@gmail.com','1','1','1.jpg','123','spm2345','2022',to_timestamp('09-05-2022 22.14.31,953000000','DD-MM-RRRR HH24.MI.SSXFF'),to_timestamp('09-05-2022 22.14.31,953000000','DD-MM-RRRR HH24.MI.SSXFF'));
Insert into SIAMI.USER_DETAILS (ID,NET_ID,ROLE_ID,AREA_ID,FOTO,TELP,JABATAN,PERIODE,CREATED_AT,UPDATED_AT) values ('32','idris@pens.ac.id','1','2','2.jpg','124','auditor','2022',to_timestamp('09-05-2022 22.15.10,901000000','DD-MM-RRRR HH24.MI.SSXFF'),to_timestamp('09-05-2022 22.15.10,901000000','DD-MM-RRRR HH24.MI.SSXFF'));
Insert into SIAMI.USER_DETAILS (ID,NET_ID,ROLE_ID,AREA_ID,FOTO,TELP,JABATAN,PERIODE,CREATED_AT,UPDATED_AT) values ('33','muarifin@pens.ac.id','2','1','3.jpg','125','auditee','2022',to_timestamp('09-05-2022 22.15.10,905000000','DD-MM-RRRR HH24.MI.SSXFF'),to_timestamp('09-05-2022 22.15.10,905000000','DD-MM-RRRR HH24.MI.SSXFF'));
Insert into SIAMI.USER_DETAILS (ID,NET_ID,ROLE_ID,AREA_ID,FOTO,TELP,JABATAN,PERIODE,CREATED_AT,UPDATED_AT) values ('49','b@b.com','1','1','a.jpg','1233','leha2','2022',to_timestamp('11-05-2022 16.40.52,835000000','DD-MM-RRRR HH24.MI.SSXFF'),to_timestamp('11-05-2022 16.40.52,835000000','DD-MM-RRRR HH24.MI.SSXFF'));
--------------------------------------------------------
--  DDL for Index AREA_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "SIAMI"."AREA_PK" ON "SIAMI"."AREA" ("ID") 
  ;
--------------------------------------------------------
--  DDL for Index AUDITEE_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "SIAMI"."AUDITEE_PK" ON "SIAMI"."AUDITEE" ("USER_ID") 
  ;
--------------------------------------------------------
--  DDL for Index AUDITOR_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "SIAMI"."AUDITOR_PK" ON "SIAMI"."AUDITOR" ("USER_ID") 
  ;
--------------------------------------------------------
--  DDL for Index CHECKLIST_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "SIAMI"."CHECKLIST_PK" ON "SIAMI"."CHECKLIST" ("ID") 
  ;
--------------------------------------------------------
--  DDL for Index KRITERIA_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "SIAMI"."KRITERIA_PK" ON "SIAMI"."KRITERIA" ("ID") 
  ;
--------------------------------------------------------
--  DDL for Index KRITERIA_UK1
--------------------------------------------------------

  CREATE UNIQUE INDEX "SIAMI"."KRITERIA_UK1" ON "SIAMI"."KRITERIA" ("KRITERIA") 
  ;
--------------------------------------------------------
--  DDL for Index PERMISSION_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "SIAMI"."PERMISSION_PK" ON "SIAMI"."PERMISSION" ("ID") 
  ;
--------------------------------------------------------
--  DDL for Index ROLE_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "SIAMI"."ROLE_PK" ON "SIAMI"."ROLE" ("ID") 
  ;
--------------------------------------------------------
--  DDL for Index SPM_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "SIAMI"."SPM_PK" ON "SIAMI"."SPM" ("USER_ID") 
  ;
--------------------------------------------------------
--  DDL for Index STANDAR_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "SIAMI"."STANDAR_PK" ON "SIAMI"."STANDAR" ("ID") 
  ;
--------------------------------------------------------
--  DDL for Index STANDAR_UK1
--------------------------------------------------------

  CREATE UNIQUE INDEX "SIAMI"."STANDAR_UK1" ON "SIAMI"."STANDAR" ("KODE") 
  ;
--------------------------------------------------------
--  DDL for Index STATUS_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "SIAMI"."STATUS_PK" ON "SIAMI"."STATUS" ("ID") 
  ;
--------------------------------------------------------
--  DDL for Index USER_DETAILS_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "SIAMI"."USER_DETAILS_PK" ON "SIAMI"."USER_DETAILS" ("NET_ID") 
  ;
--------------------------------------------------------
--  DDL for Index USER_DETAILS_UK2
--------------------------------------------------------

  CREATE UNIQUE INDEX "SIAMI"."USER_DETAILS_UK2" ON "SIAMI"."USER_DETAILS" ("ID") 
  ;
--------------------------------------------------------
--  DDL for Index AMI_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "SIAMI"."AMI_PK" ON "SIAMI"."AMI" ("ID") 
  ;
--------------------------------------------------------
--  DDL for Trigger AMI_TRG
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."AMI_TRG" 
BEFORE INSERT ON AMI 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT AMI_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;
/
ALTER TRIGGER "SIAMI"."AMI_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger AREA_TRG
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."AREA_TRG" 
BEFORE INSERT ON AREA 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT AREA_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;
/
ALTER TRIGGER "SIAMI"."AREA_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger CHECKLIST_TRG
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."CHECKLIST_TRG" 
BEFORE INSERT ON CHECKLIST 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT CHECKLIST_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;
/
ALTER TRIGGER "SIAMI"."CHECKLIST_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger KRITERIA_TRG
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."KRITERIA_TRG" 
BEFORE INSERT ON KRITERIA 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT KRITERIA_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;
/
ALTER TRIGGER "SIAMI"."KRITERIA_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger PERMISSION_TRG
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."PERMISSION_TRG" 
BEFORE INSERT ON PERMISSION 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT PERMISSION_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;
/
ALTER TRIGGER "SIAMI"."PERMISSION_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger ROLE_TRG
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."ROLE_TRG" 
BEFORE INSERT ON ROLE 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT ROLE_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;
/
ALTER TRIGGER "SIAMI"."ROLE_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger STANDAR_TRG
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."STANDAR_TRG" 
BEFORE INSERT ON STANDAR 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT STANDAR_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;
/
ALTER TRIGGER "SIAMI"."STANDAR_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger STATUS_TRG
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."STATUS_TRG" 
BEFORE INSERT ON STATUS 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT STATUS_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;
/
ALTER TRIGGER "SIAMI"."STATUS_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger USER_DETAILS_TRG
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."USER_DETAILS_TRG" BEFORE INSERT ON USER_DETAILS 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    NULL;
  END COLUMN_SEQUENCES;
END;
/
ALTER TRIGGER "SIAMI"."USER_DETAILS_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger USER_DETAILS_TRG1
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."USER_DETAILS_TRG1" 
BEFORE INSERT ON USER_DETAILS 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT USER_DETAILS_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;
/
ALTER TRIGGER "SIAMI"."USER_DETAILS_TRG1" ENABLE;
--------------------------------------------------------
--  DDL for Function CUSTOM_AUTH
--------------------------------------------------------

  CREATE OR REPLACE FUNCTION "SIAMI"."CUSTOM_AUTH" (p_username in VARCHAR2, p_password in VARCHAR2)
return BOOLEAN
is
  l_password varchar2(4000);
  l_stored_password varchar2(4000);
  l_expires_on date;
  l_count number;
begin
-- First, check to see if the user is in the user table
select count(*) into l_count from demo_users where user_name = p_username;
if l_count > 0 then
  -- First, we fetch the stored hashed password & expire date
  select password, expires_on into l_stored_password, l_expires_on
   from demo_users where user_name = p_username;

  -- Next, we check to see if the user's account is expired
  -- If it is, return FALSE
  if l_expires_on > sysdate or l_expires_on is null then

    -- If the account is not expired, we have to apply the custom hash
    -- function to the password
    l_password := custom_hash(p_username, p_password);

    -- Finally, we compare them to see if they are the same and return
    -- either TRUE or FALSE
    if l_password = l_stored_password then
      return true;
    else
      return false;
    end if;
  else
    return false;
  end if;
else
  -- The username provided is not in the DEMO_USERS table
  return false;
end if;
end;

/
--------------------------------------------------------
--  DDL for Function CUSTOM_HASH
--------------------------------------------------------

  CREATE OR REPLACE FUNCTION "SIAMI"."CUSTOM_HASH" (p_username in varchar2, p_password in varchar2)
return varchar2
is
  l_password varchar2(4000);
  l_salt varchar2(4000) := '61IWI9TPW1UA4X148VWYPJWDZDWZUG';
begin

-- This function should be wrapped, as the hash algorhythm is exposed here.
-- You can change the value of l_salt or the method of which to call the
-- DBMS_OBFUSCATOIN toolkit, but you much reset all of your passwords
-- if you choose to do this.

l_password := utl_raw.cast_to_raw(dbms_obfuscation_toolkit.md5
  (input_string => p_password || substr(l_salt,10,13) || p_username ||
    substr(l_salt, 4,10)));
return l_password;
end;

/
--------------------------------------------------------
--  Constraints for Table AMI
--------------------------------------------------------

  ALTER TABLE "SIAMI"."AMI" ADD CONSTRAINT "AMI_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "SIAMI"."AMI" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table AREA
--------------------------------------------------------

  ALTER TABLE "SIAMI"."AREA" ADD CONSTRAINT "AREA_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "SIAMI"."AREA" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table AUDITEE
--------------------------------------------------------

  ALTER TABLE "SIAMI"."AUDITEE" ADD CONSTRAINT "CHECK_USER_TYPE_1" CHECK ( "USER_TYPE" = 1 ) ENABLE;
  ALTER TABLE "SIAMI"."AUDITEE" ADD CONSTRAINT "AUDITEE_PK" PRIMARY KEY ("USER_ID") ENABLE;
  ALTER TABLE "SIAMI"."AUDITEE" MODIFY ("USER_ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table AUDITOR
--------------------------------------------------------

  ALTER TABLE "SIAMI"."AUDITOR" ADD CONSTRAINT "AUDITOR_CHK1" CHECK ("USER_TYPE" = 2) ENABLE;
  ALTER TABLE "SIAMI"."AUDITOR" ADD CONSTRAINT "AUDITOR_PK" PRIMARY KEY ("USER_ID") ENABLE;
  ALTER TABLE "SIAMI"."AUDITOR" MODIFY ("USER_ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table CHECKLIST
--------------------------------------------------------

  ALTER TABLE "SIAMI"."CHECKLIST" ADD CONSTRAINT "CHECKLIST_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "SIAMI"."CHECKLIST" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table KRITERIA
--------------------------------------------------------

  ALTER TABLE "SIAMI"."KRITERIA" ADD CONSTRAINT "KRITERIA_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "SIAMI"."KRITERIA" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "SIAMI"."KRITERIA" ADD CONSTRAINT "KRITERIA_UK1" UNIQUE ("KRITERIA") ENABLE;
--------------------------------------------------------
--  Constraints for Table PERMISSION
--------------------------------------------------------

  ALTER TABLE "SIAMI"."PERMISSION" ADD CONSTRAINT "PERMISSION_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "SIAMI"."PERMISSION" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table ROLE
--------------------------------------------------------

  ALTER TABLE "SIAMI"."ROLE" ADD CONSTRAINT "ROLE_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "SIAMI"."ROLE" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table SPM
--------------------------------------------------------

  ALTER TABLE "SIAMI"."SPM" ADD CONSTRAINT "CHECK_USER_TYPE_0" CHECK ("USER_TYPE" = 0) ENABLE;
  ALTER TABLE "SIAMI"."SPM" ADD CONSTRAINT "SPM_PK" PRIMARY KEY ("USER_ID") ENABLE;
  ALTER TABLE "SIAMI"."SPM" MODIFY ("USER_ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table STANDAR
--------------------------------------------------------

  ALTER TABLE "SIAMI"."STANDAR" ADD CONSTRAINT "STANDAR_UK1" UNIQUE ("KODE") ENABLE;
  ALTER TABLE "SIAMI"."STANDAR" ADD CONSTRAINT "STANDAR_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "SIAMI"."STANDAR" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table STATUS
--------------------------------------------------------

  ALTER TABLE "SIAMI"."STATUS" ADD CONSTRAINT "STATUS_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "SIAMI"."STATUS" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table USER_DETAILS
--------------------------------------------------------

  ALTER TABLE "SIAMI"."USER_DETAILS" ADD CONSTRAINT "USER_DETAILS_UK2" UNIQUE ("ID") ENABLE;
  ALTER TABLE "SIAMI"."USER_DETAILS" ADD CONSTRAINT "USER_DETAILS_PK" PRIMARY KEY ("NET_ID") ENABLE;
  ALTER TABLE "SIAMI"."USER_DETAILS" MODIFY ("PERIODE" NOT NULL ENABLE);
  ALTER TABLE "SIAMI"."USER_DETAILS" MODIFY ("JABATAN" NOT NULL ENABLE);
  ALTER TABLE "SIAMI"."USER_DETAILS" MODIFY ("TELP" NOT NULL ENABLE);
  ALTER TABLE "SIAMI"."USER_DETAILS" MODIFY ("NET_ID" NOT NULL ENABLE);
  ALTER TABLE "SIAMI"."USER_DETAILS" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Ref Constraints for Table AMI
--------------------------------------------------------

  ALTER TABLE "SIAMI"."AMI" ADD CONSTRAINT "AMI_FK1" FOREIGN KEY ("SPM_ID")
	  REFERENCES "SIAMI"."SPM" ("USER_ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table AUDITEE
--------------------------------------------------------

  ALTER TABLE "SIAMI"."AUDITEE" ADD CONSTRAINT "AUDITEE_FK1" FOREIGN KEY ("USER_ID")
	  REFERENCES "SIAMI"."USER_DETAILS" ("ID") ENABLE;
  ALTER TABLE "SIAMI"."AUDITEE" ADD CONSTRAINT "AUDITEE_FK2" FOREIGN KEY ("USER_TYPE")
	  REFERENCES "SIAMI"."USER_DETAILS" ("ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table AUDITOR
--------------------------------------------------------

  ALTER TABLE "SIAMI"."AUDITOR" ADD CONSTRAINT "AUDITOR_FK1" FOREIGN KEY ("USER_ID")
	  REFERENCES "SIAMI"."USER_DETAILS" ("ID") ENABLE;
  ALTER TABLE "SIAMI"."AUDITOR" ADD CONSTRAINT "AUDITOR_FK2" FOREIGN KEY ("USER_TYPE")
	  REFERENCES "SIAMI"."USER_DETAILS" ("ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table CHECKLIST
--------------------------------------------------------

  ALTER TABLE "SIAMI"."CHECKLIST" ADD CONSTRAINT "CHECKLIST_FK1" FOREIGN KEY ("ID")
	  REFERENCES "SIAMI"."AMI" ("ID") ENABLE;
  ALTER TABLE "SIAMI"."CHECKLIST" ADD CONSTRAINT "CHECKLIST_FK2" FOREIGN KEY ("AUDITEE_ID")
	  REFERENCES "SIAMI"."AUDITEE" ("USER_ID") ENABLE;
  ALTER TABLE "SIAMI"."CHECKLIST" ADD CONSTRAINT "CHECKLIST_FK3" FOREIGN KEY ("ID")
	  REFERENCES "SIAMI"."STATUS" ("ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table KRITERIA
--------------------------------------------------------

  ALTER TABLE "SIAMI"."KRITERIA" ADD CONSTRAINT "KRITERIA_FK1" FOREIGN KEY ("STANDAR_ID")
	  REFERENCES "SIAMI"."STANDAR" ("ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table SPM
--------------------------------------------------------

  ALTER TABLE "SIAMI"."SPM" ADD CONSTRAINT "SPM_FK1" FOREIGN KEY ("USER_ID")
	  REFERENCES "SIAMI"."USER_DETAILS" ("ID") ENABLE;
  ALTER TABLE "SIAMI"."SPM" ADD CONSTRAINT "SPM_FK2" FOREIGN KEY ("USER_TYPE")
	  REFERENCES "SIAMI"."USER_DETAILS" ("ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table USER_DETAILS
--------------------------------------------------------

  ALTER TABLE "SIAMI"."USER_DETAILS" ADD CONSTRAINT "USER_DETAILS_FK1" FOREIGN KEY ("ROLE_ID")
	  REFERENCES "SIAMI"."ROLE" ("ID") ENABLE;
  ALTER TABLE "SIAMI"."USER_DETAILS" ADD CONSTRAINT "USER_DETAILS_FK2" FOREIGN KEY ("AREA_ID")
	  REFERENCES "SIAMI"."AREA" ("ID") ENABLE;
