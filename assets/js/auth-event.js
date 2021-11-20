$('#switch').click(function () {
    $(this).text(function (i, text) {
        return text === "Sign Up" ? "Log In" : "Sign Up";
    });
    $('#login').toggleClass("on");
    $('#signup').toggleClass("on");
    $(this).toggleClass("two");
    $('#background').toggleClass("two");
    $('#image-overlay').toggleClass("two");
});