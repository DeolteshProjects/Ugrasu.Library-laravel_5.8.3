@extends('layouts.app')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Составленные библиотечные справки</h4>
                <h6 class="card-subtitle"><code></code></h6>
                <div class="table-responsive">

                    <div class="col-sm-12">

                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Составляемея библиографическая справка</h4>
                                <h6 class="card-subtitle">На дисциплину
                                    <text class="text-info">{{ $report['Disc']['Disc'] }}</text>
                                    для направления
                                    <text class="text-info">{{ $report['Disc']['Special'] }}</text>
                                    на
                                    <text class="text-info">{{ $report['Disc']['Year'] }}</text>
                                    год набора.
                                </h6>
                                <div class="table">
                                    <table class="table table-bordered">
                                        <thead class="text-center">
                                        <tr>
                                            <td colspan="6"><h6><b>СПРАВКА об обеспеченности учебно-методической
                                                        документацией программы направления
                                                        подготовки {{ $report['Disc']['Special'] }}
                                                        , {{ $report['Disc']['Year'] }} год набора </b></h6></td>
                                        </tr>
                                        <tr>
                                            <td width="5%"><p>№</p>
                                                <p>П/П</p></td>
                                            <td>Наименование дисциплины</td>
                                            <td colspan="2">Наименование печатных и (или) электронных учебных изданий,
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
                                                rowspan="{{ $report['number']+1 }}"> @php echo count($report['Disc'])/4; @endphp</td>
                                            <td class="text-center align-middle"
                                                rowspan="{{ $report['number']+1 }}">{{ $report['Disc']['Disc'] }}</td>
                                            @if (isset($report['records']['tBook_number']))
                                                @php
                                                    $col = $report['records']['tBook_number'];
                                                @endphp
                                                <td class="text-center align-middle" rowspan="{{ $col }}">Печатные
                                                    учебные издания
                                                </td>
                                                <td>1. {{ $report['records']['tBook']['0']['Book'] }}</td>
                                                <td class="text-center align-middle">{{ $report['records']['tBook']['0']['NumberOfCopies'] }}</td>
                                                <td class="text-center align-middle"><i
                                                            class="text-danger">Недоступно</i></td>
                                        </tr>
                                        @if ($col > 1)
                                            @for ($i = 1; $i < $col; $i++)
                                                <tr>
                                                    <td>{{ $i+1 }}. {{ $report['records']['tBook'][$i]['Book'] }}</td>
                                                    <td class="text-center align-middle">{{ $report['records']['tBook'][$i]['NumberOfCopies'] }}</td>
                                                    <td class="text-center align-middle"><i class="text-danger">Недоступно</i>
                                                    </td>
                                                </tr>
                                            @endfor
                                        @endif
                                        @endif
                                        @if (isset($report['records']['eBook_number']))
                                            @php
                                                $col = $report['records']['eBook_number'];
                                            @endphp
                                            <td class="text-center align-middle" rowspan="{{ $col }}">Электронные
                                                учебные издания, имеющиеся в электронном каталоге
                                                электронно-библиотечной системы
                                            </td>
                                            <td>1. {{ $report['records']['eBook'][0]['Book'] }}</td>
                                            <td class="text-center align-middle">{{ $report['records']['eBook'][0]['NumberOfCopies'] }}</td>
                                            <td class="text-center align-middle"><i class="text-danger">Недоступно</i>
                                            </td>
                                            </tr>
                                            @if ($col > 1)
                                                @for ($i = 1; $i < $col; $i++)
                                                    <tr>
                                                        <td>{{ $i+1 }}
                                                            . {{ $report['records']['eBook'][$i]['Book'] }}</td>
                                                        <td class="text-center align-middle">{{ $report['records']['eBook'][$i]['NumberOfCopies'] }}</td>
                                                        <td class="text-center align-middle"><i class="text-danger">Недоступно</i>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @endif
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-body">
                                <h4 class="card-title">Печать данных</h4>
                                <div id="example23_wrapper" class="dataTables_wrapper">
                                    <div class="dt-buttons"><a class="dt-button buttons-copy buttons-html5"
                                                               tabindex="0" aria-controls="example23"
                                                               href="#"><span>Copy</span></a><a
                                                class="dt-button buttons-csv buttons-html5" tabindex="0"
                                                aria-controls="example23" href="#"><span>CSV</span></a><a
                                                class="dt-button buttons-excel buttons-html5" tabindex="0"
                                                aria-controls="example23" href="#"><span>Excel</span></a><a
                                                class="dt-button buttons-pdf buttons-html5" tabindex="0"
                                                aria-controls="example23" href="#"><span>PDF</span></a><a
                                                class="dt-button buttons-print" tabindex="0"
                                                aria-controls="example23" href="#"><span>Печать</span></a></div>
                                    <table id="example23"
                                           class="table table-bordered dataTable"
                                           role="grid" aria-describedby="example23_info">
                                        <thead class="text-center">
                                        <tr>
                                            <td colspan="6"><h6><b>СПРАВКА об обеспеченности учебно-методической
                                                        документацией программы направления
                                                        подготовки {{ $report['Disc']['Special'] }}
                                                        , {{ $report['Disc']['Year'] }} год набора </b></h6></td>
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
                                                rowspan="{{ $report['number']+1 }}"> @php echo count($report['Disc'])/4; @endphp</td>
                                            <td class="text-center align-middle"
                                                rowspan="{{ $report['number']+1 }}">{{ $report['Disc']['Disc'] }}</td>
                                            @if (isset($report['records']['tBook_number']))
                                                @php
                                                    $col = $report['records']['tBook_number'];
                                                @endphp
                                                <td class="text-center align-middle" rowspan="{{ $col }}">Печатные
                                                    учебные издания
                                                </td>
                                                <td>1. {{ $report['records']['tBook']['0']['Book'] }}</td>
                                                <td class="text-center align-middle">{{ $report['records']['tBook']['0']['NumberOfCopies'] }}</td>
                                                <td class="text-center align-middle"><i
                                                            class="text-danger">Недоступно</i></td>
                                        </tr>
                                        @if ($col > 1)
                                            @for ($i = 1; $i < $col; $i++)
                                                <tr>
                                                    <td>{{ $i+1 }}
                                                        . {{ $report['records']['tBook'][$i]['Book'] }}</td>
                                                    <td class="text-center align-middle">{{ $report['records']['tBook'][$i]['NumberOfCopies'] }}</td>
                                                    <td class="text-center align-middle"><i class="text-danger">Недоступно</i>
                                                    </td>
                                                </tr>
                                            @endfor
                                        @endif
                                        @endif
                                        @if (isset($report['records']['eBook_number']))
                                            @php
                                                $col = $report['records']['eBook_number'];
                                            @endphp
                                            <td class="text-center align-middle" rowspan="{{ $col }}">Электронные
                                                учебные издания, имеющиеся в электронном каталоге
                                                электронно-библиотечной системы
                                            </td>
                                            <td>1. {{ $report['records']['eBook'][0]['Book'] }}</td>
                                            <td class="text-center align-middle">{{ $report['records']['eBook'][0]['NumberOfCopies'] }}</td>
                                            <td class="text-center align-middle"><i
                                                        class="text-danger">Недоступно</i>
                                            </td>
                                            </tr>
                                            @if ($col > 1)
                                                @for ($i = 1; $i < $col; $i++)
                                                    <tr>
                                                        <td>{{ $i+1 }}
                                                            . {{ $report['records']['eBook'][$i]['Book'] }}</td>
                                                        <td class="text-center align-middle">{{ $report['records']['eBook'][$i]['NumberOfCopies'] }}</td>
                                                        <td class="text-center align-middle"><i class="text-danger">Недоступно</i>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @endif
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-outline-info pull-right">Отправить руководителю ОПОП</button>
                </div>
            </div>
        </div>
    </div>
@endsection