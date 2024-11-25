

CREATE TABLE `tbl_attendance` (
  `attendance_id` varchar(10) NOT NULL,
  `emp_id` varchar(10) NOT NULL,
  `date` varchar(2) NOT NULL,
  `month` varchar(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_in` varchar(10) NOT NULL,
  `time_out` varchar(10) NOT NULL,
  `hours_covered` varchar(4) NOT NULL,
  PRIMARY KEY (`attendance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tbl_attendance VALUES("ATT0001","EMP0002","17","01","2024","07:00","18:35","10.0");
INSERT INTO tbl_attendance VALUES("ATT0002","EMP0002","18","01","2024","19:07","19:07","13");
INSERT INTO tbl_attendance VALUES("ATT0003","EMP0002","25","01","2024","13:13","13:33","12");
INSERT INTO tbl_attendance VALUES("ATT0004","EMP0001","25","01","2024","13:30","18:00","4.0");
INSERT INTO tbl_attendance VALUES("ATT0007","EMP0001","29","01","2024","18:38","18:38","-1.0");
INSERT INTO tbl_attendance VALUES("ATT0008","EMP0001","29","01","2024","18:41","18:46","-1.0");
INSERT INTO tbl_attendance VALUES("ATT0009","EMP0002","29","01","2024","18:44","18:45","-1.0");
INSERT INTO tbl_attendance VALUES("ATT0010","EMP0007","04","02","2024","13:44","14:39","1");
INSERT INTO tbl_attendance VALUES("ATT0011","EMP0001","04","02","2024","14:44","18:09","3.0");
INSERT INTO tbl_attendance VALUES("ATT0012","EMP0001","05","02","2024","18:02","23:51","4.0");
INSERT INTO tbl_attendance VALUES("ATT0013","EMP0007","08","02","2024","20:41","23:53","2.0");
INSERT INTO tbl_attendance VALUES("ATT0014","EMP0002","11","02","2024","11:56","","");
INSERT INTO tbl_attendance VALUES("ATT0015","EMP0007","18","02","2024","19:53","","");
INSERT INTO tbl_attendance VALUES("ATT0016","EMP0001","03","03","2024","22:45","","");



CREATE TABLE `tbl_department` (
  `department_id` varchar(10) NOT NULL,
  `departmentName` varchar(255) NOT NULL,
  `departmentDetails` varchar(255) NOT NULL,
  `departmentSupervisor` varchar(11) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tbl_department VALUES("DEP0001","Business","Handles all marketing relation activities","USR002");
INSERT INTO tbl_department VALUES("DEP0002","Networks","Handles all network activities","USR005");
INSERT INTO tbl_department VALUES("DEP0003","Engineering ","Manages all process and engineering ","USR007");
INSERT INTO tbl_department VALUES("DEP0004","Customer Operations","Handles all customer sides information management","USR011");



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
  `basic_salary` int(8) NOT NULL,
  PRIMARY KEY (`emp_id`),
  KEY `FK_Users` (`user_id`),
  CONSTRAINT `FK_Users` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tbl_employee VALUES("EMP0001","USR002","Manager","M2806710101A","57770711","2010003","Streetford End ,GB","Tammy Mount","2632207","2020-06-24","MBA in Business Administration","DEP0001","mason_mount.PNG","16500");
INSERT INTO tbl_employee VALUES("EMP0002","USR003","Customer Service ","T12354687954A","57770003","2010003"," 1 Rocket Road , CA, Hawthorne","James David","2632207","2016-10-03","Certificate in Customer Relations","DEP0001","van_persie.PNG","19560");
INSERT INTO tbl_employee VALUES("EMP0003","USR005","Manager","M2806710101A","57770700","2035689"," 1 Rocket Road , CA, Hawthorne","Mary Hag","2010031","2020-06-17","Masters in AI","DEP0002","elon_musk.PNG","24632");
INSERT INTO tbl_employee VALUES("EMP0004","USR006","Software Engineer","D160124010203A","57771234","2031001","12th DJ Record , Dreamland","Wenda Guetta","2001234","2023-11-01","Master in Music ","DEP0003","david_guetta.jpg","17562");
INSERT INTO tbl_employee VALUES("EMP0005","USR007","Mechanical Engineer","T02030110102A","57771236","2031002","Iron Stree , Florida","Alexandra Stark","2001235","2024-01-03","PhD Physics","DEP0003","tony_stark.jpg","47256");
INSERT INTO tbl_employee VALUES("EMP0006","USR008","Customer Service Agent","G2806710101A","57770711","2010006","Streetford End ,GB","James David","2037004","2023-12-15","Certificate in Customer Relations","DEP0003","garnacho_alejandro.jpg","25600");
INSERT INTO tbl_employee VALUES("EMP0007","USR011","Software Engineer","R070890040101A","57770700","2010000","Geranium Avenue , Grand Baie","Nandani Kumari Ramlochund","2010005","2023-03-24","Bsc Marketing","DEP0001","sunjeet.jpg","36256");
INSERT INTO tbl_employee VALUES("EMP0008","USR012","Marketing Assistant","P020598010506B","57891234","2021234","The Poplars Lenton Lane UK","Stan Smith","2026598","2021-11-11","Masters in Marketing","DEP0001","paul_smith.jpg","27350");



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
  `absence_status` varchar(25) NOT NULL,
  PRIMARY KEY (`leave_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tbl_leave VALUES("LEV0001","EMP0001","USR002","sick","","2024-01-09","2024-01-13","4","Approved","Confirmed");
INSERT INTO tbl_leave VALUES("LVE0002","EMP0001","USR002","sick","","2024-01-04","2024-01-13","9","Approved","Confirmed");
INSERT INTO tbl_leave VALUES("LVE0003","EMP0001","USR002","wellness","","2024-01-09","2024-01-12","3","Approved","Confirmed");
INSERT INTO tbl_leave VALUES("LVE0004","EMP0001","USR002","vacation","","2024-01-11","2024-01-12","1","Rejected","Confirmed");
INSERT INTO tbl_leave VALUES("LVE0006","EMP0002","USR002","vacation","Personal Reasons","2024-01-11","2024-01-13","2","Approved","Confirmed");
INSERT INTO tbl_leave VALUES("LVE0007","EMP0002","USR002","wellness","Fitness","2024-01-11","2024-01-12","1","Approved","Confirmed");
INSERT INTO tbl_leave VALUES("LVE0009","EMP0002","USR002","sick","","2024-02-11","2024-02-12","1","Approved","Confirmed");
INSERT INTO tbl_leave VALUES("LVE0014","EMP0001","USR002","vacation","Personal Reasons","2024-02-16","2024-02-24","8","Pending N+1","Confirmed");
INSERT INTO tbl_leave VALUES("LVE0015","EMP0002","USR002","vacation","Test 3: Verify if the Leave is being deducted ","2024-02-22","2024-02-23","1","Approved","Confirmed");
INSERT INTO tbl_leave VALUES("LVE0016","EMP0002","USR002","vacation","Test 3: Verify if the Leave is being deducted","2024-02-22","2024-02-23","1","Approved","Confirmed");



CREATE TABLE `tbl_leave_bal` (
  `bal_id` varchar(10) NOT NULL,
  `leave_id` varchar(10) NOT NULL,
  `emp_id` varchar(10) NOT NULL,
  `bal_wellness` int(2) NOT NULL,
  `bal_vacation` int(2) NOT NULL,
  `bal_sick_leave` int(2) NOT NULL,
  PRIMARY KEY (`bal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tbl_leave_bal VALUES("BAL0001","","EMP0001","0","67","22");
INSERT INTO tbl_leave_bal VALUES("BAL0002","","EMP0002","4","25","15");
INSERT INTO tbl_leave_bal VALUES("BAL0003","","EMP0005","5","23","22");
INSERT INTO tbl_leave_bal VALUES("BAL0004","","EMP0007","5","23","13");



CREATE TABLE `tbl_newsfeed` (
  `news_id` varchar(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `video_link` varchar(255) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tbl_newsfeed VALUES("NEWS0004","Symptoms of Coronavirus Sars Covid-19 Disease 2019","Know the symptoms of COVID-19, which can include cough, shortness of breath or difficulty breathing, fever, chills, muscle pain, sore throat, and new loss of taste or smell.","","https://www.youtube.com/embed/F70BzSFAZfw","1","2023-08-25 09:37:50");
INSERT INTO tbl_newsfeed VALUES("NEWS0005","Salary Pay Date - August 2023","Pay date for the month of August 2023 is scheduled for Monday 28th August 2023","paydate.png","","1","2023-08-25 10:21:29");
INSERT INTO tbl_newsfeed VALUES("NEWS0006","Performance Management System - Objectives are open for Semester 1 2023","Employees are called to fill in objectives that have been set by the management team and are requested to complete by end of September 2023","PMS Banner.png","","1","2023-08-25 11:47:47");
INSERT INTO tbl_newsfeed VALUES("NEWS0007","Salary Pay Date - September 2023","Pay date for the month of August 2023 is scheduled for Monday 28th August 2023...","Internal Communication.png","","1","2023-09-01 10:13:30");
INSERT INTO tbl_newsfeed VALUES("NEWS0008","Pay Date 29th February 2024","The pay date is set for Pay Date 29th February 2024","Internal Communication_paydate.png","","1","2024-02-04 16:17:58");
INSERT INTO tbl_newsfeed VALUES("NEWS0009","News on Dengue Fever","Dengue is a mosquito-borne viral infection. The infection causes flu-like illness, and occasionally develops into a potentially lethal complication called severe dengue. The global incidence of dengue has grown dramatically in recent decades. About half of the world’s population is now at risk. Dengue is found in tropical and sub-tropical climates worldwide, mostly in urban and semi-urban areas. There is no specific treatment for dengue/severe dengue, but early detection and access to proper medical care lowers fatality rates below 1%. Dengue prevention and control depends on effective vector control measures. A dengue vaccine has been licensed by several National Regulatory Authorities for use in people 9-45 years of age living in endemic settings.","dengue.jpg","","1","2024-02-15 22:57:47");
INSERT INTO tbl_newsfeed VALUES("NEWS0010","Test","Test","","","0","2024-02-28 21:21:30");



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
  `pay_status` varchar(25) NOT NULL,
  PRIMARY KEY (`pay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tbl_pay VALUES("PAY0001","EMP0001","February","2024","25000.00","860.00","37096","375.00","10500.00","250.00","235.00","2456","Complete");
INSERT INTO tbl_pay VALUES("PAY0003","EMP0006","June","2024","25600.00","880.64","36742","384.00","10500.00","256.00","240.64","1523","Complete");
INSERT INTO tbl_pay VALUES("PAY0005","EMP0003","March","2024","24632.00","847.34","37417","369.48","11200.00","246.32","231.54","2432","Complete");
INSERT INTO tbl_pay VALUES("PAY0006","EMP0001","February","2024","16500.00","567.60","19942","247.50","1560.00","165.00","155.10","2450","Complete");
INSERT INTO tbl_pay VALUES("PAY0007","EMP0003","March","2024","24632.00","847.34","37435","369.48","11200.00","246.32","231.54","2450","Complete");
INSERT INTO tbl_pay VALUES("PAY0008","EMP0006","April","2024","25600.00","880.64","38369","384.00","11200.00","256.00","240.64","2450","Complete");
INSERT INTO tbl_pay VALUES("PAY0010","EMP0007","January","2024","36256.00","1247.21","38879","543.84","1520.00","362.56","340.81","2350","Complete");
INSERT INTO tbl_pay VALUES("PAY0011","EMP0002","February","2024","19560.00","672.86","22787","293.40","1500.00","195.60","183.86","2400","Complete");
INSERT INTO tbl_pay VALUES("PAY0013","EMP0007","February","2024","36256.00","1247.21","44959","543.84","7500.00","362.56","340.81","2450","Complete");



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
  `pms_status` varchar(255) NOT NULL,
  PRIMARY KEY (`pms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tbl_pms VALUES("PMS0001","EMP0001","["Quarter 1","2023-12-13"]","["Service","Delivery","Operation","Finance"]","["At Least 1 Hour","Min of 3 ","Min waiting Time <30Mins","Less than 1000K"]","["Rapid","On Time","Non Delay","Reduce Cost"]","["Minimum of 30mins","3","Less than 10mins","Less than 10K"]","["23","25","30","28"]","","USR002","SU","Completed");
INSERT INTO tbl_pms VALUES("PMS0002","EMP0002","["Quarter 1","2023-12-07"]","["Financial","Process improvement","Service Delivery","Quality Assurance"]","["A Minimum of 30%","Create high level flowchart","At least 3 weeks","Provide test reports"]","["Lower the operational cost","Design efficient work flow","Fast track delivery of solutions","Make regression testing"]","["Met","6","Partial Met","Provided 4 test reports"]","["20","30","25","30"]","","USR002","SU","Completed");
INSERT INTO tbl_pms VALUES("PMS0003","EMP0003","["Quarter 2","2024-01-06"]","["Process improvement","Test","4","2"]","["Zero Complaints","Zero Complaints","Zero Complaints","Zero Complaints"]","["Customer service","Test","Delivery","Test"]","["1","2","2","3"]","","","USR005","MU","Pending");
INSERT INTO tbl_pms VALUES("PMS0004","EMP0001","["Quarter 2","2023-12-14"]","["1","2","3","4"]","["e","f","g","h"]","["a","b","c","d"]","["10","23","15","25"]","["12","22","30","30"]","","USR002","SU","Completed");
INSERT INTO tbl_pms VALUES("PMS0005","EMP0001","["Quarter 1","2024-01-11"]","["Process improvement","Design","Implementation","Fault"]","["Zero Complaints","Finance","Unit Testing","Resolution within 1 day"]","["Customer service","Billing","QA","Tracking"]","["Met","6","Partial Testing","Minimum of 30mins"]","["20","30","25","30"]","","USR002","SU","Completed");
INSERT INTO tbl_pms VALUES("PMS0006","EMP0007","["Quarter 1","2024-01-13"]","["Process improvement","Software Testing","Software QA","Design Improvement"]","["At least 3 level","Batch Test","Minimal risk in testing","Make use of Singleton"]","["Make flowcharts","Unit Testing","Check for bugs","Use design patterns"]","["4 Level","Met","Met","Singleton"]","["22","20","18","19"]","","USR002","SU","Completed");
INSERT INTO tbl_pms VALUES("PMS0007","EMP0007","["Quarter 2","2024-03-02"]","["Financial","Process improvement","Service Delivery","Quality Assurance"]","["A Minimum of 30%","Create high level flowchart","At least 3 weeks","Provide test reports"]","["Lower the operational cost","Design efficient work flow","Fast track delivery of solutions","Make regression testing"]","["Met","6","Partial Met","Provided 4 test reports"]","["26","24","28","26"]","","USR002","MU","n+2");
INSERT INTO tbl_pms VALUES("PMS0008","EMP0002","["Quarter 2","2024-03-30"]","["Process improvement","Test 2","Test 3","Test 4"]","["Zero Complaints","Test 2","Test 3","Test 4"]","["Customer service","Test 2","Test 3","Test 4"]","","","","USR002","OB","n+1");



CREATE TABLE `tbl_task` (
  `task_id` varchar(10) NOT NULL,
  `emp_id` varchar(10) NOT NULL,
  `supervisor_id` varchar(10) NOT NULL,
  `task_name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `deadline` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `progress` varchar(25) NOT NULL,
  `feedback` varchar(255) NOT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tbl_task VALUES("TSK0001","EMP0002","USR002","Manage Stock","Check mobile stock and order new quantity","2024-01-20","Completed","100","Stock updated");
INSERT INTO tbl_task VALUES("TSK0002","EMP0002","USR002","Check Finance Books","Organize the cash book of Marketing ","2024-01-16","Completed","100","");
INSERT INTO tbl_task VALUES("TSK0003","EMP0002","USR002","Equipment Maintenance","Update equipments and sort by DOM","2024-02-01","Completed","100","Test Done");
INSERT INTO tbl_task VALUES("TSK0004","EMP0007","USR002","Quality Assurance ","Use test cases to check it software meets requirement","2024-03-29","Completed","100","Testing");
INSERT INTO tbl_task VALUES("TSK0005","EMP0008","USR002","QA Testing","Perform testing of components","2024-02-28","Pending","0","");
INSERT INTO tbl_task VALUES("TSK0006","EMP0002","USR002","System Testing","Verifying if Task is successfully created and assigned to employee ","2024-02-25","Completed","100","testing");



CREATE TABLE `tbl_user` (
  `user_id` varchar(7) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tbl_user VALUES("USR001","admin@test.com","Admin123","Administrator","Infinity","Administrator","1");
INSERT INTO tbl_user VALUES("USR002","test2@test.com","Test*12345","Supervisor","Mason","Mount","1");
INSERT INTO tbl_user VALUES("USR003","test30@test.com","Test*123","Employee","Van","Persie","1");
INSERT INTO tbl_user VALUES("USR004","test31@test.com","Test*123","Employee","Test","Again","1");
INSERT INTO tbl_user VALUES("USR005","test32@test.com","Test*123","Supervisor","Elon","Musk","1");
INSERT INTO tbl_user VALUES("USR006","test10@test.com","Test*123","Employee","David","Gueta","1");
INSERT INTO tbl_user VALUES("USR007","stark@test.com","Test*123","Supervisor","Tony","Stark","1");
INSERT INTO tbl_user VALUES("USR008","garnacho@test.com","Test*123","Employee","Alejandro","Garnacho","1");
INSERT INTO tbl_user VALUES("USR009","jeff@test.com","Test*123","Employee","Jeff","Bezos","0");
INSERT INTO tbl_user VALUES("USR010","jose@test.com","Test*123","Supervisor","Jose ","Mourinho","1");
INSERT INTO tbl_user VALUES("USR011","test7@test.com","Sunmaster7","Employee","Sunjeet","Ramlochund","1");
INSERT INTO tbl_user VALUES("USR012","test17@test.com","Test*123","Employee","Paul","Smith","0");
INSERT INTO tbl_user VALUES("USR013","eric@test.com","Test12345","Employee","Eric","Cantonna","1");

