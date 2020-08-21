<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>PDF - Notas e Comentários</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        .text-right {
            text-align: right;
        }
    </style>

</head>
<body class="login-page" style="background: white">

<div>
    <div class="row">
        <div class="col-xs-7">
            <strong>{{ $establishment->corporate_name }}</strong>
        </div>

        <div class="col-xs-5 text-right">
            <img style="width: 50%;height: 50%" src="https://i.ibb.co/9bNG32B/logo-atual.png" alt="logo">
        </div>
    </div>

    <div style="margin-bottom: 0px">&nbsp;</div>

    <table class="table">
        <thead style="background: #F5F5F5;">
        <tr>
            <th>Nota</th>
            <th>Author</th>
            <th class="text-right">Data/Hora</th>
        </tr>
        </thead>
        @if ($establishment->ratings()->count() > 0)
            @foreach ($establishment->ratings as $rating)
                <tbody style="background-color: rgba(255, 245, 245, 0.986);">
                    <tr>
                        <td style="border-bottom:1px dotted grey">{{ $rating->rating }}</td>
                        <td style="border-bottom:1px dotted grey">{{ $rating->author }}</td>
                        <td class="text-right" style="border-bottom:1px dotted grey">{{ formatDateHour($rating->created_at) }}</td>
                    </tr>
                </tbody>
            @endforeach
        @else
            <tbody style="background-color: rgba(255, 245, 245, 0.986);">
                <tr>
                    <td style="border-bottom:1px dotted grey">-</td>
                    <td style="border-bottom:1px dotted grey">-</td>
                    <td class="text-right" style="border-bottom:1px dotted grey">-</td>
                </tr>
            </tbody>
        @endif
    </table>

    <table class="table">
        <thead style="background: #F5F5F5;">
            <tr>
                <th>Comentário</th>
                <th>Author</th>
                <th class="text-right">Data/Hora</th>
            </tr>
        </thead>
        @if ($establishment->comments()->count() > 0)
            @foreach ($establishment->comments as $comment)
                <tbody style="background-color: rgba(255, 245, 245, 0.986);">
                    <tr>
                        <td style="border-bottom:1px dotted grey">{{ $comment->comment }}</td>
                        <td style="border-bottom:1px dotted grey">{{ $comment->author }}</td>
                        <td class="text-right" style="border-bottom:1px dotted grey">{{ formatDateHour($comment->created_at) }}</td>
                    </tr>
                </tbody>
            @endforeach
        @else
            <tbody style="background-color: rgba(255, 245, 245, 0.986);">
                <tr>
                    <td style="border-bottom:1px dotted grey">-</td>
                    <td style="border-bottom:1px dotted grey">-</td>
                    <td class="text-right" style="border-bottom:1px dotted grey">-</td>
                </tr>
            </tbody>
        @endif
    </table>

    <div style="margin-bottom: 0px">&nbsp;</div>

    <div class="row">
        <div class="col-xs-8 invbody-terms">
            Abraços,
            <br> Equipe Nightlife
        </div>
    </div>
</div>

</body>
</html>