CREATE TRIGGER check_time_insert
BEFORE INSERT ON data_donasi
FOR EACH ROW
BEGIN
    DECLARE time_now TIME;
    DECLARE allowed_start_time TIME;
    DECLARE allowed_end_time TIME;
    
    -- Waktu yang diizinkan untuk operasi INSERT (ganti sesuai kebutuhan)
    SET allowed_start_time = ?<;
    SET allowed_end_time = ?>;
    
    -- Waktu saat ini
    SET time_now = CURTIME();
    
    -- Cek apakah waktu saat ini berada di dalam rentang yang diizinkan
    IF NOT (time_now BETWEEN allowed_start_time AND allowed_end_time) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Operasi insert data tidak diizinkan !!';
    END IF;
END;

CREATE TRIGGER check_time_update
BEFORE UPDATE ON data_donasi
FOR EACH ROW
BEGIN
    DECLARE time_now TIME;
    DECLARE allowed_start_time TIME;
    DECLARE allowed_end_time TIME;
    
    -- Waktu yang diizinkan untuk operasi INSERT (ganti sesuai kebutuhan)
    SET allowed_start_time = ?<;
    SET allowed_end_time = ?>;
    
    -- Waktu saat ini
    SET time_now = CURTIME();
    
    -- Cek apakah waktu saat ini berada di dalam rentang yang diizinkan
    IF NOT (time_now BETWEEN allowed_start_time AND allowed_end_time) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Operasi update data tidak diizinkan !!';
    END IF;
END;

CREATE TRIGGER check_time_delete
BEFORE DELETE ON data_donasi
FOR EACH ROW
BEGIN
    DECLARE time_now TIME;
    DECLARE allowed_start_time TIME;
    DECLARE allowed_end_time TIME;
    
    -- Waktu yang diizinkan untuk operasi INSERT (ganti sesuai kebutuhan)
    SET allowed_start_time = ?<;
    SET allowed_end_time = ?>;
    
    -- Waktu saat ini
    SET time_now = CURTIME();
    
    -- Cek apakah waktu saat ini berada di dalam rentang yang diizinkan
    IF NOT (time_now BETWEEN allowed_start_time AND allowed_end_time) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Operasi delete data tidak diizinkan !!';
    END IF;
END;