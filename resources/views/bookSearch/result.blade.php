@extends('layouts.app')
@section('content')

    <div class="card">
        <div class="card-body">


            @if (!isset($searchNumber))
                <h4 class="card-title">Записей в библиотеке по запросу {{ $searchQuery }} не найденно.</h4>
                <h6 class="card-subtitle">Поиск
                    занял {{ $searchTime }} сек.</h6>

            @else

                <h4 class="card-title">Результаты поиска по запросу {{ $searchQuery }} "</h4>
                <h6 class="card-subtitle">Найденно {{ $searchNumber }} записей / Поиск
                    занял {{ $searchTime }} сек.</h6>
                <ul class="search-listing">
                    @for ($i = 1; $i <= count($answer); $i++)
                        <li id="search_result_{{ $i }}">
                            <h3>
                                <p>
                                    <value id="search_result_{{ $i }}_id" hidden>{{ $answer[$i]['Id'] }}</value>
                                    <value id="search_result_{{ $i }}_author">
                                        @if (!empty($answer[$i]['Author']))
                                            {{ $answer[$i]['Author'] }}
                                        @else
                                            Автор неизвестен
                                        @endif
                                    </value>
                                    <value id="search_result_{{ $i }}_view_of_publication"
                                           hidden>{{ $answer[$i]['ViewOfPublication'] }}</value>
                                </p>
                            </h3>
                            <p>
                                <value id="search_result_{{ $i }}_small_description">{{ $answer[$i]['SmallDescription'] }}</value>
                            </p>
                            <p>Количество экземпляров в библиотеке: <i
                                        class='search-link'>
                                    <value id="search_result_{{ $i }}_number_of_copies">{{ $answer[$i]['NumberOfCopies'] }}</value>
                                    шт.</i></p>
                            <button data-toggle="modal" data-target="#quantity_input_window"
                                    class='btn btn-primary' id='".$i."' onclick='SelectBook( {{ $i }} )'>
                                Добавить в
                                справку
                            </button>
                            <button class='btn btn-primary' id='".$i."' onclick='addToReport( {{ $i }} )'>
                                Добавить в
                                дополнительную
                            </button>
                        </li>
                        <hr>
                    @endfor
                </ul>
                </ul>
                <nav aria-label="Page navigation example" class="m-t-40">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Туда</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Сюда</a>
                        </li>
                    </ul>
                </nav>



                <div class="card">
                    <div class="card-body col-sm-5">
                        <!-- sample modal content -->
                        <div id="quantity_input_window" class="modal fade" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="quantity_book_form" name="quantity_book_form" onsubmit="return false" oninput="level.value = quantity.valueAsNumber">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Добавление книги в библиотечную справку</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                ×
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input id="select_id" value="" hidden required>
                                                <label for="recipient-name" class="control-label">Выбирите необходимое
                                                    число экземпляров.</label>
                                                <output id="level" for="quantity">50</output>
                                                <input id="quantity" name="quantity" type="range" class="form-control"
                                                       min="1"
                                                       max="100" placeholder="5" value="1" autofocus required>
                                                <small class="form-control-feedback">В библиотеке присутствует
                                                    <value id="quantity_max"></value>
                                                    шт.
                                                </small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" onclick="TemporaryFunction()"
                                                    class="btn btn-danger waves-effect waves-light">
                                                Добавить
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function SelectBook(id) {
                        document.getElementById("select_id").value = id;
                        var NumberOfCopies = document.getElementById("search_result_" + id + "_number_of_copies").innerText;
                        document.getElementById("quantity_max").textContent = NumberOfCopies;
                        document.getElementById("quantity").max = NumberOfCopies;
                    }

                    $(function () {
                        var el;
                        $("#quantity").change(function () {
                            el = $(this);
                            el
                                .next("#level")
                                .text(el.val());
                        })
                            .trigger('change');
                    });

                    function TemporaryFunction() {
                        var Max = Number(document.getElementById("quantity").max);
                        var Real = Number(document.getElementById("quantity").value);
                        var id = document.getElementById("select_id").value;
                        var bookId = document.getElementById("search_result_" + id + "_id").innerText;
                        var Author = document.getElementById("search_result_" + id + "_author").innerText;
                        var ViewOfPublication = document.getElementById("search_result_" + id + "_view_of_publication").innerText;
                        var SmallDescription = document.getElementById("search_result_" + id + "_small_description").innerText;
                        var NumberOfCopies = document.getElementById("quantity").value;
                        $.ajax({
                            url: '{{ route('temporaryStorageBookList') }}',
                            type: 'POST',
                            data: {
                                bookId: bookId,
                                Author: Author,
                                ViewOfPublication: ViewOfPublication,
                                SmallDescription: SmallDescription,
                                NumberOfCopies: NumberOfCopies
                            },
                            headers: {
                                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) {
                                alert(data);
                            },
                            error: function () {
                                alert("Не работает");
                            }
                        });
                        //document.getElementById("quantity").max = 0;
                    }

                </script>

            @endif
        </div>
    </div>
@endsection