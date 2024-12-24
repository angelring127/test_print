너는 Laravel의 전문가이고, 프로젝트 디렉토리에는 이미 Laravel 프레임워크가 설치되어 있습니다. PHPSpreadsheet 라이브러리를 사용하여 Excel 파일을 처리하고, 클라이언트 측에서는 Vanilla JavaScript와 적합한 JavaScript 라이브러리를 사용하여 데이터를 표시하려고 합니다. 필요하다면 jQuery도 사용 가능합니다.

목표: 서버에서 제공된 Excel 파일을 클라이언트 측에서 처리하여 브라우저 화면에 표시하고, 데이터를 렌더링한 직후 자동으로 프린트 설정 화면을 표시하려고 합니다.

배경:

1. 백엔드: Laravel 프레임워크를 사용하며, PHPSpreadsheet 라이브러리를 통해 Excel 데이터를 처리합니다.
2. 프론트엔드: Vanilla JavaScript를 기본으로 하며, 필요 시 jQuery 또는 다른 적합한 JavaScript 라이브러리를 사용할 수 있습니다.
3. 데이터 렌더링 후, 별도의 사용자 작업 없이 브라우저 프린트 설정 화면이 자동으로 표시되어야 합니다.

작업 요청:

1. **백엔드 작업**:

    - PHPSpreadsheet를 사용하여 서버의 Excel 파일을 처리하는 Laravel 컨트롤러 코드를 작성해 주세요.
    - Excel 파일을 클라이언트에 전달하기 위한 API 엔드포인트를 생성해 주세요.
    - API 응답 형식은 Excel 원본 파일(.xlsx) 또는 JSON 형식 중 하나로 선택합니다.

2. **프론트엔드 작업**:

    - 클라이언트 측에서 적합한 JavaScript 라이브러리를 사용하여 Excel 데이터를 처리하고, 브라우저 화면에 HTML 형식으로 렌더링합니다.
    - Excel 데이터 렌더링 후 JavaScript로 `window.print()`를 호출하여 자동으로 프린트 설정 화면을 표시합니다.
    - 사용할 수 있는 JavaScript 라이브러리의 옵션을 제시하고, 선택한 라이브러리를 기반으로 코드를 작성해 주세요. 예:
        - SheetJS (js-xlsx)
        - PapasParse
        - ExcelJS
        - jQuery (필요 시 데이터 처리 또는 DOM 조작에 활용)

3. **구현 예제 요청**:
    - 백엔드 컨트롤러와 프론트엔드 렌더링 코드의 전체 예제를 제공해 주세요.
    - PHPSpreadsheet 라이브러리의 설치 및 설정 과정을 설명해 주세요.
    - 클라이언트와 서버 간의 데이터 통신 방식을 명확히 작성해 주세요(AJAX, Fetch API 등).

추가 조건:

-   Laravel 컨트롤러는 PSR-4 표준을 준수해야 합니다.
-   프론트엔드 코드는 Vanilla JS를 기본으로 작성하되, 필요 시 jQuery를 사용할 수 있습니다.
-   작성된 코드는 모든 주요 브라우저(Chrome, Firefox, Edge)에서 호환되어야 합니다.
