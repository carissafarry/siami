--------------------------------------------------------
--  Constraints for Table SPM
--------------------------------------------------------

  ALTER TABLE "SIAMI"."SPM" ADD CONSTRAINT "CHECK_USER_TYPE_0" CHECK ("USER_TYPE" = 0) ENABLE
  ALTER TABLE "SIAMI"."SPM" ADD CONSTRAINT "SPM_PK" PRIMARY KEY ("USER_ID") ENABLE
  ALTER TABLE "SIAMI"."SPM" MODIFY ("USER_ID" NOT NULL ENABLE)
