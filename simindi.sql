CREATE DATABASE simindi;

USE simindi;

DROP DATABASE simindi;

CREATE TABLE accounts(
id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
no_account VARCHAR(7) UNIQUE NOT NULL,
name VARCHAR(40) NOT NULL,
email VARCHAR(30) NOT NULL,
username VARCHAR(15) NOT NULL,
password VARCHAR(255) NOT NULL,
role VARCHAR(5) NOT NULL,
waktu_pendaftaran DATETIME NOT NULL
);

INSERT INTO accounts VALUES
(NULL, 'ADM_01', 'Zacky Achmad', 'zckyachmd@gmail.com', 'zckyachmd', '$2y$10$it62iUgzhWSM02YK7R3dKeMjTJU.eBYJR8VoN36YpU08D/AYHY4/u', '085314069191', 'Admin', NOW()),
(NULL, 'ADM_02', 'Admin', 'admin@zacky.id', 'admin', '$2y$10$xJzB26T8lzW7iJfTRYqsZe.bMRFVe/UFk8V9nrinG9Le9Hl9Lfdy.', '085314069191', 'Admin', NOW());

UPDATE accounts SET jabatan = 'Staff' WHERE no_account = 'ADM_01';

DELETE FROM accounts WHERE no_account = 'ADM_01';

CREATE TABLE members(
id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
no_member VARCHAR(12) UNIQUE NOT NULL,
nama VARCHAR(20) NOT NULL,
jenis_kelamin CHAR(1) NOT NULL,
no_ktp CHAR(13) UNIQUE NOT NULL,
tgl_lahir DATE NOT NULL,
alamat TEXT NOT NULL,
no_hp VARCHAR(13) NOT NULL,
email VARCHAR(30),
no_petugas VARCHAR(7) NOT NULL,
waktu_pendaftaran DATETIME NOT NULL,
FOREIGN KEY (no_petugas) REFERENCES accounts(no_account)
);

INSERT INTO members VALUES
(NULL, '231120191', 'Zacky', 'Achmad', 'L', '1234567890123', '2000-01-9', 'Jln. Kenangan No. Terlupakan', '085314069191', 'zckyachmd@gmail.com', 'ADM_3', NOW()),
(NULL, '231120192', 'Putri Aulianti', 'Mulida Rumi', 'P', '1234567890124', '1999-06-17', 'Jln. Kapan Nih?', '081257578900', 'putriaulianti@gmail.com', 'ADM_3', NOW()),
(NULL, '231120193', 'Chandika', 'Ivano', 'L', '1234567890125', '2000-06-13', 'Jln. Sering Jadian Kaga!', '0853140693491', 'chandikaivano24@gmail.com', 'ADM_3', NOW());

UPDATE members SET email = 'admin@zacky.id' WHERE no_ktp = '1234567890123';

DELETE FROM members WHERE no_ktp = '1234567890123';

CREATE TABLE dvd_film(
id_film VARCHAR(6) PRIMARY KEY NOT NULL,
judul VARCHAR(100) NOT NULL,
genre VARCHAR(10) NOT NULL,
director VARCHAR(100) NOT NULL,
release_date DATE NOT NULL,
durasi VARCHAR(3) NOT NULL,
country VARCHAR(100) NOT NULL,
bahasa VARCHAR(100) NOT NULL,
poster MEDIUMBLOB,
stock VARCHAR(3) NOT NULL,
no_petugas VARCHAR(7) NOT NULL,
waktu_menambahkan DATETIME NOT NULL
);

INSERT INTO dvd_film VALUES
('11223', 'Interstelar', 'Adventure', 'Christopher Nolan', '2014-11-6', '103', 'USA', NULL, '43', 'ADM_1', NOW()),
('11215', 'Avengers: Endgame', 'Adventure', 'Anthony Russo, Joe Russo', '2019-4-24', '181', 'USA', NULL, '20', 'ADM_1', NOW()),
('11212', 'Frozen II', 'Adventure', 'Chris Buck, Jennifer Lee', '2019-11-22', '103', 'USA', NULL, '10', 'ADM_1', NOW()),
('11213', 'Joker', 'Crime', 'Todd Phillips', '2019-10-4', '122', 'USA', NULL, '30', 'ADM_1', NOW()),
('11214', 'Doctor Sleep', 'Drama', 'Mike Flanagan', '2019-11-8', '152', 'USA', NULL, '20', 'ADM_1', NOW()),
('11225', 'Avengers: Endgame', 'Adventure', 'Anthony Russo, Joe Russo', '2019-4-24', '181', 'USA', NULL, '20', 'ADM_1', NOW()),
('11216', 'Good Boys', 'Adventure', 'Gene Stupnitsky', '2019-8-16', '90', 'USA', NULL, '42', 'ADM_1', NOW()),
('11217', 'Fast & Furious: Hobbs & Shaw', 'Action', 'David Leitch', '2019-8-2', '137', 'USA', NULL, '32', 'ADM_1', NOW()),
('11218', 'Captain Marvel', 'Action', 'Anna Boden, Ryan Fleck', '2019-5-8', '123', 'USA', NULL, '11', 'ADM_1', NOW()),
('11219', 'Spider-Man: Far from Home', 'Action', 'Jon Watts', '2019-6-2', '129', 'USA', NULL, '11', 'ADM_1', NOW()),
('11211', 'Toy Story 4', 'Adventure', 'Josh Cooley', '2019-6-21', '100', 'USA', NULL, '11', 'ADM_1', NOW());

UPDATE dvd_film SET poster = '1h4ty4u64764' WHERE id_film = '11219';

DELETE FROM dvd_film WHERE id_film = '11219';

CREATE TABLE meminjam(
id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
no_peminjam INT UNIQUE 	NOT NULL,
no_petugas VARCHAR(7) NOT NULL,
no_member VARCHAR(12) NOT NULL,
nama_member VARCHAR(40) NOT NULL,
id_film VARCHAR(6) NOT NULL,
judul_film VARCHAR(100) NOT NULL,
waktu_peminjaman DATETIME NOT NULL,
waktu_pengembalian DATETIME,
tenggat_waktu DATETIME NOT NULL,
FOREIGN KEY (no_member) REFERENCES members(no_member),
FOREIGN KEY (id_film) REFERENCES dvd_film(id_film)
);

INSERT INTO meminjam VALUES
(NULL, 'ADM_01', '231120191', 'Zacky Achmad', '11223', 'Interstelar', NOW(), NULL, NOW() + INTERVAL 3 DAY);

UPDATE meminjam SET judul_film = 'End Game' WHERE id_film = '231120191';

DELETE FROM meminjam WHERE id_film = '231120191';

CREATE TABLE log_login(
id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
no_account VARCHAR(7) NOT NULL,
name VARCHAR(30) NOT NULL,
last_ip VARCHAR(15) NOT NULL,
last_login DATETIME NOT NULL,
FOREIGN KEY (no_account) REFERENCES accounts(no_account)
);

CREATE TABLE log_activity(
id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
aksi VARCHAR(25) NOT NULL,
waktu DATETIME NOT NUll
);

SELECT CONCAT(nama_depan, " ", nama_belakang) AS nama FROM members WHERE id_member = "1";

CREATE TRIGGER insert_account AFTER INSERT ON accounts FOR EACH ROW INSERT INTO log_activity VALUE (NULL, 'Membuat Akun', NOW());
CREATE TRIGGER delete_account AFTER DELETE ON accounts FOR EACH ROW INSERT INTO log_activity VALUE (NULL, 'Menghapus Akun', NOW());
CREATE TRIGGER update_account AFTER UPDATE ON accounts FOR EACH ROW INSERT INTO log_activity VALUE (NULL, 'Memperbaharui Akun', NOW());

CREATE TRIGGER insert_member AFTER INSERT ON members FOR EACH ROW INSERT INTO log_activity VALUE (NULL, 'Mendaftarkan Member', NOW());
CREATE TRIGGER delete_member AFTER DELETE ON members FOR EACH ROW INSERT INTO log_activity VALUE (NULL, 'Menghapus Member', NOW());
CREATE TRIGGER update_member AFTER UPDATE ON members FOR EACH ROW INSERT INTO log_activity VALUE (NULL, 'Memperbaharui Member', NOW());

CREATE TRIGGER insert_dvd_film AFTER INSERT ON dvd_film FOR EACH ROW INSERT INTO log_activity VALUE (NULL, 'Menambahkan DVD Film', NOW());
CREATE TRIGGER delete_dvd_film AFTER DELETE ON dvd_film FOR EACH ROW INSERT INTO log_activity VALUE (NULL, 'Menghapus DVD Film', NOW());
CREATE TRIGGER update_dvd_film AFTER UPDATE ON dvd_film FOR EACH ROW INSERT INTO log_activity VALUE (NULL, 'Memperbaharui DVD Film', NOW());

CREATE TRIGGER insert_peminjam AFTER INSERT ON meminjam FOR EACH ROW INSERT INTO log_activity VALUE (NULL, 'Menambahkan Pinjaman', NOW());
CREATE TRIGGER delete_peminjam AFTER DELETE ON meminjam FOR EACH ROW INSERT INTO log_activity VALUE (NULL, 'Menghapus Pinjaman', NOW());
CREATE TRIGGER update_peminjam AFTER UPDATE ON meminjam FOR EACH ROW INSERT INTO log_activity VALUE (NULL, 'Memperbaharui Pinjaman', NOW());

CREATE VIEW view_peminjaman as SELECT no_peminjam, nama_member, judul_film, waktu_peminjaman FROM meminjam ORDER BY waktu_peminjaman DESC;
CREATE VIEW view_pengembalian as SELECT no_peminjam, nama_member, judul_film, waktu_pengembalian FROM meminjam WHERE waktu_pengembalian IS NOT NULL ORDER BY waktu_pengembalian DESC;

SELECT * FROM dvd_film INNER JOIN members ON dvd_film.no_petugas = members.no_petugas;