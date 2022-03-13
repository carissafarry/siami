--------------------------------------------------------
--  Constraints for Table AUDITEE
--------------------------------------------------------

  ALTER TABLE "SIAMI"."AUDITEE" ADD CONSTRAINT "CHECK_USER_TYPE_1" CHECK ("USER_TYPE" = 1) ENABLE
  ALTER TABLE "SIAMI"."AUDITEE" ADD CONSTRAINT "AUDITEE_PK" PRIMARY KEY ("USER_ID") ENABLE
  ALTER TABLE "SIAMI"."AUDITEE" MODIFY ("USER_ID" NOT NULL ENABLE)
