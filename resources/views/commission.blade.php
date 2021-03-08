<html>

<head>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Droid+Sans+Arabic" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link href='https://fonts.googleapis.com/css?family=Cairo&subset=arabic' rel='stylesheet' type='text/css'>

    <title>حساب العمولة</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            direction: rtl;
            padding: 17px 0px 20px 0px;
        }

        .col1 {
            display: inline-block;
            width: 48%;
        }

        .col1 p {
            display: inline;

        }

        .bank-accounts {
            padding: 5px;
            border: 1px solid;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
    </div>
    <div class="row">
        <div class="col text-center">
            <h2>ملاحظات</h2>
            @foreach ($notes as $note)
            <p>{{$note}}</p>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col text-center">
            <h2 class="title">الحسابات البنكية</h2>

            @foreach ($bank_accounts as $bank_account)
            <div class="bank-accounts">

                <div class="col2">
                    <p style="font-weight: bold;color: #00ADEF;"> اسم البنك</p>
                    <td>{{ $bank_account->bank_name }}</td>
                </div>

                <div class="col2">

                    <p style="font-weight: bold;color: #00ADEF;"> اسم الحساب</p>
                    <td>{{ $bank_account->account_name }}</td>
                </div>
                <div class="col2">
                    <p style="font-weight: bold;color: #00ADEF;"> رقم الحساب</p>
                    <td>{{ $bank_account->account_no }}</td>
                </div>
                <div class="col2">
                    <p style="font-weight: bold;color: #00ADEF;"> رقم الأيبان</p>
                    <td>{{ $bank_account->iban }}</td>
                </div>
            </div>
            @endforeach


            <a text-center href="../bankform"> <b>برجاء الضغط هنا لتعبئة نموذج الدفع بعد التحويل</b></a>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
</body>

</html>