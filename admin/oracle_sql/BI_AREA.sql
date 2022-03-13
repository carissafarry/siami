--------------------------------------------------------
--  DDL for Trigger BI_AREA
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."BI_AREA"     before insert on "AREA"    for each row    if :NEW."ID" is null then        select "AREA_SEQ".nextval into :NEW."ID" from dual;    end if;end;
ALTER TRIGGER "SIAMI"."BI_AREA" ENABLE
