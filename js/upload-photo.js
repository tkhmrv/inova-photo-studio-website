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
        if (data.success) {
            document.querySelector('img[alt="Аватар пользователя"]').src = 'images/users/' + data.filename;
        } else {
            alert('Ошибка: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Ошибка загрузки файла:', error);
        alert('Ошибка загрузки файла.');
    });
}