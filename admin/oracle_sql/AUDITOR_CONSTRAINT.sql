--------------------------------------------------------
--  Constraints for Table AUDITOR
--------------------------------------------------------

  ALTER TABLE "SIAMI"."AUDITOR" ADD CONSTRAINT "CHECK_USER_TYPE_2" CHECK ("USER_TYPE" = 2) ENABLE
  ALTER TABLE "SIAMI"."AUDITOR" ADD CONSTRAINT "AUDITOR_PK" PRIMARY KEY ("USER_ID") ENABLE
  ALTER TABLE "SIAMI"."AUDITOR" MODIFY ("USER_ID" NOT NULL ENABLE)
