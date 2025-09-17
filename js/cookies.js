// Cookie Consent logic
function setCookie(name, value, days) {
  let expires = '';
  if (days) {
    const date = new Date();
    date.setTime(date.getTime() + days*24*60*60*1000);
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
  const nameEQ = name + "=";
  const ca = document.cookie.split(';');
  for(let i=0;i < ca.length;i++) {
    let c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

document.addEventListener('DOMContentLoaded', function () {
  const consent = document.getElementById('cookie-consent');
  const acceptBtn = document.getElementById('cookie-accept-btn');

  if (getCookie('site_cookie_ok')) {
    consent.style.display = 'none';
  } else {
    consent.style.display = 'flex';
    acceptBtn.addEventListener('click', function () {
      setCookie('site_cookie_ok', 'true', 365);
      consent.style.display = 'none';
    });
  }
});