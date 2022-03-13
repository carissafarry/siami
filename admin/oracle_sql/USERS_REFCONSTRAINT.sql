--------------------------------------------------------
--  Ref Constraints for Table USERS
--------------------------------------------------------

  ALTER TABLE "SIAMI"."USERS" ADD CONSTRAINT "USERS_AREA_ID_FK2" FOREIGN KEY ("ID")
	  REFERENCES "SIAMI"."AREA" ("ID") ENABLE
  ALTER TABLE "SIAMI"."USERS" ADD CONSTRAINT "USERS_ROLE_ID_FK1" FOREIGN KEY ("ROLE_ID")
	  REFERENCES "SIAMI"."ROLE" ("ID") ENABLE
