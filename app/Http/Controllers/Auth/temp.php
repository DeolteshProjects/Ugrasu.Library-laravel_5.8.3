<tbody>
<tr>
    <td rowspan="{{ $report['number'] }}"> @php echo count($report['Disc'])/4; @endphp</td>
    <td rowspan="{{ $report['number'] }}">{{ $report['Disc']['Disc'] }}</td>
    @if (isset($report['records']['tBook_number']))
    @php
    $col = $report['records']['tBook_number'];
    @endphp
    <td rowspan="{{ $col }}">Печатные учебные издания</td>
    <td>1. {{ $report['records']['tBook'][0]['Book'] }}</td>
    <td>{{ $report['records']['tBook'][0]['NumberOfCopies'] }}</td>
    <td><i class="text-danger">Недоступно</i></td>
</tr>
@if ($col > 1)
@for ($i = 1; $i < $col; $i++)
<tr>
    <td>{{ $i+1 }}. {{ $report['records']['tBook'][$i]['Book'] }}</td>
    <td>{{ $report['records']['tBook'][$i]['NumberOfCopies'] }}</td>
    <td><i class="text-danger">Недоступно</i></td>
</tr>
@endfor
@endif
@endif
@if (isset($report['records']['eBook_number']))
@php
$col = $report['records']['eBook_number'];
@endphp
<td rowspan="{{ $col }}">Электронные учебные издания, имеющиеся в электронном каталоге электронно-библиотечной системы</td>
<td>1. {{ $report['records']['eBook'][0]['Book'] }}</td>
<td>{{ $report['records']['eBook'][0]['NumberOfCopies'] }}</td>
<td><i class="text-danger">Недоступно</i></td>
</tr>
@if ($col > 1)
@for ($i = 1; $i < $col; $i++)
<tr>
    <td>{{ $i+1 }}. {{ $report['records']['eBook'][$i]['Book'] }}</td>
    <td>{{ $report['records']['eBook'][$i]['NumberOfCopies'] }}</td>
    <td><i class="text-danger">Недоступно</i></td>
</tr>
@endfor
@endif
@endif
<tr>
    <td rowspan="5"></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
</tr></tbody>
