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

$user = getCurrentUser();

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
// $conn->close();

// Пример исходной даты из БД
$created_at = $post['created_at'];

// Преобразование даты в формат "14 Декабря 2024 в 13:30"
$date = new DateTime($created_at);
$formatted_date = $date->format('d') . ' ' . mb_strtolower(getMonthName($date->format('m'))) . ' ' . $date->format('Y') . ' в ' . $date->format('H:i');

?>

<!doctype html>
<html lang="en">

<head>

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

<?php include 'templates/header.php'; ?>

<div class="hero-2 overlay"
	style="background-image: url('images/<?php echo htmlspecialchars($post['main_photo']); ?>')">
	<div class="container">
		<div class="row align-items-center justify-content-center">
			<div class="col-lg-10 text-center mx-auto">

				<h1 class="heading text-white" data-aos="fade-up"><?php echo htmlspecialchars($post['title']); ?></h1>
				<p class="text-white" data-aos="fade-up" data-aos-delay="100"><span class="d-block mb-3 text-white"
						data-aos="fade-up"><?php echo $formatted_date; ?><span class="mx-2 text-primary">&bullet;</span>
						<?php echo htmlspecialchars($post['author']); ?></span></p>
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

				<ul class="comment-list">

					<?php
					$query = "SELECT 
									c.*, 
									u.name AS name, 
									u.email AS email, 
									u.website AS website,
									u.photo AS photo,
									count(*) OVER() AS comment_count
								FROM 
									comments c
								LEFT JOIN 
									users u ON c.user_id = u.id
								WHERE 
									c.post_slug = ?
								ORDER BY 
									c.comment_created_at DESC";

					$stmt = $conn->prepare($query);
					$stmt->bind_param("s", $slug);
					$stmt->execute();
					$result = $stmt->get_result();

					$comment_count = 0;
					$comments = [];

					while ($row = $result->fetch_assoc()) {
						$comment_count = $row['comment_count'];
						$comment_date = new DateTime($row['comment_created_at']);
						$comment_formatted_date = $comment_date->format('d') . ' ' . mb_strtolower(getMonthName($comment_date->format('m'))) . ' ' . $comment_date->format('Y') . ' в ' . $comment_date->format('H:i');

						$comments[] = [
							'photo' => $row['photo'],
							'name' => $row['name'],
							'date' => $comment_formatted_date,
							'message' => $row['message']
						];
					}

					// Вывод количества комментариев
					echo '<div class="pt-5">
						<h3 id="comment-count-header" class="mb-5">Количество комментариев: ' . htmlspecialchars($comment_count) . '</h3>';

					// Вывод комментариев
					foreach ($comments as $comment) {
						echo '<li class="comment">
							<div class="vcard bio">
								<img src="images/users/' . htmlspecialchars($comment['photo']) . '" alt="Аватар комментатотра">
							</div>
							<div class="comment-body">
								<h3>' . htmlspecialchars($comment['name']) . '</h3>
								<div class="meta">' . htmlspecialchars($comment['date']) . '</div>
								<p>' . nl2br(htmlspecialchars($comment['message'])) . '</p>
							</div>
						</li>';
					}
					?>
				</ul>

				<div class="comment-form-wrap pt-5">
					<h3 class="mb-5">Оставить комментарий</h3>
					<form action="service/add_comment.php" method="POST">
						<input type="hidden" name="post_slug" value="<?php echo htmlspecialchars($slug); ?>">
						<div class="mb-3">
							<label for="name">Имя *</label>
							<input class="form-control" type="text" id="name" name="name" minlength="3" maxlength="100"
								required
								value="<?php if (isset($user['name']))
									echo htmlspecialchars($user['name']); ?>">
						</div>

						<div class="mb-3">
							<label for="message">Сообщение *</label>
							<textarea id="message" name="message" cols="30" rows="10" class="form-control" required
								maxlength="200" placeholder="Не более 200 символов"></textarea>
						</div>
						<div class="mb-3">
							<input type="submit" value="Опубликовать" class="btn btn-primary btn-md">
						</div>
					</form>
				</div>


			</div>
			<div class="col-md-4 sidebar">
				<div class="sidebar-box">
					<img src="images/<?php echo htmlspecialchars($post['author_photo']); ?>" alt="Портрет автора поста"
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
<script src="js/add_comment.js"></script>

<!-- <div class="toast-container">
        <div id="newsToast" class="toast">
            <div class="d-flex align-items-center">
                <div class="toast-body">
                    <span id="toastMessage"></span>
                </div>
                <button type="button" class="btn-close" aria-label="Close"
                    onclick="this.closest('.toast').classList.remove('show')">&times;</button>
            </div>
        </div>
    </div> -->

</body>

</html>