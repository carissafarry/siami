--------------------------------------------------------
--  Ref Constraints for Table AUDITOR
--------------------------------------------------------

  ALTER TABLE "SIAMI"."AUDITOR" ADD CONSTRAINT "AUDITOR_USER_ID_FK1" FOREIGN KEY ("USER_ID")
	  REFERENCES "SIAMI"."USERS" ("USER_TYPE") ENABLE
  ALTER TABLE "SIAMI"."AUDITOR" ADD CONSTRAINT "AUDITOR_USER_TYPE_FK1" FOREIGN KEY ("USER_TYPE")
	  REFERENCES "SIAMI"."USERS" ("USER_TYPE") ENABLE
