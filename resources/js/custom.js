var altApp = {};
$(function () {
    altApp.validateClientForm = function() {
        alert('getting here');
        if (this.validateEmail($('#email').val()) == false) {
            alert("You have entered an invalid email address!");
        }
    };
    altApp.validateEmail = function (email) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
            return true;
        }
        return false;
    }
});
