--------------------------------------------------------
--  Constraints for Table AMI
--------------------------------------------------------

  ALTER TABLE "SIAMI"."AMI" ADD CONSTRAINT "AMI_TAHUN_U1" UNIQUE ("TAHUN") ENABLE
  ALTER TABLE "SIAMI"."AMI" ADD CONSTRAINT "AMI_PK" PRIMARY KEY ("ID") ENABLE
  ALTER TABLE "SIAMI"."AMI" MODIFY ("ID" NOT NULL ENABLE)
