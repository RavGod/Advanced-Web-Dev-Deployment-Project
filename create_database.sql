-- Step 1: Creating the databse and students table
CREATE DATABASE student_directory;
USE student_directory;

CREATE TABLE IF NOT EXISTS students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    major VARCHAR(100),
    classification VARCHAR(50)
);

-- Step 2: Inserting 8 students objects into the table
INSERT INTO students(student_id, first_name, last_name, email, major, classification)
VALUES (587229004, 'Jet', 'Longview',
        'T587229004_Greg_L@gmail.com', 'Linguistics', 'Sophomore');

INSERT INTO students(student_id, first_name, last_name, email, major, classification)
VALUES (493812750, 'Rose', 'Thornton',
        'T493812750_Maria_T@gmail.com', 'Computer Science', 'Junior');

INSERT INTO students(student_id, first_name, last_name, email, major, classification)
VALUES (612047831, 'Floyd', 'Okafor',
        'T612047831_James_O@gmail.com', 'Biology', 'Freshman');

INSERT INTO students(student_id, first_name, last_name, email, major, classification)
VALUES (748392015, 'Sofia', 'Jaeger',
        'T748392015_Sofia_R@gmail.com', 'Mathematics', 'Senior');

INSERT INTO students(student_id, first_name, last_name, email, major, classification)
VALUES (305671298, 'Tomo', 'Yomato',
        'T305671298_Derek_Y@gmail.com', 'History', 'Sophomore');

INSERT INTO students(student_id, first_name, last_name, email, major, classification)
VALUES (821563047, 'Remus', 'Ciobanu',
        'T821563047_Aisha_B@gmail.com', 'Psychology', 'Junior');

INSERT INTO students(student_id, first_name, last_name, email, major, classification)
VALUES (567930412, 'Luca', 'Ferreira',
        'T567930412_Luca_F@gmail.com', 'Political Science', 'Senior');

INSERT INTO students(student_id, first_name, last_name, email, major, classification)
VALUES (934185726, 'Abeni', 'Eshe',
        'T934185726_Priya_C@gmail.com', 'Chemistry', 'Freshman');
