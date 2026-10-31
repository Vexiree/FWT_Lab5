CREATE DATABASE IF NOT EXISTS `lab5_data` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `lab5_data`;

DROP TABLE IF EXISTS `terms`;

CREATE TABLE `terms` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `term` VARCHAR(255) NOT NULL,
  `definition` TEXT NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `terms` (`term`, `definition`, `image`) VALUES
('Салат Цезарь', 'Очень вкусный салат', 'Salad1.png'),
('Греческий салат', 'Тоже хороший салат', 'Salad2.png'),
('Салат Капрезе', 'Прикольный итальянский салат', 'Salad3.png'),
('Салат Оливье', 'Тоже приятный салат', 'Salad4.png'),
('Салат Нисуаз', 'Вкусный салат очень!', 'Salad5.png'),
('Салат Вальдорф', 'Тоже салат нормальный', 'Salad6.png'),
('Салат Винегрет', 'Русский салат, на новый год', 'Salad7.png'),
('Салат Табуле', 'Восточный салат, прикольный', 'Salad8.png'),
('Салат Кобб', 'Тоже неплохой салат', 'Salad9.png'),
('Салат Чука', 'Какой то салат с востока', 'Salad10.png');
