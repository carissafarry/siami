--------------------------------------------------------
--  Ref Constraints for Table KRITERIA
--------------------------------------------------------

  ALTER TABLE "SIAMI"."KRITERIA" ADD CONSTRAINT "KRITERIA_STANDAR_ID_FK1" FOREIGN KEY ("STANDAR_ID")
	  REFERENCES "SIAMI"."STANDAR" ("ID") ENABLE
