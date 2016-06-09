<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Public key JSZ752c40ded32d can run in my localhost-->
<!-- My     key JSZ1b90e7b67434 can run in my free host-->
<script src="http://api.its-mo.com/cgi/loader.cgi?key=JSZ752c40ded32d&ver=2.0&api=zdcmap.js,search.js,shape.js,userwidget.js,submap.js&force=1"></script>
<!-- Map -->
<script src="js/map/init_map.js"></script>
<script src="js/map/search_by_word.js"></script>
<script src="js/map/search_route.js"></script>
<script src="js/map/zoom.js"></script>
<script src="js/map/marker/msg_info.js"></script>
<script src="js/map/marker/drag.js"></script>
<script src="js/map/scale_bar.js"></script>
<script src="js/map/submap.js"></script>
<script src="js/map/search_by_latlon.js"></script>
</head>

<body onload="loadMap();">
    <div id="ZMap" style="min-width: 100%; min-height: 100%; z-index: -1; position: absolute;"></div>
    <br>
    <div class="dropdown">
        <button class="btn dropdown-toggle" style="background-color: #00D5FF; border-color: #00D5FF;" id="menu1" type="button" data-toggle="dropdown">
            |||
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
            <li id="switch_to_walk_menu_list" role="presentation"><a role="menuitem" tabindex="-1" onclick="switchToWalk()">switch to walk</a></li>
            <li role="presentation" class="divider"></li>
            <li id="show_scale_var_menu_list" role="presentation"><a role="menuitem" tabindex="-1" onclick="showScaleBar()">show scale bar in bottom left of screen</a></li>
            <li id="hide_scale_var_menu_list" style="display: none;" role="presentation"><a role="menuitem" tabindex="-1" onclick="hideScaleBar()">hide scale bar in bottom left of screen</a></li>
            <li role="presentation" class="divider"></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" onclick="searchSupermarket()">スーパー</a></li>
            <!-- <li role="presentation"><a role="menuitem" tabindex="-1">park</a></li> -->
            <li role="presentation"><a role="menuitem" tabindex="-1" onclick="searchShop()">コンビニ</a></li>
            <!-- <li role="presentation"><a role="menuitem" tabindex="-1">restaurent</a></li> -->
            <li role="presentation" class="divider"></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="https://www.zenrin-datacom.net/">About ZDC</a></li>
        </ul>

    </div>
    <h4 id="h4label" class="label center-block text-center" style="width: 36%; background-color: #0B0B3B; border-color: #00D5FF;">
        出発地点を設定ため、地図にクリックしてくだいさい。目的地のマーカをドラッグできます。
    </h4>
    <button type="button" style="width: 48px; height: 48px; border-radius: 48px; border-color: #FFFFFF; background-color: #00D5FF; font-size: 24px;" id="zoom_in_btn" onclick="zoomIn()">
        +
    </button>
    <button type="button" style="width: 48px; height: 48px; border-radius: 48px; border-color: #FFFFFF; background-color: #00D5FF; font-size: 24px;" id="zoom_out_btn" onclick="zoomOut()">
        -
    </button>

    <div id="search-area" style="width: 512px; bottom: 64px; background-color: #00D5FF; position: absolute; margin-right: 32%; margin-left: 32%;">
        <div id="search-result" style="overflow: scroll; height: 150px; display: none;">
        </div>
        <input type="text" class="form-control" style="text-align: center;" id="word" value="東京" placeholder="住所">
    </div>
    <button class="btn btn-success" style="width: 196px; bottom: 24px; position: absolute; margin-right: 36%; margin-left: 36%;"  id="search-btn" onclick='searchByWordClick();'>
        検索
    </button>

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