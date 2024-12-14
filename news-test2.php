<?php
// Подключаем файл с подключением к базе данных
require_once 'db_connection.php'; // Предположим, ваш файл называется db_connection.php
require_once 'functions.php';

// Получение слага из URL или другого источника
$slug = isset($_GET['slug']) ? $conn->real_escape_string($_GET['slug']) : '';

//$slug = $_GET['slug'] ?? null;

if (empty($slug)) {
    die("Slug is required.");
}

// SQL-запрос для получения данных о посте по слагу
$query = "
SELECT 
    p.id, 
    p.title, 
    p.main_photo, 
    p.content, 
    p.created_at, 
    p.author, 
    p.author_description, 
    p.author_photo,
    GROUP_CONCAT(DISTINCT c.name SEPARATOR ', ') AS categories,
    GROUP_CONCAT(DISTINCT t.name SEPARATOR ', ') AS tags
FROM 
    posts p
LEFT JOIN 
    post_categories pc ON p.id = pc.post_id
LEFT JOIN 
    categories c ON pc.category_id = c.id
LEFT JOIN 
    post_tags pt ON p.id = pt.post_id
LEFT JOIN 
    tags t ON pt.tag_id = t.id
WHERE 
    p.slug = '$slug'
GROUP BY 
    p.id
";

$result = $conn->query($query);

// Проверка, найден ли пост
if ($result && $result->num_rows > 0) {
    // Извлекаем данные поста
    $post = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $website = mysqli_real_escape_string($conn, $_POST['website']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Вставляем комментарий в базу данных
    $comment_query = "INSERT INTO comments (post_slug, name, email, website, message) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($comment_query);
    $stmt->bind_param("issss", $slug, $name, $email, $website, $message);
    if ($stmt->execute()) {
        header("Location: " . $_SERVER['REQUEST_URI']); // Перезагружаем страницу
        exit();
    } else {
        echo "Ошибка: " . $stmt->error;
    }
}

// Закрытие соединения
//$conn->close();

// Пример исходной даты из БД
$created_at = $post['created_at'];

// Преобразование даты в формат "14 Декабря 2024 в 13:30"
$date = new DateTime($created_at);
$formatted_date = $date->format('d') . ' ' . mb_strtolower(getMonthName($date->format('m'))) . ' ' . $date->format('Y') . ' в ' . $date->format('H:i');

?>

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="author" content="Tikhomirov Semyon">
	<link rel="shortcut icon" href="images/logo.png">

	<meta name="description"
		content="Одна из лучших и перспективных студий профессиональной фотографии и видеосъемки в Санкт-Петербурге. Приглашаем моделей, фотографов и видеографов в нашу команду." />
	<meta name="keywords" content="фотостудия, фотосалон, фотография, видеография" />

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto&display=swap"
		rel="stylesheet">

	<link rel="stylesheet" href="fonts/icomoon/style.css">
	<link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
	<link rel="stylesheet" href="css/tiny-slider.css">
	<link rel="stylesheet" href="css/aos.css">
	<link rel="stylesheet" href="css/glightbox.min.css">
	<link rel="stylesheet" href="css/style.css">

	<title>Inova &mdash; студия профессиональной фотографии и видеосъемки</title>
</head>

<body>

	<?php include 'templates/header.php'; ?>

	<div class="hero-2 overlay" style="background-image: url('images/<?php echo htmlspecialchars($post['main_photo']); ?>')">
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-lg-10 text-center mx-auto">

					<h1 class="heading text-white" data-aos="fade-up"><?php echo htmlspecialchars($post['title']); ?></h1>
					<p class="text-white" data-aos="fade-up" data-aos-delay="100"><span class="d-block mb-3 text-white"
							data-aos="fade-up"><?php echo $formatted_date; ?><span class="mx-2 text-primary">&bullet;</span> <?php echo htmlspecialchars($post['author']); ?></span></p>
				</div>
			</div>
		</div>
	</div>

	<div class="section">
		<div class="container">
			<div class="row">
				<div class="col-md-8 blog-content pe-5">
					<?php echo $post['content'] ?>
					<div class="pt-5">
						<p>Тэги: <a><?php echo htmlspecialchars($post['tags']); ?></a>
						<p>
					</div>


					<div class="pt-5">
						<h3 class="mb-5">6 Comments</h3>
						<!-- <ul class="comment-list">
							<li class="comment">
								<div class="vcard bio">
									<img src="images/person_2.jpg" alt="Free Website Template by Free-Template.co">
								</div>
								<div class="comment-body">
									<h3>Jacob Smith</h3>
									<div class="meta">January 9, 2018 at 2:21pm</div>
									<p>When she reached the first hills of the Italic Mountains, she had a last view
										back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet
										Village and the subline of her own road, the Line Lane. Pityful a rethoric
										question ran over her cheek, then she continued her way.</p>
								</div>
							</li>

							<li class="comment">
								<div class="vcard bio">
									<img src="images/person_3.jpg" alt="Free Website Template by Free-Template.co">
								</div>
								<div class="comment-body">
									<h3>Chris Meyer</h3>
									<div class="meta">January 9, 2018 at 2:21pm</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum
										necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim
										sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
								</div>
							</li>


							<li class="comment">
								<div class="vcard bio">
									<img src="images/person_2.jpg" alt="Free Website Template by Free-Template.co">
								</div>
								<div class="comment-body">
									<h3>Chintan Patel</h3>
									<div class="meta">January 9, 2018 at 2:21pm</div>
									<p>Far far away, behind the word mountains, far from the countries Vokalia and
										Consonantia, there live the blind texts. Separated they live in Bookmarksgrove
										right at the coast of the Semantics, a large language ocean.</p>
								</div>
							</li>



							<li class="comment">
								<div class="vcard bio">
									<img src="images/person_1.jpg" alt="Free Website Template by Free-Template.co">
								</div>
								<div class="comment-body">
									<h3>Jean Doe</h3>
									<div class="meta">January 9, 2018 at 2:21pm</div>
									<p>A small river named Duden flows by their place and supplies it with the necessary
										regelialia. It is a paradisematic country, in which roasted parts of sentences
										fly into your mouth.</p>
								</div>
							</li>


							<li class="comment">
								<div class="vcard bio">
									<img src="images/person_4.jpg" alt="Free Website Template by Free-Template.co">
								</div>
								<div class="comment-body">
									<h3>Ben Afflick</h3>
									<div class="meta">January 9, 2018 at 2:21pm</div>
									<p>Even the all-powerful Pointing has no control about the blind texts it is an
										almost unorthographic life One day however a small line of blind text by the
										name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
								</div>
							</li>

							<li class="comment">
								<div class="vcard bio">
									<img src="images/person_1.jpg" alt="Free Website Template by Free-Template.co">
								</div>
								<div class="comment-body">
									<h3>Jean Doe</h3>
									<div class="meta">January 9, 2018 at 2:21pm</div>
									<p>Even the all-powerful Pointing has no control about the blind texts it is an
										almost unorthographic life One day however a small line of blind text by the
										name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
								</div>
							</li>
						</ul> -->

						<ul class="comment-list">
						
						<?php
						$query = "SELECT * FROM comments WHERE post_slug = ? ORDER BY comment_created_at DESC";
						$stmt = $conn->prepare($query);
						$stmt->bind_param("i", $slug);
						$stmt->execute();
						$result = $stmt->get_result();

						while ($row = $result->fetch_assoc()) {
							echo '
							<li class="comment">
								<div class="vcard bio">
									<img src="images/person_1.jpg" alt="User Avatar">
								</div>
								<div class="comment-body">
									<h3>' . htmlspecialchars($row['name']) . '</h3>
									<div class="meta">' . htmlspecialchars($row['comment_created_at']) . '</div>
									<p>' . nl2br(htmlspecialchars($row['message'])) . '</p>
								</div>
							</li>';
						}
						?>

						</ul>
						<!-- END comment-list -->

						<div class="comment-form-wrap pt-5">
							<h3 class="mb-5">Leave a comment</h3>
							<form action="#" class="">
								<div class="mb-3">
									<label for="name">Name *</label>
									<input type="text" class="form-control" id="name">
								</div>
								<div class="mb-3">
									<label for="email">Email *</label>
									<input type="email" class="form-control" id="email">
								</div>
								<div class="mb-3">
									<label for="website">Website</label>
									<input type="url" class="form-control" id="website">
								</div>

								<div class="mb-3">
									<label for="message">Message</label>
									<textarea name="" id="message" cols="30" rows="10" class="form-control"></textarea>
								</div>
								<div class="mb-3">
									<input type="submit" value="Post Comment" class="btn btn-primary btn-md">
								</div>

							</form>
						</div>
					</div>

				</div>

				<div class="col-md-4 sidebar">
					<div class="sidebar-box">
						<img src="images/<?php echo htmlspecialchars($post['author_photo']); ?>" alt="Free Website Template by Free-Template.co"
							class="img-fluid mb-4 w-50 rounded-circle">
						<h3 class="text-black">Об авторе</h3>
						<p><?php echo htmlspecialchars($post['author_description']); ?></p>
					</div>

					<div class="sidebar-box">
						<div class="categories">
							<h3>Категории</h3>
							<li><a style="color: #fc5404;"><?php echo htmlspecialchars($post['categories']); ?></a></li>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include 'templates/footer.php'; ?>

	<!-- Preloader -->
	<div id="overlayer"></div>
	<div class="loader">
		<div class="spinner-border" role="status">
			<span class="visually-hidden">Загрузка...</span>
		</div>
	</div>

	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/tiny-slider.js"></script>
	<script src="js/aos.js"></script>
	<script src="js/glightbox.min.js"></script>
	<script src="js/navbar.js"></script>
	<script src="js/counter.js"></script>
	<script src="js/custom.js"></script>
</body>

</html>