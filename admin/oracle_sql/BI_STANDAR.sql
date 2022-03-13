--------------------------------------------------------
--  DDL for Trigger BI_STANDAR
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."BI_STANDAR" 
BEFORE INSERT ON STANDAR 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    NULL;
  END COLUMN_SEQUENCES;
END;
ALTER TRIGGER "SIAMI"."BI_STANDAR" ENABLE
