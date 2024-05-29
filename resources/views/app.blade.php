<!doctype html>
<html lang="ja">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- デバイス画面サイズに応じて正しくスケーリングして表示されるようにするための設定  -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="container">
            <h1 style="font-size:2.0rem;">自動販売機売上管理システム</h1>
            @yield('content')
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> <!--JSファイルは通常</body>タグの直前に配置される。ページのレンダリングが完了する前にJSを読み込むことでページ読み込み速度を向上させ、ユーザーエクスペリエンスを向上させるため。<head>タグ内に配置することは一般的には推奨されない。-->
            @yield('scripts')

    </body>

</html>