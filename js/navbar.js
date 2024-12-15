(function () {
	'use strict'

	var siteMenuClone = function () {
		var jsCloneNavs = document.querySelectorAll('.js-clone-nav');
		var siteMobileMenuBody = document.querySelector('.site-mobile-menu-body');
		var isUserLoggedIn = document.body.getAttribute('data-user-logged-in') === 'true';

		// Клонируем основное меню
		jsCloneNavs.forEach(nav => {
			var navCloned = nav.cloneNode(true);
			navCloned.setAttribute('class', 'site-nav-wrap');
			siteMobileMenuBody.appendChild(navCloned);
		});

		// Создаем контейнер для пользовательских элементов внизу
		var userMenu = document.createElement('div');
		userMenu.className = 'user-menu fixed-bottom bg-light py-3 border-top'; // Bootstrap стили для нижнего размещения и разделения

		if (isUserLoggedIn) {
			userMenu.innerHTML = `
                <div class="container text-center">
                    <a href="account.php" class="btn btn-outline-primary w-100">
                        Личный кабинет
                    </a>
                </div>`;
		} else {
			userMenu.innerHTML = `
                <div class="container text-center">
                    <a href="signup.php" class="btn btn-primary btn-sm w-100 mb-2">Зарегистрироваться</a>
                    <a href="signin.php" class="btn btn-outline-primary btn-sm w-100">Войти</a>
                </div>`;
		}

		// Добавляем в конец мобильного меню
		document.querySelector('.site-mobile-menu').appendChild(userMenu);

		// Оставшаяся логика работы с мобильным меню
		setTimeout(function () {
			var hasChildrens = document.querySelector('.site-mobile-menu').querySelectorAll('.has-children');

			var counter = 0;
			hasChildrens.forEach(hasChild => {
				var refEl = hasChild.querySelector('a');
				var newElSpan = document.createElement('span');
				newElSpan.setAttribute('class', 'arrow-collapse collapsed');

				hasChild.insertBefore(newElSpan, refEl);

				var arrowCollapse = hasChild.querySelector('.arrow-collapse');
				arrowCollapse.setAttribute('data-toggle', 'collapse');
				arrowCollapse.setAttribute('data-target', '#collapseItem' + counter);

				var dropdown = hasChild.querySelector('.dropdown');
				dropdown.setAttribute('class', 'collapse');
				dropdown.setAttribute('id', 'collapseItem' + counter);

				arrowCollapse.addEventListener('click', function (e) {
					e.preventDefault();
					var collapseTarget = document.querySelector(arrowCollapse.getAttribute('data-target'));
					if (collapseTarget.classList.contains('show')) {
						collapseTarget.classList.remove('show');
						arrowCollapse.classList.add('collapsed');
					} else {
						collapseTarget.classList.add('show');
						arrowCollapse.classList.remove('collapsed');
					}
				});

				counter++;
			});
		}, 1000);



		// Click js-menu-toggle

		var menuToggle = document.querySelectorAll(".js-menu-toggle");
		var mTog;
		menuToggle.forEach(mtoggle => {
			mTog = mtoggle;
			mtoggle.addEventListener("click", (e) => {
				if (document.body.classList.contains('offcanvas-menu')) {
					document.body.classList.remove('offcanvas-menu');
					mtoggle.classList.remove('active');
					mTog.classList.remove('active');
				} else {
					document.body.classList.add('offcanvas-menu');
					mtoggle.classList.add('active');
					mTog.classList.add('active');
				}
			});
		})

		var specifiedElement = document.querySelector(".site-mobile-menu");
		var mt, mtoggleTemp;
		document.addEventListener('click', function (event) {
			var isClickInside = specifiedElement.contains(event.target);
			menuToggle.forEach(mtoggle => {
				mtoggleTemp = mtoggle
				mt = mtoggle.contains(event.target);
			})

			if (!isClickInside && !mt) {
				if (document.body.classList.contains('offcanvas-menu')) {
					document.body.classList.remove('offcanvas-menu');
					mtoggleTemp.classList.remove('active');
				}
			}

		});
	};

	document.addEventListener('DOMContentLoaded', function () {
		siteMenuClone();
	});

})();