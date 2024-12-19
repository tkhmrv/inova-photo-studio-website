(function() {
    'use strict';

    // Получаем все элементы для переключения видимости пароля
    var toggleElements = document.querySelectorAll('.js-password-show-toggle');

    toggleElements.forEach(function(elToggle) {
        // Найдём конкретный input, который стоит перед текущей кнопкой
        var passwordInput = elToggle.previousElementSibling;

        elToggle.addEventListener('click', (e) => {
            e.preventDefault();

            // Переключаем тип input между "password" и "text"
            if (elToggle.classList.contains('active')) {
                passwordInput.setAttribute('type', 'password');
                elToggle.classList.remove('active');
            } else {
                passwordInput.setAttribute('type', 'text');
                elToggle.classList.add('active');
            }
        });
    });
})();