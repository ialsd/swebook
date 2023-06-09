create database swebook;
create user swebook with encrypted password '123456';

GRANT ALL PRIVILEGES ON DATABASE swebook TO swebook;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO swebook;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO swebook;

create table section(
  id integer primary key,
  name text,
  parent_id integer default null,
  level integer not null,
  status integer
);

insert into section values
(1, 'Разработчик программного обеспечения (SWEBOK)', 0, 1, 0),
(2, 'Управление требованиями', 1, 2, 0),
(3, 'Основы требований', 2, 3, 0),
(4, 'Определение требований', 3, 4, 1),
(5, 'Требования к продукту и процессу', 3, 4, 1),
(6, 'Функциональные и нефункциональные требования', 3, 4, 1),
(7, 'Независимые свойства', 3, 4, 1),
(8, 'Количественные требования', 3, 4, 1),
(9, 'Системные и программные требования', 3, 4, 1),
(10, 'Процесс', 2, 3, 0),
(11, 'Модели процессов', 10, 4, 1),
(12, 'Участники процессов', 10, 4, 1),
(13, 'Управление и поддержка процессов', 10, 4, 1),
(14, 'Качество и улучшение процессов', 10, 4, 1),
(15, 'Извлечение требований', 2, 3, 0),
(16, 'Источники требований', 15, 4, 1),
(17, 'Техники сбора требований', 15, 4, 1),
(18, 'Анализ требований', 2, 3, 0),
(19, 'Классификация требований', 18, 4, 1),
(20, 'Концептуальное моделирование', 18, 4, 1),
(21, 'Архитектурное проектирование и распределение требований', 18, 4, 1),
(22, 'Согласование требований', 18, 4, 1),
(23, 'Формальный анализ', 18, 4, 1),
(24, 'Спецификация требований', 2, 3, 0),
(25, 'Документ определения системы', 24, 4, 1),
(26, 'Спецификация системных требований', 24, 4, 1),
(27, 'Спецификация программных требований', 24, 4, 1),
(28, 'Утверждение требований', 2, 3, 0),
(29, 'Обзор требований', 28, 4, 1),
(30, 'Прототипирование', 28, 4, 1),
(31, 'Утверждение модели', 28, 4, 1),
(32, 'Приемочные тесты', 28, 4, 1),
(33, 'Практические соображения', 2, 3, 0),
(34, 'Итеративная природа процесса работы с требованиями', 33, 4, 1),
(35, 'Управление изменениями', 33, 4, 1),
(36, 'Атрибуты требований', 33, 4, 1),
(37, 'Трассировка требований', 33, 4, 1),
(38, 'Измеряемые требования', 33, 4, 1),
(39, 'Проектирование', 1, 2, 0),
(40, 'Основы проектирования', 39, 3, 0),
(41, 'Общие концепции проектирования', 40, 4, 1),
(42, 'Контекст программного дизайна', 40, 4, 1),
(43, 'Процесс проектирования', 40, 4, 1),
(44, 'Принципы проектирования', 40, 4, 1),
(45, 'Ключевые вопросы проектирования', 39, 3, 0),
(46, 'Параллелизм в проектировании', 45, 4, 1),
(47, 'Контроль и обработка событий', 45, 4, 1),
(48, 'Сохраняемость данных', 45, 4, 1),
(49, 'Распределенные компоненты', 45, 4, 1),
(50, 'Ошибки, обработка исключений и защищенность от сбоев', 45, 4, 1),
(51, 'Взаимодействие и представление', 45, 4, 1),
(52, 'Безопасность', 45, 4, 1),
(53, 'Структура и архитектура', 39, 3, 0),
(54, 'Архитектурные структуры и точки зрения', 53, 4, 1),
(55, 'Архитектурные стили (шаблоны архитектуры)', 53, 4, 1),
(56, 'Шаблоны проектирования', 53, 4, 1),
(57, 'Архитектурные решения', 53, 4, 1),
(58, 'Семейства программ и фреймворки', 53, 4, 1),
(59, 'Дизайн пользовательского интерфейса', 39, 3, 0),
(60, 'Общие принципы дизайна пользовательского интерфейса', 59, 4, 1),
(61, 'Вопросы проектирования пользовательского интерфейса', 59, 4, 1),
(62, 'Дизайн способов взаимодействия с пользователем', 59, 4, 1),
(63, 'Дизайн представления информации', 59, 4, 1),
(64, 'Процесс дизайна пользовательского интерфейса', 59, 4, 1),
(65, 'Локализация и интернационализация', 59, 4, 1),
(66, 'Метафоры и концептуальные модели', 59, 4, 1),
(67, 'Анализ качества и оценка дизайна', 39, 3, 0),
(68, 'Атрибуты качества', 67, 4, 1),
(69, 'Анализ качества и техники оценки', 67, 4, 1),
(70, 'Измерения', 67, 4, 1),
(71, 'Нотации дизайна', 39, 3, 0),
(72, 'Описания структуры (статическое представление)', 71, 4, 1),
(73, 'Описания поведения (динамическое представление)', 71, 4, 1),
(74, 'Стратегии и методы проектирования', 39, 3, 0),
(75, 'Основные стратегии', 74, 4, 1),
(76, 'Функционально-ориентированный (структурный) дизайн', 74, 4, 1),
(77, 'Объектно-ориентированный дизайн', 74, 4, 1),
(78, 'Проектирование на основе структур данных', 74, 4, 1),
(79, 'Компонентное проектирование', 74, 4, 1),
(80, 'Другие методы', 74, 4, 1),
(81, 'Инструменты для проектирования', 39, 3, 0),
(82, 'Конструирование (программирование)', 1, 2, 0),
(83, 'Основы конструирования', 82, 3, 0),
(84, 'Минимизация сложностей', 83, 4, 1),
(85, 'Прогнозирование изменений', 83, 4, 1),
(86, 'Конструирование с возможностью проверки', 83, 4, 1),
(87, 'Повторное использование', 83, 4, 1),
(88, 'Стандарты по конструированию', 83, 4, 1),
(89, 'Управление конструированием', 82, 3, 0),
(90, 'Конструирование в модели жизненного цикла', 89, 4, 1),
(91, 'Планирование конструирования', 89, 4, 1),
(92, 'Измерения в конструировании', 89, 4, 1),
(93, 'Практические соображения', 82, 3, 0),
(94, 'Проектирование в конструировании', 93, 4, 1),
(95, 'Языки конструирования', 93, 4, 1),
(96, 'Кодирование', 93, 4, 1),
(97, 'Тестирование в конструировании', 93, 4, 1),
(98, 'Конструирование для повторного использования', 93, 4, 1),
(99, 'Конструирование с повторным использованием', 93, 4, 1),
(100, 'Качество конструирования', 93, 4, 1),
(101, 'Интеграция', 93, 4, 1),
(102, 'Технологии конструирования', 82, 3, 0),
(103, 'Проектирование и использование API', 102, 4, 1),
(104, 'Вопросы выполнения в объектно-ориентированных программах', 102, 4, 1),
(105, 'Параметризация и дженерики', 102, 4, 1),
(106, 'Assertions, проектирование по контракту и защитное программирование', 102, 4, 1),
(107, 'Обработка ошибок, исключительных ситуаций и устойчивость к сбоям', 102, 4, 1),
(108, 'Модели исполнения', 102, 4, 1),
(109, 'Техники конструирования на основе состояний и таблиц', 102, 4, 1),
(110, 'Конфигурирование и интернационализация на этапе исполнения', 102, 4, 1),
(111, 'Обработка входных данных на основе грамматик', 102, 4, 1),
(112, 'Примитивы параллелизации', 102, 4, 1),
(113, 'Middleware', 102, 4, 1),
(114, 'Методы конструирования распределенных систем', 102, 4, 1),
(115, 'Методы конструирования гетерогенных систем', 102, 4, 1),
(116, 'Анализ и управление производительностью', 102, 4, 1),
(117, 'Стандарты платформ', 102, 4, 1),
(118, 'Программирование методом "сначала тест"', 102, 4, 1),
(119, 'Инструменты для конструирования', 82, 3, 0),
(120, 'Среды разработки', 119, 4, 1),
(121, 'Средства разработки GUI', 119, 4, 1),
(122, 'Инструменты для юнит-тестирования', 119, 4, 1),
(123, 'Профилирование, анализ производительности и slicing', 119, 4, 1),
(124, 'Тестирование', 1, 2, 0),
(125, 'Профессиональные стандарты РФ', 0, 1, 0),
(126, 'Потребности базового предприятия', 0, 1, 0),
(127, 'Запросы студентов (программирование)', 0, 1, 0),
(128, 'Потребности других работодателей', 0, 1, 0);

alter table section add column status_prc integer;

create table tag(
 id integer primary key,
 name text
);

insert into tag values
(1, 'RLS'),
(2, 'APIS'),
(3, 'YAMP');


CREATE TABLE section_tag (
    section_id INTEGER,
    tag_id INTEGER,
    FOREIGN KEY (section_id) REFERENCES section(id),
    FOREIGN KEY (tag_id) REFERENCES tag(id)
);

GRANT ALL PRIVILEGES ON DATABASE swebook TO swebook;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO swebook;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO swebook;