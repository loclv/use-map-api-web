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
}
// ----------------------------------------------------
function initBeginEndMarker() {
    beginMarker = new ZDC.Marker(latlon, {
            color: ZDC.MARKER_COLOR_ID_GREEN_L,
            number: ZDC.MARKER_NUMBER_ID_1_L
        });
    endMarker = new ZDC.Marker(latlon, {
            color: ZDC.MARKER_COLOR_ID_GREEN_L,
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
            "目的地地点を設定ため、地図にクリックしてくだいさい";
        document.getElementById("h4label").style.backgroundColor =
            "#00FA9A";
    } else {
        document.getElementById("h4label").innerHTML =
            "出発地点を設定ため、地図にクリックしてくだいさい";
        document.getElementById("h4label").style.backgroundColor =
            "#00D5FF";
    }
}