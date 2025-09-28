-- ======================================
-- ROLES AND PERMISSIONS MYSQL
-- ======================================
-- This file defines MySQL users and assigns permissions 
-- for different roles in the system: 
--   - db_user (basic login)
--   - db_student
--   - db_professor
--   - db_research_staff
--
-- General notes:
-- 1. Users are defined for three hosts: %, localhost, and 127.0.0.1 
--    to ensure compatibility across the development team. 
--    In production, only the required host should remain (usually %).
--
-- 2. Placeholders like laravel, pass, etc. 
--    are replaced at runtime using environment variables defined in `.env`.
--
-- 3. Main permissions used in this setup:
--    - SELECT = read-only access
--    - INSERT, UPDATE = controlled data modification
-- ======================================

-- Create a basic user for login
CREATE USER IF NOT EXISTS 'db_user'@'%' IDENTIFIED BY 'pass';
-- Database connection permission
GRANT USAGE ON *.* TO 'db_user'@'%';

-- Basic users can:
GRANT SELECT ON laravel.users TO 'db_user'@'%';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.password_resets TO 'db_user'@'%';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.password_reset_tokens TO 'db_user'@'%';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.personal_access_tokens TO 'db_user'@'%';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.sessions TO 'db_user'@'%';

-- Create user for students
CREATE USER IF NOT EXISTS 'db_student'@'%' IDENTIFIED BY 'pass';
-- Database connection permission
GRANT USAGE ON *.* TO 'db_student'@'%';

-- Students can:
GRANT SELECT ON laravel.departments TO 'db_student'@'%';
GRANT SELECT ON laravel.cities TO 'db_student'@'%';
GRANT SELECT ON laravel.city_program TO 'db_student'@'%';
GRANT SELECT ON laravel.programs TO 'db_student'@'%';
GRANT SELECT ON laravel.research_groups TO 'db_student'@'%';
GRANT SELECT ON laravel.investigation_lines TO 'db_student'@'%';
GRANT SELECT ON laravel.thematic_areas TO 'db_student'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.projects TO 'db_student'@'%';
GRANT SELECT ON laravel.project_statuses TO 'db_student'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.content_framework_project TO 'db_student'@'%';
GRANT SELECT ON laravel.content_frameworks TO 'db_student'@'%';
GRANT SELECT ON laravel.frameworks TO 'db_student'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.versions TO 'db_student'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.content_version TO 'db_student'@'%';
GRANT SELECT ON laravel.contents TO 'db_student'@'%';
GRANT SELECT ON laravel.professors TO 'db_student'@'%';
GRANT SELECT ON laravel.professor_project TO 'db_student'@'%';
GRANT SELECT ON laravel.students TO 'db_student'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.student_project TO 'db_student'@'%';
GRANT SELECT, UPDATE ON laravel.users TO 'db_student'@'%';

---- ======================================
--
---- Create a user for professors
CREATE USER IF NOT EXISTS 'db_professor'@'%' IDENTIFIED BY 'pass';
GRANT USAGE ON *.* TO 'db_professor'@'%';
--
---- Professors can:
GRANT SELECT ON laravel.departments TO 'db_professor'@'%';
GRANT SELECT ON laravel.cities TO 'db_professor'@'%';
GRANT SELECT ON laravel.city_program TO 'db_professor'@'%';
GRANT SELECT ON laravel.programs TO 'db_professor'@'%';
GRANT SELECT ON laravel.research_groups TO 'db_professor'@'%';
GRANT SELECT ON laravel.investigation_lines TO 'db_professor'@'%';
GRANT SELECT ON laravel.thematic_areas TO 'db_professor'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.projects TO 'db_professor'@'%';
GRANT SELECT ON laravel.project_statuses TO 'db_professor'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.content_framework_project TO 'db_professor'@'%';
GRANT SELECT ON laravel.content_frameworks TO 'db_professor'@'%';
GRANT SELECT ON laravel.frameworks TO 'db_professor'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.versions TO 'db_professor'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.content_version TO 'db_professor'@'%';
GRANT SELECT ON laravel.contents TO 'db_professor'@'%';
GRANT SELECT ON laravel.professors TO 'db_professor'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.professor_project TO 'db_professor'@'%';
GRANT SELECT ON laravel.students TO 'db_professor'@'%';
GRANT SELECT ON laravel.student_project TO 'db_professor'@'%';
GRANT SELECT, UPDATE ON laravel.users TO 'db_professor'@'%';
--
---- ======================================
--
---- Create a user for research_staff
CREATE USER IF NOT EXISTS 'db_research_staff'@'%' IDENTIFIED BY 'pass';
GRANT USAGE ON *.* TO 'db_research_staff'@'%';
--
---- Research staff can:
GRANT SELECT, INSERT, UPDATE ON laravel.departments TO 'db_research_staff'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.cities TO 'db_research_staff'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.city_program TO 'db_research_staff'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.programs TO 'db_research_staff'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.research_groups TO 'db_research_staff'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.investigation_lines TO 'db_research_staff'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.thematic_areas TO 'db_research_staff'@'%';
GRANT SELECT, UPDATE ON laravel.projects TO 'db_research_staff'@'%';
GRANT SELECT ON laravel.project_statuses TO 'db_research_staff'@'%';
GRANT SELECT ON laravel.content_framework_project TO 'db_research_staff'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.content_frameworks TO 'db_research_staff'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.frameworks TO 'db_research_staff'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.versions TO 'db_research_staff'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.content_version TO 'db_research_staff'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.contents TO 'db_research_staff'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.professors TO 'db_research_staff'@'%';
GRANT SELECT ON laravel.professor_project TO 'db_research_staff'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.students TO 'db_research_staff'@'%';
GRANT SELECT ON laravel.student_project TO 'db_research_staff'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.users TO 'db_research_staff'@'%';
GRANT SELECT, INSERT, UPDATE ON laravel.research_staff TO 'db_research_staff'@'%';


-- Create a basic user for login
CREATE USER IF NOT EXISTS 'db_user'@'localhost' IDENTIFIED BY 'pass';
-- Database connection permission
GRANT USAGE ON *.* TO 'db_user'@'localhost';

-- Basic users can:
GRANT SELECT ON laravel.users TO 'db_user'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.password_resets TO 'db_user'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.password_reset_tokens TO 'db_user'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.personal_access_tokens TO 'db_user'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.sessions TO 'db_user'@'localhost';

-- Create user for students
CREATE USER IF NOT EXISTS 'db_student'@'localhost' IDENTIFIED BY 'pass';
-- Database connection permission
GRANT USAGE ON *.* TO 'db_student'@'localhost';

-- Students can:
GRANT SELECT ON laravel.departments TO 'db_student'@'localhost';
GRANT SELECT ON laravel.cities TO 'db_student'@'localhost';
GRANT SELECT ON laravel.city_program TO 'db_student'@'localhost';
GRANT SELECT ON laravel.programs TO 'db_student'@'localhost';
GRANT SELECT ON laravel.research_groups TO 'db_student'@'localhost';
GRANT SELECT ON laravel.investigation_lines TO 'db_student'@'localhost';
GRANT SELECT ON laravel.thematic_areas TO 'db_student'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.projects TO 'db_student'@'localhost';
GRANT SELECT ON laravel.project_statuses TO 'db_student'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.content_framework_project TO 'db_student'@'localhost';
GRANT SELECT ON laravel.content_frameworks TO 'db_student'@'localhost';
GRANT SELECT ON laravel.frameworks TO 'db_student'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.versions TO 'db_student'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.content_version TO 'db_student'@'localhost';
GRANT SELECT ON laravel.contents TO 'db_student'@'localhost';
GRANT SELECT ON laravel.professors TO 'db_student'@'localhost';
GRANT SELECT ON laravel.professor_project TO 'db_student'@'localhost';
GRANT SELECT ON laravel.students TO 'db_student'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.student_project TO 'db_student'@'localhost';
GRANT SELECT, UPDATE ON laravel.users TO 'db_student'@'localhost';

---- ======================================
--
---- Create a user for professors
CREATE USER IF NOT EXISTS 'db_professor'@'localhost' IDENTIFIED BY 'pass';
GRANT USAGE ON *.* TO 'db_professor'@'localhost';
--
---- Professors can:
GRANT SELECT ON laravel.departments TO 'db_professor'@'localhost';
GRANT SELECT ON laravel.cities TO 'db_professor'@'localhost';
GRANT SELECT ON laravel.city_program TO 'db_professor'@'localhost';
GRANT SELECT ON laravel.programs TO 'db_professor'@'localhost';
GRANT SELECT ON laravel.research_groups TO 'db_professor'@'localhost';
GRANT SELECT ON laravel.investigation_lines TO 'db_professor'@'localhost';
GRANT SELECT ON laravel.thematic_areas TO 'db_professor'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.projects TO 'db_professor'@'localhost';
GRANT SELECT ON laravel.project_statuses TO 'db_professor'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.content_framework_project TO 'db_professor'@'localhost';
GRANT SELECT ON laravel.content_frameworks TO 'db_professor'@'localhost';
GRANT SELECT ON laravel.frameworks TO 'db_professor'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.versions TO 'db_professor'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.content_version TO 'db_professor'@'localhost';
GRANT SELECT ON laravel.contents TO 'db_professor'@'localhost';
GRANT SELECT ON laravel.professors TO 'db_professor'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.professor_project TO 'db_professor'@'localhost';
GRANT SELECT ON laravel.students TO 'db_professor'@'localhost';
GRANT SELECT ON laravel.student_project TO 'db_professor'@'localhost';
GRANT SELECT, UPDATE ON laravel.users TO 'db_professor'@'localhost';
--
---- ======================================
--
---- Create a user for research_staff
CREATE USER IF NOT EXISTS 'db_research_staff'@'localhost' IDENTIFIED BY 'pass';
GRANT USAGE ON *.* TO 'db_research_staff'@'localhost';
--
---- Research staff can:
GRANT SELECT, INSERT, UPDATE ON laravel.departments TO 'db_research_staff'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.cities TO 'db_research_staff'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.city_program TO 'db_research_staff'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.programs TO 'db_research_staff'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.research_groups TO 'db_research_staff'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.investigation_lines TO 'db_research_staff'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.thematic_areas TO 'db_research_staff'@'localhost';
GRANT SELECT, UPDATE ON laravel.projects TO 'db_research_staff'@'localhost';
GRANT SELECT ON laravel.project_statuses TO 'db_research_staff'@'localhost';
GRANT SELECT ON laravel.content_framework_project TO 'db_research_staff'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.content_frameworks TO 'db_research_staff'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.frameworks TO 'db_research_staff'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.versions TO 'db_research_staff'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.content_version TO 'db_research_staff'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.contents TO 'db_research_staff'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.professors TO 'db_research_staff'@'localhost';
GRANT SELECT ON laravel.professor_project TO 'db_research_staff'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.students TO 'db_research_staff'@'localhost';
GRANT SELECT ON laravel.student_project TO 'db_research_staff'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.users TO 'db_research_staff'@'localhost';
GRANT SELECT, INSERT, UPDATE ON laravel.research_staff TO 'db_research_staff'@'localhost';


-- Create a basic user for login
CREATE USER IF NOT EXISTS 'db_user'@'127.0.0.1' IDENTIFIED BY 'pass';
-- Database connection permission
GRANT USAGE ON *.* TO 'db_user'@'127.0.0.1';

-- Basic users can:
GRANT SELECT ON laravel.users TO 'db_user'@'127.0.0.1';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.password_resets TO 'db_user'@'127.0.0.1';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.password_reset_tokens TO 'db_user'@'127.0.0.1';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.personal_access_tokens TO 'db_user'@'127.0.0.1';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.sessions TO 'db_user'@'127.0.0.1';

-- Create user for students
CREATE USER IF NOT EXISTS 'db_student'@'127.0.0.1' IDENTIFIED BY 'pass';
-- Database connection permission
GRANT USAGE ON *.* TO 'db_student'@'127.0.0.1';

-- Students can:
GRANT SELECT ON laravel.departments TO 'db_student'@'127.0.0.1';
GRANT SELECT ON laravel.cities TO 'db_student'@'127.0.0.1';
GRANT SELECT ON laravel.city_program TO 'db_student'@'127.0.0.1';
GRANT SELECT ON laravel.programs TO 'db_student'@'127.0.0.1';
GRANT SELECT ON laravel.research_groups TO 'db_student'@'127.0.0.1';
GRANT SELECT ON laravel.investigation_lines TO 'db_student'@'127.0.0.1';
GRANT SELECT ON laravel.thematic_areas TO 'db_student'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.projects TO 'db_student'@'127.0.0.1';
GRANT SELECT ON laravel.project_statuses TO 'db_student'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.content_framework_project TO 'db_student'@'127.0.0.1';
GRANT SELECT ON laravel.content_frameworks TO 'db_student'@'127.0.0.1';
GRANT SELECT ON laravel.frameworks TO 'db_student'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.versions TO 'db_student'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.content_version TO 'db_student'@'127.0.0.1';
GRANT SELECT ON laravel.contents TO 'db_student'@'127.0.0.1';
GRANT SELECT ON laravel.professors TO 'db_student'@'127.0.0.1';
GRANT SELECT ON laravel.professor_project TO 'db_student'@'127.0.0.1';
GRANT SELECT ON laravel.students TO 'db_student'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.student_project TO 'db_student'@'127.0.0.1';
GRANT SELECT, UPDATE ON laravel.users TO 'db_student'@'127.0.0.1';

---- ======================================
--
---- Create user for professors
CREATE USER IF NOT EXISTS 'db_professor'@'127.0.0.1' IDENTIFIED BY 'pass';
GRANT USAGE ON *.* TO 'db_professor'@'127.0.0.1';
--
---- Professors can:
GRANT SELECT ON laravel.departments TO 'db_professor'@'127.0.0.1';
GRANT SELECT ON laravel.cities TO 'db_professor'@'127.0.0.1';
GRANT SELECT ON laravel.city_program TO 'db_professor'@'127.0.0.1';
GRANT SELECT ON laravel.programs TO 'db_professor'@'127.0.0.1';
GRANT SELECT ON laravel.research_groups TO 'db_professor'@'127.0.0.1';
GRANT SELECT ON laravel.investigation_lines TO 'db_professor'@'127.0.0.1';
GRANT SELECT ON laravel.thematic_areas TO 'db_professor'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.projects TO 'db_professor'@'127.0.0.1';
GRANT SELECT ON laravel.project_statuses TO 'db_professor'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.content_framework_project TO 'db_professor'@'127.0.0.1';
GRANT SELECT ON laravel.content_frameworks TO 'db_professor'@'127.0.0.1';
GRANT SELECT ON laravel.frameworks TO 'db_professor'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.versions TO 'db_professor'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.content_version TO 'db_professor'@'127.0.0.1';
GRANT SELECT ON laravel.contents TO 'db_professor'@'127.0.0.1';
GRANT SELECT ON laravel.professors TO 'db_professor'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.professor_project TO 'db_professor'@'127.0.0.1';
GRANT SELECT ON laravel.students TO 'db_professor'@'127.0.0.1';
GRANT SELECT ON laravel.student_project TO 'db_professor'@'127.0.0.1';
GRANT SELECT, UPDATE ON laravel.users TO 'db_professor'@'127.0.0.1';
--
---- ======================================
--
---- Create a user for research_staff
CREATE USER IF NOT EXISTS 'db_research_staff'@'127.0.0.1' IDENTIFIED BY 'pass';
GRANT USAGE ON *.* TO 'db_research_staff'@'127.0.0.1';
--
---- Research staff can:
GRANT SELECT, INSERT, UPDATE ON laravel.departments TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.cities TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.city_program TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.programs TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.research_groups TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.investigation_lines TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.thematic_areas TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, UPDATE ON laravel.projects TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT ON laravel.project_statuses TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT ON laravel.content_framework_project TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.content_frameworks TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.frameworks TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.versions TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.content_version TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.contents TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.professors TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT ON laravel.professor_project TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.students TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT ON laravel.student_project TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.users TO 'db_research_staff'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE ON laravel.research_staff TO 'db_research_staff'@'127.0.0.1';

-- Docker
-- Create a basic user for login
CREATE USER IF NOT EXISTS 'db_user'@'172.21.0.8' IDENTIFIED BY 'pass';
-- Database connection permission
GRANT USAGE ON *.* TO 'db_user'@'172.21.0.8';

-- Basic users can:
GRANT SELECT ON laravel.users TO 'db_user'@'172.21.0.8';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.password_resets TO 'db_user'@'172.21.0.8';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.password_reset_tokens TO 'db_user'@'172.21.0.8';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.personal_access_tokens TO 'db_user'@'172.21.0.8';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON laravel.sessions TO 'db_user'@'172.21.0.8';

-- Create user for students
CREATE USER IF NOT EXISTS 'db_student'@'172.21.0.8' IDENTIFIED BY 'pass';
-- Database connection permission
GRANT USAGE ON *.* TO 'db_student'@'172.21.0.8';

-- Students can:
GRANT SELECT ON laravel.departments TO 'db_student'@'172.21.0.8';
GRANT SELECT ON laravel.cities TO 'db_student'@'172.21.0.8';
GRANT SELECT ON laravel.city_program TO 'db_student'@'172.21.0.8';
GRANT SELECT ON laravel.programs TO 'db_student'@'172.21.0.8';
GRANT SELECT ON laravel.research_groups TO 'db_student'@'172.21.0.8';
GRANT SELECT ON laravel.investigation_lines TO 'db_student'@'172.21.0.8';
GRANT SELECT ON laravel.thematic_areas TO 'db_student'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.projects TO 'db_student'@'172.21.0.8';
GRANT SELECT ON laravel.project_statuses TO 'db_student'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.content_framework_project TO 'db_student'@'172.21.0.8';
GRANT SELECT ON laravel.content_frameworks TO 'db_student'@'172.21.0.8';
GRANT SELECT ON laravel.frameworks TO 'db_student'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.versions TO 'db_student'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.content_version TO 'db_student'@'172.21.0.8';
GRANT SELECT ON laravel.contents TO 'db_student'@'172.21.0.8';
GRANT SELECT ON laravel.professors TO 'db_student'@'172.21.0.8';
GRANT SELECT ON laravel.professor_project TO 'db_student'@'172.21.0.8';
GRANT SELECT ON laravel.students TO 'db_student'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.student_project TO 'db_student'@'172.21.0.8';
GRANT SELECT, UPDATE ON laravel.users TO 'db_student'@'172.21.0.8';

---- ======================================
--
---- Create user for professors
CREATE USER IF NOT EXISTS 'db_professor'@'172.21.0.8' IDENTIFIED BY 'pass';
GRANT USAGE ON *.* TO 'db_professor'@'172.21.0.8';
--
---- Professors can:
GRANT SELECT ON laravel.departments TO 'db_professor'@'172.21.0.8';
GRANT SELECT ON laravel.cities TO 'db_professor'@'172.21.0.8';
GRANT SELECT ON laravel.city_program TO 'db_professor'@'172.21.0.8';
GRANT SELECT ON laravel.programs TO 'db_professor'@'172.21.0.8';
GRANT SELECT ON laravel.research_groups TO 'db_professor'@'172.21.0.8';
GRANT SELECT ON laravel.investigation_lines TO 'db_professor'@'172.21.0.8';
GRANT SELECT ON laravel.thematic_areas TO 'db_professor'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.projects TO 'db_professor'@'172.21.0.8';
GRANT SELECT ON laravel.project_statuses TO 'db_professor'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.content_framework_project TO 'db_professor'@'172.21.0.8';
GRANT SELECT ON laravel.content_frameworks TO 'db_professor'@'172.21.0.8';
GRANT SELECT ON laravel.frameworks TO 'db_professor'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.versions TO 'db_professor'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.content_version TO 'db_professor'@'172.21.0.8';
GRANT SELECT ON laravel.contents TO 'db_professor'@'172.21.0.8';
GRANT SELECT ON laravel.professors TO 'db_professor'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.professor_project TO 'db_professor'@'172.21.0.8';
GRANT SELECT ON laravel.students TO 'db_professor'@'172.21.0.8';
GRANT SELECT ON laravel.student_project TO 'db_professor'@'172.21.0.8';
GRANT SELECT, UPDATE ON laravel.users TO 'db_professor'@'172.21.0.8';
--
---- ======================================
--
---- Create a user for research_staff
CREATE USER IF NOT EXISTS 'db_research_staff'@'172.21.0.8' IDENTIFIED BY 'pass';
GRANT USAGE ON *.* TO 'db_research_staff'@'172.21.0.8';
--
---- Research staff can:
GRANT SELECT, INSERT, UPDATE ON laravel.departments TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.cities TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.city_program TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.programs TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.research_groups TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.investigation_lines TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.thematic_areas TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, UPDATE ON laravel.projects TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT ON laravel.project_statuses TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT ON laravel.content_framework_project TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.content_frameworks TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.frameworks TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.versions TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.content_version TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.contents TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.professors TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT ON laravel.professor_project TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.students TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT ON laravel.student_project TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.users TO 'db_research_staff'@'172.21.0.8';
GRANT SELECT, INSERT, UPDATE ON laravel.research_staff TO 'db_research_staff'@'172.21.0.8';
