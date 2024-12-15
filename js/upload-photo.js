function uploadPhoto(input) {
    const file = input.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('photo', file);

    fetch('service/upload_photo.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        const toastElement = document.getElementById('accountToast');
        const toastMessage = document.getElementById('toastMessage');

        if (data.success) {
            // Устанавливаем изображение
            document.querySelector('img[alt="Аватар пользователя"]').src = 'images/users/' + data.filename;

            // Успешный toast
            toastMessage.textContent = 'Фотография успешно загружена!';
            toastElement.classList.remove('error');
        } else {
            // Ошибка
            toastMessage.textContent = data.message;
            toastElement.classList.add('error');
        }

        // Показываем toast
        toastElement.classList.add('show');
        setTimeout(() => {
            toastElement.classList.remove('show');
        }, 5000);
    })
    .catch(error => {
        console.error('Ошибка загрузки файла:', error);

        const toastElement = document.getElementById('accountToast');
        const toastMessage = document.getElementById('toastMessage');

        toastMessage.textContent = 'Ошибка загрузки файла.';
        toastElement.classList.add('error');
        toastElement.classList.add('show');

        setTimeout(() => {
            toastElement.classList.remove('show');
        }, 5000);
    });
}