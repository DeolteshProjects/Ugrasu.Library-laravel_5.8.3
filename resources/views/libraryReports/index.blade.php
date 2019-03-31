@extends('layouts.app')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Составленная справка</h4>
                <h6 class="card-subtitle"><code></code></h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="text-center">
                            <td width="5%"><p>№</p>П/П</td>
                            <td>Наименование дисциплины</td>
                            <td colspan="2">Наименование печатных и (или) электронных учебных изданий, методические издания, периодические издания по всем входящим в реализуемую образовательную программу учебным предметам, курсам, дисциплинам (модулям) в <i>соответствии с рабочими программами дисциплин, модулей, практик</i></td>
                            <td>Количество экземпляров</td>
                            <td width="10%">Студентов учебной литературы (экземпляров на одного студента)</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            <td rowspan="{{ $num*2 }}">1</td>
                            <td class="align-middle" rowspan="{{ $num*2 }}">Название дисциплины</td>
                            <td class="align-middle"  rowspan="{{ $num }}" width="10%">Электронные учебные издания, имеющиеся в электронном каталоге электроннно-библиотечной системы</td>
                        </tr>
                        @for ($i=1; $i<$num; $i++)
                            <tr>
                                <td>{{ $i }}. {{ $report[$i]['Author'] }}. {{ $report[$i]['SmallDescription'] }}</td>
                                <td>{{ $report[$i]['NumberOfCopies'] }}</td>
                                <td>###</td>
                            </tr>
                        @endfor
                        <tr class="text-center">
                            <td class="align-middle" rowspan="{{ $num }}" width="10%">Электронные учебные издания, имеющиеся в электронном каталоге электроннно-библиотечной системы</td>
                        </tr>
                        @for ($i=1; $i<$num; $i++)
                            <tr>
                                <td>{{ $i }}. {{ $report[$i]['Author'] }}. {{ $report[$i]['SmallDescription'] }}</td>
                                <td>{{ $report[$i]['NumberOfCopies'] }}</td>
                                <td>###</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection