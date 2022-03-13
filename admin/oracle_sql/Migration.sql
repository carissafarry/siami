CREATE TABLE "MIGRATION" (
    id INT PRIMARY KEY NOT NULL ,
    migration VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE SEQUENCE migration_id_seq;
DROP SEQUENCE MIGRATION_ID_SEQ;

CREATE TABLE migrations (
    id INT DEFAULT migration_id_seq.nextval,
    migration VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TRIGGER migration_bi
    BEFORE INSERT ON migrations
    FOR EACH ROW
    BEGIN
        SELECT migration_id_seq.nextval
            INTO :NEW.id
        FROM DUAL;
    END;

drop trigger migration_bi;

select * from SIAMI.MIGRATIONS;

INSERT INTO migrations (migration) VALUES ('Carissa');
INSERT INTO migrations (migration) VALUES ('Farry');
INSERT INTO migrations (migration) VALUES ('Hilmi');

drop TABLE MIGRATIONS;

CREATE TABLE "MIGRATION" (
     "id" number(10) NOT NULL,
     "migration" varchar2(255) NOT NULL,
     "created_at" timestamp(5) NOT NULL ON UPDATE CURRENT_TIMESTAMP
);



