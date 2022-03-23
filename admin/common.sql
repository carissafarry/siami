-- Daftar Trigger
select * from all_triggers
where OWNER='SIAMI';


-- Daftar Sequence
select * from user_sequences;

-- Hapus semua data
DELETE FROM users
WHERE EXISTS (
    SELECT * FROM users
);

-- Reset urutan Sequence
drop sequence USERS_SEQ;
CREATE SEQUENCE USERS_SEQ MINVALUE 1 INCREMENT BY 1 START WITH 1 NOCYCLE;