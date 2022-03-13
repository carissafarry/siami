--------------------------------------------------------
--  DDL for Trigger BI_USERS
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."BI_USERS" 
    before insert on "USERS"
    for each row
begin
    if :NEW."ID" is null then
        select "USERS_SEQ".nextval into :NEW."ID" from dual;
    end if;
end;
ALTER TRIGGER "SIAMI"."BI_USERS" ENABLE
