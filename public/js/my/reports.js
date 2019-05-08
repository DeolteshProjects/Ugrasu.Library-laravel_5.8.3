//Получаем года для списка
function writeSelectYear() {
    //Инициализируем список годов поступления
    var yearsSelect = document.getElementById("selectedYear");
    //Берем текущий год в js
    var currentDate = new Date();
    var year;
    //Если ранее июня, то берем еще за предыдущий год (календарный)
    currentDate.getMonth() < 5 ? year = currentDate.getFullYear() - 1 : year = currentDate.getFullYear();

    //Добавляем 1 год назад и 4 года вперед
    for ($i = 0; $i <= 5; $i++) {
        yearsSelect.options[$i] = new Option(($i + year - 1) + " - " + ($i + year), ($i + year - 1));
    }
}

writeSelectYear();

/**
 * Далее все функции идут примерно по хронологии действий
 */
//На вкладке дисциплины
function changeYear() {
    var selectedYear = document.getElementById("selectedYear").value;
    //Загрузка направлений по году
    $.ajax({
        url: '/workprogram/workprogram/get_speciality',
        type: 'POST',
        async: true,
        data: {
            year: selectedYear
        },
        headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            alert("Работает");
            document.getElementById("selectedSpec").disabled = false;
        },
        error: function () {
            alert("Не работает!");
        }
    })
}