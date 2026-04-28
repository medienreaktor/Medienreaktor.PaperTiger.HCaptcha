window.setHcaptchaResponse = function (response) {
    const hiddenField = document.getElementsByClassName('verify-captcha')[0];
    if (hiddenField) {
        hiddenField.value = response;
    }
};