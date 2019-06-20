@extends('layouts.CompilerApp')
@section('content')

    <div class="card">
        <div class="card-body">

            @if (($realSearchNumber < 1))
                @if ($searchNumber > 0)
                    <h4 class="card-title text-danger">Найденную по запросу  литературу, невозможно
                        использовать для составления вашей библиографической справки.</h4>
                    <h5>Возможные причины:</h5>
                    <ul>
                        <li>Количество экземпляров в библиотеке недостаточно для книгообеспечения.</li>
                        <li>Найденная литература изданна ранее 2000 года.</li>
                    </ul>
                @else
                    <h4 class="card-title">Литература по запросу не была найдена.</h4>
                @endif
                <h6 class="card-subtitle">Поиск
                    занял {{ $searchTime }} сек.</h6>
                Попробуйте повторить поиск с другими параметрами: <button class="btn btn-outline-warning" data-toggle="modal" data-target="#ModalBookSearchForm">Повторить поиск</button>
            @else
                <h4 class="card-title">Результаты поиска по запросу</h4>
                <h6 class="card-subtitle">Найденно {{ $searchNumber }} записей .</h6> <h6 class="text-danger"> Из
                    них {{ ($searchNumber - $realSearchNumber) }} недоступны для использования в библиографической
                    справке.</h6>
                <h6 class="card-subtitle text-info">Доступны для использования в библиографической
                    справке {{ $realSearchNumber }}
                    .</h6>
                <h6 class="card-subtitle">Поиск занял <i class="
                    @if (($searchTime < 3) AND ($searchTime > -3))
                            text-success">{{ $searchTime }}
                        @else
                            text-warning">{{ $searchTime }}
                        @endif
                    </i> сек.</h6>
                <ul class="search-listing">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($answer as $result)
                        <li id="search_result_{{ $i }}">
                            <button
                                    class='btn btn-outline-warning btn-sm pull-right' id='{{ $i }}'
                                    onclick="alert('В планах на будующие')">
                                Сообщить о некоректной записи
                            </button>
                            <div id="search_content_{{ $i }}">
                                <h3>
                                    <p>
                                        <value id="search_result_{{ $i }}_id"
                                               hidden>{{ $result['Id'] }}</value>
                                        <value id="search_result_{{ $i }}_author">
                                            @if (!empty($result['Author']))
                                                {{ $result['Author'] }}
                                            @else
                                                Автор неизвестен
                                            @endif
                                        </value>
                                        <value id="search_result_{{ $i }}_view_of_publication"
                                               hidden>{{ $result['ViewOfPublication'] }}</value>
                                        <value id="search_result_{{ $i }}_city_of_publication"
                                                hidden>{{ $result['CityOfPublication'] }}</value>
                                    </p>
                                </h3>
                                <p>
                                    <value id="search_result_{{ $i }}_small_description">{{ $result['SmallDescription'] }}</value>
                                </p>
                                @if (($result['Link'] !== "(=^.^=)") && ($result['Link'] !== "1"))
                                    <p>Количество экземпляров в библиотеке: <i
                                                class='search-link'>
                                            <value id="search_result_{{ $i }}_number_of_copies">{{ $result['NumberOfCopies'] }}</value>
                                            шт.</i></p>
                                    <p>Ссылка на издание: <i
                                                class='search-link'>
                                            <value id="search_result_{{ $i }}_link"><a class="link text-info"
                                                                                       href="{{ $result['Link'] }}">{{ $result['Link'] }}</a>
                                            </value>
                                        </i></p>
                                @else
                                    <p>Количество экземпляров в библиотеке: <i
                                                class='search-link'>
                                            <value id="search_result_{{ $i }}_number_of_copies">{{ $result['NumberOfCopies'] }}</value>
                                            шт.</i></p>
                                @endif
                            </div>
                            @if (Session::has('LibraryReportDiscLocal.Creating'))
                                <div class="alert-light" id="search_footer_{{ $i }}">
                                    Добавить к справке 
                                    <!--
                                    <button data-toggle="modal" data-target="#quantity_input_window"
                                            class='btn btn-success' id='{{ $i }}'
                                            onclick='SelectBook( {{ $i }} , 0)'>
                                        основной
                                    </button>
                                    -->
                                    <button class='btn btn-outline-success btn-sm' id='{{ $i }}'
                                            onclick='SelectBook( {{ $i }} , 0)'>
                                        основной
                                    </button>
                                    или
                                    <button class='btn btn-outline-primary btn-sm' id='{{ $i }}'
                                            onclick='SelectBook( {{ $i }} , 1)'>
                                        дополнительной
                                    </button>
                                    литературой
                                </div>
                            @endif
                            <hr>
                        </li>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </ul>

                <div class="card">
                    <div class="card-body col-sm-5">
                        <!-- sample modal content -->
                        <div id="quantity_input_window" class="modal fade" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="quantity_book_form" name="quantity_book_form" onsubmit="return false"
                                          oninput="level.value = quantity.valueAsNumber">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Добавление
                                                <value id="selectedType"></value>
                                                литературы в библиографическую справку
                                            </h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true" id="close_modal">
                                                ×
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input id="select_id" value="" hidden required>
                                                <p>В библиотеке присутствует
                                                    <value id="quantity_max"></value>
                                                    шт.
                                                </p>
                                                <label for="recipient-name" class="control-label">Количество
                                                    экземпляров:</label>

                                                <input class="form-control text-center" id="level" for="quantity"
                                                       value="1" readonly>
                                                <input id="quantity" name="quantity" type="range"
                                                       class="form-control"
                                                       min="1"
                                                       max="100" placeholder="5" value="1" autofocus required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" onclick="AddBookInCreatingLibraryReport()"
                                                    class="btn btn-danger waves-effect waves-light">
                                                Добавить к справке
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function Notification(title, description, status) {
                        var bg;
                        switch (status) {
                            case "success":
                                bg = "#06d79c";
                                break;
                            case "info":
                                bg = "#398bf7";
                                break;
                            case "warning":
                                bg = "#ffb22b";
                                break;
                            case "error":
                                bg = "#ef5350";
                                break;
                        }
                        $.toast({
                            heading: '' + title + '', //Заголовок
                            text: '' + description + '', //Описание
                            position: 'top-right',  //Расположение
                            bgColor: bg,    //Фон
                            textColor: 'white', //Текст
                            loaderBg: '#ff6849', //Фон лоадера
                            icon: status,   //Иконка
                            //hideAfter: 0,    //Таймер
                            stack: 1,   //Максимальное количество
                            showHideTransition: 'fade',   //Эффект
                            allowToastClose: false, //Кнопка закрытия
                        });
                    }

                    var type;

                    function SelectBook(id, type_) {
                        document.getElementById("select_id").value = id;
                        var NumberOfCopies = document.getElementById("search_result_" + id + "_number_of_copies").innerText;
                        document.getElementById("quantity_max").textContent = NumberOfCopies;
                        document.getElementById("quantity").max = NumberOfCopies;
                        document.getElementById("quantity").value = 1;
                        document.getElementById("level").value = 1;
                        if (type == 0) document.getElementById("selectedType").textContent = "основной";
                        if (type == 1) document.getElementById("selectedType").textContent = "дополнительной";
                        type = type_;
                        AddBookInCreatingLibraryReport(id);
                    }

                    function AddBookInCreatingLibraryReport(id) {
                        //var id = document.getElementById("select_id").value;
                        var bookId = document.getElementById("search_result_" + id + "_id").innerText;
                        var Author = document.getElementById("search_result_" + id + "_author").innerText;
                        var ViewOfPublication = document.getElementById("search_result_" + id + "_view_of_publication").innerText;
                        var CityOfPublication = document.getElementById("search_result_" + id + "_city_of_publication").innerText;
                        var SmallDescription = document.getElementById("search_result_" + id + "_small_description").innerText;
                        var NumberOfCopies = document.getElementById("search_result_" + id + "_number_of_copies").innerText;
                        //var NumberOfCopies = document.getElementById("quantity").value;
                        //var NumberOfCopies
                        var Max = document.getElementById("quantity").max;
                        NumberOfCopies = 3;
                        $.ajax({
                            url: '{{ route('Compiler.addBook') }}',
                            type: 'POST',
                            data: {
                                Id: bookId,
                                Author: Author,
                                ViewOfPublication: ViewOfPublication,
                                CityOfPublication: CityOfPublication,
                                SmallDescription: SmallDescription,
                                NumberOfCopies: NumberOfCopies,
                                Max: Max,
                                Type: type
                            },
                            headers: {
                                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) {
                                Notification('Литература успешно добавленна в библиографическую справку', '', 'success');
                                document.getElementById("close_modal").click();
                                if (document.getElementById("linkLibraryReportsSeed").hidden = true) {
                                    document.getElementById("linkLibraryReportsSeed").hidden = false;
                                }
                                document.getElementById("search_result_" + id).hidden = true;
                                document.getElementById("compilingLink").href = "{{ route('Compiler.getCreatingLocalLibraryReport') }}";
                                document.getElementById("compilingLink").innerText = "Перейти к составляемой справке";
                                document.getElementById("compilingLink").removeAttribute('data-toggle');
                                document.getElementById("compilingLink").removeAttribute('data-target');
                                document.getElementById("search_result_" + id).fadeIn(1000).fadeOut(1000, function () {
                                    $(this).remove()
                                });
                            },
                            error: function () {
                                Notification('Ошибка', 'Нет ответа от сервера', 'success');
                            }
                        });
                    }

                </script>

            @endif
        </div>
    </div>
@endsection