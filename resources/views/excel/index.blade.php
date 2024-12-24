<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel 데이터 표시</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <style>
        .container {
            padding: 20px;
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

        #pdfViewer {
            width: 100%;
            height: 800px;
            border: 1px solid #ddd;
            margin-top: 20px;
            display: none;
        }

        .button-container {
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            margin-right: 10px;
            cursor: pointer;
        }

        #loadingMessage {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            display: none;
        }

        .view-container {
            display: none;
        }

        .view-container.active {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="button-container">
            <button onclick="showView('excel')">Excel 직접 출력</button>
            <button onclick="showView('pdf')">PDF 변환 출력</button>
        </div>

        <div id="loadingMessage">데이터 로딩 중...</div>

        <!-- Excel 직접 출력 뷰 -->
        <div id="excelView" class="view-container">
            <div id="excelData"></div>
        </div>

        <!-- PDF 변환 출력 뷰 -->
        <div id="pdfView" class="view-container">
            <iframe id="pdfViewer"></iframe>
        </div>
    </div>

    <script>
        let currentView = null;

        function showView(viewType) {
            // 이전 뷰 숨기기
            if (currentView) {
                document.getElementById(currentView + 'View').classList.remove('active');
            }

            // 새로운 뷰 표시
            currentView = viewType;
            document.getElementById(viewType + 'View').classList.add('active');

            // 데이터 로드
            if (viewType === 'excel') {
                fetchExcelData();
            } else {
                loadPdf();
            }
        }

        async function fetchExcelData() {
            document.getElementById('loadingMessage').style.display = 'block';

            try {
                const response = await fetch('/process-excel');
                const result = await response.json();

                if (result.success) {
                    renderExcelData(result.data);
                    // Excel 데이터 렌더링 후 프린트 다이얼로그 표시
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

        async function loadPdf() {
            document.getElementById('loadingMessage').style.display = 'block';

            try {
                const response = await fetch('/convert-to-pdf');
                const result = await response.json();

                if (result.success) {
                    displayPDF(result.pdfContent);
                } else {
                    document.getElementById('loadingMessage').textContent =
                        '데이터 로드 실패: ' + result.message;
                }
            } catch (error) {
                document.getElementById('loadingMessage').textContent =
                    '에러 발생: ' + error.message;
            }
        }

        function displayPDF(base64PDF) {
            const pdfViewer = document.getElementById('pdfViewer');
            const loadingMessage = document.getElementById('loadingMessage');

            // base64 PDF 데이터를 Blob으로 변환
            const binaryString = window.atob(base64PDF);
            const len = binaryString.length;
            const bytes = new Uint8Array(len);
            for (let i = 0; i < len; i++) {
                bytes[i] = binaryString.charCodeAt(i);
            }
            const pdfBlob = new Blob([bytes.buffer], {
                type: 'application/pdf'
            });

            // Blob URL 생성 및 iframe에 표시
            const blobUrl = URL.createObjectURL(pdfBlob);
            pdfViewer.src = blobUrl;

            // 로딩 메시지 숨기고 PDF 뷰어 표시
            loadingMessage.style.display = 'none';
            pdfViewer.style.display = 'block';

            // PDF 로드 완료 후 프린트 다이얼로그 표시
            pdfViewer.onload = function() {
                setTimeout(() => {
                    window.print();
                }, 1000);
            };
        }
    </script>
</body>

</html>