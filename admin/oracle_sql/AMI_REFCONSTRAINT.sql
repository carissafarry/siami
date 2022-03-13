--------------------------------------------------------
--  Ref Constraints for Table AMI
--------------------------------------------------------

  ALTER TABLE "SIAMI"."AMI" ADD CONSTRAINT "AMI_SPM_ID_FK1" FOREIGN KEY ("SPM_ID")
	  REFERENCES "SIAMI"."SPM" ("USER_ID") ENABLE
