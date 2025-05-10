CREATE DATABASE project;
USE project;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE attachments (
  id int(11) NOT NULL,
  request_id int(11) NOT NULL,
  file_path varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE register1 (
  id int(11) NOT NULL,
  signupUsername varchar(50) NOT NULL,
  signupEmail varchar(100) NOT NULL,
  signupPassword varchar(255) NOT NULL,
  signupRePassword varchar(255) NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE reports (
  id int(11) NOT NULL,
  email varchar(255) NOT NULL,
  worker_name varchar(255) NOT NULL,
  wrongdoing text NOT NULL,
  submission_date timestamp NOT NULL DEFAULT current_timestamp(),
  status enum('pending','reviewed','resolved') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE report_images (
  id int(11) NOT NULL,
  report_id int(11) NOT NULL,
  image_path varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE requests (
  id int(11) NOT NULL,
  name varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  feature varchar(255) NOT NULL,
  description text NOT NULL,
  submission_date timestamp NOT NULL DEFAULT current_timestamp(),
  status enum('pending','reviewed','implemented') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE workers (
  id int(11) NOT NULL,
  profile_picture varchar(255) DEFAULT NULL,
  full_name varchar(100) NOT NULL,
  phone_number varchar(20) NOT NULL,
  title varchar(100) NOT NULL,
  work_type varchar(50) NOT NULL,
  city varchar(50) NOT NULL,
  details text NOT NULL,
  work_pictures text DEFAULT NULL,
  additional_notes text DEFAULT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE attachments
  ADD PRIMARY KEY (id),
  ADD KEY request_id (request_id);

ALTER TABLE register1
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY email_unique (signupEmail);

ALTER TABLE reports
  ADD PRIMARY KEY (id);

ALTER TABLE report_images
  ADD PRIMARY KEY (id),
  ADD KEY report_id (report_id);

ALTER TABLE requests
  ADD PRIMARY KEY (id);

ALTER TABLE workers
  ADD PRIMARY KEY (id);

ALTER TABLE attachments
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE register1
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE reports
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE report_images
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE requests
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE workers
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE attachments
  ADD CONSTRAINT attachments_ibfk_1 FOREIGN KEY (request_id) REFERENCES requests (id) ON DELETE CASCADE;

ALTER TABLE report_images
  ADD CONSTRAINT report_images_ibfk_1 FOREIGN KEY (report_id) REFERENCES reports (id) ON DELETE CASCADE;
COMMIT;