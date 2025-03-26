-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: airdrops_teachers:3306
-- Generation Time: Mar 26, 2025 at 07:49 AM
-- Server version: 11.7.2-MariaDB-ubu2404
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teachers`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_tbl`
--

CREATE TABLE `login_tbl` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject_teacher`
--

CREATE TABLE `subject_teacher` (
  `subteacherid` int(11) NOT NULL,
  `subjectid` int(11) NOT NULL,
  `teacherid` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `academicid` int(11) NOT NULL,
  `semester` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblacademicyear`
--

CREATE TABLE `tblacademicyear` (
  `academicid` int(11) NOT NULL,
  `academicyear` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblcourse`
--

CREATE TABLE `tblcourse` (
  `courseid` int(11) NOT NULL,
  `coursename` varchar(50) NOT NULL,
  `departmentid` int(11) NOT NULL,
  `semesterno` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartment`
--

CREATE TABLE `tbldepartment` (
  `departmentid` int(11) NOT NULL,
  `departmentname` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblremark`
--

CREATE TABLE `tblremark` (
  `remarkid` int(11) NOT NULL,
  `fdate` date NOT NULL,
  `tdate` date NOT NULL,
  `hodremark` varchar(100) NOT NULL,
  `principalremark` varchar(100) NOT NULL,
  `teacherid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblsemester`
--

CREATE TABLE `tblsemester` (
  `semesterid` int(11) NOT NULL,
  `semestername` varchar(50) NOT NULL,
  `courseid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblsubject`
--

CREATE TABLE `tblsubject` (
  `subjectid` int(11) NOT NULL,
  `subjectname` varchar(50) NOT NULL,
  `courseid` int(50) NOT NULL,
  `semester` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblteacher`
--

CREATE TABLE `tblteacher` (
  `teacherid` int(11) NOT NULL,
  `teachername` varchar(25) NOT NULL,
  `teacheremail` varchar(50) NOT NULL,
  `teacherphone` bigint(20) NOT NULL,
  `teacherusername` varchar(25) NOT NULL,
  `teacherpassword` varchar(25) NOT NULL,
  `teacherrole` varchar(25) NOT NULL,
  `departmentid` int(11) NOT NULL,
  `isverified` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblteacherlog`
--

CREATE TABLE `tblteacherlog` (
  `teacherlogid` int(11) NOT NULL,
  `hour` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `semester` varchar(100) NOT NULL,
  `subjectid` int(11) NOT NULL,
  `module` varchar(100) NOT NULL,
  `topic` varchar(300) NOT NULL,
  `teacherid` int(11) NOT NULL,
  `submitteddate` date NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachersubject`
--

CREATE TABLE `teachersubject` (
  `teachersubid` int(11) NOT NULL,
  `subjectid` int(25) NOT NULL,
  `teacherid` int(11) NOT NULL,
  `academicid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE tblstudent (
    universityid VARCHAR(50) NOT NULL,
    studentname VARCHAR(100) NOT NULL,
    parentemail VARCHAR(100) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    departmentid INT(11) NOT NULL,
    semester VARCHAR(25) NOT NULL,
    PRIMARY KEY (universityid),
)  ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE tblattendance (
    attendanceid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    universityid VARCHAR(50) NOT NULL,
    hour INT(1) NOT NULL CHECK (hour BETWEEN 1 AND 6),
    ispresent BOOLEAN NOT NULL DEFAULT 0, -- 0 for absent, 1 for present
    marked_at DATE,
    subjectid INT(11) NOT NULL,
    teacherid INT(11) NOT NULL
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_tbl`
--
ALTER TABLE `login_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_teacher`
--
ALTER TABLE `subject_teacher`
  ADD PRIMARY KEY (`subteacherid`);

--
-- Indexes for table `tblacademicyear`
--
ALTER TABLE `tblacademicyear`
  ADD PRIMARY KEY (`academicid`);

--
-- Indexes for table `tblcourse`
--
ALTER TABLE `tblcourse`
  ADD PRIMARY KEY (`courseid`);

--
-- Indexes for table `tbldepartment`
--
ALTER TABLE `tbldepartment`
  ADD PRIMARY KEY (`departmentid`);

--
-- Indexes for table `tblremark`
--
ALTER TABLE `tblremark`
  ADD PRIMARY KEY (`remarkid`);

--
-- Indexes for table `tblsemester`
--
ALTER TABLE `tblsemester`
  ADD PRIMARY KEY (`semesterid`);

--
-- Indexes for table `tblsubject`
--
ALTER TABLE `tblsubject`
  ADD PRIMARY KEY (`subjectid`);

--
-- Indexes for table `tblteacher`
--
ALTER TABLE `tblteacher`
  ADD PRIMARY KEY (`teacherid`);

--
-- Indexes for table `tblteacherlog`
--
ALTER TABLE `tblteacherlog`
  ADD PRIMARY KEY (`teacherlogid`);

--
-- Indexes for table `teachersubject`
--
ALTER TABLE `teachersubject`
  ADD PRIMARY KEY (`teachersubid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_tbl`
--
ALTER TABLE `login_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject_teacher`
--
ALTER TABLE `subject_teacher`
  MODIFY `subteacherid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblacademicyear`
--
ALTER TABLE `tblacademicyear`
  MODIFY `academicid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcourse`
--
ALTER TABLE `tblcourse`
  MODIFY `courseid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbldepartment`
--
ALTER TABLE `tbldepartment`
  MODIFY `departmentid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblremark`
--
ALTER TABLE `tblremark`
  MODIFY `remarkid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblsemester`
--
ALTER TABLE `tblsemester`
  MODIFY `semesterid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblsubject`
--
ALTER TABLE `tblsubject`
  MODIFY `subjectid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblteacher`
--
ALTER TABLE `tblteacher`
  MODIFY `teacherid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblteacherlog`
--
ALTER TABLE `tblteacherlog`
  MODIFY `teacherlogid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teachersubject`
--
ALTER TABLE `teachersubject`
  MODIFY `teachersubid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
