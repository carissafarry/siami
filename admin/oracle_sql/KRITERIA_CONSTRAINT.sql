--------------------------------------------------------
--  Constraints for Table KRITERIA
--------------------------------------------------------

  ALTER TABLE "SIAMI"."KRITERIA" ADD CONSTRAINT "KRITERIA_KODE_U1" UNIQUE ("KRITERIA") ENABLE
  ALTER TABLE "SIAMI"."KRITERIA" ADD CONSTRAINT "KRITERIA_PK" PRIMARY KEY ("ID") ENABLE
  ALTER TABLE "SIAMI"."KRITERIA" MODIFY ("ID" NOT NULL ENABLE)
