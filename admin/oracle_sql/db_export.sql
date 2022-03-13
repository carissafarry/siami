--------------------------------------------------------
--  File created - Friday-March-11-2022   
--------------------------------------------------------
DROP SEQUENCE "AMI_SEQ";
DROP SEQUENCE "AREA_SEQ";
DROP SEQUENCE "AUDITEE_SEQ";
DROP SEQUENCE "AUDITOR_SEQ";
DROP SEQUENCE "CHECKLIST_SEQ";
DROP SEQUENCE "KRITERIA_SEQ";
DROP SEQUENCE "PERMISSION_SEQ";
DROP SEQUENCE "ROLE_SEQ";
DROP SEQUENCE "SPM_SEQ";
DROP SEQUENCE "STANDAR_SEQ";
DROP SEQUENCE "STATUS_SEQ";
DROP SEQUENCE "USERS_SEQ";
--DROP TABLE "AMI" cascade constraints;
DROP TABLE "AREA" cascade constraints;
--DROP TABLE "AUDITEE" cascade constraints;
--DROP TABLE "AUDITOR" cascade constraints;
--DROP TABLE "CHECKLIST" cascade constraints;
--DROP TABLE "KRITERIA" cascade constraints;
--DROP TABLE "PERMISSION" cascade constraints;
--DROP TABLE "ROLE" cascade constraints;
--DROP TABLE "SPM" cascade constraints;
--DROP TABLE "STANDAR" cascade constraints;
--DROP TABLE "STATUS" cascade constraints;
--DROP TABLE "USERS" cascade constraints;
--------------------------------------------------------
--  DDL for Sequence AMI_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "AMI_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE;
--------------------------------------------------------
--  DDL for Sequence AREA_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "AREA_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 21 CACHE 20 NOORDER  NOCYCLE;
--------------------------------------------------------
--  DDL for Sequence AUDITEE_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "AUDITEE_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE;
--------------------------------------------------------
--  DDL for Sequence AUDITOR_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "AUDITOR_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE;
--------------------------------------------------------
--  DDL for Sequence CHECKLIST_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "CHECKLIST_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE;
--------------------------------------------------------
--  DDL for Sequence KRITERIA_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "KRITERIA_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE;
--------------------------------------------------------
--  DDL for Sequence PERMISSION_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "PERMISSION_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE;
--------------------------------------------------------
--  DDL for Sequence ROLE_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "ROLE_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 21 CACHE 20 NOORDER  NOCYCLE;
--------------------------------------------------------
--  DDL for Sequence SPM_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "SPM_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE;
--------------------------------------------------------
--  DDL for Sequence STANDAR_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "STANDAR_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE;
--------------------------------------------------------
--  DDL for Sequence STATUS_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "STATUS_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE;
--------------------------------------------------------
--  DDL for Sequence USERS_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "USERS_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE;
--------------------------------------------------------
--  DDL for Table AMI
--------------------------------------------------------

  CREATE TABLE "AMI" 
   (	"ID" NUMBER, 
	"SPM_ID" NUMBER, 
	"TAHUN" VARCHAR2(20 BYTE), 
	"JADWAL_MULAI" DATE, 
	"JADWAL_SELESAI" DATE, 
	"IS_TINDAK_LANJUT" VARCHAR2(1 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP
   );
--------------------------------------------------------
--  DDL for Table AREA
--------------------------------------------------------

  CREATE TABLE "AREA" 
   (	"ID" NUMBER, 
	"NAMA" VARCHAR2(255 BYTE), 
	"IS_PRODI" VARCHAR2(1 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP
   );
--------------------------------------------------------
--  DDL for Table AUDITEE
--------------------------------------------------------

  CREATE TABLE "AUDITEE" 
   (	"USER_ID" NUMBER, 
	"USER_TYPE" NUMBER
   );
--------------------------------------------------------
--  DDL for Table AUDITOR
--------------------------------------------------------

  CREATE TABLE "AUDITOR" 
   (	"USER_ID" NUMBER, 
	"USER_TYPE" NUMBER
   );
--------------------------------------------------------
--  DDL for Table CHECKLIST
--------------------------------------------------------

  CREATE TABLE "CHECKLIST" 
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
   );
--------------------------------------------------------
--  DDL for Table KRITERIA
--------------------------------------------------------

  CREATE TABLE "KRITERIA" 
   (	"ID" VARCHAR2(20 BYTE), 
	"STANDAR_ID" NUMBER, 
	"KODE" VARCHAR2(20 BYTE), 
	"KRITERIA" VARCHAR2(225 BYTE), 
	"KET_NILAI" VARCHAR2(225 BYTE), 
	"CATATAN" VARCHAR2(225 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP
   );
--------------------------------------------------------
--  DDL for Table PERMISSION
--------------------------------------------------------

  CREATE TABLE "PERMISSION" 
   (	"ID" NUMBER, 
	"PERMISSION" VARCHAR2(225 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP
   );
--------------------------------------------------------
--  DDL for Table ROLE
--------------------------------------------------------

  CREATE TABLE "ROLE" 
   (	"ID" NUMBER, 
	"ROLE" VARCHAR2(225 BYTE), 
	"DESKRIPSI" VARCHAR2(225 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP
   );
--------------------------------------------------------
--  DDL for Table SPM
--------------------------------------------------------

  CREATE TABLE "SPM" 
   (	"USER_ID" NUMBER, 
	"USER_TYPE" NUMBER
   );
--------------------------------------------------------
--  DDL for Table STANDAR
--------------------------------------------------------

  CREATE TABLE "STANDAR" 
   (	"ID" NUMBER, 
	"KODE" VARCHAR2(225 BYTE), 
	"STANDAR" VARCHAR2(225 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP
   );
--------------------------------------------------------
--  DDL for Table STATUS
--------------------------------------------------------

  CREATE TABLE "STATUS" 
   (	"ID" NUMBER, 
	"STATUS" VARCHAR2(225 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP
   );
--------------------------------------------------------
--  DDL for Table USERS
--------------------------------------------------------

  CREATE TABLE "USERS" 
   (	"ID" NUMBER, 
	"ROLE_ID" NUMBER, 
	"AREA_ID" NUMBER, 
	"EMAIL" VARCHAR2(255 BYTE), 
	"PASSWORD" VARCHAR2(255 BYTE), 
	"NIP" VARCHAR2(255 BYTE), 
	"NAMA" VARCHAR2(255 BYTE), 
	"FOTO" VARCHAR2(255 BYTE), 
	"TELP" VARCHAR2(255 BYTE), 
	"JABATAN" VARCHAR2(255 BYTE), 
	"PERIODE" VARCHAR2(255 BYTE), 
	"CREATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
	"UPDATED_AT" TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
	"USER_TYPE" NUMBER
   );
REM INSERTING into AMI
SET DEFINE OFF;
REM INSERTING into AREA
SET DEFINE OFF;
--Insert into AREA (NAMA,IS_PRODI) values ('Carissa','1');
REM INSERTING into AUDITEE
SET DEFINE OFF;
REM INSERTING into AUDITOR
SET DEFINE OFF;
REM INSERTING into CHECKLIST
SET DEFINE OFF;
REM INSERTING into KRITERIA
SET DEFINE OFF;
REM INSERTING into PERMISSION
SET DEFINE OFF;
REM INSERTING into ROLE
SET DEFINE OFF;
--Insert into ROLE (ROLE,DESKRIPSI) values ('SPM','Sistem Penjamin Mutu Internal');
REM INSERTING into SPM
SET DEFINE OFF;
REM INSERTING into STANDAR
SET DEFINE OFF;
REM INSERTING into STATUS
SET DEFINE OFF;
REM INSERTING into USERS
SET DEFINE OFF;
--------------------------------------------------------
--  DDL for Trigger BI_AMI
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "BI_AMI" 
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
ALTER TRIGGER "BI_AMI" ENABLE;
--------------------------------------------------------
--  DDL for Trigger BI_AREA
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "BI_AREA"     before insert on "AREA"    for each row    if :NEW."ID" is null then        select "AREA_SEQ".nextval into :NEW."ID" from dual;    end if;end;
ALTER TRIGGER "BI_AREA" ENABLE;
--------------------------------------------------------
--  DDL for Trigger BI_AUDITEE
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "BI_AUDITEE" 
BEFORE INSERT ON AUDITEE 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.USER_ID IS NULL THEN
      SELECT AUDITEE_SEQ.NEXTVAL INTO :NEW.USER_ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;
ALTER TRIGGER "BI_AUDITEE" ENABLE;
--------------------------------------------------------
--  DDL for Trigger BI_AUDITOR
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "BI_AUDITOR" 
BEFORE INSERT ON AUDITOR 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.USER_ID IS NULL THEN
      SELECT AUDITOR_SEQ.NEXTVAL INTO :NEW.USER_ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;
ALTER TRIGGER "BI_AUDITOR" ENABLE;
--------------------------------------------------------
--  DDL for Trigger BI_DEMO_USERS
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "BI_DEMO_USERS" 
BEFORE
insert on "DEMO_USERS"
for each row
begin
begin
  for c1 in (
    select DEMO_USERS_SEQ.nextval next_val
    from dual
  ) loop
    :new.USER_ID :=  c1.next_val;
    :new.admin_user := 'N';
    :new.created_on := sysdate;
  end loop;
end;
end;
ALTER TRIGGER "BI_DEMO_USERS" ENABLE;
--------------------------------------------------------
--  DDL for Trigger BI_KRITERIA
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "BI_KRITERIA" 
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
ALTER TRIGGER "BI_KRITERIA" ENABLE;
--------------------------------------------------------
--  DDL for Trigger BI_PERMISSION
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "BI_PERMISSION" 
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
ALTER TRIGGER "BI_PERMISSION" ENABLE;
--------------------------------------------------------
--  DDL for Trigger BI_ROLE
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "BI_ROLE" 
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
ALTER TRIGGER "BI_ROLE" ENABLE;
--------------------------------------------------------
--  DDL for Trigger BI_SPM
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "BI_SPM" 
BEFORE INSERT ON SPM 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.USER_ID IS NULL THEN
      SELECT SPM_SEQ.NEXTVAL INTO :NEW.USER_ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;
ALTER TRIGGER "BI_SPM" ENABLE;
--------------------------------------------------------
--  DDL for Trigger BI_STANDAR
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "BI_STANDAR" 
BEFORE INSERT ON STANDAR 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    NULL;
  END COLUMN_SEQUENCES;
END;
ALTER TRIGGER "BI_STANDAR" ENABLE;
--------------------------------------------------------
--  DDL for Trigger BI_STATUS
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "BI_STATUS" 
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
ALTER TRIGGER "BI_STATUS" ENABLE;
--------------------------------------------------------
--  DDL for Trigger BI_USERS
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "BI_USERS" 
    before insert on "USERS"
    for each row
begin
    if :NEW."ID" is null then
        select "USERS_SEQ".nextval into :NEW."ID" from dual;
    end if;
end;
ALTER TRIGGER "BI_USERS" ENABLE;
--------------------------------------------------------
--  DDL for Synonymn DUAL
--------------------------------------------------------

  CREATE OR REPLACE PUBLIC SYNONYM "DUAL" FOR "DUAL";



Insert into AREA (NAMA,IS_PRODI) values ('Carissa','1');
Insert into ROLE (ROLE,DESKRIPSI) values ('SPM','Sistem Penjamin Mutu Internal');
--------------------------------------------------------
--  Constraints for Table AMI
--------------------------------------------------------

  ALTER TABLE "AMI" ADD CONSTRAINT "AMI_TAHUN_U1" UNIQUE ("TAHUN") ENABLE;
  ALTER TABLE "AMI" ADD CONSTRAINT "AMI_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "AMI" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table AREA
--------------------------------------------------------

  ALTER TABLE "AREA" ADD CONSTRAINT "AREA_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "AREA" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table AUDITEE
--------------------------------------------------------

  ALTER TABLE "AUDITEE" ADD CONSTRAINT "CHECK_USER_TYPE_1" CHECK ("USER_TYPE" = 1) ENABLE;
  ALTER TABLE "AUDITEE" ADD CONSTRAINT "AUDITEE_PK" PRIMARY KEY ("USER_ID") ENABLE;
  ALTER TABLE "AUDITEE" MODIFY ("USER_ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table AUDITOR
--------------------------------------------------------

  ALTER TABLE "AUDITOR" ADD CONSTRAINT "CHECK_USER_TYPE_2" CHECK ("USER_TYPE" = 2) ENABLE;
  ALTER TABLE "AUDITOR" ADD CONSTRAINT "AUDITOR_PK" PRIMARY KEY ("USER_ID") ENABLE;
  ALTER TABLE "AUDITOR" MODIFY ("USER_ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table CHECKLIST
--------------------------------------------------------

  ALTER TABLE "CHECKLIST" ADD CONSTRAINT "CHECKLIST_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "CHECKLIST" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table KRITERIA
--------------------------------------------------------

  ALTER TABLE "KRITERIA" ADD CONSTRAINT "KRITERIA_KODE_U1" UNIQUE ("KRITERIA") ENABLE;
  ALTER TABLE "KRITERIA" ADD CONSTRAINT "KRITERIA_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "KRITERIA" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table PERMISSION
--------------------------------------------------------

  ALTER TABLE "PERMISSION" ADD CONSTRAINT "PERMISSION_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "PERMISSION" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table ROLE
--------------------------------------------------------

  ALTER TABLE "ROLE" ADD CONSTRAINT "ROLE_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "ROLE" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table SPM
--------------------------------------------------------

  ALTER TABLE "SPM" ADD CONSTRAINT "CHECK_USER_TYPE_0" CHECK ("USER_TYPE" = 0) ENABLE;
  ALTER TABLE "SPM" ADD CONSTRAINT "SPM_PK" PRIMARY KEY ("USER_ID") ENABLE;
  ALTER TABLE "SPM" MODIFY ("USER_ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table STANDAR
--------------------------------------------------------

  ALTER TABLE "STANDAR" ADD CONSTRAINT "STANDAR_KODE_U1" UNIQUE ("KODE") ENABLE;
  ALTER TABLE "STANDAR" ADD CONSTRAINT "STANDAR_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "STANDAR" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table STATUS
--------------------------------------------------------

  ALTER TABLE "STATUS" ADD CONSTRAINT "STATUS_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "STATUS" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table USERS
--------------------------------------------------------

  ALTER TABLE "USERS" ADD CONSTRAINT "USERS_NIP_U2" UNIQUE ("NIP") ENABLE;
  ALTER TABLE "USERS" ADD CONSTRAINT "USERS_USER_TYPE_U1" UNIQUE ("USER_TYPE") ENABLE;
  ALTER TABLE "USERS" ADD CONSTRAINT "USERS_PK" PRIMARY KEY ("ID") ENABLE;
  ALTER TABLE "USERS" MODIFY ("PERIODE" NOT NULL ENABLE);
  ALTER TABLE "USERS" MODIFY ("NIP" NOT NULL ENABLE);
  ALTER TABLE "USERS" MODIFY ("PASSWORD" NOT NULL ENABLE);
  ALTER TABLE "USERS" MODIFY ("EMAIL" NOT NULL ENABLE);
  ALTER TABLE "USERS" MODIFY ("AREA_ID" NOT NULL ENABLE);
  ALTER TABLE "USERS" MODIFY ("ROLE_ID" NOT NULL ENABLE);
  ALTER TABLE "USERS" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Ref Constraints for Table AMI
--------------------------------------------------------

  ALTER TABLE "AMI" ADD CONSTRAINT "AMI_SPM_ID_FK1" FOREIGN KEY ("SPM_ID")
	  REFERENCES "SPM" ("USER_ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table AUDITEE
--------------------------------------------------------

  ALTER TABLE "AUDITEE" ADD CONSTRAINT "AUDITEE_USER_ID_FK1" FOREIGN KEY ("USER_ID")
	  REFERENCES "USERS" ("USER_TYPE") ENABLE;
  ALTER TABLE "AUDITEE" ADD CONSTRAINT "AUDITEE_USER_TYPE_FK1" FOREIGN KEY ("USER_TYPE")
	  REFERENCES "USERS" ("USER_TYPE") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table AUDITOR
--------------------------------------------------------

  ALTER TABLE "AUDITOR" ADD CONSTRAINT "AUDITOR_USER_ID_FK1" FOREIGN KEY ("USER_ID")
	  REFERENCES "USERS" ("USER_TYPE") ENABLE;
  ALTER TABLE "AUDITOR" ADD CONSTRAINT "AUDITOR_USER_TYPE_FK1" FOREIGN KEY ("USER_TYPE")
	  REFERENCES "USERS" ("USER_TYPE") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table CHECKLIST
--------------------------------------------------------

  ALTER TABLE "CHECKLIST" ADD CONSTRAINT "CHECKLIST_AMI_ID_FK1" FOREIGN KEY ("ID")
	  REFERENCES "AMI" ("ID") ENABLE;
  ALTER TABLE "CHECKLIST" ADD CONSTRAINT "CHECKLIST_AUDITEE_ID_FK3" FOREIGN KEY ("AUDITEE_ID")
	  REFERENCES "AUDITEE" ("USER_ID") ENABLE;
  ALTER TABLE "CHECKLIST" ADD CONSTRAINT "CHECKLIST_STATUS_ID_FK2" FOREIGN KEY ("ID")
	  REFERENCES "STATUS" ("ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table KRITERIA
--------------------------------------------------------

  ALTER TABLE "KRITERIA" ADD CONSTRAINT "KRITERIA_STANDAR_ID_FK1" FOREIGN KEY ("STANDAR_ID")
	  REFERENCES "STANDAR" ("ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table SPM
--------------------------------------------------------

  ALTER TABLE "SPM" ADD CONSTRAINT "SPM_USER_ID_FK1" FOREIGN KEY ("USER_ID")
	  REFERENCES "USERS" ("USER_TYPE") ENABLE;
  ALTER TABLE "SPM" ADD CONSTRAINT "SPM_USER_TYPE_FK1" FOREIGN KEY ("USER_TYPE")
	  REFERENCES "USERS" ("USER_TYPE") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table USERS
--------------------------------------------------------

  ALTER TABLE "USERS" ADD CONSTRAINT "USERS_AREA_ID_FK2" FOREIGN KEY ("ID")
	  REFERENCES "AREA" ("ID") ENABLE;
  ALTER TABLE "USERS" ADD CONSTRAINT "USERS_ROLE_ID_FK1" FOREIGN KEY ("ROLE_ID")
	  REFERENCES "ROLE" ("ID") ENABLE;
