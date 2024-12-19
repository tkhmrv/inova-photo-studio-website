document.addEventListener('DOMContentLoaded', () => {
    const commentForm = document.querySelector('.comment-form-wrap form');

    if (commentForm) {
        commentForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Предотвращаем перезагрузку страницы

            const formData = new FormData(commentForm);
            formData.append('post_slug', document.querySelector('[name="post_slug"]').value);

            fetch('service/add_comment.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        addCommentToPage(data.comment);
                        showToast('Комментарий успешно добавлен!', false);
                        commentForm.reset();
                    } else {
                        showToast(data.message, true);
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    showToast('Ошибка добавления комментария.', true);
                });
        });
    }

    function addCommentToPage(comment) {
        const commentCountHeader = document.getElementById('comment-count-header');
    
        // Создаём HTML нового комментария
        const commentHTML = `
            <li class="comment">
                <div class="vcard bio">
                    <img src="images/users/${comment.photo}" alt="Аватар комментатора">
                </div>
                <div class="comment-body">
                    <h3>${comment.name}</h3>
                    <div class="meta">${comment.date}</div>
                    <p>${comment.message}</p>
                </div>
            </li>
        `;
    
        // Добавляем комментарий на страницу
        commentCountHeader.insertAdjacentHTML('afterend', commentHTML);
    
        // Обновляем количество комментариев
        const currentCount = parseInt(commentCountHeader.textContent.match(/\d+/)) || 0; // Получаем текущее число
        const newCount = currentCount + 1; // Увеличиваем на 1
        commentCountHeader.textContent = `Количество комментариев: ${newCount}`;
    }
});

// function showToast(message, isError = false) {
//     const toastElement = document.getElementById('newsToast');
//     const toastMessage = document.getElementById('toastMessage');

//     // Устанавливаем текст сообщения
//     toastMessage.textContent = message;

//     // Задаём стили для ошибки или успеха
//     if (isError) {
//         toastElement.classList.add('error');
//         toastElement.classList.remove('success');
//     } else {
//         toastElement.classList.add('success');
//         toastElement.classList.remove('error');
//     }

//     // Показываем тост
//     toastElement.classList.add('show');

//     // Автоматическое скрытие через 5 секунд
//     setTimeout(() => {
//         toastElement.classList.remove('show');
//     }, 50000);
// };

function showToast(message, isError = false) {
    // Находим или создаем контейнер для тостов
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container';
        document.body.appendChild(toastContainer);
    }

    // Создаем тост
    const toast = document.createElement('div');
    toast.className = 'toast';
    if (isError) {
        toast.classList.add('error');
    }
    toast.innerHTML = `
        <div class="toast-body">
            ${message}
            <button type="button" class="btn-close" aria-label="Close">&times;</button>
        </div>
    `;

    // Добавляем событие для кнопки закрытия
    toast.querySelector('.btn-close').addEventListener('click', () => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 500); // Удаляем из DOM после анимации
    });

    // Добавляем тост в контейнер и показываем его
    toastContainer.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10); // Небольшая задержка для анимации

    // Автоматическое скрытие через 5 секунд
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 500); // Удаляем из DOM после скрытия
    }, 50000);
}
