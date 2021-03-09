<head>
    <style>
        body {}

        .content {
            font max-width: 500px;
            padding: 35px;
            text-align: center;
            margin: auto;
            font-family: 'Cairo', sans-serif;
        }

        .table {
            direction: rtl;
        }

        .title {
            color: #00ADEF;
        }

        .nowrap {
            white-space: nowrap;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Cairo" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


    <title>التحويل البنكي</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>
    <div class="container">
        <div class="content">

            <div class="row">
                <div class="col-12">

                    <h2 class="title">التحويل البنكي</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name"> اسم المحول</label>
                            <input required type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="name"> الإيميل *اختياري</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <label for="from_bank">رقم الحساب </label>
                            <input required type="text" class="form-control" name="from_bank">
                        </div>
                        <div class="form-group">
                            <label for="bank_name"> اسم البنك </label>
                            <input required type="text" class="form-control" name="bank_name">
                        </div>
                        <div class="form-group">
                            <label for="name"> رقم الجوال</label>
                            <input required="required" type="tel" class="form-control" name="mobile">
                        </div>
                        <div class="form-group">
                            <label for="amount"> المبلغ الذي تم تحويله </label>
                            <input required type="number" class="form-control" name="amount">
                        </div>
                        <div class="form-group">
                            <label for="amount"> تاريخ التحويل </label>
                            <input required type="date" class="form-control" name="date">
                        </div>
                        <div class="form-group">
                            <label for="to_bank">البنك المحول اليه</label>
                            <select style="direction:rtl" required="required" id="to_bank" class="form-control" name="to_bank">
                                <option selected>اختر...</option>
                                <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value=<?php echo e($bank->bank_name, false); ?>><?php echo e($bank->bank_name, false); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="photo"> صورة التحويل</label><br>
                            <input type="file" name="photo">
                        </div>

                        <input type="hidden" name="_token" value="<?php echo e(csrf_token(), false); ?>">
                        <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error, false); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary">إرسال</button>
                    </form>

                </div>
            </div>
</body>