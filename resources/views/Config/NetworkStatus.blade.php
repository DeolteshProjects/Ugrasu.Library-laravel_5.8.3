@extends('layouts.app')

@section('content')

    @php

        $DB_IP_GALA = "192.168.100.18";
        $DB_IP_LOCAL = "127.0.0.1";
        $DB_PORT = "1521";
        $IRBIS_IP = "192.168.6.30";
        $IRBIS_IP_LOCAL = "127.0.0.1";
        $IRBIS_PORT = "6666";
        $waitTimeoutInSeconds = 1;
    @endphp


<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h3><label class="card-title">Сеть Университета</label></h3>
            </div>
            <div class="card-body row">
                @php
                    try  {
                        fsockopen($DB_IP_GALA,$DB_PORT,$errCode,$errStr,$waitTimeoutInSeconds);
                @endphp

                <div class='col-md-6'>
                    <div class='alert alert-success text-center'><h1><i class='fa fa-database'></i></h1></br>База данных
                        подключена
                    </div>
                </div>
                @php
                    } catch (Exception $exception) {
                @endphp
                <div class='col-md-6'>
                    <div class='alert alert-danger text-center'><h1><i class='fa fa-database'></i></h1></br>База данных недоступна</div>
                </div>
                @php
                    }
                @endphp

                @php
                    try  {
                        fsockopen($IRBIS_IP,$IRBIS_PORT,$errCode,$errStr,$waitTimeoutInSeconds);
                @endphp

                <div class='col-md-6'>
                    <div class='alert alert-success text-center'><h1><i class='fa fa-book'></i></h1></br>Сервер библиотеки подключен
                    </div>
                </div>
                @php
                    } catch (Exception $exception) {
                @endphp
                <div class='col-md-6'>
                    <div class='alert alert-danger text-center'><h1><i class='fa fa-book'></i></h1></br>Сервер библиотеки недоступен</div>
                </div>
                @php
                    }
                @endphp
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h3><label class="card-title">Локальная сеть</label></h3>
            </div>
            <div class="card-body row">
                @php
                    try  {
                        fsockopen($DB_IP_LOCAL,$DB_PORT,$errCode,$errStr,$waitTimeoutInSeconds);
                @endphp

                <div class='col-md-6'>
                    <div class='alert alert-success text-center'><h1><i class='fa fa-database'></i></h1></br>База данных
                        подключена
                    </div>
                </div>
                @php
                    } catch (Exception $exception) {
                @endphp
                <div class='col-md-6'>
                    <div class='alert alert-danger text-center'><h1><i class='fa fa-database'></i></h1></br>База данных недоступна</div>
                </div>
                @php
                    }
                @endphp

                
                @php
                    try  {
                        fsockopen($IRBIS_IP_LOCAL,$IRBIS_PORT,$errCode,$errStr,$waitTimeoutInSeconds);
                @endphp

                <div class='col-md-6'>
                    <div class='alert alert-success text-center'><h1><i class='fa fa-book'></i></h1></br>Сервер библиотеки подключен
                    </div>
                </div>
                @php
                    } catch (Exception $exception) {
                @endphp
                <div class='col-md-6'>
                    <div class='alert alert-danger text-center'><h1><i class='fa fa-book'></i></h1></br>Сервер библиотеки недоступен</div>
                </div>
                @php
                    }
                @endphp
            </div>
        </div>
    </div>

</div>
@endsection
