@extends('layouts.app')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <div class="form-body">
                        <h3 class="card-title">Введите необходимые параметры</h3>
                        <hr>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Год набора</label>
                                    <select class="form-control custom-select" id="selectedYear" name="selectedYear"
                                            type="number" onchange="changeYear()" required>
                                        <optgroup label="Выберите год набора">
                                        </optgroup>
                                    </select>
                                    <small class="form-control-feedback">
                                    </small>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Форма обучения</label>
                                    <select class="form-control custom-select" id="selectedLernForm" name="selectedLernForm"
                                            type="text" onchange="changeLernForm()" disabled required>
                                        <option value="1">Очная</option>
                                    </select>
                                    <small class="form-control-feedback">
                                    </small>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Направление</label>
                                    <select class="form-control custom-select" id="selectedSpec" name="selectedSpec"
                                            type="text" onchange="changeSpec()" disabled required>
                                        <option value="1">09.03.01 - Информатика и вычислительная техника</option>
                                    </select>
                                    <small class="form-control-feedback">
                                    </small>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Модуль</label>
                                    <select class="form-control custom-select" id="selectedModul" name="selectedModul"
                                            type="text" onchange="changeModul()" disabled required>
                                        <option value="1">...</option>
                                    </select>
                                    <small class="form-control-feedback">
                                        <i class="text text-danger">В данный момент вкладка модулей недоступна</i>
                                    </small>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Дисциплина</label>
                                    <select class="form-control custom-select" id="selectedDisc" name="selectedDisc"
                                            type="text" disabled required>
                                        <option value="1">Основы программирования</option>
                                    </select>
                                    <small class="form-control-feedback">
                                    </small>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">ФГОС</label>
                                    <select class="form-control custom-select" id="selectedFgos" name="selectedFgos"
                                            type="text" disabled required>
                                        <option value="3+">ФГОС 3+</option>
                                    </select>
                                    <small class="form-control-feedback">
                                    </small>
                                </div>
                            </div>
                            <!--/span-->
                            <!--/span-->
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn btn-primary" disabled>Далее
                        </button>
                        <button type="reset" class="btn btn-inverse">Сброс</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

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
                url: '/model/LibraryReport/get_speciality',
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

    </script>
@endsection