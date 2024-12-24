<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel PDF 변환 출력</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #pdfViewer {
            width: 100%;
            flex: 1;
            border: none;
            display: none;
        }

        #loadingMessage {
            text-align: center;
            padding: 20px;
            font-size: 18px;
        }

        @media print {
            #loadingMessage {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div id="loadingMessage">PDF 로딩 중...</div>
    <iframe id="pdfViewer"></iframe>

    <script>
        document.addEventListener('DOMContentLoaded', loadPdf);

        async function loadPdf() {
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

            // Blob URL 생성
            const blobUrl = URL.createObjectURL(pdfBlob);

            // 새 창에서 PDF 열기
            const pdfWindow = window.open(blobUrl, '_blank');

            // PDF가 로드된 후 프린트 다이얼로그 표시
            if (pdfWindow) {
                pdfWindow.onload = function() {
                    setTimeout(() => {
                        pdfWindow.print();
                    }, 2000);
                };
            }

            // 로딩 메시지 숨기기
            loadingMessage.style.display = 'none';
        }
    </script>
</body>

</html>