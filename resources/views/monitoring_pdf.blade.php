<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Monitoring - {{ $monitoring->title }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        /* @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: normal;
            src: url(http://themes.googleusercontent.com/static/fonts/sourcesanspro/v7/ODelI1aHBYDBqgeIAH2zlNzbP97U9sKh0jjxbPbfOKg.ttf) format('truetype');
        } */
        @page {
            margin: 0px;
        }
        body {
            margin: 0px;
        }
        .header {
            padding: 1.2rem;
            padding-bottom: 0 !important;
            position: relative;
        }
        .description-content p {
            margin: 0 !important;
        }
        .body {
            padding: 1.2rem;
            padding-top: 0.8rem !important;
            position: relative;
        }
        * {
            font-family: 'Montserrat', Arial, sans-serif;
        }
        a {
            color: #2D2A70;
            text-decoration: none;
        }
        .value-input {
            padding: .5rem;
            background-color: rgb(245, 245, 245);
            border-radius: .25rem;
            border: 2px solid rgb(224, 224, 224);
            margin-bottom: 12px;
        }

    </style>
</head>
<body>
    <div class="header">
        <img src="data:image/png;base64,{{ $logoDishub }}" width="50px" alt="Logo Dishub">
        <img src="data:image/png;base64,{{ $logoBTP }}" width="50px" style="margin: 0px 24px" alt="Logo BTP Jabar">
        <img src="data:image/png;base64,{{ $logoApp }}" style="position: absolute; right: 0; top: 0; margin: .95rem" width="64px" alt="Logo App">
        <div style="display: block">
            <p style="font-size: 1.2rem; margin-bottom: 1px; font-weight: bold">BALAI PERKERETAAPIAN - JAWABARAT</p>
            <p style="font-size: .9rem; margin: 0 0 20px 0;">Jl Raya Gedebage No 68 Bandung, Jawabarat</p>
            <div style="height: 4px; width: 100%; background-color: #BBB8FB"></div>
        </div>
    </div>
    <div class="body">
        <div style="text-align: center">
            <p style="font-size: 1.2rem; margin-bottom: 1px !important; font-weight: bold">LAPORAN MONITORING</p>
            <p style="font-size: .9rem; margin: 0 0 20px 0;">Aplikasi Inovatif SIMPKA</p>
        </div>
        <div style="text-align: left; padding: .5rem">
            <table style="width: 100%">
                <tr>
                    <td><b>Judul Monitoring</b></td>
                    <th>:</th>
                    <td>{{ $monitoring->title }}</td>
                </tr>
                <tr>
                    <td><b>Tim Monitoring</b></td>
                    <th>:</th>
                    <td>{{ $monitoring->team->name }}</td>
                </tr>
                <tr>
                    <td><b>Sujek Monitoring</b></td>
                    <th>:</th>
                    <td>{{ $monitoring->employee->name }}</td>
                </tr>
                <tr>
                    <td><b>Deskripsi</b></td>
                    <th>:</th>
                    <td class="description-content">{!! $monitoring->description !!}</td>
                </tr>
            </table>
        </div>
        @if (count($inputs['category']) > 0)
            <div style="margin-top: 24px; padding-top: 20px; border-top: 3px solid gainsboro; padding-left: 10px">
                <p style="font-size: 1rem; font-weight: bold; margin: 0 0 0px 0;">Formulir {{ $category->name }}</p>
                <p style="font-size: .9rem; margin: 6px 0 20px 0;">Formulir berdasarkan kategori</p>
            </div>
            @foreach ($inputs['category'] as $input)
                <ol style="list-style: none">
                    <li style="margin-bottom: 8px"><u>{{ $input->label }} :</u></li>
                    <li class="value-input">
                        @if ($input->valueData != null && count($input->valueData) > 0)
                            @if ($input->type == 'text')
                                {{ $input->valueData[0]->string_value }}
                            @endif
                            @if ($input->type == 'textarea')
                                <div class="description-content">
                                    {!! $input->valueData[0]->text_value !!}
                                </div>
                            @endif
                            @if ($input->type == 'number')
                                {{ $input->valueData[0]->number_value }}
                            @endif
                            @if ($input->type == 'dropdown')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                                {{ $input->valueData[0]->string_value }}
                            @endif
                            @if ($input->type == 'checkbox')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                                {{ $input->valueData[0]->string_value }}
                            @endif
                            @if ($input->type == 'radio')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                                {{ $input->valueData[0]->string_value }}
                            @endif
                            @if ($input->type == 'file')
                                @if ($input->valueData[0]->type_file == 'image')
                                    <span style="display: inline-block; font-weight: bold">File Gambar - </span>
                                @endif
                                @if ($input->valueData[0]->type_file == 'excel')
                                    <span style="display: inline-block; font-weight: bold">File Excel - </span>
                                @endif
                                @if ($input->valueData[0]->type_file == 'ppt')
                                    <span style="display: inline-block; font-weight: bold">File Presentation - </span>
                                @endif
                                @if ($input->valueData[0]->type_file == 'document')
                                    <span style="display: inline-block; font-weight: bold">File Document - </span>
                                @endif
                                @if ($input->valueData[0]->type_file == 'pdf')
                                    <span style="display: inline-block; font-weight: bold">File PDF - </span>
                                @endif
                                <a style="display: inline-block" href="{{ route('app.value.download', ['id' => $input->valueData[0]->id]) }}">
                                    {{ $input->valueData[0]->file_value }}
                                </a>
                            @endif
                            @if ($input->type == 'date')
                                {{ \Carbon\Carbon::parse($input->valueData[0]->date_value)->format('l, d F Y') }}
                            @endif
                            @if ($input->type == 'time')
                                {{ $input->valueData[0]->time_value }}
                            @endif
                        @else
                            @if ($input->type == 'text')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'textarea')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'number')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'date')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'file')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'time')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'dropdown')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            @if ($input->type == 'checkbox')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            @if ($input->type == 'radio')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            @if ($input->type == 'description')
                                <div class="description-content">
                                    {!! $input->description !!}
                                </div>
                            @endif
                            @if ($input->type == 'image')
                                <span style="display: inline-block; font-weight: bold">File Gambar - </span>
                                <a style="display: inline-block" href="{{ route('app.input-image.download', ['id' => $input->id]) }}">
                                    {{ $input->image }}
                                </a>
                            @endif
                            @if ($input->type == 'media-youtube')
                                <a href="{{ $input->link }}">
                                    {{ $input->link }}
                                </a>
                            @endif
                        @endif
                    </li>
                </ol>
            @endforeach
        @endif

        @if (count($inputs['object']) > 0)
            <div style="margin-top: 24px; padding-top: 20px; border-top: 3px solid gainsboro; padding-left: 10px">
                <p style="font-size: 1rem; font-weight: bold; margin: 0 0 0px 0;">Formulir {{ $object->name }}</p>
                <p style="font-size: .9rem; margin: 6px 0 20px 0;">Formulir berdasarkan objek</p>
            </div>
            @foreach ($inputs['object'] as $input)
                <ol style="list-style: none">
                    <li style="margin-bottom: 8px"><u>{{ $input->label }} :</u></li>
                    <li class="value-input">
                        @if ($input->valueData != null && count($input->valueData) > 0)
                            @if ($input->type == 'text')
                                {{ $input->valueData[0]->string_value }}
                            @endif
                            @if ($input->type == 'textarea')
                                <div class="description-content">
                                    {!! $input->valueData[0]->text_value !!}
                                </div>
                            @endif
                            @if ($input->type == 'number')
                                {{ $input->valueData[0]->number_value }}
                            @endif
                            @if ($input->type == 'dropdown')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                                {{ $input->valueData[0]->string_value }}
                            @endif
                            @if ($input->type == 'checkbox')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                                {{ $input->valueData[0]->string_value }}
                            @endif
                            @if ($input->type == 'radio')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                                {{ $input->valueData[0]->string_value }}
                            @endif
                            @if ($input->type == 'file')
                                @if ($input->valueData[0]->type_file == 'image')
                                    <span style="display: inline-block; font-weight: bold">File Gambar - </span>
                                @endif
                                @if ($input->valueData[0]->type_file == 'excel')
                                    <span style="display: inline-block; font-weight: bold">File Excel - </span>
                                @endif
                                @if ($input->valueData[0]->type_file == 'ppt')
                                    <span style="display: inline-block; font-weight: bold">File Presentation - </span>
                                @endif
                                @if ($input->valueData[0]->type_file == 'document')
                                    <span style="display: inline-block; font-weight: bold">File Document - </span>
                                @endif
                                @if ($input->valueData[0]->type_file == 'pdf')
                                    <span style="display: inline-block; font-weight: bold">File PDF - </span>
                                @endif
                                <a style="display: inline-block" href="{{ route('app.value.download', ['id' => $input->valueData[0]->id]) }}">
                                    {{ $input->valueData[0]->file_value }}
                                </a>
                            @endif
                            @if ($input->type == 'date')
                                {{ \Carbon\Carbon::parse($input->valueData[0]->date_value)->format('l, d F Y') }}
                            @endif
                            @if ($input->type == 'time')
                                {{ $input->valueData[0]->time_value }}
                            @endif
                        @else
                            @if ($input->type == 'text')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'textarea')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'number')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'date')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'file')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'time')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'dropdown')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            @if ($input->type == 'checkbox')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            @if ($input->type == 'radio')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            @if ($input->type == 'description')
                                <div class="description-content">
                                    {!! $input->description !!}
                                </div>
                            @endif
                            @if ($input->type == 'image')
                                <span style="display: inline-block; font-weight: bold">File Gambar - </span>
                                <a style="display: inline-block" href="{{ route('app.input-image.download', ['id' => $input->id]) }}">
                                    {{ $input->image }}
                                </a>
                            @endif
                            @if ($input->type == 'media-youtube')
                                <a href="{{ $input->link }}">
                                    {{ $input->link }}
                                </a>
                            @endif
                        @endif
                    </li>
                </ol>
            @endforeach
        @endif

        @if (count($inputs['monitoring']) > 0)
            <div style="margin-top: 24px; padding-top: 20px; border-top: 3px solid gainsboro; padding-left: 10px">
                <p style="font-size: 1rem; font-weight: bold; margin: 0 0 0px 0;">Formulir {{ $monitoring->title }}</p>
                <p style="font-size: .9rem; margin: 6px 0 20px 0;">Formulir berdasarkan data monitoring</p>
            </div>
            @foreach ($inputs['monitoring'] as $input)
                <ol style="list-style: none">
                    <li style="margin-bottom: 8px"><u>{{ $input->label }} :</u></li>
                    <li class="value-input">
                        @if ($input->valueData != null && count($input->valueData) > 0)
                            @if ($input->type == 'text')
                                {{ $input->valueData[0]->string_value }}
                            @endif
                            @if ($input->type == 'textarea')
                                <div class="description-content">
                                    {!! $input->valueData[0]->text_value !!}
                                </div>
                            @endif
                            @if ($input->type == 'number')
                                {{ $input->valueData[0]->number_value }}
                            @endif
                            @if ($input->type == 'dropdown')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                                {{ $input->valueData[0]->string_value }}
                            @endif
                            @if ($input->type == 'checkbox')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                                {{ $input->valueData[0]->string_value }}
                            @endif
                            @if ($input->type == 'radio')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                                {{ $input->valueData[0]->string_value }}
                            @endif
                            @if ($input->type == 'file')
                                @if ($input->valueData[0]->type_file == 'image')
                                    <span style="display: inline-block; font-weight: bold">File Gambar - </span>
                                @endif
                                @if ($input->valueData[0]->type_file == 'excel')
                                    <span style="display: inline-block; font-weight: bold">File Excel - </span>
                                @endif
                                @if ($input->valueData[0]->type_file == 'ppt')
                                    <span style="display: inline-block; font-weight: bold">File Presentation - </span>
                                @endif
                                @if ($input->valueData[0]->type_file == 'document')
                                    <span style="display: inline-block; font-weight: bold">File Document - </span>
                                @endif
                                @if ($input->valueData[0]->type_file == 'pdf')
                                    <span style="display: inline-block; font-weight: bold">File PDF - </span>
                                @endif
                                <a style="display: inline-block" href="{{ route('app.value.download', ['id' => $input->valueData[0]->id]) }}">
                                    {{ $input->valueData[0]->file_value }}
                                </a>
                            @endif
                            @if ($input->type == 'date')
                                {{ \Carbon\Carbon::parse($input->valueData[0]->date_value)->format('l, d F Y') }}
                            @endif
                            @if ($input->type == 'time')
                                {{ $input->valueData[0]->time_value }}
                            @endif
                        @else
                            @if ($input->type == 'text')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'textarea')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'number')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'date')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'file')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'time')
                                Tidak ada data
                            @endif
                            @if ($input->type == 'dropdown')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            @if ($input->type == 'checkbox')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            @if ($input->type == 'radio')
                                @foreach ($input->option as $option)
                                    @if ($option->optionValue != null && count($option->optionValue) > 0)
                                        @foreach ($option->optionValue as $value)
                                            <span>{{ $value->value }}, </span>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            @if ($input->type == 'description')
                                <div class="description-content">
                                    {!! $input->description !!}
                                </div>
                            @endif
                            @if ($input->type == 'image')
                                <span style="display: inline-block; font-weight: bold">File Gambar - </span>
                                <a style="display: inline-block" href="{{ route('app.input-image.download', ['id' => $input->id]) }}">
                                    {{ $input->image }}
                                </a>
                            @endif
                            @if ($input->type == 'media-youtube')
                                <a href="{{ $input->link }}">
                                    {{ $input->link }}
                                </a>
                            @endif
                        @endif
                    </li>
                </ol>
            @endforeach
        @endif

        @if (count($images) > 0)
            <div style="margin-top: 24px; padding-top: 20px; border-top: 3px solid gainsboro; padding-left: 10px">
                <p style="font-size: 1rem; font-weight: bold; margin: 0 0 0px 0;">Data gambar dokumentasi</p>
                <p style="font-size: .9rem; margin: 6px 0 20px 0;">Data dokumentasi formulir</p>
            </div>

            @foreach ($images as $image)
                <ol style="list-style: none">
                    <li style="margin-bottom: 8px"><u>{{ $image->label }} :</u></li>
                    <li class="value-input">
                        <span style="display: inline-block; font-weight: bold">File Gambar - </span>
                        <a style="display: inline-block" href="{{ route('app.image.download', ['id' => $image->id]) }}">
                            {{ $image->name }}
                        </a>
                    </li>
                </ol>
            @endforeach

        @endif
    </div>
    <div style="text-align: center; margin-top: 30px">
        <img src="data:image/png;base64,{{ $logoDev }}" style="display: inline-block" width="80px" alt="Logo Dev">
        <p style="margin: 10px 0; font-size: 1.1rem; font-weight: bold">Sidescript Indonesia</p>
        <p style="margin: 5px 0; font-size: .8rem">Startup Digital Creative</p>
    </div>

</body>
</html>
