<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Public key JSZ752c40ded32d can run in my localhost-->
<!-- My key     JSZ1b90e7b67434 can run in my free host-->
<script src="http://api.its-mo.com/cgi/loader.cgi?key=JSZ1b90e7b67434&ver=2.0&api=zdcmap.js,search.js,shape.js,userwidget.js&force=1"></script>
<!-- Map -->
<script src="js/map.js"></script>
</head>

<body onload="loadMap();">
    <div id="ZMap" style="min-width: 100%; min-height: 100%; z-index: -1; position: absolute;"></div>
    <br>
    <br>
    <h4 id="h4label" class="center-block text-center" style="width: 36%; background-color: #00D5FF; border-radius: 48px; border-color: #00D5FF;">
        出発地点を設定ため、地図にクリックしてくだいさい
    </h4>
    <button type="button" style="width: 48px; height: 48px; border-radius: 48px; border-color: #FFFFFF;background-color: #00D5FF; font-size: 24px;" id="zoom_in_btn" onclick="zoomIn()">
        +
    </button>
    <br>
    <button type="button" style="width: 48px; height: 48px; border-radius: 48px; border-color: #FFFFFF;background-color: #00D5FF; font-size: 24px;" id="zoom_out_btn" onclick="zoomOut()">
        -
    </button>

    <div id="search-area" style="width: 600px; height: 175px; bottom: 0px; left:20px; position:absolute; background-color: #00D5FF;" class="panel-success">
        <input type="text" class="form-control" id="word" value="東京" placeholder="住所">
        <input type="button" class="btn btn-success" id="search-btn" value='検索' onclick='searchByWordClick();'>
        <div id="search-result" style="overflow: scroll; height: 150px">
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">情報</h4>
                    </div>

                    <div class="modal-body">
                        <p id="dialogOutputText"></p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                    </div>
              </div>

        </div>
    </div>

    <!-- Bootstrap -->
    <script src="js/jquery-2.2.4.min.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="js/bootstrap.js"></script>

    <!-- NProgress -->
    <script src='js/nprogress.js'></script>
    <link rel='stylesheet' href='css/nprogress.css'/>
</body>
</html>