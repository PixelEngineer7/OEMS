-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2024 at 08:43 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oems`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `attendance_id` varchar(10) NOT NULL,
  `emp_id` varchar(10) NOT NULL,
  `date` varchar(2) NOT NULL,
  `month` varchar(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_in` varchar(10) NOT NULL,
  `time_out` varchar(10) NOT NULL,
  `hours_covered` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`attendance_id`, `emp_id`, `date`, `month`, `year`, `time_in`, `time_out`, `hours_covered`) VALUES
('ATT0001', 'EMP0001', '06', '03', 2024, '20:22', '', ''),
('ATT0002', 'EMP0012', '06', '03', 2024, '20:27', '', '');

--
-- Triggers `tbl_attendance`
--
DELIMITER $$
CREATE TRIGGER `trg_generate_attendance_id` BEFORE INSERT ON `tbl_attendance` FOR EACH ROW BEGIN
    DECLARE last_attendance_id VARCHAR(10);
    SET last_attendance_id = (SELECT attendance_id FROM tbl_attendance ORDER BY attendance_id DESC LIMIT 1);

    IF last_attendance_id IS NULL THEN
        SET NEW.attendance_id = 'ATT0001';
    ELSE
        SET NEW.attendance_id = CONCAT('ATT', LPAD(SUBSTRING(last_attendance_id, 4) + 1, 4, '0'));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `department_id` varchar(10) NOT NULL,
  `departmentName` varchar(255) NOT NULL,
  `departmentDetails` varchar(255) NOT NULL,
  `departmentSupervisor` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`department_id`, `departmentName`, `departmentDetails`, `departmentSupervisor`) VALUES
('DEP0001', 'Marketing', 'Handles all marketing relation activities', 'USR003'),
('DEP0002', 'Software Engineering', 'Handles all development and Engineering solutions for the company', 'USR002'),
('DEP0003', 'Networks', 'Handles all network activities', 'USR004');

--
-- Triggers `tbl_department`
--
DELIMITER $$
CREATE TRIGGER `trg_before_insert_department` BEFORE INSERT ON `tbl_department` FOR EACH ROW BEGIN
    DECLARE last_department_id VARCHAR(10);
    SET last_department_id = (SELECT department_id FROM tbl_department ORDER BY department_id DESC LIMIT 1);

    IF last_department_id IS NULL THEN
        SET NEW.department_id = 'DEP0001';
    ELSE
        SET NEW.department_id = CONCAT('DEP', LPAD(SUBSTRING(last_department_id, 4) + 1, 4, '0'));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE `tbl_employee` (
  `emp_id` varchar(10) NOT NULL,
  `user_id` varchar(11) NOT NULL,
  `position` varchar(255) NOT NULL,
  `nic` varchar(14) NOT NULL,
  `mobile_number` varchar(8) NOT NULL,
  `phone_number` varchar(7) NOT NULL,
  `address` varchar(200) NOT NULL,
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_number` varchar(7) DEFAULT NULL,
  `date_joined` date NOT NULL,
  `qualification` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `profile_img` varchar(255) NOT NULL,
  `basic_salary` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_employee`
--

INSERT INTO `tbl_employee` (`emp_id`, `user_id`, `position`, `nic`, `mobile_number`, `phone_number`, `address`, `emergency_contact_name`, `emergency_contact_number`, `date_joined`, `qualification`, `department`, `profile_img`, `basic_salary`) VALUES
('EMP0001', 'USR002', 'Software Engineer', 'R070890040101A', '57770001', '2010001', 'Geranium Avenue , Grand Baie', 'Nandani Kumari Ramlochund', '5920695', '2012-05-02', 'BSc Software Engineering', 'DEP0002', 'PP_Ramlochund.jfif', 41588),
('EMP0002', 'USR003', 'Manager', 'S2806710101A', '57770002', '2010002', '123 Main Street , Binance', 'Shiba Nakamoto', '5777200', '2010-08-05', 'Masters in Cryptography', 'DEP0001', 'satoshi_nakamoto.PNG', 65125),
('EMP0003', 'USR004', 'Senior Engineer', 'E2806810109A', '57770003', '2010003', ' 1 Rocket Road , CA, Hawthorne', 'Talulah Riley', '5777200', '2011-08-15', 'Masters in AI and Robotics', 'DEP0003', 'elon_musk.PNG', 75125),
('EMP0004', 'USR005', 'Technical Assistant', 'B2010061213151', '57770006', '2010006', '186 Noble Fourth', 'Mckay Edward', '5777600', '2022-06-30', 'Certificate in Customer Relations', 'DEP0003', 'brittanie_mackay.jpg', 27350),
('EMP0005', 'USR006', 'Technical Support', 'E2010061213152', '57770007', '2010007', 'P.O. Box 98514', 'Snijder Brittanie', '5777700', '2019-10-17', 'Certificate in Routing and Switching', 'DEP0003', 'edward_snjider.jpg', 22350),
('EMP0006', 'USR007', 'Customer Specialist 3', 'M2010061213153', '57770008', '2010008', 'P.O. Box 48830', 'Viegen Edward', '5777800', '2018-06-09', 'Certificate in Customer Relations', 'DEP0003', 'maurice_viegen.jpg', 19560),
('EMP0007', 'USR008', 'Sales Coordinator', 'N2010061213154', '57770009', '2010009', '595 Merry Shore', 'Diedenhoven Maurice', '5777900', '2023-03-23', 'BSc Marketing', 'DEP0001', 'nickolas_diedenhoven.jpg', 22965),
('EMP0008', 'USR009', 'Merchandiser', 'V2010061213155', '57770010', '2010010', '29 SW Circle Valley', 'Carver Nickolas', '5777100', '2019-10-25', 'Masters in Marketing', 'DEP0001', 'vicenta_carver.webp', 25600),
('EMP0009', 'USR010', 'Senior Sales Officer', 'H2010061213156', '57770011', '2010011', '833 Horse Turnpike', 'Rubio Vicenta', '5777110', '2023-11-22', 'MBA in Business Administration', 'DEP0001', 'helen_rubio.jpg', 36256),
('EMP0010', 'USR011', 'Frontend Engineer', 'C2010061213157', '57770012', '2010012', '856 Emerald Fair', 'Knowles Helene', '5777120', '2023-03-23', 'BSc Computer Science', 'DEP0002', 'coleman_knowles.jpg', 34256),
('EMP0011', 'USR012', 'Backend Engineer', 'D2010061213158', '57770013', '2010013', '749 Jagged Plain', 'Crispijn Coleman', '5777130', '2022-07-20', 'BSc Computer Application', 'DEP0002', 'dalila_crispijin.jpg', 28965),
('EMP0012', 'USR013', 'UI/UX Specialist', 'W2010061213159', '57770014', '2010014', '790 Misty Falls', 'Little Dalila', '5777140', '2021-07-29', 'BSc Graphic Design', 'DEP0002', 'little_wilbert.jpg', 32568),
('EMP0013', 'USR014', 'API Specialist', 'D2010061213110', '57770015', '2010015', '872 N Well Manor', 'Efdee Wilbert', '5777150', '2020-01-16', 'MSc Information Technology', 'DEP0002', 'danuta_efdee.jpeg', 41568);

--
-- Triggers `tbl_employee`
--
DELIMITER $$
CREATE TRIGGER `trg_generate_emp_id` BEFORE INSERT ON `tbl_employee` FOR EACH ROW BEGIN
    DECLARE last_emp_id VARCHAR(10);
    SET last_emp_id = (SELECT emp_id FROM tbl_employee ORDER BY emp_id DESC LIMIT 1);

    IF last_emp_id IS NULL THEN
        SET NEW.emp_id = 'EMP0001';
    ELSE
        SET NEW.emp_id = CONCAT('EMP', LPAD(SUBSTRING(last_emp_id, 4) + 1, 4, '0'));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave`
--

CREATE TABLE `tbl_leave` (
  `leave_id` varchar(10) NOT NULL,
  `emp_id` varchar(10) NOT NULL,
  `supervisor_id` varchar(10) NOT NULL,
  `leave_type` varchar(25) NOT NULL,
  `leave_reason` varchar(100) NOT NULL,
  `start_date` varchar(25) NOT NULL,
  `end_date` varchar(25) NOT NULL,
  `leave_total` varchar(10) NOT NULL,
  `approval_status` varchar(25) NOT NULL,
  `absence_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_leave`
--

INSERT INTO `tbl_leave` (`leave_id`, `emp_id`, `supervisor_id`, `leave_type`, `leave_reason`, `start_date`, `end_date`, `leave_total`, `approval_status`, `absence_status`) VALUES
('LEV0001', 'EMP0001', 'USR002', 'vacation', 'Personal Reasons', '2024-03-07', '2024-03-08', '1', 'Pending N+2', 'Confirmed');

--
-- Triggers `tbl_leave`
--
DELIMITER $$
CREATE TRIGGER `trg_generate_leave_id` BEFORE INSERT ON `tbl_leave` FOR EACH ROW BEGIN
    DECLARE last_leave_id VARCHAR(10);
    SET last_leave_id = (SELECT leave_id FROM tbl_leave ORDER BY leave_id DESC LIMIT 1);

    IF last_leave_id IS NULL THEN
        SET NEW.leave_id = 'LEV0001';
    ELSE
        SET NEW.leave_id = CONCAT('LVE', LPAD(SUBSTRING(last_leave_id, 4) + 1, 4, '0'));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave_bal`
--

CREATE TABLE `tbl_leave_bal` (
  `bal_id` varchar(10) NOT NULL,
  `leave_id` varchar(10) NOT NULL,
  `emp_id` varchar(10) NOT NULL,
  `bal_wellness` int(2) NOT NULL,
  `bal_vacation` int(2) NOT NULL,
  `bal_sick_leave` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_leave_bal`
--

INSERT INTO `tbl_leave_bal` (`bal_id`, `leave_id`, `emp_id`, `bal_wellness`, `bal_vacation`, `bal_sick_leave`) VALUES
('BAL0001', '', 'EMP0001', 5, 25, 22),
('BAL0002', '', 'EMP0002', 5, 29, 22),
('BAL0003', '', 'EMP0003', 5, 56, 22),
('BAL0004', '', 'EMP0004', 5, 20, 15),
('BAL0005', '', 'EMP0005', 5, 17, 15),
('BAL0006', '', 'EMP0006', 5, 19, 15);

--
-- Triggers `tbl_leave_bal`
--
DELIMITER $$
CREATE TRIGGER `trg_generate_bal_id` BEFORE INSERT ON `tbl_leave_bal` FOR EACH ROW BEGIN
    DECLARE last_bal_id VARCHAR(10);
    SET last_bal_id = (SELECT bal_id FROM tbl_leave_bal ORDER BY bal_id DESC LIMIT 1);

    IF last_bal_id IS NULL THEN
        SET NEW.bal_id = 'BAL0001';
    ELSE
        SET NEW.bal_id = CONCAT('BAL', LPAD(SUBSTRING(last_bal_id, 4) + 1, 4, '0'));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_newsfeed`
--

CREATE TABLE `tbl_newsfeed` (
  `news_id` varchar(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `video_link` varchar(255) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_newsfeed`
--

INSERT INTO `tbl_newsfeed` (`news_id`, `title`, `content`, `image`, `video_link`, `isActive`, `date_posted`) VALUES
('NEWS0004', 'Symptoms of Coronavirus Sars Covid-19 Disease 2019', 'Know the symptoms of COVID-19, which can include cough, shortness of breath or difficulty breathing, fever, chills, muscle pain, sore throat, and new loss of taste or smell.', '', 'https://www.youtube.com/embed/F70BzSFAZfw', 1, '2023-08-25 05:37:50'),
('NEWS0005', 'Salary Pay Date - August 2023', 'Pay date for the month of August 2023 is scheduled for Monday 28th August 2023', 'paydate.png', '', 1, '2023-08-25 06:21:29'),
('NEWS0006', 'Performance Management System - Objectives are open for Semester 1 2023', 'Employees are called to fill in objectives that have been set by the management team and are requested to complete by end of September 2023', 'PMS Banner.png', '', 1, '2023-08-25 07:47:47'),
('NEWS0007', 'Salary Pay Date - September 2023', 'Pay date for the month of August 2023 is scheduled for Monday 28th August 2023...', 'Internal Communication.png', '', 1, '2023-09-01 06:13:30'),
('NEWS0008', 'Pay Date 29th February 2024', 'The pay date is set for Pay Date 29th February 2024', 'Internal Communication_paydate.png', '', 1, '2024-02-04 12:17:58'),
('NEWS0009', 'News on Dengue Fever', 'Dengue is a mosquito-borne viral infection. The infection causes flu-like illness, and occasionally develops into a potentially lethal complication called severe dengue. The global incidence of dengue has grown dramatically in recent decades. About half of the world’s population is now at risk. Dengue is found in tropical and sub-tropical climates worldwide, mostly in urban and semi-urban areas. There is no specific treatment for dengue/severe dengue, but early detection and access to proper medical care lowers fatality rates below 1%. Dengue prevention and control depends on effective vector control measures. A dengue vaccine has been licensed by several National Regulatory Authorities for use in people 9-45 years of age living in endemic settings.', 'dengue.jpg', '', 1, '2024-02-15 18:57:47');

--
-- Triggers `tbl_newsfeed`
--
DELIMITER $$
CREATE TRIGGER `trg_generate_department_id` BEFORE INSERT ON `tbl_newsfeed` FOR EACH ROW BEGIN
    DECLARE last_news_id VARCHAR(10);
    SET last_news_id = (SELECT news_id FROM tbl_newsfeed ORDER BY news_id DESC LIMIT 1);

    IF last_news_id IS NULL THEN
        SET NEW.news_id = 'NEWS0001';
    ELSE
        SET NEW.news_id = CONCAT('NEWS', LPAD(SUBSTRING(last_news_id, 5) + 1, 4, '0'));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pay`
--

CREATE TABLE `tbl_pay` (
  `pay_id` varchar(10) NOT NULL,
  `emp_id` varchar(10) NOT NULL,
  `month` varchar(25) NOT NULL,
  `year` int(4) NOT NULL,
  `basic_salary` decimal(8,2) NOT NULL,
  `deductions` decimal(8,2) NOT NULL,
  `net_pay` int(8) NOT NULL,
  `csg_contri` decimal(8,2) NOT NULL,
  `overtime` decimal(8,2) NOT NULL,
  `medical_contri` decimal(8,2) NOT NULL,
  `nsf_contri` decimal(8,2) NOT NULL,
  `bus_fare` int(8) NOT NULL,
  `pay_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pay`
--

INSERT INTO `tbl_pay` (`pay_id`, `emp_id`, `month`, `year`, `basic_salary`, `deductions`, `net_pay`, `csg_contri`, `overtime`, `medical_contri`, `nsf_contri`, `bus_fare`, `pay_status`) VALUES
('PAY0001', 'EMP0001', 'March', 2024, '41588.00', '1430.63', 49107, '623.82', '6500.00', '415.88', '390.93', 2450, 'Complete'),
('PAY0002', 'EMP0002', 'March', 2024, '65125.00', '2240.30', 72795, '976.88', '7560.00', '651.25', '612.18', 2350, 'Complete'),
('PAY0003', 'EMP0003', 'March', 2024, '75125.00', '2584.30', 76551, '1126.88', '1560.00', '751.25', '706.18', 2450, 'Complete');

--
-- Triggers `tbl_pay`
--
DELIMITER $$
CREATE TRIGGER `trg_generate_pay_id` BEFORE INSERT ON `tbl_pay` FOR EACH ROW BEGIN
    DECLARE last_pay_id VARCHAR(10);
    SET last_pay_id = (SELECT pay_id FROM tbl_pay ORDER BY pay_id DESC LIMIT 1);

    IF last_pay_id IS NULL THEN
        SET NEW.pay_id = 'PAY0001';
    ELSE
        SET NEW.pay_id = CONCAT('PAY', LPAD(SUBSTRING(last_pay_id, 4) + 1, 4, '0'));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pms`
--

CREATE TABLE `tbl_pms` (
  `pms_id` varchar(10) NOT NULL,
  `emp_id` varchar(10) NOT NULL,
  `quarter_array` varchar(255) NOT NULL,
  `kpa_array` varchar(255) NOT NULL,
  `kpi_array` varchar(255) NOT NULL,
  `objective_array` varchar(255) NOT NULL,
  `metric_array` varchar(255) NOT NULL,
  `score_array` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `supervisor_id` varchar(255) NOT NULL,
  `management_status` varchar(255) NOT NULL,
  `pms_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pms`
--

INSERT INTO `tbl_pms` (`pms_id`, `emp_id`, `quarter_array`, `kpa_array`, `kpi_array`, `objective_array`, `metric_array`, `score_array`, `remarks`, `supervisor_id`, `management_status`, `pms_status`) VALUES
('PMS0001', 'EMP0001', '[\"Quarter 1\",\"2024-04-10\"]', '[\"Software Development\",\"Technical Expertise\",\"Problem Solving\",\"Team Collaboration\"]', '[\"Code review effectiveness\",\"Adoption of new technologies\",\"Ability to analyze and understand complex requirements\",\"Peer feedback\"]', '[\"Minimizing bugs and issues in the codebase.\",\"Contributions to technical discussions or decision-making.\",\"Providing innovative solutions to technical challenges.\",\"Collaboration in code reviews and knowledge sharing.\"]', '', '', '', 'USR002', 'OB', 'n+1'),
('PMS0002', 'EMP0002', '[\"Quarter 1\",\"2024-03-09\"]', '[\"Brand Management\",\"Lead Generation and Conversion\",\"Campaign Management\",\"Market Research and Analysis\"]', '[\"Brand awareness metrics (e.g., brand recall, brand recognition).\",\"Number of leads generated.\",\"Cost per acquisition (CPA) or cost per lead (CPL).\",\"Market share analysis.\"]', '[\"Enhance brand visibility and recognition through targeted marketing initiatives.\",\"Plan, execute, and evaluate marketing campaign\",\"Conduct market research\",\"Leverage digital channels to enhance brand presence\"]', '', '', '', 'USR003', 'OB', 'n+1'),
('PMS0003', 'EMP0003', '[\"Quarter 1\",\"2024-03-06\"]', '[\"Network Infrastructure Management\",\"Network Security\",\"Network Performance Optimization\",\"Network Monitoring and Troubleshooting\"]', '[\"Network uptime\\/downtime\",\"Availability and reliability of network components\",\"Security vulnerability assessment results\",\"Network latency and response time.\"]', '[\"Maintain network uptime to support\",\"Improve network performance\",\"Anticipate future network capacity\",\" Implement proactive monitoring tools\"]', '', '', '', 'USR004', 'OB', 'n+1');

--
-- Triggers `tbl_pms`
--
DELIMITER $$
CREATE TRIGGER `trg_generate_pms_id` BEFORE INSERT ON `tbl_pms` FOR EACH ROW BEGIN
    DECLARE last_pms_id VARCHAR(10);
    SET last_pms_id = (SELECT pms_id FROM tbl_pms ORDER BY pms_id DESC LIMIT 1);

    IF last_pms_id IS NULL THEN
        SET NEW.pms_id = 'PMS0001';
    ELSE
        SET NEW.pms_id = CONCAT('PMS', LPAD(SUBSTRING(last_pms_id, 4) + 1, 4, '0'));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_task`
--

CREATE TABLE `tbl_task` (
  `task_id` varchar(10) NOT NULL,
  `emp_id` varchar(10) NOT NULL,
  `supervisor_id` varchar(10) NOT NULL,
  `task_name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `deadline` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `progress` varchar(25) NOT NULL,
  `feedback` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_task`
--

INSERT INTO `tbl_task` (`task_id`, `emp_id`, `supervisor_id`, `task_name`, `description`, `deadline`, `status`, `progress`, `feedback`) VALUES
('TSK0001', 'EMP0011', 'USR002', 'System Testing', 'Use test cases to check it software meets requirement', '2024-03-21', 'Pending', '0', ''),
('TSK0002', 'EMP0012', 'USR002', 'Front End Demo', 'Provide a full demo of the upcoming software project on OEMS', '2024-03-25', 'In Progress', '30', '');

--
-- Triggers `tbl_task`
--
DELIMITER $$
CREATE TRIGGER `trg_generate_task_id` BEFORE INSERT ON `tbl_task` FOR EACH ROW BEGIN
    DECLARE last_task_id VARCHAR(10);
    SET last_task_id = (SELECT task_id FROM tbl_task ORDER BY task_id DESC LIMIT 1);

    IF last_task_id IS NULL THEN
        SET NEW.task_id = 'TSK0001';
    ELSE
        SET NEW.task_id = CONCAT('TSK', LPAD(SUBSTRING(last_task_id, 4) + 1, 4, '0'));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` varchar(7) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `email`, `password`, `role`, `name`, `surname`, `isActive`) VALUES
('USR001', 'admin@test.com', 'Admin123', 'Administrator', 'Infinity', 'Administrator', 1),
('USR002', 'test2@test.com', 'Test*123', 'Supervisor', 'Ramlochund ', 'Gitendrajeet', 1),
('USR003', 'test3@test.com', 'Test*123', 'Supervisor', 'Satoshi', 'Nakamoto', 1),
('USR004', 'test4@test.com', 'Test*123', 'Supervisor', 'Elon', 'Musk', 1),
('USR005', 'test6@test.com', 'Test*123', 'Employee', 'Brittanie', 'Mckay', 1),
('USR006', 'test7@test.com', 'Test*123', 'Employee', 'Edward', 'Snijder', 1),
('USR007', 'test8@test.com', 'Test*123', 'Employee', 'Maurice', 'Viegen', 1),
('USR008', 'test9@test.com', 'Test*123', 'Employee', 'Nickolas', 'Diedenhoven', 1),
('USR009', 'test10@test.com', 'Test*123', 'Employee', 'Vicenta', 'Carver', 1),
('USR010', 'test11@test.com', 'Test*123', 'Employee', 'Helene', 'Rubio', 1),
('USR011', 'test12@test.com', 'Test*123', 'Employee', 'Coleman', 'Knowles', 1),
('USR012', 'test13@test.com', 'Test*123', 'Employee', 'Dalila', 'Crispijn', 1),
('USR013', 'test14@test.com', 'Test*123', 'Employee', 'Wilbert', 'Little', 1),
('USR014', 'test15@test.com', 'Test*123', 'Employee', 'Danuta', 'Efdee', 1),
('USR015', 'test16@test.com', 'Test*123', 'Employee', 'Rodrigo', 'Dekking', 1),
('USR016', 'test17@test.com', 'Test*123', 'Employee', 'Armand', 'Jacobs', 1),
('USR017', 'test18@test.com', 'Test*123', 'Employee', 'Berneice', 'Short', 1),
('USR018', 'test19@test.com', 'Test*123', 'Employee', 'Jae', 'Kastelein', 1),
('USR019', 'finance@infinty.com', 'Test*12345', 'Administrator', 'HR', 'Finance', 1);

--
-- Triggers `tbl_user`
--
DELIMITER $$
CREATE TRIGGER `before_insert_tbl_user` BEFORE INSERT ON `tbl_user` FOR EACH ROW BEGIN
    DECLARE next_id INT;

    -- Calculate the next user_id
    SET next_id = (
        SELECT COALESCE(MAX(CAST(SUBSTRING(user_id, 4) AS UNSIGNED)) + 1, 1)
        FROM tbl_user
    );

    -- Set the new user_id
    SET NEW.user_id = CONCAT('USR', LPAD(next_id, 3, '0'));
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `FK_emp_Users` (`emp_id`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`department_id`),
  ADD KEY `FK_deptSup_User` (`departmentSupervisor`);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `FK_Users` (`user_id`);

--
-- Indexes for table `tbl_leave`
--
ALTER TABLE `tbl_leave`
  ADD PRIMARY KEY (`leave_id`),
  ADD KEY `FK_emp_id_Users` (`emp_id`),
  ADD KEY `FK_sup_id_Users` (`supervisor_id`);

--
-- Indexes for table `tbl_leave_bal`
--
ALTER TABLE `tbl_leave_bal`
  ADD PRIMARY KEY (`bal_id`),
  ADD KEY `FK_emp_id_Leaves` (`emp_id`);

--
-- Indexes for table `tbl_newsfeed`
--
ALTER TABLE `tbl_newsfeed`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `tbl_pay`
--
ALTER TABLE `tbl_pay`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `FK_emp_id_Pay` (`emp_id`);

--
-- Indexes for table `tbl_pms`
--
ALTER TABLE `tbl_pms`
  ADD PRIMARY KEY (`pms_id`),
  ADD KEY `FK_emp_id_pms` (`emp_id`),
  ADD KEY `FK_sup_id_pms` (`supervisor_id`);

--
-- Indexes for table `tbl_task`
--
ALTER TABLE `tbl_task`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `FK_emp_task` (`emp_id`),
  ADD KEY `FK_sup_task` (`supervisor_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD CONSTRAINT `FK_emp_Users` FOREIGN KEY (`emp_id`) REFERENCES `tbl_employee` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD CONSTRAINT `FK_deptSup_User` FOREIGN KEY (`departmentSupervisor`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD CONSTRAINT `FK_Users` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_leave`
--
ALTER TABLE `tbl_leave`
  ADD CONSTRAINT `FK_emp_id_Users` FOREIGN KEY (`emp_id`) REFERENCES `tbl_employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_sup_id_Users` FOREIGN KEY (`supervisor_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_leave_bal`
--
ALTER TABLE `tbl_leave_bal`
  ADD CONSTRAINT `FK_emp_id_Leaves` FOREIGN KEY (`emp_id`) REFERENCES `tbl_employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_pay`
--
ALTER TABLE `tbl_pay`
  ADD CONSTRAINT `FK_emp_id_Pay` FOREIGN KEY (`emp_id`) REFERENCES `tbl_employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_pms`
--
ALTER TABLE `tbl_pms`
  ADD CONSTRAINT `FK_emp_id_pms` FOREIGN KEY (`emp_id`) REFERENCES `tbl_employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_sup_id_pms` FOREIGN KEY (`supervisor_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_task`
--
ALTER TABLE `tbl_task`
  ADD CONSTRAINT `FK_emp_task` FOREIGN KEY (`emp_id`) REFERENCES `tbl_employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_sup_task` FOREIGN KEY (`supervisor_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
