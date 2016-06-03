var map,
    /* 東京 */
    lat = 35.6778614,
    lon = 139.7703167,
    latlon = new ZDC.LatLon(lat, lon),
    isBeginPoint = true,
    isSearchRouteComplete = true,
    beginMarker,
    endMarker,
    searchResultMarker,
    select_eki_latlon = {},
    imgdir ='../../image/search/';

function loadMap() {

    map = new ZDC.Map(
    document.getElementById('ZMap'),{
        latlon: new ZDC.LatLon(lat, lon),
        zoom: 8
    });
    /* 地図をクリックしたときの動作 */
    ZDC.addListener(map, ZDC.MAP_CLICK, getClickLatLon);
    initBeginEndMarker();
    map.addWidget(beginMarker);
    map.addWidget(endMarker);
    beginMarker.hidden();
    endMarker.hidden();

    initSearchResultMarker();
    map.addWidget(searchResultMarker);
    searchResultMarker.hidden();

    /* 地図上の緯度経度を取得(getPointerPosition)できるようにする */
    map.pointerPositionOn();

    /* 地図にイベントを追加 */
    // when mouse move too fast to position in map not in marker
    ZDC.addListener(map, ZDC.MAP_MOUSEMOVE, onMouseMove);
    ZDC.addListener(map, ZDC.MAP_MOUSEUP, onMouseUp);

    /* documentにイベントを追加 */
    // when mouse up outside of the map, onMouseUp still can run
    ZDC.addDomListener(document, 'mouseup', onMouseUp);

    add_submap();
}
// ----------------------------------------------------
function initBeginEndMarker() {
    beginMarker = new ZDC.Marker(latlon, {
            color: ZDC.MARKER_COLOR_ID_GREEN_L,
            number: ZDC.MARKER_NUMBER_ID_1_L
        });
    endMarker = new ZDC.Marker(latlon, {
            color: ZDC.MARKER_COLOR_ID_RED_L,
            number: ZDC.MARKER_NUMBER_ID_2_L
        });
    /*
    *  スタートとゴールのウィジットが他のマーカの
    *  下にならないようにz-indexを設定します
    */
    beginMarker.setZindex(110);
    endMarker.setZindex(110);
    beginMarker.setTitle("start");
    endMarker.setTitle("end");

    /* マーカにイベントを追加 */
    ZDC.addListener(endMarker, ZDC.MARKER_MOUSEMOVE, onMouseMove);
    ZDC.addListener(endMarker, ZDC.MARKER_MOUSEDOWN, onMouseDown);
    ZDC.addListener(endMarker, ZDC.MARKER_MOUSEUP, onMouseUp);
}

function initSearchResultMarker() {
    searchResultMarker = new ZDC.Marker(latlon, {
        color: ZDC.MARKER_COLOR_ID_GREEN_L,
        number: ZDC.MARKER_NUMBER_ID_STAR_S
    });
    /*
    *  スタートとゴールのウィジットが他のマーカの
    *  下にならないようにz-indexを設定します
    */
    searchResultMarker.setZindex(109);
    searchResultMarker.setTitle("result of searching for destination search");
}
/* クリックした地点の緯度経度を表示する */
function getClickLatLon() {
    if (isBeginPoint) {
        endMarker.hidden();
        beginMarker.moveLatLon(map.getClickLatLon());
        beginMarker.visible();
        changeInforLabel(isBeginPoint);
        isBeginPoint = false;
    } else {
        endMarker.moveLatLon(map.getClickLatLon());
        endMarker.visible();
        searchRoute();
        changeInforLabel(isBeginPoint);
        isBeginPoint = true;
    }
}

function changeInforLabel(isBeginPoint) {
    if (isBeginPoint) {
        document.getElementById("h4label").innerHTML =
            "目的地点を設定ため、地図にクリックしてくだいさい。";
        document.getElementById("h4label").style.backgroundColor =
            "#00FA9A";
    } else {
        document.getElementById("h4label").innerHTML =
            "出発地点を設定ため、地図にクリックしてくだいさい。目的地のマーカをドラッグできます。";
        document.getElementById("h4label").style.backgroundColor =
            "#00D5FF";
    }
}