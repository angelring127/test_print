<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel 직접 출력</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        #loadingMessage {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            display: none;
        }

        @media print {
            body {
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div id="loadingMessage">데이터 로딩 중...</div>
    <div id="excelData"></div>

    <script>
        document.addEventListener('DOMContentLoaded', fetchExcelData);

        async function fetchExcelData() {
            document.getElementById('loadingMessage').style.display = 'block';

            try {
                const response = await fetch('/process-excel');
                const result = await response.json();

                if (result.success) {
                    renderExcelData(result.data);
                    // 데이터 렌더링 후 프린트 다이얼로그 표시
                    setTimeout(() => {
                        window.print();
                    }, 1000);
                } else {
                    document.getElementById('loadingMessage').textContent =
                        '데이터 로드 실패: ' + result.message;
                }
            } catch (error) {
                document.getElementById('loadingMessage').textContent =
                    '에러 발생: ' + error.message;
            }
        }

        function renderExcelData(data) {
            const container = document.getElementById('excelData');
            container.innerHTML = '';

            const table = document.createElement('table');

            data.forEach((row, rowIndex) => {
                const tr = document.createElement('tr');
                row.forEach((cell) => {
                    const element = rowIndex === 0 ? 'th' : 'td';
                    const td = document.createElement(element);
                    td.textContent = cell;
                    tr.appendChild(td);
                });
                table.appendChild(tr);
            });

            container.appendChild(table);
            document.getElementById('loadingMessage').style.display = 'none';
        }
    </script>
</body>

</html>