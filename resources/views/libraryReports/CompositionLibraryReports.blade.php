@extends('layouts.app')
@section('content')
    <div class="col-lg-12">
        <h3 class="text-center card-title">Составленные библиографические справки</h3>

        <!-- Column -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Cоставленные библиографические справки по направлению обучения {{ $data['Created'][0]->speciality }} на {{ $data['Created'][0]->yeared }} год набора.</h4>
                @if(((count($data['Created'])) + (count($data['None'])))>10)
                <label class="form-inline">Показывать &nbsp;
                    <select id="demo-show-entries">
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="{{ ((count($data['Created'])) + (count($data['None']))) }}">Все</option>
                    </select> &nbsp; записей </label>
                @endif
                <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny" data-page-size="">
                    <thead>
                    <tr class="row text-left">
                        <th class="col-md-6" data-hide="discipline"> Дисциплина</th>
                        <th class="col-md-3" data-hide="compiler"> Составитель</th>
                        <th class="col-md-2 text-center" data-hide="status"> Состояние</th>
                        <td class="col-md-1 text-center" data-hide="action"> Дейстивия</td>
                    </tr>
                    </thead>

                    <tbody class="text-left">
                    @foreach($data['Created'] as $value)
                        <tr class="row">
                            <!-- Дисциплина -->
                            <td  class="col-md-6">{{ $value->discipline }}</td>
                            <!-- Составитель -->
                            <td  class="col-md-3">{{ $value->compiler }}</td>
                            <!-- Статус -->
                            <td class="col-md-2 text-center"><span
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
                            <td class="col-md-1 text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-info dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Действия
                                    </button>
                                    <div class="dropdown-menu">
                                        <div class="alert-info">
                                            <a class="dropdown-item btn btn-outline-info" href="{{ route('LibraryReportDiscLibraryCompiled.showLibraryReport') }}?year={{ $value->yeared }}&speciality={{ $value->speciality }}&discipline={{ $value->discipline }}&compiler={{ $value->compiler }}&createdate={{ $value->createdate }}"><i class="fa fa-eye"></i> Открыть</a>
                                        </div>
                                        <div class="alert-primary">
                                            @if (($value->status) == 10)
                                                <button class="dropdown-item btn-outline-primary"><i class="fa fa-file-word-o"></i> Скачать</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @foreach($data['None'] as $value)
                        <tr class="row">
                            <!-- Дисциплина -->
                            <td  class="col-md-6">{{ $value->discipline }}</td>
                            <!-- Статус -->
                            <td class="col-md-6 label-danger text-center" colspan="3"><span class="label label-danger"><b>Не составлялась</b></span></td>
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
        </div>
        <!-- Column -->

    </div>

    <script>
    </script>
@endsection