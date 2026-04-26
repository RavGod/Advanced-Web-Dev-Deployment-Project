-- Create table
CREATE TABLE IF NOT EXISTS students (
    student_id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    major VARCHAR(100),
    classification VARCHAR(50)
);

-- Step 2: Inserting 8 students objects into the table
INSERT INTO students(first_name, last_name, email, major, classification)
VALUES ('Jet', 'Longview',
        'T587229004_Greg_L@gmail.com', 'Linguistics', 'Sophomore');

INSERT INTO students(first_name, last_name, email, major, classification)
VALUES ('Rose', 'Thornton',
        'T493812750_Maria_T@gmail.com', 'Computer Science', 'Junior');

INSERT INTO students(first_name, last_name, email, major, classification)
VALUES ('Floyd', 'Okafor',
        'T612047831_James_O@gmail.com', 'Biology', 'Freshman');

INSERT INTO students(first_name, last_name, email, major, classification)
VALUES ('Sofia', 'Jaeger',
        'T748392015_Sofia_R@gmail.com', 'Mathematics', 'Senior');

INSERT INTO students(first_name, last_name, email, major, classification)
VALUES ('Tomo', 'Yomato',
        'T305671298_Derek_Y@gmail.com', 'History', 'Sophomore');

INSERT INTO students(first_name, last_name, email, major, classification)
VALUES ('Remus', 'Ciobanu',
        'T821563047_Aisha_B@gmail.com', 'Psychology', 'Junior');

INSERT INTO students(first_name, last_name, email, major, classification)
VALUES ('Luca', 'Ferreira',
        'T567930412_Luca_F@gmail.com', 'Political Science', 'Senior');

INSERT INTO students(first_name, last_name, email, major, classification)
VALUES ('Abeni', 'Eshe',
        'T934185726_Priya_C@gmail.com', 'Chemistry', 'Freshman');
