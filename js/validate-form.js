//console.log('heeloo')

///Проверка совпадения паролей
function checkpass(pass) {
  let pass2 = document.getElementById('validate-password').value
  pass != pass2 ? document.getElementById('validate-password').setCustomValidity(false) : document.getElementById('validate-password').setCustomValidity('')
}
