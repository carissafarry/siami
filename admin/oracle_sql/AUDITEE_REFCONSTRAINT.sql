--------------------------------------------------------
--  Ref Constraints for Table AUDITEE
--------------------------------------------------------

  ALTER TABLE "SIAMI"."AUDITEE" ADD CONSTRAINT "AUDITEE_USER_ID_FK1" FOREIGN KEY ("USER_ID")
	  REFERENCES "SIAMI"."USERS" ("USER_TYPE") ENABLE
  ALTER TABLE "SIAMI"."AUDITEE" ADD CONSTRAINT "AUDITEE_USER_TYPE_FK1" FOREIGN KEY ("USER_TYPE")
	  REFERENCES "SIAMI"."USERS" ("USER_TYPE") ENABLE
