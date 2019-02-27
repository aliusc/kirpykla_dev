<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?=$this->e($title)?></title>

    <script type="text/javascript" charset="utf-8" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://code.jquery.com/ui/1.9.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/default.css">
    <script type="text/javascript" charset="utf-8">
        $(document).ready( function () {

        });

        $(function() {
            $.datepicker.setDefaults($.datepicker.regional['lt']);
            var dates = $('#datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                showOtherMonths: true,
                selectOtherMonths: true,
                minDate: 0
            });
        });
    </script>
</head>
<body>