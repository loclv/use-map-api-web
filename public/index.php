<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<script src="http://test.api.its-mo.com/cgi/loader.cgi?key=JSZ752c40ded32d&ver=2.0&api=zdcmap.js,search.js,shape.js&enc=EUC&force=1"></script>

</head>

<body onload="loadMap();">
    <div id="ZMap" style="min-width: 100%; min-height: 100%; z-index: -1; position: absolute;"></div>
    <br>
    <h4 id="h4label" class="center-block text-center" style="width: 36%; background-color: #00D5FF; border-style: solid; border-width: 4px; border-radius: 48px; border-color: #00D5FF;">
        touch the map to set begin point
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
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="js/bootstrap.js"></script>
    <!-- Map -->
    <script src="map.js"></script>
</body>
</html>