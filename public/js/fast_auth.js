//Авторизация как преподаватель
function fastTeacherAuth() {
    $.ajax({
        type: 'POST',
        url: 'system/modules/fast_auth.php',
        data: 'access=T',
        success: function (data) {
            window.location.replace('index.php');

        }
    });
}

//Авторизация как руководитель ОПОП
function fastRucopopAuth() {
    $.ajax({
        type: 'POST',
        url: 'system/modules/fast_auth.php',
        data: 'access=R',
        success: function (data) {
            window.location.replace('index.php');
        }
    });
}

//Авторизация как библиотека
function fastLibraryAuth() {
    $.ajax({
        type: 'POST',
        url: 'system/modules/fast_auth.php',
        data: 'access=L',
        success: function (data) {
            window.location.replace('index.php');
        }
    });
}


//Авторизация как библиотека
function fastLogout() {
    $.ajax({
        type: 'POST',
        url: 'system/modules/fast_auth.php',
        data: 'access=O',
        success: function (data) {
            window.location.replace('index.php');
        }
    });
}