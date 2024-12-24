<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel 출력 방식 선택</title>
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
        }

        .button-container {
            margin-top: 30px;
        }

        button {
            padding: 15px 30px;
            margin: 10px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Excel 출력 방식 선택</h1>
        <p>원하시는 출력 방식을 선택해주세요.</p>

        <div class="button-container">
            <button onclick="location.href='/excel/direct'">Excel 직접 출력</button>
            <button onclick="location.href='/excel/pdf'">PDF 변환 출력</button>
        </div>
    </div>
</body>

</html>