CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(255) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    main_photo VARCHAR(255) NOT NULL,
    preview_photo VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    author VARCHAR(255) NOT NULL,
	  author_description TEXT NOT NULL,
	  author_photo VARCHAR(255) NOT NULL
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE post_categories (
    post_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (post_id, category_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE post_tags (
    post_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (post_id, tag_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_slug VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    comment_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_slug) REFERENCES posts(slug) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE users (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL DEFAULT 1,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified tinyint(1) DEFAULT 0,
    photo VARCHAR(255),
    website VARCHAR(255),
    signup_date datetime DEFAULT CURRENT_TIMESTAMP,
    `token` varchar(255) DEFAULT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

CREATE TABLE feedback_form (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_name VARCHAR(100) NOT NULL,
    sender_email VARCHAR(100) NOT NULL,
    topic VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    sent_at datetime DEFAULT CURRENT_TIMESTAMP
);

Грант

INSERT IGNORE INTO categories (name) VALUES ('Фотография'), ('Пленка'), ('Грант'), ('Оборудование'), ('Планы');
INSERT IGNORE INTO tags (name) VALUES ('#оцифровка'), ('#проявка'), ('#грант'), ('#оборудование'), ('#пополнение'), ('#планы'), ('#расширение'), ('#улица');;

INSERT INTO post_categories (post_id, category_id) 
VALUES (1, (SELECT id FROM categories WHERE name = 'Фотография'));
INSERT INTO post_categories (post_id, category_id) 
VALUES (1, (SELECT id FROM categories WHERE name = 'Пленка'));
INSERT INTO post_categories (post_id, category_id) 
VALUES (2, (SELECT id FROM categories WHERE name = 'Грант'));
INSERT INTO post_categories (post_id, category_id) 
VALUES (2, (SELECT id FROM categories WHERE name = 'Оборудование'));
INSERT INTO post_categories (post_id, category_id) 
VALUES (3, (SELECT id FROM categories WHERE name = 'Планы'));
INSERT INTO post_categories (post_id, category_id) 
VALUES (3, (SELECT id FROM categories WHERE name = 'Фотография'));

INSERT INTO post_tags (post_id, tag_id) 
VALUES (1, (SELECT id FROM tags WHERE name = '#оцифровка'));
INSERT INTO post_tags (post_id, tag_id) 
VALUES (1, (SELECT id FROM tags WHERE name = '#проявка'));
INSERT INTO post_tags (post_id, tag_id) 
VALUES (2, (SELECT id FROM tags WHERE name = '#грант'));
INSERT INTO post_tags (post_id, tag_id) 
VALUES (2, (SELECT id FROM tags WHERE name = '#оборудование'));
INSERT INTO post_tags (post_id, tag_id) 
VALUES (2, (SELECT id FROM tags WHERE name = '#пополнение'));
INSERT INTO post_tags (post_id, tag_id) 
VALUES (3, (SELECT id FROM tags WHERE name = '#планы'));
INSERT INTO post_tags (post_id, tag_id) 
VALUES (3, (SELECT id FROM tags WHERE name = '#расширение'));
INSERT INTO post_tags (post_id, tag_id) 
VALUES (3, (SELECT id FROM tags WHERE name = '#улица'));

INSERT INTO posts (slug, title, main_photo, content, author, author_description, author_photo) VALUES
(
    'film-photography', 
    'Пленочная фотография? Да легко!',
    'film.jpg',
    '<p class="lead">Спешим порадовать фотографов, которые не изменяют традициям и даже в цифровой век используют фотопленку. С этого дня наш фотосалон предлагает услуги проявки четырьмя разными процессами, а также оцифровку пленки.</p> <p>Проявка по процессу C-41 осуществляется в проходных процессорах Noritsu (V30, V50 и V100) и Fujifilm FP-232, с использованием отлично себя зарекомендовавших материалов фирмы Kodak. Автоматический контроль рабочей температуры и постоянное обновление растворов обеспечивают высочайшую стабильность и качество обработки.</p> <blockquote> <p>Проявка цветных обращаемых фотопленок по процессу Е-6 осуществляется в машине ротационного типа JOBO ATL-1500 фирменными растворами FUJI HUNT PRO Е6, с использованием дистиллированной воды, что гарантирует идеальную равномерность обработки эмульсии и стабильность процесса. </p> </blockquote> <p>Проявка черно-белых негативных фотопленок по процессу D-76 осуществляется в машине ротационного типа JOBO ATL-1500 с использованием проявителя Kodak Professional, специально рекомендованном для применения в проявочных машинах этого типа.</p> <p>ЕCN-II — это процесс проявки негативных цветных киноплёнок. Цветные негативные кинопленки сейчас активно используют для фотографии. Единственная особенность — сажевый противоореольный слой, который не позволяет проявлять такие пленки в автоматическом проявочном процессоре. В настоящих проявочных процессорах для ECN-II первым этапом идет смывка противоорельного слоя: под давлением специальные форсунки смывают сажу с пленки, валики убирают остатки сажи и далее пленка попадает в проявочные емкости с составами, мало отличающимися от процесса C-41.</p>',
    'Тео Крафорд',
    'Я Тео, фотограф и режиссер, работающий в Австрии, но имеющий корни в Великобритании и Японии. Я почти всегда использую пленку и люблю фотографировать все, что вызывает во мне интерес. Обычно это ландшафты, дома, интерьеры, сцены на улицах и необычное освещение.',
    'teo-news.jpg'
);

INSERT INTO posts (slug, title, main_photo, preview_photo, description, content, author, author_description, author_photo) VALUES
(
    'grant-won', 
    'Фотостудия выиграла грант на фото/видео оборудование!',
    'grant.jpg',
    'grant-prev.jpg',
    'Фотосалон Inova, получивший грант как перспективное творческое пространство, планирует расширить оборудование, чтобы удовлетворить спрос видеографов и контент-мейкеров.',
  '<p class="lead">Поздравляем себя и своих посетителей с прекрасной новостью — фотостудия Inova выиграла грант как перспективное творческое
пространство. После совещания генерального директора и всех специалистов фотостудии, было принято решение потратить
данный грант на увеличение оборудования, особенно для видеосъемок.
</p>
<p>Мы не хотим забыть про наших видеографов и контент-мейкеров. Именно поэтому 10 декабря состоялась встреча генерального
директора фотосалона с Анной Нятовой — специалистом по видеографии и одним из основных поставщиков нашего фотосалона.
</p>
<blockquote>
  <p>На встрече обсуждалась возможность приобретения фотосалоном нового оборудования, а конкретно: 1. Софтбоксов разных
размеров, для создания идеальных условий для съемки 2. Специализированных штативов, позволяющих делать плавные кадры и
подсъёмы 3. Анаморфотных объективов, позволяющих снимать кадры как в кино 4. Другого оборудования
 </p>
</blockquote>
<p>Вскоре наша коллекция для создания искусства пополнится. Приходите, чтобы попробовать новые технологии вживую!</p>',
    'Семен Тихомиров',
    'Основатель и генеральный директор фотостудии Inova. Имеет многолетний опыт работы в сфере профессиональной фотографии и инновационных технологий в фотографии. Под его руководством студия постоянно развивается, внедряя новые технологии и услуги для удовлетворения растущих потребностей клиентов в современном визуальном контенте.',
    'semyon.jpg'
);


INSERT INTO posts (slug, title, main_photo, preview_photo, description, content, author, author_description, author_photo) VALUES
(
    'street-photography', 
    'Уличная фотосъемка. Наши планы.',
    'street-photography.jpg',
    'street-prev.jpg',
    'Фотоcтудия готова расширить свои услуги, добавив уличную фотографию к существующим фотосессиям внутри помещений, открывая новые возможности для фотографов и моделей.',
    '<p class="lead">За почти 3 года работы нашего фотосалона мы успешно достигли все поставленные цели и хотим расширятся.
  Мы давно и много думали о том, какой путь выбрать. Общим решением стала уличная фотография.
</p>
<p>Скоро мы сможем предлагать фотосессии не только в наших крытых залах, но и в городе, на природе и на других
  интересных со стороны фотографии объектах. Фотосъемка свадьбы и других праздников не входит в планы.
</p>
<blockquote>
  <p>Фотография за пределами здания порой даже более интересна и необычна. Фотограф и модель не ограничены стенами и
    освещением софтбоксов. Вы сможете сами выбирать локации или довериться профессионалам. Различное освещение и
    композиция смогут привнести что-то новое в однообразные портфолио моделей, а для фотографов станут настоящим
    испытанием.
  </p>
</blockquote>
<p>Следите за новостями в наших соцсетях и не пропускайте момент!</p>',
    'Ксения Анисимова',
    'Я - арт-директор фотостудии Inova. Я имею глубокие знания в области художественной фотографии и современного визуального искусства. Под моим творческим руководством студия постоянно экспериментирует с новыми стилями и техниками, создавая уникальные образы для клиентов Inova.',
    'ksusha.jpg'
);