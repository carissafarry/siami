--------------------------------------------------------
--  Constraints for Table USERS
--------------------------------------------------------

  ALTER TABLE "SIAMI"."USERS" ADD CONSTRAINT "USERS_NIP_U2" UNIQUE ("NIP") ENABLE
  ALTER TABLE "SIAMI"."USERS" ADD CONSTRAINT "USERS_USER_TYPE_U1" UNIQUE ("USER_TYPE") ENABLE
  ALTER TABLE "SIAMI"."USERS" ADD CONSTRAINT "USERS_PK" PRIMARY KEY ("ID") ENABLE
  ALTER TABLE "SIAMI"."USERS" MODIFY ("PERIODE" NOT NULL ENABLE)
  ALTER TABLE "SIAMI"."USERS" MODIFY ("NIP" NOT NULL ENABLE)
  ALTER TABLE "SIAMI"."USERS" MODIFY ("PASSWORD" NOT NULL ENABLE)
  ALTER TABLE "SIAMI"."USERS" MODIFY ("EMAIL" NOT NULL ENABLE)
  ALTER TABLE "SIAMI"."USERS" MODIFY ("AREA_ID" NOT NULL ENABLE)
  ALTER TABLE "SIAMI"."USERS" MODIFY ("ROLE_ID" NOT NULL ENABLE)
  ALTER TABLE "SIAMI"."USERS" MODIFY ("ID" NOT NULL ENABLE)