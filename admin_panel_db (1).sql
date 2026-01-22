-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2026 at 02:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_panel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_sessions`
--

CREATE TABLE `academic_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_sessions`
--

INSERT INTO `academic_sessions` (`id`, `name`, `start_date`, `end_date`, `is_current`, `created_at`, `updated_at`) VALUES
(1, '2023-2024', '2023-04-01', '2024-03-31', 0, '2026-01-10 03:44:37', '2026-01-10 04:14:34'),
(2, '2024-2025', '2024-04-01', '2025-03-31', 0, '2026-01-10 03:44:37', '2026-01-10 04:14:34'),
(3, '2025-2026', '2025-04-01', '2026-03-31', 1, '2026-01-10 03:44:37', '2026-01-10 04:14:34');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `status` enum('Present','Absent','Late','Half Day') NOT NULL DEFAULT 'Present',
  `auth_method` varchar(255) NOT NULL DEFAULT 'Manual',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `available_quantity` int(11) NOT NULL DEFAULT 1,
  `rack_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `isbn`, `category`, `quantity`, `available_quantity`, `rack_number`, `created_at`, `updated_at`) VALUES
(1, 'Napoleon Hill', '1234567890', NULL, '10', 1, 1, NULL, '2026-01-10 05:18:46', '2026-01-10 05:18:46'),
(2, 'Think and Grow Rich', 'Napoleon Hill', '1234567890', NULL, 10, 10, NULL, '2026-01-10 05:18:58', '2026-01-10 05:23:11');

-- --------------------------------------------------------

--
-- Table structure for table `book_issues`
--

CREATE TABLE `book_issues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('Issued','Returned','Lost') NOT NULL DEFAULT 'Issued',
  `fine_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_issues`
--

INSERT INTO `book_issues` (`id`, `book_id`, `student_id`, `issue_date`, `due_date`, `return_date`, `status`, `fine_amount`, `created_at`, `updated_at`) VALUES
(1, 2, 51, '2026-01-10', '2026-01-20', '2026-01-10', 'Returned', 0.00, '2026-01-10 05:22:52', '2026-01-10 05:23:11');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@email.com|127.0.0.1', 'i:1;', 1769083430),
('laravel-cache-admin@email.com|127.0.0.1:timer', 'i:1769083430;', 1769083430),
('laravel-cache-admin@example.com|127.0.0.1', 'i:3;', 1769083443),
('laravel-cache-admin@example.com|127.0.0.1:timer', 'i:1769083443;', 1769083443);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `section` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_name`, `section`, `capacity`, `is_active`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Grade 1', NULL, NULL, 1, NULL, '2026-01-10 03:56:30', '2026-01-10 03:56:30'),
(2, 'Grade 2', NULL, NULL, 1, NULL, '2026-01-10 03:56:30', '2026-01-10 03:56:30');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `duration`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Heavy Equipment Mechanic Course', 'Eos officia tempora et debitis qui atque. Assumenda suscipit qui quae rerum aut saepe. Aut amet voluptatem qui accusamus optio. Mollitia ipsa quia illo sed soluta quis commodi.', '6 Months', 445.81, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(2, 'Aircraft Assembler Course', 'Neque fuga adipisci dolorem et ab doloribus. Accusamus itaque alias explicabo officia. Eum ullam qui unde molestias.', '1 Months', 189.55, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(3, 'Jeweler Course', 'Omnis iste autem voluptas dolor dolores eius rerum. Minus vero voluptates omnis tempore molestias. Velit laudantium laudantium nesciunt aut ratione minima quam.', '4 Months', 413.16, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(4, 'Homeland Security Course', 'Explicabo animi ducimus molestias sit ea velit molestiae. Est est iste quia dignissimos exercitationem optio aliquid dignissimos. Nulla officia commodi autem et enim fugit incidunt occaecati.', '2 Months', 256.29, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(5, 'Industrial Safety Engineer Course', 'Sint voluptatem fuga sunt cum doloremque aliquam modi. Reprehenderit est dolorem eius est commodi. Esse earum autem adipisci et a veritatis aut.', '5 Months', 347.60, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(6, 'Precision Printing Worker Course', 'Sed minima aliquid molestiae est. Voluptatem facilis facere laudantium quod omnis provident. Alias dolor rerum numquam sit quae modi.', '1 Months', 219.41, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(7, 'Orthodontist Course', 'Incidunt quis quos beatae hic. Voluptatem voluptates sint ab ipsa. Aut ut doloribus omnis sed voluptatem et eligendi.', '8 Months', 126.75, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(8, 'Nuclear Power Reactor Operator Course', 'Quidem dolorem perspiciatis similique. Minus blanditiis nemo sapiente. Quos soluta aut aliquid suscipit quia.', '7 Months', 478.94, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(9, 'Network Systems Analyst Course', 'Eius id animi iure in cupiditate. Consequuntur dolor odio doloribus voluptatem nisi aut. Iure aspernatur et ducimus vel sit harum vitae.', '12 Months', 489.01, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(10, 'Personal Trainer Course', 'Fuga maxime dolorum eligendi ut voluptas et. Laudantium ipsum qui eos a rerum. Ut expedita vitae dolorem delectus ut vel. Qui harum aliquam omnis aut repellat nostrum nam. Veniam itaque et laboriosam hic error cupiditate esse.', '9 Months', 188.32, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(11, 'Nuclear Technician Course', 'Ullam provident ipsum nihil. Nemo aut doloremque laborum omnis deserunt. Sunt velit autem qui voluptas debitis non. Cum sit atque itaque facilis dolores iste.', '10 Months', 115.62, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(12, 'Museum Conservator Course', 'Ipsa et excepturi ut labore qui non quisquam. Rerum repellendus saepe consequatur eius quo ratione repellendus nobis. Quasi vel optio est nulla qui consequatur officia. Esse animi autem ratione voluptatem velit.', '7 Months', 92.23, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(13, 'Agricultural Sciences Teacher Course', 'Quisquam et vero sint qui. Hic a quia sunt quia sit. Rerum laborum aliquid impedit hic sed id quas occaecati. Aut qui sit et velit consequatur itaque odio aliquam.', '8 Months', 185.96, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(14, 'Operations Research Analyst Course', 'Occaecati voluptatem nostrum fugit eveniet. Ut dolorum similique consequatur a. Autem ut ut tenetur nemo. Accusamus quia molestiae et velit et sunt.', '12 Months', 215.13, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(15, 'Gaming Manager Course', 'Eum ut et nihil excepturi quod pariatur sit. Molestiae est eaque deserunt expedita et doloremque. Possimus dolor enim molestias esse deleniti.', '5 Months', 155.74, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(16, 'Valve Repairer OR Regulator Repairer Course', 'Rem architecto recusandae laudantium delectus natus assumenda voluptatum. Dolor et minus aut quas. Ut aliquam veniam quaerat voluptas.', '9 Months', 170.83, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(17, 'Safety Engineer Course', 'Labore recusandae unde dignissimos et odio. Amet facere dolorem voluptate. Et et in corporis et omnis saepe.', '3 Months', 150.39, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(18, 'Physical Therapist Course', 'Tempora neque autem id repellendus omnis saepe sunt. Rem omnis ut animi ea labore. Amet nisi ut nostrum est ut velit.', '3 Months', 76.05, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(19, 'Auxiliary Equipment Operator Course', 'Architecto veniam neque reprehenderit est. Illo adipisci perferendis nostrum. Voluptas dolore facilis aut. Dolor unde dolores aspernatur delectus.', '12 Months', 90.26, '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(20, 'Reporters OR Correspondent Course', 'Maiores quas numquam maiores laudantium. Deleniti ut dolores molestiae sed. Blanditiis maxime et numquam nulla laudantium aut et voluptas.', '2 Months', 493.91, '2026-01-10 03:23:55', '2026-01-10 03:23:55');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `academic_session_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `academic_session_id`, `name`, `start_date`, `end_date`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 3, 'Final Term 2026', '2026-03-01', '2026-03-31', NULL, 1, '2026-01-10 04:50:48', '2026-01-10 04:50:48');

-- --------------------------------------------------------

--
-- Table structure for table `exam_marks`
--

CREATE TABLE `exam_marks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_schedule_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `marks_obtained` decimal(5,2) DEFAULT NULL,
  `is_absent` tinyint(1) NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_marks`
--

INSERT INTO `exam_marks` (`id`, `exam_schedule_id`, `student_id`, `marks_obtained`, `is_absent`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 52, 85.00, 0, NULL, '2026-01-10 04:53:10', '2026-01-10 04:53:10'),
(2, 1, 53, 0.00, 1, NULL, '2026-01-10 04:53:10', '2026-01-10 04:53:10'),
(3, 1, 54, 0.00, 0, NULL, '2026-01-10 04:53:10', '2026-01-10 04:53:10');

-- --------------------------------------------------------

--
-- Table structure for table `exam_schedules`
--

CREATE TABLE `exam_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `full_marks` int(11) NOT NULL DEFAULT 100,
  `pass_marks` int(11) NOT NULL DEFAULT 40,
  `room_no` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_schedules`
--

INSERT INTO `exam_schedules` (`id`, `exam_id`, `class_id`, `course_id`, `date`, `start_time`, `end_time`, `full_marks`, `pass_marks`, `room_no`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '2026-03-05', '09:00:00', '12:00:00', 100, 40, NULL, '2026-01-10 04:52:23', '2026-01-10 04:52:23');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_payments`
--

CREATE TABLE `fee_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `fee_structure_id` bigint(20) UNSIGNED NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `for_month` varchar(255) DEFAULT NULL,
  `for_year` int(11) NOT NULL,
  `receipt_no` varchar(255) NOT NULL,
  `payment_method` enum('Cash','Online','Cheque') NOT NULL DEFAULT 'Cash',
  `transaction_id` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_structures`
--

CREATE TABLE `fee_structures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `fee_head` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `fee_type` enum('Monthly','Quarterly','Half-Yearly','Yearly','One-Time') NOT NULL DEFAULT 'Yearly',
  `frequency` enum('One-Time','Monthly','Quarterly','Yearly') NOT NULL DEFAULT 'One-Time',
  `is_mandatory` tinyint(1) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internal_messages`
--

CREATE TABLE `internal_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `sender_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `sender_archived` tinyint(1) NOT NULL DEFAULT 0,
  `receiver_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `receiver_archived` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `internal_messages`
--

INSERT INTO `internal_messages` (`id`, `sender_id`, `receiver_id`, `subject`, `body`, `read_at`, `sender_deleted`, `sender_archived`, `receiver_deleted`, `receiver_archived`, `created_at`, `updated_at`) VALUES
(1, 7, 11, 'Test Message E5AFw', 'This is a generated test message body. FhV9d5yz7grRksHMe4ZHEK28wnJFFqpW05Vf5mjI4zKcEjiWLl', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-03 11:23:14', '2026-01-10 03:24:14'),
(2, 5, 1, 'Test Message 2b6vk', 'This is a generated test message body. apVfY1a9TN94M4565SdWECqUuhx7syyogHZpbYDIWWmfLFEica', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 05:27:14', '2026-01-10 03:24:14'),
(3, 2, 4, 'Test Message 4Ptox', 'This is a generated test message body. XAvZnp3V1OvnXM2tjI9hdtKvTcnxS2QOuCNdnVjpS7bsiedpw7', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-05 12:03:14', '2026-01-10 03:24:14'),
(4, 11, 2, 'Test Message dfOyO', 'This is a generated test message body. iaovINe6lBq8hfdP5B5fT702Cnuz6LPSJRe4ANGbytB8lSElcC', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-06 13:03:14', '2026-01-10 03:24:14'),
(5, 11, 8, 'Test Message yuk4h', 'This is a generated test message body. XMXbyMcOJoGBr7QS50x6opQo5xcI7XJGGgN4mVe6IeVhcGDM3M', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-06 17:37:14', '2026-01-10 03:24:14'),
(6, 10, 1, 'Test Message Iwn7t', 'This is a generated test message body. Ff3sVE10FFy5OIWJ3EyKhBFMUTHH0hCRFc4UcGjdAeOTFWEimO', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-09 10:31:14', '2026-01-10 03:24:14'),
(7, 9, 11, 'Test Message aLzry', 'This is a generated test message body. PKDs7AZpgf5biiawzkwtDNZhLvyEQlmczgzQKEDXQvhR8s3b7a', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 09:32:14', '2026-01-10 03:24:14'),
(8, 10, 2, 'Test Message 3JvA8', 'This is a generated test message body. sKyyBVfSWH8387HinN81ue3vQCSpWlTMmTjGuVhZCa8UnEL0m3', NULL, 0, 0, 0, 0, '2026-01-05 18:26:14', '2026-01-10 03:24:14'),
(9, 8, 1, 'Test Message kAwrc', 'This is a generated test message body. 9zvhxTUE8f0b2muqCapOcIUlMS4JIXqLrzkf8HTwwcY3IRpACH', NULL, 0, 0, 0, 0, '2026-01-09 23:56:14', '2026-01-10 03:24:14'),
(10, 5, 7, 'Test Message wviF4', 'This is a generated test message body. 6MSrApxQfBcSjYJv0wAAtRIh7LWbCkgAt4UzYS8BHMo7wyuwJP', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-07 21:00:14', '2026-01-10 03:24:14'),
(11, 5, 6, 'Test Message T4zw3', 'This is a generated test message body. ynXGjYlD4MMf0l1tEfDbfvODnXAUnMTF3M8HESPLeGietK5lPb', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-09 11:25:14', '2026-01-10 03:24:14'),
(12, 3, 2, 'Test Message c5Nn9', 'This is a generated test message body. wPDxs1azFVNgec68Krl8J1EhmvAS4fzUzJ65D63YIrob20ESxh', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-05 07:51:14', '2026-01-10 03:24:14'),
(13, 8, 6, 'Test Message aA9cI', 'This is a generated test message body. ddiTqbvqrOLwDIVG2mU2T5R5JB3pt34V8QylCCFkp8vmUPykHO', NULL, 0, 0, 0, 0, '2026-01-06 11:06:14', '2026-01-10 03:24:14'),
(14, 6, 5, 'Test Message hwAv3', 'This is a generated test message body. slSFx6bLR2bo8g5PcDxruQE9g2AvwRtjzQWIkVTqywRqEYyCiF', NULL, 0, 0, 0, 0, '2026-01-06 00:36:14', '2026-01-10 03:24:14'),
(15, 1, 5, 'Test Message 3Kfm4', 'This is a generated test message body. UEVVgyCmSiMhTmLhuFVM6e5jSFyR0K8vmhmCGOZK2KBSz5cfrR', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-03 14:55:14', '2026-01-10 03:24:14'),
(16, 1, 4, 'Test Message dU8Xz', 'This is a generated test message body. CdQc4WQXtgUys9hyf4p6lFz2bpbhAjcCJkPie2oNhXxasYhdXb', NULL, 0, 0, 0, 0, '2026-01-07 12:41:14', '2026-01-10 03:24:14'),
(17, 5, 3, 'Test Message tCHyH', 'This is a generated test message body. mGXVhifoDFioY27dgAypQh9yBbfDfCTE26M3YjK9PYBaEGpkyC', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-09 22:31:14', '2026-01-10 03:24:14'),
(18, 1, 4, 'Test Message 5SHvt', 'This is a generated test message body. 4WaY7lDcaOijoWRHEPQdArRI4WoR9IJTMP3lWVy2fsDOYntcuV', NULL, 0, 0, 0, 0, '2026-01-08 22:30:14', '2026-01-10 03:24:14'),
(19, 7, 10, 'Test Message pcv4g', 'This is a generated test message body. 7PnWQxJiz2wDQHNg16g8aXIl2SFpdAuMnj3MtH13LvxEixAc0T', NULL, 0, 0, 0, 0, '2026-01-07 02:50:14', '2026-01-10 03:24:14'),
(20, 5, 7, 'Test Message Cljk4', 'This is a generated test message body. JyjrfpMX7b3GdIGUexcKRDO7t4bCXerPqTbNaxq43J8U0VWwAW', NULL, 0, 0, 0, 0, '2026-01-04 09:41:14', '2026-01-10 03:24:14'),
(21, 2, 11, 'Test Message 6i5go', 'This is a generated test message body. 7BiCMPut32onbhs6YuMX3QoJBa18ScfJgIm9yMLFI8zhXndxH4', NULL, 0, 0, 0, 0, '2026-01-04 10:58:14', '2026-01-10 03:24:14'),
(22, 2, 10, 'Test Message ZGJIA', 'This is a generated test message body. BpJIOMG7CoLKyLrgj1bmyjuj9RQOyLhj9EdRDEknqwkjCgqnmx', NULL, 0, 0, 0, 0, '2026-01-08 00:11:14', '2026-01-10 03:24:14'),
(23, 6, 7, 'Test Message uRlnF', 'This is a generated test message body. xwzvbYIOyqNvd2UyQXeVnr5je935b3tnTqDNOosa9YYzFWFRWF', NULL, 0, 0, 0, 0, '2026-01-09 13:52:14', '2026-01-10 03:24:14'),
(24, 4, 9, 'Test Message A6S8D', 'This is a generated test message body. KmxFGgWJp069AlcIQjXtF0T13qy9ayV2D3mRubOGeGeAoXJQuO', NULL, 0, 0, 0, 0, '2026-01-07 00:56:14', '2026-01-10 03:24:14'),
(25, 11, 9, 'Test Message pxgah', 'This is a generated test message body. 9iSTQPKm8cXlX6wGrSnEh91jI6OnLKQGGKN93ipw0ghrSci3mD', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-07 07:37:14', '2026-01-10 03:24:14'),
(26, 4, 2, 'Test Message aC8zI', 'This is a generated test message body. mEg4ICf2dS2iNSKvkebmVNgH6BVNClLTKHbbiFPQAhpQ8i665P', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-05 21:24:14', '2026-01-10 03:24:14'),
(27, 10, 9, 'Test Message daw5a', 'This is a generated test message body. mUr8Gb0gOhfzbMQJ8wAd5WditfkgjOW0HOEiVGg0YjxMotYtbV', NULL, 0, 0, 0, 0, '2026-01-06 17:42:14', '2026-01-10 03:24:14'),
(28, 11, 3, 'Test Message 6iVJM', 'This is a generated test message body. lNI022bcPtWilW9Ndm5Mc6RxY9rKNFGa1BR991H1sWiaIfPUHQ', NULL, 0, 0, 0, 0, '2026-01-08 20:08:14', '2026-01-10 03:24:14'),
(29, 2, 8, 'Test Message 7DVdj', 'This is a generated test message body. Or8jB0xaULJz2rDwEAk89pQUI1dcZgKYo3tv0FKccQaRQgr7FX', NULL, 0, 0, 0, 0, '2026-01-03 05:25:14', '2026-01-10 03:24:14'),
(30, 5, 4, 'Test Message aSsM7', 'This is a generated test message body. KTlbFXmiVX869ORFVC1Y1ErNFe9i5nqMSoQ8uC1KXyKBJKm457', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-09 20:05:14', '2026-01-10 03:24:14'),
(31, 7, 8, 'Test Message l85sh', 'This is a generated test message body. a9EW8ZK2cW4FMviB95JbNpE8yBXO3LxJ2gvHr4evAh7sSEqH2d', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-08 18:33:14', '2026-01-10 03:24:14'),
(32, 5, 8, 'Test Message YXNzR', 'This is a generated test message body. bBF6QKbA7f5wVJHtfrpu4MaqQasnqxW7OTVbBTrVrJUPWQvEyC', NULL, 0, 0, 0, 0, '2026-01-04 01:13:14', '2026-01-10 03:24:14'),
(33, 1, 8, 'Test Message qHtKs', 'This is a generated test message body. yA0nJ9zH8RN2Fsr2ul82Jl5BnOqEMUFpdTCDyYAj4UUO8Tpq94', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 05:22:14', '2026-01-10 03:24:14'),
(34, 2, 4, 'Test Message QlFHb', 'This is a generated test message body. NlXm32AYt66u8XPQ0AMtWcrQMItA1m3GbofoS7brgVDXMEqm0A', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-06 02:34:14', '2026-01-10 03:24:14'),
(35, 4, 10, 'Test Message xHfkr', 'This is a generated test message body. iqKyIjbvYIdwajxhjToZB6bA7AKXgrZweus2FK6hlFDDTCC4jn', NULL, 0, 0, 0, 0, '2026-01-04 20:13:14', '2026-01-10 03:24:14'),
(36, 2, 8, 'Test Message atUqz', 'This is a generated test message body. Qgbf8LCPsaiGCrKWYaBWW9ep6dH2Md2aLhBvghhvezeI4LTphi', NULL, 0, 0, 0, 0, '2026-01-10 00:17:14', '2026-01-10 03:24:14'),
(37, 7, 1, 'Test Message vbWQ1', 'This is a generated test message body. joeOGaPLnogVSUFaRxqN3OB1lNWbAeMJyBKxxOGb4J5zbq77rI', NULL, 0, 0, 0, 0, '2026-01-04 05:02:14', '2026-01-10 03:24:14'),
(38, 1, 9, 'Test Message OLbdt', 'This is a generated test message body. Gv6bPdLafKds81wgjyLnvFDCz3qLp8Zd8Vgcuy2l2ANTwEWt8i', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-06 20:43:14', '2026-01-10 03:24:14'),
(39, 11, 10, 'Test Message euy12', 'This is a generated test message body. hc6mnYfUkP057jELf4nJ8HRmR8r8hmqMLinOhEXZxFklFsqeY7', NULL, 0, 0, 0, 0, '2026-01-08 18:25:14', '2026-01-10 03:24:14'),
(40, 9, 7, 'Test Message qME3L', 'This is a generated test message body. IXwYS8m3es58duMm6UE0yjd0vJgqMapUtoUpqKAU8S6XX9xV6L', NULL, 0, 0, 0, 0, '2026-01-08 22:15:14', '2026-01-10 03:24:14'),
(41, 1, 5, 'Test Message CW7xN', 'This is a generated test message body. qwUkvABj8wAn7uEGLh5zmudyApOgVLcz2pUotgcY0rCQ6L8GnU', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-09 07:50:14', '2026-01-10 03:24:14'),
(42, 8, 4, 'Test Message B7HYu', 'This is a generated test message body. yrFm4DyWzUH4TO1aF4SC9hD9uq7yKaCYLBw3Zglt30EbJFcdcS', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-09 13:28:14', '2026-01-10 03:24:14'),
(43, 1, 8, 'Test Message 7porD', 'This is a generated test message body. OSzkEVm6pLnKR8MoEuz9o0nzEqBRT974ka9fnhy60NhYRQtpNH', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-05 07:21:14', '2026-01-10 03:24:14'),
(44, 5, 10, 'Test Message ofka3', 'This is a generated test message body. R1NjkeOx1w2yqbhQg0mE2BN6MiJdx7cW2xSuHPETuwrxmEtl35', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-06 02:41:14', '2026-01-10 03:24:14'),
(45, 4, 1, 'Test Message vmACw', 'This is a generated test message body. XjJDP2GBDD1cbMHIFx2kOGPXbWG2ehi5iYApGj5ItoHivFNArW', NULL, 0, 0, 0, 0, '2026-01-03 21:49:14', '2026-01-10 03:24:14'),
(46, 11, 3, 'Test Message 9BcIy', 'This is a generated test message body. iVCywJQ318mj1pZqzhLbkeSYinroQspLoO3mmN0XQPz13XZQU1', NULL, 0, 0, 0, 0, '2026-01-09 22:50:14', '2026-01-10 03:24:14'),
(47, 5, 7, 'Test Message 7hU2w', 'This is a generated test message body. o3v3lh5re4CxgBcWCaJClNoGnqy7tBcTp8XkucRX0mfUA6Y4Zx', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-07 19:19:14', '2026-01-10 03:24:14'),
(48, 9, 2, 'Test Message Nrggk', 'This is a generated test message body. l829nNl0rerSAPkfT0Hpi7mGtlNBSt745jrjHMBGek1iXcakr3', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-08 13:23:14', '2026-01-10 03:24:14'),
(49, 4, 5, 'Test Message LnPw4', 'This is a generated test message body. R39M1cS97dgct2oahbuI1qZdLqnRc6asfVUVRDo9NYhaEJUU5C', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-05 14:07:14', '2026-01-10 03:24:14'),
(50, 5, 1, 'Test Message OOsy3', 'This is a generated test message body. pa648EThY4bWKDHw4cgCVdCCDZKrr1CKYbDuK1UscNhi8i5nDL', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-09 06:19:14', '2026-01-10 03:24:14'),
(51, 3, 10, 'Test Message UJXH8', 'This is a generated test message body. EEHsY5vh1Yijtl04mq4MSAQMuK8TZO1r5BXqiAnjD2QXdEyG2z', NULL, 0, 0, 0, 0, '2026-01-06 21:45:14', '2026-01-10 03:24:14'),
(52, 6, 2, 'Test Message v95sT', 'This is a generated test message body. vK2krb1I5RMhGUctD5wvtrApNZm0c2GenHz4KJB0nL8QCM4qsz', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 19:49:14', '2026-01-10 03:24:14'),
(53, 10, 9, 'Test Message aBBT0', 'This is a generated test message body. tOotl6Aq1NJ7yHbIgtgpZEzDstCzCbXDe6phdzObDXJxslUq2Z', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-08 22:31:14', '2026-01-10 03:24:14'),
(54, 1, 4, 'Test Message QRkED', 'This is a generated test message body. uWECrd9NiPlDoBJGXJQgxhWssSSGnO5axB9A7pzu89ilBNZUHJ', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-07 00:13:14', '2026-01-10 03:24:14'),
(55, 9, 8, 'Test Message A2YLz', 'This is a generated test message body. zbt0m94nRXu9YuqhrF1adN20zkv3HiOhN0FqYC8saHIc15B34d', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-06 18:46:14', '2026-01-10 03:24:14'),
(56, 3, 4, 'Test Message g5FjG', 'This is a generated test message body. xfYd1q4Z5KOF2wyk0DpyPZmQDH1H4Se5TJ3kIVxr40NUfR5f9B', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 11:07:14', '2026-01-10 03:24:14'),
(57, 7, 2, 'Test Message mz3Ua', 'This is a generated test message body. jUbZnaP9EfDlVHP67U9E5V9hCv6IFREZc0N4ZJvLeRhbJ9EuPa', NULL, 0, 0, 0, 0, '2026-01-06 07:29:14', '2026-01-10 03:24:14'),
(58, 7, 4, 'Test Message kmp2t', 'This is a generated test message body. 9mC1iAl5y0CdYWuE73Yz7z47al31zDwAO9RaMlPlv2xAiNQrIM', NULL, 0, 0, 0, 0, '2026-01-03 19:34:14', '2026-01-10 03:24:14'),
(59, 7, 5, 'Test Message veSEl', 'This is a generated test message body. rGnJwcipGQvLBlqk9S6VkdW4PImtEliLaSVKtSNDVfvLpaeKiC', NULL, 0, 0, 0, 0, '2026-01-07 00:39:14', '2026-01-10 03:24:14'),
(60, 6, 4, 'Test Message NNjrq', 'This is a generated test message body. E4d72rGoXfncyiqiD2LmtXkDCRFtn1yFi7YPiteOh01th1azaS', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 21:10:14', '2026-01-10 03:24:14'),
(61, 6, 1, 'Test Message 6KbuX', 'This is a generated test message body. gQdUujr0jOrcnnlKXHm9kc8YIpbRxcmLYMS1jaRgM0Kp0XzR9C', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-05 21:06:14', '2026-01-10 03:24:14'),
(62, 11, 8, 'Test Message D2EZf', 'This is a generated test message body. 0TCbuDBwMFfWQmElrvzg9P9urtXPrYDZWCgqA3QGHLRoBArUVR', NULL, 0, 0, 0, 0, '2026-01-09 09:13:14', '2026-01-10 03:24:14'),
(63, 7, 5, 'Test Message rCFHg', 'This is a generated test message body. ALmI2U6zR6ELFfUbQn6cqVNZKWDaurAOWmIsHN7ZD66hDze7Py', NULL, 0, 0, 0, 0, '2026-01-06 09:12:14', '2026-01-10 03:24:14'),
(64, 4, 3, 'Test Message 5lZMX', 'This is a generated test message body. R7HZ0CtkG3BTUPGak98KW0IXev4J9oMLtyyiAxQz4AElooWRxM', NULL, 0, 0, 0, 0, '2026-01-05 14:25:14', '2026-01-10 03:24:14'),
(65, 2, 3, 'Test Message Z26kq', 'This is a generated test message body. QntCinuvSTB40o4eo1JnGcSPgYLTXopZMKyZbqePdSCf1qBaTZ', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-05 15:28:14', '2026-01-10 03:24:14'),
(66, 7, 3, 'Test Message 1TPs9', 'This is a generated test message body. 0EzXigjYk2uMZKJgrIwExkOW3Z6da7aXDEHR9ZsXOMH8KrrdG8', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-07 04:46:14', '2026-01-10 03:24:14'),
(67, 10, 6, 'Test Message yMIqU', 'This is a generated test message body. UaO3JGUI5ZyKXGm8izFiGiQN7Rn1oLA3hR65AAjDZ4axcZkpIx', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 03:08:14', '2026-01-10 03:24:14'),
(68, 10, 3, 'Test Message caSCC', 'This is a generated test message body. Z9WBP5Pw45BXJU7VGe8aIrWUtWT2kNat6qsvBpLkNZsawESlrE', NULL, 0, 0, 0, 0, '2026-01-10 00:22:14', '2026-01-10 03:24:14'),
(69, 3, 7, 'Test Message B3Ruv', 'This is a generated test message body. G9T5c69AjBVWXXhMYqGPN30RtQpxkMVlHpAMhXDBjmaW48AFpb', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-05 05:28:14', '2026-01-10 03:24:14'),
(70, 2, 9, 'Test Message M5CKG', 'This is a generated test message body. vKeESwCHGNPGAI8nWIJ5VCfvpXlP06OtrWst5qTBBfGd6ZN4Zr', NULL, 0, 0, 0, 0, '2026-01-04 13:59:14', '2026-01-10 03:24:14'),
(71, 6, 9, 'Test Message 00yhe', 'This is a generated test message body. oz3IN3E756CmWIXfDESSHWqMpd6aqLwll9qSZk018RR2yFKHSb', NULL, 0, 0, 0, 0, '2026-01-04 23:43:14', '2026-01-10 03:24:14'),
(72, 11, 1, 'Test Message 9Gwtl', 'This is a generated test message body. TtBArkiV5TxpvuWK4FDX7VzWkuX7lFh1f9WsF8wsdqShsanCe5', NULL, 0, 0, 0, 0, '2026-01-05 20:04:14', '2026-01-10 03:24:14'),
(73, 11, 5, 'Test Message NvDPJ', 'This is a generated test message body. aNgRmt1Iq25NSVqVlOPmjS3xCdnkyd3QWgmqvgd55F1A8G5p23', NULL, 0, 0, 0, 0, '2026-01-08 01:52:14', '2026-01-10 03:24:14'),
(74, 3, 9, 'Test Message 5BRbB', 'This is a generated test message body. M9RESm01H63oxTtQxHnIGMaEtwA2qvngZUqYGnViPoZiDbIoEJ', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-07 00:31:14', '2026-01-10 03:24:14'),
(75, 8, 1, 'Test Message nacgf', 'This is a generated test message body. AV3cmARhHJu1MUltPdzdCdBuyHGXv7YMu9dypXxhkUCT9s6O3z', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-05 21:03:14', '2026-01-10 03:24:14'),
(76, 4, 5, 'Test Message cSDlA', 'This is a generated test message body. pZOzY7ZY2wTrO2W7Gti0w7ycHfBivwWdK28bLAcT9ANXb9AITF', NULL, 0, 0, 0, 0, '2026-01-07 06:02:14', '2026-01-10 03:24:14'),
(77, 2, 11, 'Test Message QQXsd', 'This is a generated test message body. MD6mXCgp6XkaCjY2XQikOotprYCBdp0faBeEsM6qvUrcT2sfoe', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-07 12:41:14', '2026-01-10 03:24:14'),
(78, 8, 6, 'Test Message x73WY', 'This is a generated test message body. aF8RinMRJT27IVJYRGO6l5VeAyBrXjodOFgi8LKXVnGxfYde4V', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 23:32:14', '2026-01-10 03:24:14'),
(79, 9, 10, 'Test Message EY8WI', 'This is a generated test message body. wFCraIAFo50AskwWZgtpmqR0v6gckNGKBBsznvetZJhmbVV57W', NULL, 0, 0, 0, 0, '2026-01-04 06:30:14', '2026-01-10 03:24:14'),
(80, 1, 8, 'Test Message pRpFu', 'This is a generated test message body. 3rXzWDhT6B8pmKZgosow6qiehR73EpF8xwOUAHAyjrEAma5mKb', NULL, 0, 0, 0, 0, '2026-01-03 18:51:14', '2026-01-10 03:24:14'),
(81, 6, 8, 'Test Message vD0ym', 'This is a generated test message body. fRC6kncGkFDjIzhwARuSvOWDVNB1Dc7jWaVlk8LdNR1hRB7lxs', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 11:43:14', '2026-01-10 03:24:14'),
(82, 10, 7, 'Test Message 21Pwh', 'This is a generated test message body. mOW06p6NsLSZawPox9nsPEUVfV8XyBLRQ4Ytr7bZPd0evX98gM', NULL, 0, 0, 0, 0, '2026-01-07 09:48:14', '2026-01-10 03:24:14'),
(83, 3, 11, 'Test Message eECMq', 'This is a generated test message body. TekqwIc1h9MuCEP9E1DATqatPOzhouKypMiJhIaBz1vEBRUEnF', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 02:57:14', '2026-01-10 03:24:14'),
(84, 11, 10, 'Test Message DqIjb', 'This is a generated test message body. di7dztvYDI6p8qv43C1i7sdxxakatA6JgMDEAR39NqSDBPzD5S', NULL, 0, 0, 0, 0, '2026-01-09 21:12:14', '2026-01-10 03:24:14'),
(85, 7, 1, 'Test Message 9fcX7', 'This is a generated test message body. wCf4ydkAbdUaWZrRjvKX0lNzALE5KTMYTaS7V0B9BceZLatfew', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-05 22:16:14', '2026-01-10 03:24:14'),
(86, 8, 6, 'Test Message KP2g6', 'This is a generated test message body. RSHAuJk4M1JpYaLsRCh9Th2ORuPvWKEZVOpisVaD2dzsAc81Gg', NULL, 0, 0, 0, 0, '2026-01-08 18:34:14', '2026-01-10 03:24:14'),
(87, 3, 4, 'Test Message rw18k', 'This is a generated test message body. KygTa1rb4W7hyoUVBlIuJJNLGTuY63w1VTAA9I7DvASrQI1xpd', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-07 03:06:14', '2026-01-10 03:24:14'),
(88, 2, 10, 'Test Message cCRJZ', 'This is a generated test message body. RkX6d7hoXiZUDAXZ8Lg4cb2Q3rOSRMt8p3CYhHOty0jNX5Y7gn', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-08 21:55:14', '2026-01-10 03:24:14'),
(89, 3, 8, 'Test Message 5bqh2', 'This is a generated test message body. n1pr7NsiTZHeN2hT8UcfKybtUL1TVfLUWHCfoguSplAzHX25h2', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 01:09:14', '2026-01-10 03:24:14'),
(90, 11, 4, 'Test Message WfdDE', 'This is a generated test message body. qtjej3Ldu84iFAGPx2GmLvNMRpDp1wInozz4oWXl92GCbyCLF6', NULL, 0, 0, 0, 0, '2026-01-04 12:41:14', '2026-01-10 03:24:14'),
(91, 11, 9, 'Test Message kjm2p', 'This is a generated test message body. bkjSv5YFxcZUXUotd9UfRcBZSzpRdzlbaq86OzGy8n3RQY0J20', NULL, 0, 0, 0, 0, '2026-01-08 04:39:14', '2026-01-10 03:24:14'),
(92, 8, 6, 'Test Message FLzIH', 'This is a generated test message body. vIYdxtaVwdI7uivHeNnzRuHQpLz2McnUY0zKw6P3eLBSOPsQDX', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-06 01:35:14', '2026-01-10 03:24:14'),
(93, 5, 3, 'Test Message U8AA9', 'This is a generated test message body. 6A7GTecxaCw2UGsLcZ3ghyKpRL3LUPKuDBnLMO147RyEplR5j1', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 09:39:14', '2026-01-10 03:24:14'),
(94, 1, 10, 'Test Message 5ry5g', 'This is a generated test message body. LDrwz6IcOONcHLMyz76XrB27oB7wHPjXoR8pP1MKGioyJogdRT', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-08 22:42:14', '2026-01-10 03:24:14'),
(95, 8, 9, 'Test Message 3zsdI', 'This is a generated test message body. CLZw8S34M08u3dZBBjWwyN0MldQMSzqcgqI7O9nfES0vt2RxHq', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-09 00:30:14', '2026-01-10 03:24:14'),
(96, 10, 6, 'Test Message lk9TG', 'This is a generated test message body. yoIHz7CfqyNPzXhNIBVK6LAdKsaSQF4QMC4Y5Sm3uNkiTa0euS', NULL, 0, 0, 0, 0, '2026-01-03 18:00:14', '2026-01-10 03:24:14'),
(97, 11, 1, 'Test Message 1nndJ', 'This is a generated test message body. Q5BRVLFvKvMYOiIMQFZmFktdxS57cE65MfW40wLsGkxGzuZQ2S', NULL, 0, 0, 0, 0, '2026-01-04 11:45:14', '2026-01-10 03:24:14'),
(98, 4, 9, 'Test Message 8XmRU', 'This is a generated test message body. mIUHHPatTl2JzQEZQEr0gs3nTB75jbqWJTm7LVkG6oAIi8ZFEy', NULL, 0, 0, 0, 0, '2026-01-09 19:52:14', '2026-01-10 03:24:14'),
(99, 11, 2, 'Test Message m6XEw', 'This is a generated test message body. jkHqltGh3yrvUEmHMMGKFwejIXWQGgLwMcNbVicEH1sqlJOLJr', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 08:07:14', '2026-01-10 03:24:14'),
(100, 1, 11, 'Test Message tN0NV', 'This is a generated test message body. 3YklZzn540gXhXELyp8PKrSSD90nIhiAO908OEVFxlG6f9FQAT', NULL, 0, 0, 0, 0, '2026-01-09 17:30:14', '2026-01-10 03:24:14'),
(101, 9, 1, 'Test Message YB6vM', 'This is a generated test message body. 0nInZT8yHeOe52jxNlE0jzL28fqTbZM6SLFtcpu4mxEEiQNDCg', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-08 15:51:14', '2026-01-10 03:24:14'),
(102, 3, 10, 'Test Message Taguw', 'This is a generated test message body. 2QRckUi4XZuEoEP0xxIPxOK4juvYTla1QuDXDVZa3xffoDfegx', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-08 15:12:14', '2026-01-10 03:24:14'),
(103, 11, 7, 'Test Message LA1g4', 'This is a generated test message body. eTW0BUufbLUkgFSu1IdYuI6C2gLhsKF48IJrfCHflz5PhmKpRe', NULL, 0, 0, 0, 0, '2026-01-05 17:28:14', '2026-01-10 03:24:14'),
(104, 1, 4, 'Test Message 2HdO5', 'This is a generated test message body. pIT9PFAD9lV3FLwpcie8LT2q2jJjC90KAToe7R5YqZH4UnwHlE', NULL, 0, 0, 0, 0, '2026-01-04 14:52:14', '2026-01-10 03:24:14'),
(105, 4, 8, 'Test Message FTkol', 'This is a generated test message body. OLI4RQqiMHCUnUnj4TK4Fnx2ND5mb85Mcp88hkSN77sHBZNaxd', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-03 08:13:14', '2026-01-10 03:24:14'),
(106, 7, 5, 'Test Message faS62', 'This is a generated test message body. PBlMg90M7RU2ihHbEg57Vn05OV9RUUv5ajWIzJa3JEUK5vfOuW', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-05 16:52:14', '2026-01-10 03:24:14'),
(107, 5, 2, 'Test Message O2hyU', 'This is a generated test message body. 24r0GvfUQMfFHqmAWDY1jEY3M1jOR39mH9QTDQjgbhJS6qpSau', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-05 05:41:14', '2026-01-10 03:24:14'),
(108, 3, 6, 'Test Message xBZqi', 'This is a generated test message body. cccgJCXNy9kAXXXf739z7yZpnisI2NNCIMCkduNvEQOH5gxQzj', NULL, 0, 0, 0, 0, '2026-01-07 07:58:14', '2026-01-10 03:24:14'),
(109, 9, 2, 'Test Message iK3Ih', 'This is a generated test message body. lCtWEdSkBJ11MnK1SMqAyP3TvGHUMaoGP6KSy8Bnbr0gKr25rx', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-03 08:27:14', '2026-01-10 03:24:14'),
(110, 7, 3, 'Test Message 1Wy5D', 'This is a generated test message body. n8jX17c298wDgaWJh85ALZYxWIXANu4eBskSlumQpJU6UOU8qE', NULL, 0, 0, 0, 0, '2026-01-06 13:29:14', '2026-01-10 03:24:14'),
(111, 11, 5, 'Test Message B847q', 'This is a generated test message body. rUmRRgodCPAQCKcLOMDwYAY75of92JU6hY7UENWMryV12oAZYn', NULL, 0, 0, 0, 0, '2026-01-08 16:11:14', '2026-01-10 03:24:14'),
(112, 9, 4, 'Test Message 41h9d', 'This is a generated test message body. W38f6s1ECquJZlcigV3kc6VTJ6W0cF3rWCFqNuIz4LrfTWAGsZ', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-08 01:51:14', '2026-01-10 03:24:14'),
(113, 5, 4, 'Test Message lp9LH', 'This is a generated test message body. maYB2uZrFN57DzZZLtjLkXm96Mhyz3jIKvbfjyswN1TlDtAWgN', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-05 23:55:14', '2026-01-10 03:24:14'),
(114, 11, 3, 'Test Message qOP9l', 'This is a generated test message body. 8J4GSOauNQ9hoF8ATl5WpT2xiexOzUdfcrtHsPnczVmrYpPDrn', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-08 02:02:14', '2026-01-10 03:24:14'),
(115, 1, 8, 'Test Message 2VkAS', 'This is a generated test message body. BV4Mej9bcQTf6sg31uHsqz1RF5J7i8DZh8PZpzJpTKpEl8adxY', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 03:13:14', '2026-01-10 03:24:14'),
(116, 6, 9, 'Test Message D46lw', 'This is a generated test message body. Ke9HYEQxpahyvzLkuZaZ8voQuMs6gwmdlxUUPGv4HMdGMYrOcd', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 06:35:14', '2026-01-10 03:24:14'),
(117, 2, 11, 'Test Message BO8lv', 'This is a generated test message body. iHLKpv8jT7Ge4RdwqqCA247o18XDxt1dyraaYbSYy6UulhN3Pz', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 00:19:14', '2026-01-10 03:24:14'),
(118, 1, 6, 'Test Message YSMk8', 'This is a generated test message body. rknuSGChrEPLcY4bPATXIRhATDpJNK0GfYXPqgLzXfwRby7ymn', NULL, 0, 0, 0, 0, '2026-01-05 14:49:14', '2026-01-10 03:24:14'),
(119, 4, 10, 'Test Message mQ4ea', 'This is a generated test message body. nqp4hKD51xZ3IjM8I5UKMDMMyWK9dge6wklPFBIoe8uh7Coi6y', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-03 14:57:14', '2026-01-10 03:24:14'),
(120, 10, 8, 'Test Message 2nG9I', 'This is a generated test message body. NHXhVIqxznfApbkOPyxm5UFk3iZG3KjjjTFBqr82axwRyA4EwS', NULL, 0, 0, 0, 0, '2026-01-06 17:07:14', '2026-01-10 03:24:14'),
(121, 8, 10, 'Test Message M9fU6', 'This is a generated test message body. 8Gg02Ok2S08pp5xHt3coiDm9vkcZcZmPMFCclemReeGuKrq6rZ', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-10 00:13:14', '2026-01-10 03:24:14'),
(122, 6, 3, 'Test Message NMss1', 'This is a generated test message body. XfDOFGASAuTWoCC3HTWzgtJ4BHjUzZkgGE45NeYJ0y6RLfRb1N', NULL, 0, 0, 0, 0, '2026-01-08 08:11:14', '2026-01-10 03:24:14'),
(123, 11, 8, 'Test Message sacXa', 'This is a generated test message body. ucdx737L3JCsefJgOWqAGPXdmOayNr7zAgn6XW3UIgVrct1C2z', NULL, 0, 0, 0, 0, '2026-01-06 15:10:14', '2026-01-10 03:24:14'),
(124, 3, 8, 'Test Message gEsQB', 'This is a generated test message body. 8JTBd1eYVTaV5GAGKurhKaC5ncSPz1RtgkS6SF43e5AVWGprt2', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-06 20:22:14', '2026-01-10 03:24:14'),
(125, 10, 2, 'Test Message j37OY', 'This is a generated test message body. xox4CfSzBZP7KaicslzDOSo3MHs7QpZwgp1UIVMU5GzhB0or0m', NULL, 0, 0, 0, 0, '2026-01-06 22:41:14', '2026-01-10 03:24:14'),
(126, 1, 5, 'Test Message y9kW8', 'This is a generated test message body. HykBaKdNdR4XdhwOy9ZZ2v0bD98bwdVK9LcFUk8vBzXbZPAwQH', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-08 11:47:14', '2026-01-10 03:24:14'),
(127, 4, 9, 'Test Message h87tT', 'This is a generated test message body. IUBL1o7aAlG0yuICAi4b5EWVOrwwUvbCPquiWRXpLXbL5qtUPa', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-06 22:27:14', '2026-01-10 03:24:14'),
(128, 4, 11, 'Test Message lkQ97', 'This is a generated test message body. RsQDtmeC0N2pf08AODonZlHzJ2mSpObSS8v1zF1XNcxIgHplQl', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-08 11:16:14', '2026-01-10 03:24:14'),
(129, 10, 9, 'Test Message Q8jML', 'This is a generated test message body. 6rYAYk1jyep9DOCfZTEJmjyJ21C9kpUYSm3dvKyhHMUT8rhuWY', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-06 00:39:14', '2026-01-10 03:24:14'),
(130, 1, 3, 'Test Message kzaxM', 'This is a generated test message body. JFEvJMxztptOGUoJjpYtNqiFgeQL1GB8ALx7bMKM5mGOH5DGne', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-07 02:02:14', '2026-01-10 03:24:14'),
(131, 3, 1, 'Test Message M8oSD', 'This is a generated test message body. epZcN8fpAzdeF9YwIuwmFpJh8bKXGeykHcps8k2FDBdThomV42', NULL, 0, 0, 0, 0, '2026-01-04 14:20:14', '2026-01-10 03:24:14'),
(132, 8, 7, 'Test Message raJZe', 'This is a generated test message body. qwAjKb9VvvYeYGbybQ9kXOAmk9FqLsadleRYZ2PHj3qEbDjHaQ', NULL, 0, 0, 0, 0, '2026-01-05 14:38:14', '2026-01-10 03:24:14'),
(133, 11, 7, 'Test Message 9gKLG', 'This is a generated test message body. gcjJlVTGsDoa6cn7HEB8NhjY9rWWD4RlgQ4jVfISCcL40r4fdl', NULL, 0, 0, 0, 0, '2026-01-07 19:31:14', '2026-01-10 03:24:14'),
(134, 6, 8, 'Test Message vHQ4H', 'This is a generated test message body. psWZuP4rTpk4vtQQ5w9m2uCItaAkJOPvs9i5ftT9RqbnWPFp1c', NULL, 0, 0, 0, 0, '2026-01-06 13:17:14', '2026-01-10 03:24:14'),
(135, 6, 2, 'Test Message mMP1c', 'This is a generated test message body. nOWVgnShM6aCWrOqi1sHgIgsfgHrVPRYtTREL5l18ya4Mx2zKb', NULL, 0, 0, 0, 0, '2026-01-05 09:53:14', '2026-01-10 03:24:14'),
(136, 10, 9, 'Test Message WHEKn', 'This is a generated test message body. iNtB442UN4xrCImYYOkuQmwEObMMuNnzp6uFdSjfRk7Y12xPKF', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-10 03:22:14', '2026-01-10 03:24:14'),
(137, 1, 8, 'Test Message sXdwn', 'This is a generated test message body. zCoWVG4PUMsAIHXF09hVT6VsOLIJqYlW6Gx5jzLmjHxuDYlps6', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-05 04:21:14', '2026-01-10 03:24:14'),
(138, 5, 9, 'Test Message Ezpn8', 'This is a generated test message body. hM1F1n2jMxQakrSXssz28gwi4ucXKSsfa7gEUXfsPFzowhDlgJ', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-07 04:28:14', '2026-01-10 03:24:14'),
(139, 1, 9, 'Test Message 6WBXX', 'This is a generated test message body. Od5tvNKVsVwsQSG3VN02tQzWRJ5OpwKVKKmGkDImGnrnJeMYjs', NULL, 0, 0, 0, 0, '2026-01-06 23:47:14', '2026-01-10 03:24:14'),
(140, 8, 7, 'Test Message T7QAK', 'This is a generated test message body. LnV1SS3IMcTdIlOJdG7tmzy9ZlnjfFneD2Yhfg5vCPwPzXYfTx', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-09 07:25:14', '2026-01-10 03:24:14'),
(141, 5, 1, 'Test Message dSM3U', 'This is a generated test message body. tLMjBGk98raPoRfYSlu1F5ZEKgxDuWO34MONLxwSDtzOOoOPbe', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-04 12:38:14', '2026-01-10 03:24:14'),
(142, 2, 6, 'Test Message 6vWcs', 'This is a generated test message body. frp5RVAXEwWWV07FIeCtJUBzEVG0yhGWp8Dg5g4RgTJ47tbZeP', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-08 11:54:14', '2026-01-10 03:24:14'),
(143, 7, 10, 'Test Message W8tCq', 'This is a generated test message body. UyVY1aUp5vWEZH8IcFlXBDzX1dtv1ebucozixmyerAEHiXDDe3', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-06 18:19:14', '2026-01-10 03:24:14'),
(144, 9, 11, 'Test Message 5jIdK', 'This is a generated test message body. GIsO69AfUUvgV6W22QhUk0XGBkc2j388V0g5Avi5hzM0dnJEkA', '2026-01-10 03:24:14', 0, 0, 0, 0, '2026-01-03 09:37:14', '2026-01-10 03:24:14'),
(145, 9, 2, 'Test Message DEUgo', 'This is a generated test message body. 2eprXKXSCHtM8gCSIkYWwX3ovXHCPIOybYUK9v87XCv7jYIygJ', NULL, 0, 0, 0, 0, '2026-01-09 16:27:14', '2026-01-10 03:24:14'),
(146, 3, 11, 'Test Message Gzy9Z', 'This is a generated test message body. x2MUoh1co8rRxhEPdJZIC4zCDw431qj5zcqfyhUi2A59671xHw', NULL, 0, 0, 0, 0, '2026-01-08 03:25:14', '2026-01-10 03:24:14'),
(147, 1, 7, 'Test Message lrQTV', 'This is a generated test message body. vdZSfjaUV8C4wz1RxPf9nyKXSeZ2Tne9lkLc0jH8fdiA2hvAAU', NULL, 0, 0, 0, 0, '2026-01-06 20:52:14', '2026-01-10 03:24:14'),
(148, 9, 10, 'Test Message jHseV', 'This is a generated test message body. d42r65N9cue79sK8LOqP8pKlZ5GWyEGURhoKqXBqgse7HkGC49', NULL, 0, 0, 0, 0, '2026-01-06 10:18:14', '2026-01-10 03:24:14'),
(149, 5, 8, 'Test Message d7sb6', 'This is a generated test message body. mQuC25FeMa6XdnegYEHoe2uNcYFwzbZn3gpkdiftrlHXfbGp2c', NULL, 0, 0, 0, 0, '2026-01-03 06:19:14', '2026-01-10 03:24:14'),
(150, 10, 11, 'Test Message m28bI', 'This is a generated test message body. hZ3OsWcCyGff8oBRfJHdDgMdAhDshDpIX46kbG1gj0Hnz8UtJg', NULL, 0, 0, 0, 0, '2026-01-03 19:21:14', '2026-01-10 03:24:14');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_attachments`
--

CREATE TABLE `message_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `internal_message_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_09_091035_create_students_table', 1),
(5, '2026_01_09_091047_create_courses_table', 1),
(6, '2026_01_09_112028_create_school_settings_table', 1),
(7, '2026_01_09_112034_create_classes_table', 1),
(8, '2026_01_09_112041_create_fee_structures_table', 1),
(9, '2026_01_09_113636_create_fee_payments_table', 1),
(10, '2026_01_09_113955_add_class_id_to_students_table', 1),
(11, '2026_01_09_121812_create_staff_table', 1),
(12, '2026_01_09_121813_add_photo_to_students_table', 1),
(13, '2026_01_09_121813_create_attendances_table', 1),
(14, '2026_01_09_122641_add_role_to_users_table', 1),
(15, '2026_01_09_122642_add_user_id_to_staff_table', 1),
(16, '2026_01_10_051950_create_internal_messages_table', 1),
(17, '2026_01_10_062155_create_message_attachments_table', 1),
(18, '2026_01_10_063033_add_is_archived_to_internal_messages_table', 1),
(19, '2026_01_10_090914_create_academic_sessions_table', 2),
(20, '2026_01_10_090917_create_student_sessions_table', 2),
(21, '2026_01_10_094717_create_student_attendances_table', 3),
(23, '2026_01_10_100617_create_exams_table', 4),
(24, '2026_01_10_100700_create_exam_schedules_table', 4),
(25, '2026_01_10_100800_create_exam_marks_table', 4),
(26, '2026_01_10_102837_create_time_tables_table', 5),
(28, '2026_01_10_104301_create_books_table', 6),
(29, '2026_01_10_104302_create_book_issues_table', 6),
(30, '2026_01_10_105528_add_parent_id_to_students_table', 7),
(31, '2026_01_10_105528_create_notices_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `target` enum('All','Students','Staff','Parents') NOT NULL DEFAULT 'All',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_settings`
--

CREATE TABLE `school_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('n8uEsjLUm662tryDQjkuEVab7Q6NoBDTYxvMvKI6', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidmFuUVYwQ2tjWGVYQnp1MmN1ZFY0clFTcmtSSjdiV0hWbjU5ZVAzViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9zdHVkZW50cyI7czo1OiJyb3V0ZSI7czoxNDoic3R1ZGVudHMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNDt9', 1769086948);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `designation` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `class_id`, `name`, `email`, `phone`, `photo`, `dob`, `created_at`, `updated_at`, `parent_id`) VALUES
(51, 1, 'John Doe', 'student1@example.com', NULL, NULL, NULL, '2026-01-10 03:56:30', '2026-01-10 04:04:01', NULL),
(52, 2, 'John Doe', 'john.doe@example.com', NULL, NULL, NULL, '2026-01-10 04:08:52', '2026-01-10 04:09:10', NULL),
(53, 2, 'Promotion Test', 'prom@test.com', NULL, NULL, NULL, '2026-01-10 04:11:35', '2026-01-10 04:11:54', NULL),
(54, 2, 'Test Promotion', 'test@promotion.com', NULL, NULL, NULL, '2026-01-10 04:12:30', '2026-01-10 04:13:54', NULL),
(55, 1, 'John Library', 'john.library@example.com', NULL, NULL, NULL, '2026-01-10 05:19:48', '2026-01-10 05:44:30', 13);

-- --------------------------------------------------------

--
-- Table structure for table `student_attendances`
--

CREATE TABLE `student_attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent','Late','Half Day','Holiday') NOT NULL DEFAULT 'Present',
  `remarks` text DEFAULT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_attendances`
--

INSERT INTO `student_attendances` (`id`, `student_id`, `class_id`, `date`, `status`, `remarks`, `is_locked`, `created_at`, `updated_at`) VALUES
(1, 52, 2, '2026-01-10', 'Present', NULL, 0, '2026-01-10 04:21:28', '2026-01-10 04:21:28'),
(2, 53, 2, '2026-01-10', 'Present', NULL, 0, '2026-01-10 04:21:28', '2026-01-10 04:21:28'),
(3, 54, 2, '2026-01-10', 'Present', NULL, 0, '2026-01-10 04:21:28', '2026-01-10 04:21:28');

-- --------------------------------------------------------

--
-- Table structure for table `student_sessions`
--

CREATE TABLE `student_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `academic_session_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('studying','promoted','failed','dropped') NOT NULL DEFAULT 'studying',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_sessions`
--

INSERT INTO `student_sessions` (`id`, `student_id`, `academic_session_id`, `class_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 51, 2, 1, 'promoted', '2026-01-10 03:59:31', '2026-01-10 03:59:31'),
(2, 51, 3, 2, 'studying', '2026-01-10 03:59:31', '2026-01-10 03:59:31'),
(3, 52, 2, 1, 'promoted', '2026-01-10 04:09:10', '2026-01-10 04:09:10'),
(4, 52, 3, 2, 'studying', '2026-01-10 04:09:10', '2026-01-10 04:09:10'),
(5, 53, 2, 1, 'promoted', '2026-01-10 04:11:54', '2026-01-10 04:11:54'),
(6, 53, 3, 2, 'studying', '2026-01-10 04:11:54', '2026-01-10 04:11:54'),
(7, 54, 2, 1, 'promoted', '2026-01-10 04:13:54', '2026-01-10 04:13:54'),
(8, 54, 3, 2, 'studying', '2026-01-10 04:13:54', '2026-01-10 04:13:54');

-- --------------------------------------------------------

--
-- Table structure for table `time_tables`
--

CREATE TABLE `time_tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED DEFAULT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room_no` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_tables`
--

INSERT INTO `time_tables` (`id`, `class_id`, `course_id`, `staff_id`, `day`, `start_time`, `end_time`, `room_no`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, 'Monday', '09:00:00', '10:00:00', '09:00', '2026-01-10 05:02:27', '2026-01-10 05:02:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', '2026-01-10 03:23:55', '$2y$12$f.hOK68Xpshmt9MKE9foGezqgRmkU1GiAiA6U9fzgi6LVr7/REQSa', 'admin', '342FyVeePRu1YQmuvqywfzv1yl0sOhQKzqS8lMgvORMvTkzx4PWkP645eyH1', '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(2, 'Selmer Thompson', 'richmond77@example.org', '2026-01-10 03:23:55', '$2y$12$CrM7FDDpz5Z88I18RlPDDO59Qn9Rqmry.tMqA4gDF3r1PIvWuKQPC', 'admin', 'GvWQaRqcM0', '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(3, 'Gerald Kihn', 'bashirian.tavares@example.net', '2026-01-10 03:23:55', '$2y$12$CrM7FDDpz5Z88I18RlPDDO59Qn9Rqmry.tMqA4gDF3r1PIvWuKQPC', 'admin', 'FET1JcfkHq', '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(4, 'Prof. Eduardo Conroy', 'mckenna.bednar@example.com', '2026-01-10 03:23:55', '$2y$12$CrM7FDDpz5Z88I18RlPDDO59Qn9Rqmry.tMqA4gDF3r1PIvWuKQPC', 'admin', 'p1u9kgQxUq', '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(5, 'Mr. Emerson Monahan DDS', 'katharina05@example.org', '2026-01-10 03:23:55', '$2y$12$CrM7FDDpz5Z88I18RlPDDO59Qn9Rqmry.tMqA4gDF3r1PIvWuKQPC', 'admin', 'vttHf18Deg', '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(6, 'Amaya Hackett', 'jamar08@example.org', '2026-01-10 03:23:55', '$2y$12$CrM7FDDpz5Z88I18RlPDDO59Qn9Rqmry.tMqA4gDF3r1PIvWuKQPC', 'admin', 'jBxHt2GFCg', '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(7, 'Catalina Klocko DDS', 'rhianna27@example.com', '2026-01-10 03:23:55', '$2y$12$CrM7FDDpz5Z88I18RlPDDO59Qn9Rqmry.tMqA4gDF3r1PIvWuKQPC', 'admin', 'xOxABItSR8', '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(8, 'Miss Avis Lynch IV', 'towne.nick@example.net', '2026-01-10 03:23:55', '$2y$12$CrM7FDDpz5Z88I18RlPDDO59Qn9Rqmry.tMqA4gDF3r1PIvWuKQPC', 'admin', 'OTaZZ2FRdh', '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(9, 'Mr. Cloyd Abernathy', 'jameson39@example.org', '2026-01-10 03:23:55', '$2y$12$CrM7FDDpz5Z88I18RlPDDO59Qn9Rqmry.tMqA4gDF3r1PIvWuKQPC', 'admin', 'rGoJSJZhfN', '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(10, 'Arnaldo Hagenes', 'earlene.lynch@example.net', '2026-01-10 03:23:55', '$2y$12$CrM7FDDpz5Z88I18RlPDDO59Qn9Rqmry.tMqA4gDF3r1PIvWuKQPC', 'admin', 'XrgNFAC03F', '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(11, 'Lilly Boyer', 'stephon63@example.org', '2026-01-10 03:23:55', '$2y$12$CrM7FDDpz5Z88I18RlPDDO59Qn9Rqmry.tMqA4gDF3r1PIvWuKQPC', 'admin', 'RIi0cwYOO1', '2026-01-10 03:23:55', '2026-01-10 03:23:55'),
(12, 'Test', 'test@example.com', NULL, '$2y$12$Da8lecPlnqAD7TWolb4MZu9cc90Yvx3TRIXDYdIf/odcN3AeC314a', 'admin', NULL, '2026-01-10 03:30:37', '2026-01-10 03:30:37'),
(13, 'Demo Parent', 'parent@demo.com', NULL, '$2y$12$95ruVd5/eMRG5ar2587GiOpyyPDwENUVQxwrBZw8R/dll3kpReDsa', 'parent', NULL, '2026-01-10 05:36:54', '2026-01-10 05:36:54'),
(14, 'Test', 'admin@gmail.com', NULL, '$2y$12$W.W.JRT8GLr7g6qBcMosL.WwyUJyUHK5AHAW0wpVbXdUgl8bu.MMu', 'admin', NULL, '2026-01-22 06:34:30', '2026-01-22 06:34:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_sessions`
--
ALTER TABLE `academic_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `academic_sessions_name_unique` (`name`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_staff_id_date_unique` (`staff_id`,`date`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `books_isbn_unique` (`isbn`);

--
-- Indexes for table `book_issues`
--
ALTER TABLE `book_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_issues_book_id_foreign` (`book_id`),
  ADD KEY `book_issues_student_id_foreign` (`student_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exams_academic_session_id_foreign` (`academic_session_id`);

--
-- Indexes for table `exam_marks`
--
ALTER TABLE `exam_marks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exam_marks_exam_schedule_id_student_id_unique` (`exam_schedule_id`,`student_id`),
  ADD KEY `exam_marks_student_id_foreign` (`student_id`);

--
-- Indexes for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exam_schedules_exam_id_class_id_course_id_unique` (`exam_id`,`class_id`,`course_id`),
  ADD KEY `exam_schedules_class_id_foreign` (`class_id`),
  ADD KEY `exam_schedules_course_id_foreign` (`course_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fee_payments`
--
ALTER TABLE `fee_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fee_payments_receipt_no_unique` (`receipt_no`),
  ADD KEY `fee_payments_student_id_foreign` (`student_id`),
  ADD KEY `fee_payments_fee_structure_id_foreign` (`fee_structure_id`);

--
-- Indexes for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fee_structures_class_id_foreign` (`class_id`);

--
-- Indexes for table `internal_messages`
--
ALTER TABLE `internal_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internal_messages_sender_id_foreign` (`sender_id`),
  ADD KEY `internal_messages_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_attachments`
--
ALTER TABLE `message_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_attachments_internal_message_id_foreign` (`internal_message_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `school_settings`
--
ALTER TABLE `school_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_email_unique` (`email`),
  ADD KEY `staff_user_id_foreign` (`user_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_email_unique` (`email`),
  ADD KEY `students_class_id_foreign` (`class_id`),
  ADD KEY `students_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `student_attendances`
--
ALTER TABLE `student_attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_attendances_student_id_date_unique` (`student_id`,`date`),
  ADD KEY `student_attendances_class_id_foreign` (`class_id`);

--
-- Indexes for table `student_sessions`
--
ALTER TABLE `student_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_sessions_student_id_academic_session_id_unique` (`student_id`,`academic_session_id`),
  ADD KEY `student_sessions_academic_session_id_foreign` (`academic_session_id`),
  ADD KEY `student_sessions_class_id_foreign` (`class_id`);

--
-- Indexes for table `time_tables`
--
ALTER TABLE `time_tables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `time_tables_class_id_foreign` (`class_id`),
  ADD KEY `time_tables_course_id_foreign` (`course_id`),
  ADD KEY `time_tables_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_sessions`
--
ALTER TABLE `academic_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `book_issues`
--
ALTER TABLE `book_issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam_marks`
--
ALTER TABLE `exam_marks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_payments`
--
ALTER TABLE `fee_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_structures`
--
ALTER TABLE `fee_structures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internal_messages`
--
ALTER TABLE `internal_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_attachments`
--
ALTER TABLE `message_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_settings`
--
ALTER TABLE `school_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `student_attendances`
--
ALTER TABLE `student_attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_sessions`
--
ALTER TABLE `student_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `time_tables`
--
ALTER TABLE `time_tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `book_issues`
--
ALTER TABLE `book_issues`
  ADD CONSTRAINT `book_issues_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_issues_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_academic_session_id_foreign` FOREIGN KEY (`academic_session_id`) REFERENCES `academic_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_marks`
--
ALTER TABLE `exam_marks`
  ADD CONSTRAINT `exam_marks_exam_schedule_id_foreign` FOREIGN KEY (`exam_schedule_id`) REFERENCES `exam_schedules` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_marks_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  ADD CONSTRAINT `exam_schedules_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_schedules_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_schedules_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_payments`
--
ALTER TABLE `fee_payments`
  ADD CONSTRAINT `fee_payments_fee_structure_id_foreign` FOREIGN KEY (`fee_structure_id`) REFERENCES `fee_structures` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_payments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD CONSTRAINT `fee_structures_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `internal_messages`
--
ALTER TABLE `internal_messages`
  ADD CONSTRAINT `internal_messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `internal_messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `message_attachments`
--
ALTER TABLE `message_attachments`
  ADD CONSTRAINT `message_attachments_internal_message_id_foreign` FOREIGN KEY (`internal_message_id`) REFERENCES `internal_messages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `student_attendances`
--
ALTER TABLE `student_attendances`
  ADD CONSTRAINT `student_attendances_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_sessions`
--
ALTER TABLE `student_sessions`
  ADD CONSTRAINT `student_sessions_academic_session_id_foreign` FOREIGN KEY (`academic_session_id`) REFERENCES `academic_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_sessions_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_sessions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `time_tables`
--
ALTER TABLE `time_tables`
  ADD CONSTRAINT `time_tables_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `time_tables_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `time_tables_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
