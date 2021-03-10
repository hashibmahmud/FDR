<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail Body</title>
</head>
<body>
    <h1>Hello,</h1>
    <p>Your following FDR has been verified</p>
    <ul>
        <li>FDR Number: {{ $fdr_no }}</li>
        <li>Bank Name: {{ $bank }}</li>
        <li>Branch Name: {{ $branch }}</li>
    </ul>
</body>
</html>
