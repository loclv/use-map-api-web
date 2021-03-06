<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Public key JSZ752c40ded32d can run in my localhost-->
<!-- My     key JSZ1b90e7b67434 can run in my free host-->
<script src="http://api.its-mo.com/cgi/loader.cgi?key=JSZ1b90e7b67434&ver=2.0&api=zdcmap.js,search.js,shape.js,userwidget.js,submap.js&force=1"></script>
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
    <div class="dropdown" style="left: 16px;">
        <button class="btn dropdown-toggle" style="background-color: #0B0B3B; border-color: #0B0B3B;" id="menu1" type="button" data-toggle="dropdown">
            <img src="drop.png" role="menuitem" tabindex="-1" style="width: 16px; height: 16px;">
        </button>
        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" style="background-color: #0B0B3B;">
            <li id="switch_to_walk_menu_list" role="presentation" onclick="switchToWalk()">
                <img src="walk.png" role="menuitem" tabindex="-1" style="width: 36px; height: 36px;">
            </li>
            <li id="switch_to_drive_menu_list" style="display: none;" role="presentation" onclick="switchToDrive()">
                <img src="car.png" role="menuitem" tabindex="-1" style="width: 36px; height: 36px;">
            </li>
            <li role="presentation" class="divider"></li>
            <li id="show_scale_var_menu_list" role="presentation">
                <a role="menuitem" tabindex="-1" onclick="showScaleBar()">
                    <font color="white">スケールバーを表示する</font>
                </a>
            </li>
            <li id="hide_scale_var_menu_list" style="display: none;" role="presentation">
                <a role="menuitem" tabindex="-1" onclick="hideScaleBar()">
                    <font color="white">スケールバーを削除する</font>
                </a>
            </li>
            <li role="presentation" class="divider"></li>
            <li role="presentation">
                <a role="menuitem" tabindex="-1" onclick="searchSupermarket()">
                    <font color="white">スーパー</font>
                </a>
            </li>
            <!-- <li role="presentation"><a role="menuitem" tabindex="-1">park</a></li> -->
            <li role="presentation">
                <a role="menuitem" tabindex="-1" onclick="searchShop()">
                    <font color="white">コンビニ</font>
                </a>
            </li>
            <!-- <li role="presentation"><a role="menuitem" tabindex="-1">restaurent</a></li> -->
            <li role="presentation" class="divider"></li>
            <li role="presentation">
                <a role="menuitem" tabindex="-1" href="https://www.zenrin-datacom.net/">
                    <font color="white">ゼンリンデータコムについて</font>
                </a>
            </li>
        </ul>

    </div>
    <h4 id="h4label" class="label center-block text-center" style="width: 36%; background-color: #0B0B3B; border-color: #00D5FF;">
        出発地点を設定ため、地図にクリックしてくだいさい。目的地のマーカをドラッグできます。
    </h4>
    <button type="button" style="width: 48px; height: 48px; border-radius: 48px; border-color: #FFFFFF; background-color: #0B0B3B; font-size: 24px; left: 16px; position: absolute;" id="zoom_in_btn" onclick="zoomIn()">
        <font color="white">+</font>
    </button>
    <button type="button" style="width: 48px; height: 48px; border-radius: 48px; border-color: #FFFFFF; background-color: #0B0B3B; font-size: 24px; left: 16px; top: 148px; position: absolute;" id="zoom_out_btn" onclick="zoomOut()">
        <font color="white">-</font>
    </button>

    <div id="search-area" style="width: 36%; bottom: 64px; background-color: #00D5FF; position: absolute; margin-right: 32%; margin-left: 32%;">
        <div id="search-result" style="overflow: scroll; height: 150px; display: none;">
        </div>
        <input type="text" class="form-control" style="text-align: center;" id="input_text" value="東京" placeholder="住所">
    </div>
    <button class="btn btn-success" style="width: 16%; bottom: 24px; position: absolute; margin-right: 42%; margin-left: 42%; background-color: #0B3B0B;"  id="search-btn" onclick='searchByWordClick();'>
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
    <script src="js/controller.js"></script>
    <link rel='stylesheet' href='css/nprogress.css'/>
</body>
</html>