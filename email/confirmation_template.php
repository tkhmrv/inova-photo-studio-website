<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Подтверждение регистрации</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 20px;">
  <table style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
    <tr>
      <td style="text-align: center; padding: 20px;">
        <h1 style="font-size: 24px; color: #333;">Подтвердите ваш Email</h1>
      </td>
    </tr>
    <tr>
      <td style="padding: 0 20px;">
        <p>Здравствуйте, {{username}}!</p>
        <p>Благодарим за регистрацию на сайте фотостудии Inova. Пожалуйста, подтвердите свой email, нажав на кнопку ниже.</p>
      </td>
    </tr>
    <tr>
      <td style="text-align: center; padding: 20px;">
        <a href="{{confirmation_link}}" style="display: inline-block; padding: 10px 20px; background-color: #fc5404; color: #ffffff; text-decoration: none; border-radius: 4px; font-size: 16px;">Подтвердить Email</a>
      </td>
    </tr>
    <tr>
      <td style="padding: 0 20px;">
        <p>Если кнопка не работает, перейдите по ссылке:</p>
        <p><a href="{{confirmation_link}}" style="color: #fc5404;">{{confirmation_link}}</a></p>
      </td>
    </tr>
    <tr>
      <td style="text-align: center; padding: 20px; font-size: 12px; color: #999;">
        <p>© 2024 Inova. Все права защищены.</p>
      </td>
    </tr>
  </table>
</body>

</html>