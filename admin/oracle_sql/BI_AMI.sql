--------------------------------------------------------
--  DDL for Trigger BI_AMI
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."BI_AMI" 
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
ALTER TRIGGER "SIAMI"."BI_AMI" ENABLE
