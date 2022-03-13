--------------------------------------------------------
--  Ref Constraints for Table SPM
--------------------------------------------------------

  ALTER TABLE "SIAMI"."SPM" ADD CONSTRAINT "SPM_USER_ID_FK1" FOREIGN KEY ("USER_ID")
	  REFERENCES "SIAMI"."USERS" ("USER_TYPE") ENABLE
  ALTER TABLE "SIAMI"."SPM" ADD CONSTRAINT "SPM_USER_TYPE_FK1" FOREIGN KEY ("USER_TYPE")
	  REFERENCES "SIAMI"."USERS" ("USER_TYPE") ENABLE
