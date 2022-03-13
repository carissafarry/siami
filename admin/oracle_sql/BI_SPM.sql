--------------------------------------------------------
--  DDL for Trigger BI_SPM
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."BI_SPM" 
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
ALTER TRIGGER "SIAMI"."BI_SPM" ENABLE
