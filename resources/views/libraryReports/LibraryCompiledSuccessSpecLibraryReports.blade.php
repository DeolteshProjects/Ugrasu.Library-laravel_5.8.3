@extends('layouts.app')
@section('content')
    <div class="col-lg-12">
        <h3 class="text-center card-title">Составляемые и составленные библиографические по направлениям обучения</h3>

        <!-- Column -->
        <div class="card">
            <div class="card-body">
                @if(count($data) == 0)
                    <h3>
                    <div class="alert alert-warning text-center">На данный момент направления со всем принятыми библиографическими справками отсутствуют</div>
                    </h3>
                    @else
                <h4 class="card-title">Направления с составляемыми или составленными библиографическими справками</h4>
                <h6 class="card-subtitle">Отображены справки содержащие в себе справки в состояних 
                    <span class="label label-light-warning">Новая</span>
                    <span class="label label-light-primary">Исправлена</span>
                    <span class="label label-light-success">Принятые библиотекой</span>
                    <span class="label label-light-danger">Отклоненные библиотекой</span>
                </h6>
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
                        <th class="col-md-2" data-toggle="true"> Год набора</th>
                        <th class="col-md-8" data-hide="speciality"> Направление обучения</th>
                        <td class="col-md-2 text-center" data-hide="action"> Дейстивия</td>
                    </tr>
                    </thead>

                    <tbody class="text-left">
                    @foreach($data as $value)
                        <tr class="row">
                            <!-- Год набора -->
                            <td class="col-md-2">{{ $value->yeared }}</td>
                            <!-- Направление обучения -->
                            <td  class="col-md-8">{{ $value->specialitycode }} - {{ $value->speciality }}</td>
                            <!-- Дисциплина -->
                            <td class="col-md-2 text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-info dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Действия
                                    </button>
                                    <div class="dropdown-menu">
                                        <div class="alert-info">

                                            <a class="dropdown-item btn btn-outline-info" href="{{ route('ReportCompositionSpecial',['year'=>$value->yeared, 'specialitycode' => $value->specialitycode])}}"><i class="fa fa-list-alt"></i> Составляющие</a>
                                        </div>
                                        <div class="alert-primary">
                                                <button class="dropdown-item btn-outline-primary" onclick="printOnlyOneSpecial('{{ $value->specialitycode }}', '{{ $value->yeared }}')"><i class="fa fa-file-word-o"></i> Скачать</button>
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