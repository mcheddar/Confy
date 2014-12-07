SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `confy_NEW_CONFERENCE_configuration` (
  `setting` text NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `confy_NEW_CONFERENCE_configuration` (`setting`, `value`) VALUES
('page_title', 'New Conference'),
('name', 'New Event'),
('name_subtitle', ''),
('meta_title', ''),
('meta_keywords', ''),
('meta_reply_to', ''),
('meta_category', ''),
('meta_rating', ''),
('meta_robots', ''),
('meta_revisit_after', ''),
('deadline_registration', '1893538740'),
('deadline_submission', '1893538740'),
('conference_email', 'noreply@confy.sk'),
('page_footer', 'Copyright © 2012.'),
('regform_notes', ''),
('subform_notes', ''),
('subform_file_types', 'doc, docx, pdf'),
('app_body_background', '#FFFFFF'),
('app_body_text', '#000000'),
('app_main_background', '#FFFFFF'),
('app_lines_top', '#4C5F89'),
('app_lines_bottom', '#88B9E2'),
('app_h2_line', '#C6C6C6'),
('app_a_link', '#2E94F3'),
('app_a_hover', '#323232'),
('app_table_1', '#F5F5F5'),
('app_table_2', '#E6E6E6'),
('app_table_head', '#4C5F89'),
('app_table_head_text', '#FFFFFF'),
('app_table_border', '#BBBBBB'),
('app_menu_mainitem_bcg', '#4C5F89'),
('app_menu_mainitem_bcg_hover', '#88B9E2'),
('app_menu_mainitem_text', '#FFFFFF'),
('app_menu_mainitem_text_hover', '#FFFFFF'),
('app_menu_subitem_bcg', '#EAEBD8'),
('app_menu_subitem_bcg_hover', '#49A3FF'),
('app_menu_subitem_text', '#2875DD'),
('app_menu_subitem_text_hover', '#FFFFFF'),
('app_menu_subitem_border', '#5970B2'),
('email_new_registration_text', 'Thank you for registering to the <b>{CONFERENCE_FULL_NAME}</b>!\r\n\r\nYou can now log in to your user account using your e-mail address and password below. You can change your password in your Control Panel now or anytime later. \r\n\r\nE-mail: {USER_EMAIL}\r\nPassword: {USER_PASSWORD}\r\n\r\nLog in to your user account to review your registration details or submit a contribution. Please, don\\''t forget the following deadlines:\r\nDeadline for registration revision is on <b>{REGISTRATION_DEADLINE}</b>.\r\nDeadline for paper submission is on <b>{SUBMISSION_DEADLINE}</b>.\r\n\r\nIn the attachment, there is a confirmation PDF with your Registration Overview.\r\n\r\n\r\nSincerely,\r\n{PAGE_TITLE} Team'),
('email_new_registration_subject', '{PAGE_TITLE} - Welcome'),
('email_change_registration_text', 'Dear participant,\r\nyou have just changed your registration details on the <b>{CONFERENCE_FULL_NAME}</b>. The updated confirmation PDF with your Registration Overview is attached to this e-mail.\r\n\r\nLog in to your user account to review your registration details or submit a contribution. Please, don\\''t forget the following deadlines:\r\n\r\nDeadline for registration revision is on <b>{REGISTRATION_DEADLINE}</b>.<br />\r\nDeadline for paper submission is on <b>{SUBMISSION_DEADLINE}</b>.\r\n\r\n\r\nSincerely,\r\n{PAGE_TITLE} Team'),
('email_change_registration_subject', '{PAGE_TITLE} - Registration Changed'),
('email_new_password_text', 'Dear participant,\r\nYour password to the <b>{CONFERENCE_FULL_NAME}</b> has been reset.\r\n\r\nYou can now log in to your user account using your e-mail address and password below. You can change your password in your Control Panel now or anytime later. \r\n\r\nE-mail: {USER_EMAIL}\r\nPassword: {USER_PASSWORD}\r\n\r\n\r\nSincerely,\r\n{PAGE_TITLE} Team'),
('email_new_password_subject', '{PAGE_TITLE} - Your password has been reset'),
('email_new_contribution_text', 'Dear participant,\r\nYou have submitted a new contribution to the <b>{CONFERENCE_FULL_NAME}</b>. The contribution has been successfully received.\r\n\r\n<b>Type:</b> {PAPER_TYPE}\r\n<b>Topic:</b> {PAPER_TOPIC}\r\n<b>Title:</b> {PAPER_TITLE}\r\n\r\nYou can view and manage your contributions by logging into your user account.\r\n\r\n\r\nSincerely,\r\n{PAGE_TITLE} Team'),
('email_new_contribution_subject', '{PAGE_TITLE} - Contribution Received'),
('email_delete_contribution_text', 'Dear participant,\r\nYour contribution <b>{PAPER_TITLE}</b> has been successfully deleted.\r\n\r\n\r\nSincerely,\r\n{PAGE_TITLE} Team'),
('email_delete_contribution_subject', '{PAGE_TITLE} - Contribution Deleted'),
('msg_new_registration', 'Thank you for registering to the <b>{CONFERENCE_FULL_NAME}</b>! We have sent you a confirmation e-mail with a password to your user account. Use this password to <a href=\\"login.html\\">Log in</a>, if you want to submit a contribution, or change your registration details.\r\n\r\nDeadline for registration revision is on <b>{REGISTRATION_DEADLINE}</b>.\r\nDeadline for paper submission is on <b>{SUBMISSION_DEADLINE}</b>.');


CREATE TABLE IF NOT EXISTS `confy_NEW_CONFERENCE_menu` (
  `id_primary` int(11) NOT NULL auto_increment,
  `id` int(11) NOT NULL,
  `subitem` int(11) NOT NULL,
  `special` tinyint(1) NOT NULL,
  `link` text NOT NULL,
  `caption` text NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id_primary`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `confy_NEW_CONFERENCE_menu` (`id_primary`, `id`, `subitem`, `special`, `link`, `caption`, `hidden`) VALUES
(1, 1, 0, 1, 'home', 'Home Page', 0),
(2, 3, 1, 1, 'registration-form', 'Online Registration', 0),
(3, 4, 1, 1, 'participants', 'Registered Participants', 0),
(4, 6, 1, 1, 'submitted-papers', 'Submitted Papers', 0),
(5, 5, 0, 0, '0', 'Contributed Papers', 0),
(6, 2, 0, 0, '0', 'Registration', 0);

CREATE TABLE IF NOT EXISTS `confy_NEW_CONFERENCE_pages` (
  `id` int(11) NOT NULL auto_increment,
  `url` text NOT NULL,
  `title` text NOT NULL,
  `html` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `confy_NEW_CONFERENCE_pages` (`id`, `url`, `title`, `html`) VALUES
(1, 'home', 'Home Page', '<h2>Welcome!</h2>\r\nThis is the first page of the New Event.');

CREATE TABLE IF NOT EXISTS `confy_NEW_CONFERENCE_papers` (
  `id` int(11) NOT NULL auto_increment,
  `author` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `file` text NOT NULL,
  `type` text NOT NULL,
  `topic` int(11) NOT NULL,
  `title` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `confy_NEW_CONFERENCE_participants` (
  `id` int(11) NOT NULL auto_increment,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `title` text NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `university` text NOT NULL,
  `faculty` text NOT NULL,
  `street` text NOT NULL,
  `postal_code` text NOT NULL,
  `city` text NOT NULL,
  `country` text NOT NULL,
  `phone` text NOT NULL,
  `fax` text NOT NULL,
  `sex` text NOT NULL,
  `type_of_participant` text NOT NULL,
  `roommates` text NOT NULL,
  `type_of_menu` text NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `confy_NEW_CONFERENCE_regform` (
  `id_primary` int(11) NOT NULL auto_increment,
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `db_column` text NOT NULL,
  `caption` text NOT NULL,
  `options` text NOT NULL,
  `display` text NOT NULL,
  `required` int(11) NOT NULL,
  PRIMARY KEY  (`id_primary`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

INSERT INTO `confy_NEW_CONFERENCE_regform` (`id_primary`, `id`, `type`, `db_column`, `caption`, `options`, `display`, `required`) VALUES
(1, 1, 'title', '', 'Log in information', '', '', 0),
(2, 2, 'text', 'email', 'E-mail Address', '', '', 1),
(3, 3, 'title', '', 'Basic Information', '', '', 0),
(4, 4, 'radio', 'title', 'Title', 'Prof., Dr., Mr., Mrs., Ms.', 'row', 1),
(5, 5, 'text', 'first_name', 'First Name', '', '', 1),
(6, 6, 'text', 'last_name', 'Last Name', '', '', 1),
(7, 7, 'text', 'university', 'University / Institute', '', '', 1),
(8, 8, 'text', 'faculty', 'Faculty', '', '', 0),
(9, 9, 'text', 'street', 'Street & no.', '', '', 1),
(10, 10, 'text', 'postal_code', 'Postal Code', '', '', 1),
(11, 11, 'text', 'city', 'City', '', '', 1),
(12, 12, 'country_select', 'country', 'Country', '', '', 1),
(13, 13, 'text', 'phone', 'Phone', '', '', 0),
(14, 14, 'text', 'fax', 'Fax', '', '', 0),
(15, 15, 'title', '', 'Accomodation', '', '', 0),
(16, 16, 'radio', 'sex', 'Sex', 'Male, Female', 'row', 1),
(17, 17, 'radio', 'type_of_participant', 'Type of participant', 'regular participant, accompanying person', 'row', 1),
(18, 18, 'text', 'roommates', 'Desired roommate(s)', '', '', 0),
(19, 19, 'title', '', 'Additional Information', '', '', 0),
(20, 20, 'checkbox', 'type_of_menu', 'Type of menu', 'Vegetarian menu', 'row', 0),
(21, 21, 'textarea', 'comments', 'Comments', '', '', 0);

CREATE TABLE IF NOT EXISTS `confy_NEW_CONFERENCE_sessions` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `ip` text NOT NULL,
  `time` int(11) NOT NULL,
  `random_num` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `confy_NEW_CONFERENCE_topics` (
  `id` int(11) NOT NULL auto_increment,
  `topic` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
