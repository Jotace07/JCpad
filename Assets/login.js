function error_message(message){
    const errorMessageElement = document.getElementById('message');
    errorMessageElement.hidden = false;
    errorMessageElement.textContent = message;
    errorMessageElement.style.color = 'red';
}