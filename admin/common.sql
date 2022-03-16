-- Daftar Trigger
select * from all_triggers
where OWNER='SIAMI';


-- Daftar Sequence
select * from user_sequences;

-- Hapus semua data
DELETE FROM area
WHERE EXISTS (
    SELECT * FROM area
);

-- Reset urutan Sequence
drop sequence AREA_SEQ ;
CREATE SEQUENCE AREA_SEQ MINVALUE 1 INCREMENT BY 1 START WITH 1 NOCYCLE