@extends('layouts.app')

@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Стартовая страница</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Главная</a></li>
                <li class="breadcrumb-item active">Стартовая страница</li>
            </ol>
        </div>
        <div class="col-md-7 align-self-center text-right d-none d-md-block">
            <a href="{{ route('libraryReports.create') }}" class="btn btn-info"><i class="fa fa-plus-circle"></i>
                Составить библиотечную справку</a>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card-header bg-info">
                <h4 class="m-b-0 text-white">Форма поиска книг</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('bookSearch.result') }}" method="POST">
                    @csrf
                    <div class="form-body">
                        <h3 class="card-title">Введите необходимые параметры поиска</h3>
                        <hr>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Автор литературы</label>
                                    <input type="text" id="bookAuthor" name="bookAuthor"
                                           class="form-control" placeholder="Петров">
                                    <small class="form-control-feedback">
                                    </small>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Заглавие</label>
                                    <input type="text" id="bookTitle" name="bookTitle" class="form-control"
                                           placeholder="Математика">
                                    <small class="form-control-feedback">
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
                                    <label class="control-label">Ключевые слова</label>
                                    <input type="text" id="bookKeyWord" name="bookKeyWord"
                                           class="form-control"
                                           placeholder="Математическая статистика">
                                    <small class="form-control-feedback">
                                    </small>
                                </div>
                            </div>
                            <!--/span-->
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Ограничение количества поиска</label>
                                    <select class="form-control custom-select" id="bookLimit" name="bookLimit"
                                            type="text" required>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                        <option value="500">500</option>
                                        <option value="1000">1000. Вы реально можете дойти до конца?
                                        </option>
                                        <option value="5000">5000. Вы уверены что вам действительно нужна
                                            эта книга?
                                        </option>
                                    </select>
                                    <small class="form-control-feedback">
                                        <b><i class="text text-warning">От этого параметра будет зависеть
                                                скорость загрузки результатов. </i></b>
                                    </small>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label class="control-label">Общий поиск литературы</label>
                                    <input class="form-control" name="fullSearch" type="text" placeholder="Математика, Статистика, И, Моделирование, Алексей Аверьянович">
                                    <small class="form-control-feedback"> Все возможные слова, которые могут встретиться в описании литературы.
                                        <p><i class="text text-danger">Необходимо дополнить разделение по запятым</i></p>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/row-->
                    <h3 class="box-title m-t-40">Место поиска</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label class="control-label">База данных поиска</label>
                                <select class="form-control custom-select" id="bookDataBase" name="bookDataBase"
                                        type="text" required>
                                    <option value="FOND">Библиотечный фонд</option>
                                    <option value="ZNANIUM">База данных "Знаниум"</option>
                                    <option value="URAIT">База данных "Юрайт"</option>
                                    <option value="LAN">База данных "Лань"</option>
                                    <option value="IBIS">Локальная база</option>
                                </select>
                                <small class="form-control-feedback"> Выберите базу данных, в которой
                                    будет выполняться поиск.
                                    <p><i class="text text-danger">Более не представляет необходимости, нужно
                                            вырезать</i></p>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn btn-primary"><i
                                    class="fa fa-check"></i>Поиск
                        </button>
                        <button type="reset" class="btn btn-inverse">Сброс</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection