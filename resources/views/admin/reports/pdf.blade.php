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
              <strong>(($establishment->establishment_users))</strong><br>
                (($establishment->establishment_address)) <br>
                (($establishment->establishment_phones)) <br>
                <br>
            </div>

            <div class="col-xs-4">
                <img src="https://res.cloudinary.com/dqzxpn5db/image/upload/v1537151698/website/logo.png" alt="logo">
            </div>
        </div>

        <div style="margin-bottom: 0px">&nbsp;</div>

        <table class="table">
            <thead style="background: #F5F5F5;">
                <tr>
                  <th>Nota</th>
                  <th></th>
                  <th class="text-right">Data</th>
                </tr>
            </thead>
            @foreach ($pdf as $rating)
            <tbody style="background-color: rgba(255, 245, 245, 0.986);">
                    <td style="border-bottom:1px dotted grey"><p>rating->rating NOTA</p></td>
                    <td style="border-bottom:1px dotted grey"></td>
                    <td class="text-right" style="border-bottom:1px dotted grey">rating ->created_at 01/02</td><br>
            </tbody>
            @endforeach
        </table>

        <table class="table">
            <thead style="background: #F5F5F5;">
              <tr>
                <th>Comentário</th>
                <th></th>
                <th class="text-right">Data</th>
              </tr>
          </thead>
          @foreach ($pdf as $comment)
          <tr style="background-color: rgba(255, 245, 245, 0.986);">
                  <td style="border-bottom:1px dotted grey"><p>comment->comment Comentário .... </p></td>
                  <td style="border-bottom:1px dotted gray"></td>
                  <td class="text-right" style="border-bottom:1px dotted gray">comment->created_at 01/02</td>
                  <br>
            </tr>
            @endforeach
        </table>

            <div style="margin-bottom: 0px">&nbsp;</div>

            <div class="row">
                <div class="col-xs-8 invbody-terms">
                  <br>
                  Nightlife agradece. <br>
                </div>
            </div>
        </div>

    </body>
    </html>