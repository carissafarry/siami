--------------------------------------------------------
--  DDL for Trigger BI_AUDITOR
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."BI_AUDITOR" 
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
ALTER TRIGGER "SIAMI"."BI_AUDITOR" ENABLE
