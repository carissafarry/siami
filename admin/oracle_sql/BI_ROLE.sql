--------------------------------------------------------
--  DDL for Trigger BI_ROLE
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."BI_ROLE" 
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
ALTER TRIGGER "SIAMI"."BI_ROLE" ENABLE
