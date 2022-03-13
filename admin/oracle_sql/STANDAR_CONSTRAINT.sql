--------------------------------------------------------
--  Constraints for Table STANDAR
--------------------------------------------------------

  ALTER TABLE "SIAMI"."STANDAR" ADD CONSTRAINT "STANDAR_KODE_U1" UNIQUE ("KODE") ENABLE
  ALTER TABLE "SIAMI"."STANDAR" ADD CONSTRAINT "STANDAR_PK" PRIMARY KEY ("ID") ENABLE
  ALTER TABLE "SIAMI"."STANDAR" MODIFY ("ID" NOT NULL ENABLE)
