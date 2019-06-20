@extends('layouts.CompilerApp')
@section('content')
    <div class="col-lg-12">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="CreatingTable" class="table">
                        <table class="table table-bordered">
                            <thead class="text-center">
                            <tr>
                                <td colspan="8" width="100%">
                                    <div class="col-md-12 text-right">
                                        <div id="compiler_name" class="col-md-12">
                                            <h6>
                                                Составитель: <b class="left">{{ $LibraryReport['Compiler'] }}</b>
                                            </h6>
                                        </div>
                                        <div class="col-md-12">
                                            <h6>
                                                </br> Дата составления: <b>{{ $LibraryReport['CreateDate'] }}</b>
                                            </h6>
                                        </div>
                                        @if(!empty($LibraryReport['UpdateDate']))
                                            <div class="col-md-12">
                                                <h6>
                                                    </br> Дата обновления: <b>{{ $LibraryReport['UpdateDate'] }}</b>
                                                </h6>
                                            </div>
                                        @endif
                                        <div class="col-md-12">
                                            <h6>
                                                </br> Состояние: <b>
                                                    @if($LibraryReport['Status'] == 0)
                                                        <span class="label label-light-warning">Новая</span>
                                                    @elseif($LibraryReport['Status'] == 2)
                                                        <span class="label label-light-primary">Исправлена</span>
                                                    @elseif($LibraryReport['Status'] == 8)
                                                        <span class="label label-light-danger">Отклонена библиотекой</span>
                                                    @elseif($LibraryReport['Status'] == 10)
                                                        <span class="label label-light-success">Принята библиотекой</span>
                                                    @else
                                                        <span class="label label-light-dark">Неизвестно</span>
                                                    @endif
                                                </b>
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" width="100%"><h6><b>СПРАВКА об обеспеченности
                                            учебно-методической
                                            документацией программы направления
                                            подготовки {{ $LibraryReport['SpecialityCode'] }} {{ $LibraryReport['Speciality'] }}
                                            , {{ $LibraryReport['Yeared'] }} год набора </b></h6>
                                </td>
                            </tr>
                            <tr>
                                <td width="5%"><p>№</p>
                                    <p>П/П</p></td>
                                <td>Наименование дисциплины</td>
                                <td colspan="2">Наименование печатных и (или) электронных учебных
                                    изданий,
                                    методические издания, периодические издания по всем входящим
                                    в реализуемую образовательную программу учебным предметам,
                                    курсам, дисциплинам (модулям) в соответствии с рабочими программами
                                    дисциплин, модулей, практик
                                </td>
                                <td>Количество экземпляров</td>
                                <td>Cтудентов учебной литературой (экземпляров на одного студента)</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center align-middle"
                                    rowspan="{{ $AmountOfLiterature }}"> 1
                                </td>
                                <td class="text-center align-middle"
                                    rowspan="{{ $AmountOfLiterature }}">{{ $LibraryReport['Discipline'] }}</td>
                                @if ( $AmountOftBookLiterature > 0)
                                    <td class="text-center align-middle"
                                        rowspan="{{ $AmountOftBookLiterature }}">Печатные
                                        учебные издания
                                    </td>
                                    <td>
                                        <div class="col-md-12">1. {{ $tBook['0']['Book'] }}
                                            @if($tBook[0]['Memory'])
                                                <i class='text-primary'>{Дополнительная}</i>
                                            @endif
                                        </div>
                                        <!--
                                        <div class="col-md-12 alert alert-warning">
                                        <h5 class="text-warning"><i class="fa fa-warning"></i> Данная литература не подходит для составления БС</h5>
                                        </div>
                                        <div class="col-md-12 row">
                                            <div class="col-md-12 row">
                                                <div class="col-md-10">
                                                    <textarea class="form-control" id="textComment_t_0"></textarea>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-outline-warning" onclick='addCommentToLit('t','0', '(document.getElementById("textComment_"+"t"+"_"+"0").value)')>Добавить комментарий</buttons>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        -->
                                    </td>
                                    <td class="text-center align-middle">{{ $tBook['0']['NumberOfCopies'] }}
                                        из {{ $tBook[0]['Max'] }}</td>
                                    <td class="text-center align-middle"><i
                                                class="text-danger">1</i></td>
                            </tr>
                            @endif
                            @if ($AmountOftBookLiterature > 1)
                                @for ($i = 1; $i < $AmountOftBookLiterature; $i++)
                                    <tr>
                                        <td>{{ $i+1 }}. {{ $tBook[$i]['Book'] }}
                                            @if($tBook[$i]['Memory'])
                                                <i class='text-primary'>{Дополнительная}</i>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">{{ $tBook[$i]['NumberOfCopies'] }}
                                            из {{ $tBook[$i]['Max'] }}</td>
                                        <td class="text-center align-middle"><i class="text-danger">1</i>
                                        </td>
                                    </tr>
                                @endfor
                            @endif
                            @if ($AmountOfeBookLiterature > 0)
                                <td class="text-center align-middle"
                                    rowspan="{{ $AmountOfeBookLiterature }}">Электронные
                                    учебные издания, имеющиеся в электронном каталоге
                                    электронно-библиотечной системы
                                </td>
                                <td>1. {{ $eBook[0]['Book'] }}
                                    @if($eBook[0]['Memory'])
                                        <i class='text-primary'>{Дополнительная}</i>
                                    @endif</td>
                                <td class="text-center align-middle">{{ $eBook[0]['NumberOfCopies'] }}
                                    из {{ $eBook[0]['Max'] }}</td>
                                <td class="text-center align-middle"><i class="text-danger">1</i>
                                </td>
                                </tr>
                            @endif
                            @if ($AmountOfeBookLiterature > 1)
                                @for ($i = 1; $i < $AmountOfeBookLiterature; $i++)
                                    <tr>
                                        <td>{{ $i+1 }}
                                            . {{ $eBook[$i]['Book'] }}
                                            @if($eBook[$i]['Memory'])
                                                <i class='text-primary'>{Дополнительная}</i>
                                            @endif</td>
                                        <td class="text-center align-middle">{{ $eBook[$i]['NumberOfCopies'] }}
                                            из {{ $eBook[$i]['Max'] }}</td>
                                        <td class="text-center align-middle"><i class="text-danger">1</i>
                                        </td>
                                    </tr>
                                @endfor
                            @endif
                            </tbody>
                        </table>
                        @if($Activity != NULL)
                            <div id="activity">
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <thead>
                                        <tr>
                                            <div class="card-header text-center">
                                                <span class="card-title">Активность справки</span>
                                            </div>
                                        </tr>
                                        <tr class="row">
                                            <td class="col-md-2">Дата</td>
                                            <td class="col-md-3">Оператор</td>
                                            <td class="col-md-2">Активность</td>
                                            <td class="col-md-5">Комментарий</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Activity as $Active)
                                            <tr class="row
                                    @if($Active['ActivityStatus'] == 10)
                                                    label-light-success
@elseif($Active['ActivityStatus'] == 8)
                                                    label-light-danger
@elseif($Active['ActivityStatus'] == 2)
                                                    label-light-primary
@elseif($Active['ActivityStatus'] == 0)
                                                    label-light-warning
@endif
                                                    ">
                                                <td class="col-md-2">{{ $Active['ActivityDate'] }}</td>
                                                <td class="col-md-3">{{ $Active['ActivityPerson'] }}</td>
                                                <td class="col-md-2">
                                                    <b>
                                                        @if($Active['ActivityStatus'] == 10)
                                                            <b class="text-success">Принятие</b>
                                                        @elseif($Active['ActivityStatus'] == 8)
                                                            <b class="text-danger">Отклонение</b>
                                                        @elseif($Active['ActivityStatus'] == 2)
                                                            <b class="text-primary"> Исправление</b>
                                                        @elseif($Active['ActivityStatus'] == 0)
                                                            <b class="text-warning">Создание</b>
                                                        @endif
                                                    </b>
                                                </td>
                                                <td class="col-md-5">
                                                    @if(!empty($Active['ActivityComment']))
                                                        {{ $Active['ActivityComment'] }}
                                                    @else

                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        @if(($LibraryReport['Status'] > 2))
                            <div class="pull-right">
                                @if(($LibraryReport['Status'] == 8))
                                    <div class="alert-warning">
                                        <a class="btn btn-outline-warning"
                                           href="{{ route('Compiler.edit',['year' => $LibraryReport['Yeared'], 'specialitycode' =>$LibraryReport['SpecialityCode'], 'disciplinecode' => $LibraryReport['DisciplineCode']])}}">
                                            <i class="fa fa-pencil"></i> Редактировать</a>
                                    </div>
                                @endif
                                @if($LibraryReport['Status'] == 10)
                                    <div class="alert-primary">
                                        <a class="btn btn-outline-primary"
                                                onclick="printOnlyOneDisc('{{ $LibraryReport['SpecialityCode'] }}', '{{ $LibraryReport['Yeared'] }}', '{{ $LibraryReport['DisciplineCode'] }}')">
                                            <i class="fa fa-file-word-o"></i> Скачать
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection