(function() {
    'use strict';

    // Получаем все элементы для переключения видимости пароля
    var toggleElements = document.querySelectorAll('.js-password-show-toggle');

    toggleElements.forEach(function(elToggle) {
        // Получаем соответствующее поле ввода пароля
        var passwordInput = elToggle.closest('.form-floating').querySelector('input[type="password"]');

        elToggle.addEventListener('click', (e) => {
            e.preventDefault();

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