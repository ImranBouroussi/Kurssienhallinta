-- Database and sample data
CREATE DATABASE IF NOT EXISTS kurssihallinta CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE kurssihallinta;

CREATE TABLE IF NOT EXISTS students (
  student_id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  birthdate DATE,
  year_group TINYINT UNSIGNED CHECK (year_group BETWEEN 1 AND 3)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS teachers (
  teacher_id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  subject VARCHAR(100)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS rooms (
  room_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  capacity INT UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS courses (
  course_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  description TEXT,
  start_date DATE,
  end_date DATE,
  teacher_id INT NOT NULL,
  room_id INT NOT NULL,
  FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (room_id) REFERENCES rooms(room_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS enrollments (
  enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  course_id INT NOT NULL,
  enrolled_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE ON UPDATE CASCADE,
  UNIQUE KEY unique_student_course (student_id, course_id)
) ENGINE=InnoDB;

-- sample data
INSERT INTO teachers (first_name, last_name, subject) VALUES
('Matti', 'Korhonen', 'Mathematics'),
('Liisa', 'Laine', 'Biology'),
('Antti', 'Niemi', 'History');

INSERT INTO rooms (name, capacity) VALUES
('B101', 25),
('C202', 15);

INSERT INTO students (first_name, last_name, birthdate, year_group) VALUES
('Aino','Virtanen','2006-03-12',1),
('Otto','Mäkinen','2005-07-21',2),
('Emma','Laakso','2004-01-30',3),
('Janne','Peltonen','2006-12-05',1),
('Sofia','Ranne','2005-05-10',2),
('Kalle','Salo','2004-11-18',3);

INSERT INTO courses (name, description, start_date, end_date, teacher_id, room_id) VALUES
('Algebra I','Peruslaskentaa ja yhtälöitä','2025-09-01','2025-12-20',1,1),
('Biologia 1','Elämä ja solut','2025-09-02','2025-12-18',2,2),
('Suomen historia','Keskiajalta nykypäivään','2025-10-01','2026-01-15',3,1);

INSERT INTO enrollments (student_id, course_id, enrolled_at) VALUES
(1,1,'2025-08-20 10:00:00'),
(2,1,'2025-08-21 11:30:00'),
(3,2,'2025-08-22 09:00:00'),
(4,1,'2025-08-23 14:00:00'),
(5,2,'2025-08-24 16:45:00'),
(6,3,'2025-09-01 12:00:00'),
(1,3,'2025-09-02 09:15:00');
