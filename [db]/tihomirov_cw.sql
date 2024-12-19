-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 19, 2024 at 04:53 PM
-- Server version: 10.11.10-MariaDB-ubu2204
-- PHP Version: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tihomirov_cw`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(3, 'Грант'),
(4, 'Оборудование'),
(5, 'Планы'),
(2, 'Пленка'),
(1, 'Фотография');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_slug` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `comment_created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_slug`, `message`, `comment_created_at`) VALUES
(1, 4, 'film-photography', 'Уважаемые фотографы! Я просто обалденная фотография. Пленка создает невероятный эффект. Спасибо за такое уникальное творчество!', '2024-12-15 21:42:53'),
(2, 5, 'film-photography', 'Фото просто потрясающее! Какая глубина, какое свечение. Пленочная техника - это настоящее искусство.', '2024-12-15 21:42:53'),
(3, 6, 'film-photography', 'Я не могу поверить, что это реальная фотография. Пленка добавляет такой волшебства. Очень впечатляюще!', '2024-12-15 21:42:53'),
(25, 3, 'street-photography', 'sn vdsfvsdfvjb j dsfjv dsfv', '2024-12-16 17:13:40'),
(26, 3, 'street-photography', 'ыфмалофы амфыам', '2024-12-16 17:15:06'),
(27, 3, 'street-photography', 'ыфмалофы амфыам', '2024-12-16 17:15:06'),
(28, 3, 'street-photography', '.neav s,dfvns dfv', '2024-12-16 17:21:33'),
(29, 3, 'street-photography', 'лывамлывамолдывамывам', '2024-12-16 17:26:18'),
(30, 9, 'street-photography', 'Гойдаааа', '2024-12-16 19:13:04'),
(31, 9, 'grant-won', 'Семен Тихомиров - Основатель и генеральный директор фотостудии Inova. \r\nМежгалактический уровень 🎯🔥', '2024-12-16 19:15:21'),
(32, 3, 'street-photography', 'rsfvasrvsfvsfv', '2024-12-17 10:56:28'),
(33, 3, 'street-photography', 'fvdafvafvfavs', '2024-12-17 10:56:43'),
(34, 3, 'street-photography', 'savjksakvdsfv', '2024-12-17 10:59:13'),
(35, 3, 'street-photography', 'avasmnfv sav', '2024-12-17 10:59:23'),
(36, 3, 'street-photography', 'тестовый комментарий', '2024-12-17 11:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_form`
--

CREATE TABLE `feedback_form` (
  `id` int(11) NOT NULL,
  `sender_name` varchar(100) NOT NULL,
  `sender_email` varchar(100) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sent_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback_form`
--

INSERT INTO `feedback_form` (`id`, `sender_name`, `sender_email`, `topic`, `message`, `sent_at`) VALUES
(1, 'test', 's3rvic3t3st@yandex.ru', 'тема', 'фмфам ва мваимывпиываифмвым', '2024-12-16 19:17:33'),
(2, 'kjvf kaf', 'rvebew@kjfnv.com', 'topic', 'message', '2024-12-16 19:19:01'),
(3, 'аумамвам', 'djfhvbdfs@lss.com', 'fvhbhsv', 'sdfvsfvsv', '2024-12-16 19:26:52'),
(4, 'test', 's3rvic3t3st@yandex.ru', 'asf sa', 'asd asd vdsfvdfdsd', '2024-12-16 19:55:26'),
(5, 'test', 's3rvic3t3st@yandex.ru', 's vsa as', 'kjf lhvdsbfhvblsd', '2024-12-16 19:57:11'),
(6, 'test', 's3rvic3t3st@yandex.ru', 'dfsbdgb', 'dsfjkv bhjsdbfh bsdf', '2024-12-16 19:58:57'),
(7, 'test', 's3rvic3t3st@yandex.ru', 'sadfsajdvnasjkd safvkjnaskjv', 'asdjcbkasbdvhaksbfv', '2024-12-16 19:59:47'),
(8, 'test', 's3rvic3t3st@yandex.ru', 'ыфам оывамывам', 'фыамфымфыамыфм', '2024-12-16 20:02:59'),
(9, 'test', 's3rvic3t3st@yandex.ru', 'dfvkds fv', 'sdj,fhv hjdsfjvsdfv', '2024-12-16 20:04:51'),
(10, 'test', 's3rvic3t3st@yandex.ru', 'afvkn sdjhfvsd', 'afvj sdhkjf vhj sdfhjv', '2024-12-16 20:07:47'),
(11, 'test', 's3rvic3t3st@yandex.ru', 'sfvfsdvsdv', 'jvh sdfjhvb jhsdfv', '2024-12-16 20:09:12'),
(12, 'test', 's3rvic3t3st@yandex.ru', 'выамывамыва', 'ывамывамывам', '2024-12-16 20:20:11'),
(13, 'Leonid', 'korobkov-leo@mail.ru', 'Не придумал', 'Гойдааааа', '2024-12-16 22:25:17');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `main_photo` varchar(255) NOT NULL,
  `preview_photo` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `author` varchar(255) NOT NULL,
  `author_description` text NOT NULL,
  `author_photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `slug`, `title`, `main_photo`, `preview_photo`, `description`, `content`, `created_at`, `author`, `author_description`, `author_photo`) VALUES
(1, 'film-photography', 'Пленочная фотография? Да легко!', 'film.jpg', 'film-prev.jpg', 'Фотостудия теперь предлагает услуги проявки фотопленки четырьмя процессами и оцифровку, используя современное оборудование и качественные материалы для сохранения оригинального изображения.', '<p class=\"lead\">Спешим порадовать фотографов, которые не изменяют традициям и даже в цифровой век используют\r\n  фотопленку. С этого дня наш фотосалон предлагает услуги проявки четырьмя разными процессами, а также оцифровку пленки.\r\n</p>\r\n<p>Проявка по процессу C-41 осуществляется в проходных процессорах Noritsu (V30, V50 и V100) и Fujifilm FP-232, с\r\n  использованием отлично себя зарекомендовавших материалов фирмы Kodak. Автоматический контроль рабочей температуры и\r\n  постоянное обновление растворов обеспечивают высочайшую стабильность и качество обработки.</p>\r\n<blockquote>\r\n  <p>Проявка цветных обращаемых фотопленок по процессу Е-6 осуществляется в машине ротационного типа JOBO ATL-1500\r\n    фирменными растворами FUJI HUNT PRO Е6, с использованием дистиллированной воды, что гарантирует идеальную\r\n    равномерность обработки эмульсии и стабильность процесса. </p>\r\n</blockquote>\r\n<p>Проявка черно-белых негативных фотопленок по процессу D-76 осуществляется в машине ротационного типа JOBO ATL-1500 с\r\n  использованием проявителя Kodak Professional, специально рекомендованном для применения в проявочных машинах этого\r\n  типа.</p>\r\n<p>ЕCN-II — это процесс проявки негативных цветных киноплёнок. Цветные негативные кинопленки сейчас активно используют\r\n  для фотографии. Единственная особенность — сажевый противоореольный слой, который не позволяет проявлять такие пленки\r\n  в автоматическом проявочном процессоре. В настоящих проявочных процессорах для ECN-II первым этапом идет смывка\r\n  противоорельного слоя: под давлением специальные форсунки смывают сажу с пленки, валики убирают остатки сажи и далее\r\n  пленка попадает в проявочные емкости с составами, мало отличающимися от процесса C-41.</p>', '2024-12-14 10:56:30', 'Тео Крафорд', 'Я Тео, фотограф и режиссер, работающий в Австрии, но имеющий корни в Великобритании и Японии. Я почти всегда использую пленку и люблю фотографировать все, что вызывает во мне интерес. Обычно это ландшафты, дома, интерьеры, сцены на улицах и необычное освещение.', 'teo-news.jpg'),
(2, 'grant-won', 'Фотостудия выиграла грант на фото/видео оборудование!', 'grant.jpg', 'grant-prev.jpg', 'Фотосалон Inova, получивший грант как перспективное творческое пространство, планирует расширить оборудование, чтобы удовлетворить спрос видеографов и контент-мейкеров.', '<p class=\"lead\">Поздравляем себя и своих посетителей с прекрасной новостью — фотостудия Inova выиграла грант как перспективное творческое\r\nпространство. После совещания генерального директора и всех специалистов фотостудии, было принято решение потратить\r\nданный грант на увеличение оборудования, особенно для видеосъемок.\r\n</p>\r\n<p>Мы не хотим забыть про наших видеографов и контент-мейкеров. Именно поэтому 10 декабря состоялась встреча генерального\r\nдиректора фотосалона с Анной Нятовой — специалистом по видеографии и одним из основных поставщиков нашего фотосалона.\r\n</p>\r\n<blockquote>\r\n  <p>На встрече обсуждалась возможность приобретения фотосалоном нового оборудования, а конкретно: 1. Софтбоксов разных\r\nразмеров, для создания идеальных условий для съемки 2. Специализированных штативов, позволяющих делать плавные кадры и\r\nподсъёмы 3. Анаморфотных объективов, позволяющих снимать кадры как в кино 4. Другого оборудования\r\n </p>\r\n</blockquote>\r\n<p>Вскоре наша коллекция для создания искусства пополнится. Приходите, чтобы попробовать новые технологии вживую!</p>', '2024-12-16 10:59:06', 'Семен Тихомиров', 'Основатель и генеральный директор фотостудии Inova. Имеет многолетний опыт работы в сфере профессиональной фотографии и инновационных технологий в фотографии. Под его руководством студия постоянно развивается, внедряя новые технологии и услуги для удовлетворения растущих потребностей клиентов в современном визуальном контенте.', 'semyon.jpg'),
(3, 'street-photography', 'Уличная фотосъемка. Наши планы.', 'street-photography.jpg', 'street-prev.jpg', 'Фотоcтудия готова расширить свои услуги, добавив уличную фотографию к существующим фотосессиям внутри помещений, открывая новые возможности для фотографов и моделей.', '<p class=\"lead\">За почти 3 года работы нашего фотосалона мы успешно достигли все поставленные цели и хотим расширятся.\r\n  Мы давно и много думали о том, какой путь выбрать. Общим решением стала уличная фотография.\r\n</p>\r\n<p>Скоро мы сможем предлагать фотосессии не только в наших крытых залах, но и в городе, на природе и на других\r\n  интересных со стороны фотографии объектах. Фотосъемка свадьбы и других праздников не входит в планы.\r\n</p>\r\n<blockquote>\r\n  <p>Фотография за пределами здания порой даже более интересна и необычна. Фотограф и модель не ограничены стенами и\r\n    освещением софтбоксов. Вы сможете сами выбирать локации или довериться профессионалам. Различное освещение и\r\n    композиция смогут привнести что-то новое в однообразные портфолио моделей, а для фотографов станут настоящим\r\n    испытанием.\r\n  </p>\r\n</blockquote>\r\n<p>Следите за новостями в наших соцсетях и не пропускайте момент!</p>', '2024-12-16 11:31:54', 'Ксения Анисимова', 'Я - арт-директор фотостудии Inova. Я имею глубокие знания в области художественной фотографии и современного визуального искусства. Под моим творческим руководством студия постоянно экспериментирует с новыми стилями и техниками, создавая уникальные образы для клиентов Inova.', 'ksusha.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

CREATE TABLE `post_categories` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_categories`
--

INSERT INTO `post_categories` (`post_id`, `category_id`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 1),
(3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

CREATE TABLE `post_tags` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_tags`
--

INSERT INTO `post_tags` (`post_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(2, 5),
(3, 6),
(3, 7),
(3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(2, 'Администратор'),
(1, 'Пользователь');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(3, '#грант'),
(4, '#оборудование'),
(1, '#оцифровка'),
(6, '#планы'),
(5, '#пополнение'),
(2, '#проявка'),
(7, '#расширение'),
(8, '#улица');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 1,
  `name` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `photo` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `signup_date` datetime DEFAULT current_timestamp(),
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `username`, `password`, `email`, `email_verified`, `photo`, `website`, `signup_date`, `token`) VALUES
(3, 2, 'test', 'test', '$2y$10$wF2Y8RyL4AxE9uF6lajtEOayzVrKFqmS5g8KyUahyQr9ZiFu0NySm', 's3rvic3t3st@yandex.ru', 1, '3_1734434263.jpg', 'https://www.diffchecker.com/text-compare/', '2024-12-15 17:38:02', '174e1fbac8ae1f8f27c1bb3d8d83a8'),
(4, 1, 'Александр Петров', 'alex_petrov', '$2y$10$abcdefghijklmnopqrstuv', 'alex.petrov@example.com', 0, 'person_1.jpg', 'http://petrov.ru', '2024-12-16 00:40:57', NULL),
(5, 1, 'Екатерина Смирнова', 'kate_smirnova', '$2y$10$bcdefghijklmnopqrstuvw', 'kate.smirnova@example.com', 0, 'person_2.jpg', 'http://smirnova.com', '2024-12-16 00:40:57', NULL),
(6, 1, 'Ольга Иванова', 'olga_ivanova', '$2y$10$cdefghijklmnopqrstuvwx', 'olga.ivanova@example.com', 0, 'person_3.jpg', 'http://ivanova.net', '2024-12-16 00:40:57', NULL),
(7, 1, 'Дмитрий Козлов', 'dmitry_kozlov', '$2y$10$defghijklmnopqrstuvwxy', 'dmitry.kozlov@example.com', 0, 'person_4.jpg', 'http://kozlov.org', '2024-12-16 00:40:57', NULL),
(8, 1, 'Анна Соколова', 'anna_sokolova', '$2y$10$efghijklmnopqrstuvwxyz', 'anna.sokolova@example.com', 0, 'person_5.jpg', 'http://sokolova.info', '2024-12-16 00:40:57', NULL),
(9, 1, 'Leonid', 'krbln', '$2y$10$lYv2yRI/6wiiGvXrpbPK7OztvOhxcJ1b59t18nVUfXfnGKCTeQc/W', 'korobkov-leo@mail.ru', 0, '9_1734376268.jpeg', '', '2024-12-16 22:10:41', 'f19557b5912e141107af1047e369db'),
(13, 1, 'semyon', 'semyon', '$2y$10$2aGPW13dLJvsD7MK9apY..jQg0Z14m4u/AlDrAlv7ckVONMlaLmnu', 'toy12u@gmail.com', 1, '13_1734434606.jpg', NULL, '2024-12-17 14:22:09', '6b23487c569ca219925889bda5e44376c6fa7786032a3cf9516a48cb89dbf056'),
(14, 1, 'Елена', '3232', '$2y$10$dZ9DpvpyKAhJdRuZAn9D8evo026cZQNtfThTXkh6H8Yy9HxDtONn6', 'tihomirova22@gmail.com', 1, NULL, NULL, '2024-12-17 21:40:41', '4762bb8804d14a552e63431809a0a09a2d469ac94a5412548e9f079d748ec4f9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_slug` (`post_slug`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `feedback_form`
--
ALTER TABLE `feedback_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`post_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`post_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `feedback_form`
--
ALTER TABLE `feedback_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_slug`) REFERENCES `posts` (`slug`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD CONSTRAINT `post_categories_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD CONSTRAINT `post_tags_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
