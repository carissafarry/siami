--------------------------------------------------------
--  DDL for Trigger BI_DEMO_USERS
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SIAMI"."BI_DEMO_USERS" 
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
ALTER TRIGGER "SIAMI"."BI_DEMO_USERS" ENABLE
