@extends('layouts.LibraryApp')
@section('content')
    <div class="col-lg-12">
        <h3 class="text-center card-title">Составленные библиографические справки</h3>

        <!-- Column -->
        <div class="card">
            <div class="card-body">
                @if(count($data) == 0)
                    <h3>
                    <div class="alert alert-warning text-center">На данный момент библиографические справки отсутствуют</div>
                    </h3>
                    @else
                <h4 class="card-title">Cоставленные библиографические справки</h4>
                @if((count($data)>10))
                <label class="form-inline">Показывать &nbsp;
                    <select id="demo-show-entries">
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="{{ count($data) }}">Все</option>
                    </select> &nbsp; записей </label>
                @endif
                <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny" data-page-size="">
                    <thead>
                    <tr class="row text-left">
                        <th class="col-md-1" data-toggle="true"> Год набора</th>
                        <th class="col-md-4" data-hide="speciality"> Направление обучения</th>
                        <th class="col-md-3" data-hide="discipline"> Дисциплина</th>
                        <th class="col-md-2" data-hide="compiler"> Составитель</th>
                        <th class="col-md-1 text-center" data-hide="status"> Состояние</th>
                        <th data-hide="all"> Составитель</th>
                        <th data-hide="all"> Год набора</th>
                        <th data-hide="all"> Учебный год</th>
                        <th data-hide="all"> Код специальности</th>
                        <th data-hide="all"> Специальность</th>
                        <th data-hide="all"> Код дисциплины</th>
                        <th data-hide="all"> Дисциплина</th>
                        <th data-hide="all"> ФГОС</th>
                        <th data-hide="all"> Составленна / Обновлена</th>
                        <td class="col-md-1 text-center" data-hide="action"> Дейстивия</td>
                    </tr>
                    </thead>

                    <tbody class="text-left">
                    @foreach($data as $value)
                        <tr class="row">
                            <!-- Год набора -->
                            <td class="col-md-1">{{ $value->yeareds }}</td>
                            <!-- Направление обучения -->
                            <td  class="col-md-4">{{ $value->speciality }}</td>
                            <!-- Дисциплина -->
                            <td  class="col-md-3">{{ $value->discipline }}</td>
                            <!-- Составитель -->
                            <td  class="col-md-2">{{ $value->compiler }}</td>
                            <!-- Статус -->
                            <td class="col-md-1 text-center"><span
                                        @if (($value->status) == 0)
                                        class="label label-light-warning"><b>Новая</b>
                                        @elseif (($value->status) == 2)
                                        class="label label-light-primary"><b>Исправлена</b>
                                    @elseif (($value->status) == 8)
                                        class="label label-light-danger"><b>Отклонена библиотекой</b>
                                    @elseif (($value->status) == 10)
                                        class="label label-light-success"><b>Принята библиотекой</b>
                                    @endif
                                    </span></td>
                            <!-- Составитель -->
                            <td>{{ $value->compiler }}</td>
                            <!-- Год набора -->
                            <td>{{ $value->yeared }}</td>
                            <!-- Учебный год -->
                            <td>{{ $value->yeareds }}</td>
                            <!-- Код направления обучения -->
                            <td>{{ $value->specialitycode }}</td>
                            <!-- Направление обучения -->
                            <td>{{ $value->speciality }}</td>
                            <!-- Код дисциплины -->
                            <td>{{ $value->disciplinecode }}</td>
                            <!-- Дисциплина -->
                            <td>{{ $value->discipline }}</td>
                            <!-- ФГОС -->
                            <td>{{ $value->fgos }}</td>
                            <!-- Составленна / Обновлена -->
                            <td>{{ $value->createdate }} / {{ $value->updatedate }}</td>
                            <td class="col-md-1 text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-info dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Действия
                                    </button>
                                    <div class="dropdown-menu">
                                        <div class="alert-info">
                                            <a class="dropdown-item btn btn-outline-info" href="{{ route('Library.showLibraryReport') }}?year={{ $value->yeared }}&speciality={{ $value->speciality }}&discipline={{ $value->discipline }}&compiler={{ $value->compiler }}&createdate={{ $value->createdate }}"><i class="fa fa-eye"></i> Открыть</a>
                                        </div>
                                        <div class="alert-primary">
                                            @if (($value->status) == 10)
                                                <div class="alert-primary">
                                                    <button class="dropdown-item btn-outline-primary" onclick="printOnlyOneDisc('{{ $value->specialitycode }}', '{{ $value->yeared }}', '{{ $value->disciplinecode }}')"><i class="fa fa-file-word-o"></i> Скачать</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="text-right">
                                <ul class="pagination pagination-split m-t-30"></ul>
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>
        <!-- Column -->

    </div>

    <script>
    </script>
@endsection